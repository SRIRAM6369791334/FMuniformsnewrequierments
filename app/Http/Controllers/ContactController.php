<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Models\ContactQuery;
use App\Models\User;
use App\Jobs\SendContactQueryNotification;

class ContactController extends Controller
{
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'first_name' => 'required|string|min:2|max:50',
            'last_name' => 'required|string|min:1|max:50',
            'email' => 'required|email',
            'subject' => 'required|string|max:100',
            'message' => 'required|string|max:1000',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'errors' => $validator->errors()
            ], 422);
        }

        // Find user by email to associate with contact query
        $user = User::where('email', $request->email)->first();
        
        // Determine the correct user_id to use
        // The user_id field may contain IP addresses for guest users, so we need to validate it
        $userId = null;
        if ($user) {
            if (is_numeric($user->user_id) && $user->user_id > 0) {
                $userId = $user->user_id;
            } elseif (!$user->is_guest_user && $user->id) {
                // For non-guest users, use the primary key 'id' if user_id is not valid
                $userId = $user->id;
            }
            // For guest users with IP address in user_id, leave as null
        }

        $contactQuery = ContactQuery::create([
            'first_name' => $request->first_name,
            'last_name' => $request->last_name ?: '', // Ensure empty string instead of null
            'email' => $request->email,
            'subject' => $request->subject,
            'message' => $request->message,
            'user_id' => $userId,
        ]);

        // Dispatch notification job to send email to admin
        SendContactQueryNotification::dispatch($contactQuery);

        return response()->json([
            'success' => true,
            'message' => 'Your message has been sent successfully!'
        ]);
    }

}
