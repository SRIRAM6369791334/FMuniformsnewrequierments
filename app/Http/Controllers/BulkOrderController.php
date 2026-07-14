<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Models\BulkOrder;
use App\Jobs\SendBulkOrderNotifications;

class BulkOrderController extends Controller
{
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'first_name' => 'required|string|min:2|max:50',
            'last_name' => 'nullable|string|min:1|max:50',
            'email' => 'required|email',
            'phone' => 'required|string|regex:/^[0-9]{10}$/',
            'institution' => 'required|string|max:100',
            'uniform_type' => 'required|string',
            'quantity' => 'required|integer|min:100',
            'budget' => 'nullable|string|max:50',
            'message' => 'required|string|max:1000',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'errors' => $validator->errors()
            ], 422);
        }

        $user = auth()->user();

        // Ensure the email matches the authenticated user's email validation removed to allow editing

        // Create bulk order
        $bulkOrder = BulkOrder::create([
            'bulk_order_id' => BulkOrder::generateNextBulkOrderId(),
            'user_id' => $user->id,
            'first_name' => $request->first_name,
            'last_name' => $request->last_name,
            'email' => $request->email,
            'phone' => $request->phone,
            'institution' => $request->institution,
            'uniform_type' => $request->uniform_type,
            'quantity' => $request->quantity,
            'budget' => $request->budget,
            'message' => $request->message,
            'status' => 'pending',
        ]);

        // Dispatch notification job
        SendBulkOrderNotifications::dispatch($bulkOrder);

        return response()->json([
            'success' => true,
            'message' => 'Your bulk order request has been submitted successfully! We will contact you soon.'
        ]);
    }
}
