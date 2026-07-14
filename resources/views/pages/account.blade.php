@extends('layouts.app')

@section('content')
<style>
    body { -webkit-font-smoothing: antialiased; -moz-osx-font-smoothing: grayscale; }

    /* Sidebar active link */
    .sidebar-link.active {
        background-color: #0f172a;
        color: #ffffff;
    }
    .sidebar-link.active i { color: #c99355; }

    /* Tab content */
    .tab-content { display: none; }
    .tab-content.active { display: block; }

    /* Status badges */
    .badge-delivered  { background: #dcfce7; color: #166534; }
    .badge-processing { background: #fef9c3; color: #854d0e; }
    .badge-shipped    { background: #dbeafe; color: #1e40af; }
    .badge-cancelled  { background: #fee2e2; color: #991b1b; }

    /* Smooth hover lift */
    .hover-lift { transition: transform 0.2s ease, box-shadow 0.2s ease; }
    .hover-lift:hover { transform: translateY(-3px); box-shadow: 0 10px 25px -5px rgba(0,0,0,0.1); }

    /* Input focus */
    .fm-input {
        width: 100%;
        border: 1px solid #d1d5db;
        border-radius: 0.375rem;
        padding: 0.75rem 1rem;
        font-size: 0.875rem;
        background: #f9fafb;
        transition: border-color 0.15s, background 0.15s;
    }
    .fm-input:focus {
        outline: none;
        border-color: #c99355;
        background: #fff;
        box-shadow: 0 0 0 3px rgba(201,147,85,0.12);
    }
</style>

<!-- Breadcrumb -->
<div class="max-w-[1400px] mx-auto px-4 lg:px-8 py-4 text-xs text-gray-500">
    <a href="{{ url('/') }}" class="hover:text-[#c99355] transition-colors">Home</a>
    <i class="ph ph-caret-right mx-1 text-[10px]"></i>
    <span class="text-[#c99355] font-semibold">My Account</span>
</div>

<!-- ===== MAIN LAYOUT ===== -->
<div class="max-w-[1400px] mx-auto px-4 lg:px-8 pb-20 bg-[#f4f5f7]">
    <div class="flex flex-col lg:flex-row gap-8">

        <!-- ===== LEFT SIDEBAR ===== -->
        <aside class="lg:w-72 shrink-0">

            <!-- Profile Card -->
            <div class="bg-[#0f172a] rounded-xl p-6 mb-4 text-white relative overflow-hidden shadow-xl">
                <div class="absolute top-0 right-0 w-32 h-32 bg-[#c99355]/10 rounded-full blur-2xl"></div>
                <div class="relative z-10 flex items-center gap-4">
                    <div class="w-16 h-16 rounded-full bg-[#c99355]/20 border-2 border-[#c99355] flex items-center justify-center text-[#c99355] text-3xl shrink-0">
                        <i class="ph-fill ph-user-circle"></i>
                    </div>
                    <div>
                        <h2 class="font-heading font-bold text-lg leading-tight">Rajesh Kumar</h2>
                        <p class="text-gray-400 text-xs mt-0.5">rajesh@hospital.com</p>
                        <span class="inline-block mt-2 bg-[#c99355]/20 text-[#c99355] text-[0.6rem] font-bold px-2 py-0.5 rounded-full uppercase tracking-widest border border-[#c99355]/30">MediQo B2B</span>
                    </div>
                </div>
                <div class="relative z-10 mt-5 pt-5 border-t border-gray-700 grid grid-cols-3 text-center gap-2">
                    <div>
                        <div class="text-lg font-heading font-extrabold text-white">12</div>
                        <div class="text-[0.6rem] text-gray-400 uppercase tracking-wide">Orders</div>
                    </div>
                    <div class="border-x border-gray-700">
                        <div class="text-lg font-heading font-extrabold text-white">4</div>
                        <div class="text-[0.6rem] text-gray-400 uppercase tracking-wide">Wishlist</div>
                    </div>
                    <div>
                        <div class="text-lg font-heading font-extrabold text-white">2</div>
                        <div class="text-[0.6rem] text-gray-400 uppercase tracking-wide">Addresses</div>
                    </div>
                </div>
            </div>

            <!-- Sidebar Navigation -->
            <div class="bg-white rounded-xl border border-gray-200 overflow-hidden shadow-sm">
                <div class="px-4 py-3 border-b border-gray-100">
                    <span class="text-[0.6rem] text-gray-400 font-bold uppercase tracking-widest">Account Menu</span>
                </div>
                <nav class="p-2 space-y-1">
                    <a href="#" onclick="showTab('dashboard', this); return false;" class="sidebar-link active flex items-center gap-3 px-4 py-3 rounded-lg text-sm font-semibold transition-all">
                        <i class="ph ph-squares-four text-xl text-[#c99355]"></i> Dashboard
                    </a>
                    <a href="#" onclick="showTab('orders', this); return false;" class="sidebar-link flex items-center gap-3 px-4 py-3 rounded-lg text-sm font-semibold text-gray-600 hover:bg-gray-50 transition-all">
                        <i class="ph ph-package text-xl"></i> My Orders
                        <span class="ml-auto bg-[#c99355] text-white text-[0.6rem] font-bold px-2 py-0.5 rounded-full">12</span>
                    </a>
                    <a href="#" onclick="showTab('wishlist', this); return false;" class="sidebar-link flex items-center gap-3 px-4 py-3 rounded-lg text-sm font-semibold text-gray-600 hover:bg-gray-50 transition-all">
                        <i class="ph ph-heart text-xl"></i> Wishlist
                        <span class="ml-auto bg-gray-200 text-gray-600 text-[0.6rem] font-bold px-2 py-0.5 rounded-full">4</span>
                    </a>
                    <a href="#" onclick="showTab('addresses', this); return false;" class="sidebar-link flex items-center gap-3 px-4 py-3 rounded-lg text-sm font-semibold text-gray-600 hover:bg-gray-50 transition-all">
                        <i class="ph ph-map-pin text-xl"></i> Addresses
                    </a>
                    <a href="#" onclick="showTab('profile', this); return false;" class="sidebar-link flex items-center gap-3 px-4 py-3 rounded-lg text-sm font-semibold text-gray-600 hover:bg-gray-50 transition-all">
                        <i class="ph ph-user-gear text-xl"></i> Profile Settings
                    </a>
                    <a href="#" onclick="showTab('password', this); return false;" class="sidebar-link flex items-center gap-3 px-4 py-3 rounded-lg text-sm font-semibold text-gray-600 hover:bg-gray-50 transition-all">
                        <i class="ph ph-lock-key text-xl"></i> Change Password
                    </a>
                    <div class="border-t border-gray-100 mt-1 pt-1">
                        <a href="{{ url('/logout') }}" class="flex items-center gap-3 px-4 py-3 rounded-lg text-sm font-semibold text-red-500 hover:bg-red-50 transition-all">
                            <i class="ph ph-sign-out text-xl"></i> Logout
                        </a>
                    </div>
                </nav>
            </div>

            <!-- Help Card -->
            <div class="bg-white rounded-xl border border-gray-200 p-5 mt-4 shadow-sm">
                <div class="flex items-center gap-3 mb-3">
                    <div class="w-10 h-10 bg-orange-50 text-[#c99355] rounded-full flex items-center justify-center text-xl shrink-0">
                        <i class="ph ph-headset"></i>
                    </div>
                    <div>
                        <h4 class="font-bold text-sm text-[#0f172a]">Need Help?</h4>
                        <p class="text-xs text-gray-500">Mon – Sat, 9am to 6pm</p>
                    </div>
                </div>
                <a href="{{ url('/contact') }}" class="block text-center w-full bg-[#0f172a] hover:bg-gray-800 text-white text-xs font-bold py-2.5 rounded-md uppercase tracking-widest transition-colors">
                    Contact Support
                </a>
            </div>
        </aside>

        <!-- ===== RIGHT CONTENT AREA ===== -->
        <div class="flex-1 min-w-0">

            <!-- ===== DASHBOARD TAB ===== -->
            <div id="tab-dashboard" class="tab-content active">

                <!-- Welcome Banner -->
                <div class="bg-gradient-to-r from-[#0f172a] to-[#1e293b] rounded-xl p-6 lg:p-8 mb-6 text-white relative overflow-hidden shadow-xl">
                    <div class="absolute inset-0 opacity-10 bg-cover mix-blend-overlay"></div>
                    <div class="absolute top-0 right-0 w-64 h-64 bg-[#c99355]/10 rounded-full blur-3xl"></div>
                    <div class="relative z-10 flex flex-col md:flex-row items-start md:items-center justify-between gap-6">
                        <div>
                            <div class="text-[0.65rem] text-[#c99355] tracking-[0.2em] uppercase font-bold mb-2"><i class="ph ph-hand-waving mr-1"></i> Welcome Back</div>
                            <h1 class="text-2xl lg:text-3xl font-heading font-extrabold tracking-tight mb-1">Good Afternoon, Rajesh!</h1>
                            <p class="text-gray-400 text-sm">You have <span class="text-[#c99355] font-bold">2 orders</span> awaiting delivery. Track them below.</p>
                        </div>
                        <a href="#" onclick="showTab('orders', document.querySelector('[onclick*=orders]')); return false;" class="bg-[#c99355] hover:bg-yellow-600 text-white font-bold text-xs px-6 py-3 rounded-md uppercase tracking-widest transition-colors shadow-lg shadow-yellow-700/20 whitespace-nowrap flex items-center gap-2">
                            <i class="ph ph-package"></i> VIEW ORDERS
                        </a>
                    </div>
                </div>

                <!-- Stats Row -->
                <div class="grid grid-cols-2 lg:grid-cols-4 gap-4 mb-6">
                    <div class="bg-white rounded-xl p-5 border border-gray-200 shadow-sm hover-lift">
                        <div class="flex items-center justify-between mb-3">
                            <div class="w-10 h-10 bg-blue-50 text-blue-600 rounded-full flex items-center justify-center text-xl">
                                <i class="ph ph-package"></i>
                            </div>
                            <span class="text-[0.6rem] text-blue-600 bg-blue-50 font-bold px-2 py-0.5 rounded-full">All Time</span>
                        </div>
                        <div class="text-2xl font-heading font-extrabold text-[#0f172a]">12</div>
                        <div class="text-xs text-gray-500 mt-0.5 uppercase tracking-wide font-medium">Total Orders</div>
                    </div>
                    <div class="bg-white rounded-xl p-5 border border-gray-200 shadow-sm hover-lift">
                        <div class="flex items-center justify-between mb-3">
                            <div class="w-10 h-10 bg-green-50 text-green-600 rounded-full flex items-center justify-center text-xl">
                                <i class="ph ph-check-circle"></i>
                            </div>
                            <span class="text-[0.6rem] text-green-600 bg-green-50 font-bold px-2 py-0.5 rounded-full">Done</span>
                        </div>
                        <div class="text-2xl font-heading font-extrabold text-[#0f172a]">9</div>
                        <div class="text-xs text-gray-500 mt-0.5 uppercase tracking-wide font-medium">Delivered</div>
                    </div>
                    <div class="bg-white rounded-xl p-5 border border-gray-200 shadow-sm hover-lift">
                        <div class="flex items-center justify-between mb-3">
                            <div class="w-10 h-10 bg-orange-50 text-[#c99355] rounded-full flex items-center justify-center text-xl">
                                <i class="ph ph-truck"></i>
                            </div>
                            <span class="text-[0.6rem] text-[#c99355] bg-orange-50 font-bold px-2 py-0.5 rounded-full">Active</span>
                        </div>
                        <div class="text-2xl font-heading font-extrabold text-[#0f172a]">2</div>
                        <div class="text-xs text-gray-500 mt-0.5 uppercase tracking-wide font-medium">In Transit</div>
                    </div>
                    <div class="bg-white rounded-xl p-5 border border-gray-200 shadow-sm hover-lift">
                        <div class="flex items-center justify-between mb-3">
                            <div class="w-10 h-10 bg-red-50 text-red-500 rounded-full flex items-center justify-center text-xl">
                                <i class="ph ph-heart"></i>
                            </div>
                            <span class="text-[0.6rem] text-red-500 bg-red-50 font-bold px-2 py-0.5 rounded-full">Saved</span>
                        </div>
                        <div class="text-2xl font-heading font-extrabold text-[#0f172a]">4</div>
                        <div class="text-xs text-gray-500 mt-0.5 uppercase tracking-wide font-medium">Wishlist Items</div>
                    </div>
                </div>

                <!-- Recent Orders -->
                <div class="bg-white rounded-xl border border-gray-200 shadow-sm mb-6">
                    <div class="px-6 py-4 border-b border-gray-100 flex items-center justify-between">
                        <h3 class="font-heading font-bold text-[#0f172a] text-base uppercase tracking-wider">Recent Orders</h3>
                        <a href="#" onclick="showTab('orders', document.querySelector('[onclick*=orders]')); return false;" class="text-xs text-[#c99355] font-bold hover:underline">View All →</a>
                    </div>
                    <div class="overflow-x-auto">
                        <table class="w-full text-sm">
                            <thead>
                                <tr class="bg-gray-50 border-b border-gray-100">
                                    <th class="text-left text-[0.65rem] font-bold text-gray-400 uppercase tracking-widest px-6 py-3">Order ID</th>
                                    <th class="text-left text-[0.65rem] font-bold text-gray-400 uppercase tracking-widest px-4 py-3">Items</th>
                                    <th class="text-left text-[0.65rem] font-bold text-gray-400 uppercase tracking-widest px-4 py-3">Date</th>
                                    <th class="text-left text-[0.65rem] font-bold text-gray-400 uppercase tracking-widest px-4 py-3">Total</th>
                                    <th class="text-left text-[0.65rem] font-bold text-gray-400 uppercase tracking-widest px-4 py-3">Status</th>
                                    <th class="px-4 py-3"></th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-gray-50">
                                <tr class="hover:bg-gray-50/50 transition-colors">
                                    <td class="px-6 py-4 font-bold text-[#0f172a]">#FM-2408</td>
                                    <td class="px-4 py-4">
                                        <div class="flex items-center gap-2">
                                            <div class="w-10 h-10 bg-gray-100 rounded-md overflow-hidden border border-gray-200 shrink-0">
                                                <img src="https://placehold.co/80x80/e2e8f0/475569?text=Scrub" class="w-full h-full object-cover">
                                            </div>
                                            <div>
                                                <div class="font-semibold text-gray-800">Premium Scrub Set</div>
                                                <div class="text-xs text-gray-400">Navy × 3</div>
                                            </div>
                                        </div>
                                    </td>
                                    <td class="px-4 py-4 text-gray-500">15 Jun 2024</td>
                                    <td class="px-4 py-4 font-bold text-[#0f172a]">₹5,394</td>
                                    <td class="px-4 py-4"><span class="badge-shipped text-[0.65rem] font-bold px-2.5 py-1 rounded-full uppercase tracking-wide">Shipped</span></td>
                                    <td class="px-4 py-4"><button class="text-[#c99355] hover:text-yellow-600 font-bold text-xs uppercase tracking-wider">Track</button></td>
                                </tr>
                                <tr class="hover:bg-gray-50/50 transition-colors">
                                    <td class="px-6 py-4 font-bold text-[#0f172a]">#FM-2391</td>
                                    <td class="px-4 py-4">
                                        <div class="flex items-center gap-2">
                                            <div class="w-10 h-10 bg-gray-100 rounded-md overflow-hidden border border-gray-200 shrink-0">
                                                <img src="https://placehold.co/80x80/e2e8f0/475569?text=Coat" class="w-full h-full object-cover">
                                            </div>
                                            <div>
                                                <div class="font-semibold text-gray-800">Lab Coat (Custom)</div>
                                                <div class="text-xs text-gray-400">White × 5 + Embroidery</div>
                                            </div>
                                        </div>
                                    </td>
                                    <td class="px-4 py-4 text-gray-500">2 Jun 2024</td>
                                    <td class="px-4 py-4 font-bold text-[#0f172a]">₹12,750</td>
                                    <td class="px-4 py-4"><span class="badge-delivered text-[0.65rem] font-bold px-2.5 py-1 rounded-full uppercase tracking-wide">Delivered</span></td>
                                    <td class="px-4 py-4"><button class="text-[#0f172a] hover:text-[#c99355] font-bold text-xs uppercase tracking-wider">Reorder</button></td>
                                </tr>
                                <tr class="hover:bg-gray-50/50 transition-colors">
                                    <td class="px-6 py-4 font-bold text-[#0f172a]">#FM-2374</td>
                                    <td class="px-4 py-4">
                                        <div class="flex items-center gap-2">
                                            <div class="w-10 h-10 bg-gray-100 rounded-md overflow-hidden border border-gray-200 shrink-0">
                                                <img src="https://placehold.co/80x80/e2e8f0/475569?text=Shirt" class="w-full h-full object-cover">
                                            </div>
                                            <div>
                                                <div class="font-semibold text-gray-800">Corporate Formal Shirt</div>
                                                <div class="text-xs text-gray-400">Sky Blue × 10</div>
                                            </div>
                                        </div>
                                    </td>
                                    <td class="px-4 py-4 text-gray-500">18 May 2024</td>
                                    <td class="px-4 py-4 font-bold text-[#0f172a]">₹8,990</td>
                                    <td class="px-4 py-4"><span class="badge-delivered text-[0.65rem] font-bold px-2.5 py-1 rounded-full uppercase tracking-wide">Delivered</span></td>
                                    <td class="px-4 py-4"><button class="text-[#0f172a] hover:text-[#c99355] font-bold text-xs uppercase tracking-wider">Reorder</button></td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>

                <!-- Quick Actions -->
                <div class="grid grid-cols-2 md:grid-cols-4 gap-4">
                    <a href="{{ url('/bulkorder') }}" class="hover-lift bg-white rounded-xl p-5 border border-gray-200 shadow-sm flex flex-col items-center text-center gap-3 group">
                        <div class="w-12 h-12 bg-orange-50 text-[#c99355] rounded-full flex items-center justify-center text-2xl group-hover:bg-[#c99355] group-hover:text-white transition-colors">
                            <i class="ph ph-package-plus"></i>
                        </div>
                        <div>
                            <h4 class="font-bold text-sm text-[#0f172a]">New Bulk Order</h4>
                            <p class="text-xs text-gray-400 mt-0.5">Request B2B quote</p>
                        </div>
                    </a>
                    <a href="{{ url('/customize') }}" class="hover-lift bg-white rounded-xl p-5 border border-gray-200 shadow-sm flex flex-col items-center text-center gap-3 group">
                        <div class="w-12 h-12 bg-blue-50 text-blue-600 rounded-full flex items-center justify-center text-2xl group-hover:bg-blue-600 group-hover:text-white transition-colors">
                            <i class="ph ph-needle"></i>
                        </div>
                        <div>
                            <h4 class="font-bold text-sm text-[#0f172a]">Customize</h4>
                            <p class="text-xs text-gray-400 mt-0.5">Add logo & branding</p>
                        </div>
                    </a>
                    <a href="#" onclick="showTab('addresses', document.querySelector('[onclick*=addresses]')); return false;" class="hover-lift bg-white rounded-xl p-5 border border-gray-200 shadow-sm flex flex-col items-center text-center gap-3 group">
                        <div class="w-12 h-12 bg-green-50 text-green-600 rounded-full flex items-center justify-center text-2xl group-hover:bg-green-600 group-hover:text-white transition-colors">
                            <i class="ph ph-map-pin-plus"></i>
                        </div>
                        <div>
                            <h4 class="font-bold text-sm text-[#0f172a]">Addresses</h4>
                            <p class="text-xs text-gray-400 mt-0.5">Manage delivery points</p>
                        </div>
                    </a>
                    <a href="{{ url('/contact') }}" class="hover-lift bg-white rounded-xl p-5 border border-gray-200 shadow-sm flex flex-col items-center text-center gap-3 group">
                        <div class="w-12 h-12 bg-purple-50 text-purple-600 rounded-full flex items-center justify-center text-2xl group-hover:bg-purple-600 group-hover:text-white transition-colors">
                            <i class="ph ph-headset"></i>
                        </div>
                        <div>
                            <h4 class="font-bold text-sm text-[#0f172a]">Support</h4>
                            <p class="text-xs text-gray-400 mt-0.5">Talk to our team</p>
                        </div>
                    </a>
                </div>
            </div>

            <!-- ===== ORDERS TAB ===== -->
            <div id="tab-orders" class="tab-content">
                <div class="bg-white rounded-xl border border-gray-200 shadow-sm">
                    <div class="px-6 py-4 border-b border-gray-100 flex items-center justify-between flex-wrap gap-3">
                        <h3 class="font-heading font-bold text-[#0f172a] uppercase tracking-wider">All Orders</h3>
                        <div class="flex gap-2">
                            <select class="border border-gray-200 text-sm text-gray-600 px-3 py-2 rounded-md bg-gray-50 focus:outline-none focus:border-[#c99355]">
                                <option>All Status</option>
                                <option>Delivered</option>
                                <option>Shipped</option>
                                <option>Processing</option>
                                <option>Cancelled</option>
                            </select>
                            <input type="text" placeholder="Search order ID…" class="border border-gray-200 text-sm text-gray-600 px-3 py-2 rounded-md bg-gray-50 focus:outline-none focus:border-[#c99355] w-40">
                        </div>
                    </div>
                    <div class="overflow-x-auto">
                        <table class="w-full text-sm">
                            <thead>
                                <tr class="bg-gray-50 border-b border-gray-100">
                                    <th class="text-left text-[0.65rem] font-bold text-gray-400 uppercase tracking-widest px-6 py-3">Order</th>
                                    <th class="text-left text-[0.65rem] font-bold text-gray-400 uppercase tracking-widest px-4 py-3">Items</th>
                                    <th class="text-left text-[0.65rem] font-bold text-gray-400 uppercase tracking-widest px-4 py-3">Date</th>
                                    <th class="text-left text-[0.65rem] font-bold text-gray-400 uppercase tracking-widest px-4 py-3">Total</th>
                                    <th class="text-left text-[0.65rem] font-bold text-gray-400 uppercase tracking-widest px-4 py-3">Status</th>
                                    <th class="px-4 py-3"></th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-gray-50">
                                <tr class="hover:bg-gray-50/50 transition-colors">
                                    <td class="px-6 py-4"><span class="font-bold text-[#0f172a]">#FM-2408</span></td>
                                    <td class="px-4 py-4">
                                        <div class="font-semibold text-gray-800">Premium Scrub Set</div>
                                        <div class="text-xs text-gray-400">Navy × 3</div>
                                    </td>
                                    <td class="px-4 py-4 text-gray-500">15 Jun 2024</td>
                                    <td class="px-4 py-4 font-bold text-[#0f172a]">₹5,394</td>
                                    <td class="px-4 py-4"><span class="badge-shipped text-[0.65rem] font-bold px-2.5 py-1 rounded-full">Shipped</span></td>
                                    <td class="px-4 py-4 flex gap-2">
                                        <button class="text-[#c99355] hover:underline font-bold text-xs">Track</button>
                                        <span class="text-gray-300">|</span>
                                        <button class="text-gray-500 hover:underline font-bold text-xs">Invoice</button>
                                    </td>
                                </tr>
                                <tr class="hover:bg-gray-50/50 transition-colors">
                                    <td class="px-6 py-4"><span class="font-bold text-[#0f172a]">#FM-2391</span></td>
                                    <td class="px-4 py-4">
                                        <div class="font-semibold text-gray-800">Lab Coat (Custom Embroidery)</div>
                                        <div class="text-xs text-gray-400">White × 5</div>
                                    </td>
                                    <td class="px-4 py-4 text-gray-500">2 Jun 2024</td>
                                    <td class="px-4 py-4 font-bold text-[#0f172a]">₹12,750</td>
                                    <td class="px-4 py-4"><span class="badge-delivered text-[0.65rem] font-bold px-2.5 py-1 rounded-full">Delivered</span></td>
                                    <td class="px-4 py-4 flex gap-2">
                                        <button class="text-[#0f172a] hover:text-[#c99355] font-bold text-xs">Reorder</button>
                                        <span class="text-gray-300">|</span>
                                        <button class="text-gray-500 hover:underline font-bold text-xs">Invoice</button>
                                    </td>
                                </tr>
                                <tr class="hover:bg-gray-50/50 transition-colors">
                                    <td class="px-6 py-4"><span class="font-bold text-[#0f172a]">#FM-2374</span></td>
                                    <td class="px-4 py-4">
                                        <div class="font-semibold text-gray-800">Corporate Formal Shirt</div>
                                        <div class="text-xs text-gray-400">Sky Blue × 10</div>
                                    </td>
                                    <td class="px-4 py-4 text-gray-500">18 May 2024</td>
                                    <td class="px-4 py-4 font-bold text-[#0f172a]">₹8,990</td>
                                    <td class="px-4 py-4"><span class="badge-delivered text-[0.65rem] font-bold px-2.5 py-1 rounded-full">Delivered</span></td>
                                    <td class="px-4 py-4 flex gap-2">
                                        <button class="text-[#0f172a] hover:text-[#c99355] font-bold text-xs">Reorder</button>
                                        <span class="text-gray-300">|</span>
                                        <button class="text-gray-500 hover:underline font-bold text-xs">Invoice</button>
                                    </td>
                                </tr>
                                <tr class="hover:bg-gray-50/50 transition-colors">
                                    <td class="px-6 py-4"><span class="font-bold text-[#0f172a]">#FM-2360</span></td>
                                    <td class="px-4 py-4">
                                        <div class="font-semibold text-gray-800">Chef Coat (Bulk)</div>
                                        <div class="text-xs text-gray-400">White × 25</div>
                                    </td>
                                    <td class="px-4 py-4 text-gray-500">5 May 2024</td>
                                    <td class="px-4 py-4 font-bold text-[#0f172a]">₹22,500</td>
                                    <td class="px-4 py-4"><span class="badge-processing text-[0.65rem] font-bold px-2.5 py-1 rounded-full">Processing</span></td>
                                    <td class="px-4 py-4">
                                        <button class="text-gray-500 hover:underline font-bold text-xs">Invoice</button>
                                    </td>
                                </tr>
                                <tr class="hover:bg-gray-50/50 transition-colors">
                                    <td class="px-6 py-4"><span class="font-bold text-[#0f172a]">#FM-2341</span></td>
                                    <td class="px-4 py-4">
                                        <div class="font-semibold text-gray-800">School Shirt (Boys)</div>
                                        <div class="text-xs text-gray-400">White × 50</div>
                                    </td>
                                    <td class="px-4 py-4 text-gray-500">12 Apr 2024</td>
                                    <td class="px-4 py-4 font-bold text-[#0f172a]">₹14,000</td>
                                    <td class="px-4 py-4"><span class="badge-cancelled text-[0.65rem] font-bold px-2.5 py-1 rounded-full">Cancelled</span></td>
                                    <td class="px-4 py-4">
                                        <button class="text-[#0f172a] hover:text-[#c99355] font-bold text-xs">Reorder</button>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>

            <!-- ===== WISHLIST TAB ===== -->
            <div id="tab-wishlist" class="tab-content">
                <div class="bg-white rounded-xl border border-gray-200 shadow-sm p-6">
                    <h3 class="font-heading font-bold text-[#0f172a] text-base uppercase tracking-wider mb-6 border-b border-gray-100 pb-4">My Wishlist</h3>
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <!-- Wishlist Item 1 -->
                        <div class="flex gap-4 border border-gray-200 rounded-xl p-4 hover:shadow-md transition-shadow group">
                            <div class="w-20 h-20 bg-gray-100 rounded-lg overflow-hidden border border-gray-200 shrink-0">
                                <img src="https://placehold.co/160x160/e2e8f0/475569?text=Scrub" class="w-full h-full object-cover mix-blend-multiply">
                            </div>
                            <div class="flex-1 min-w-0">
                                <h4 class="font-bold text-sm text-[#0f172a] truncate">Premium Scrub Top</h4>
                                <p class="text-xs text-gray-500 mb-1">MediQo Collection</p>
                                <p class="text-[#0f172a] font-extrabold">₹899</p>
                                <div class="flex gap-2 mt-3">
                                    <button class="flex-1 bg-[#0f172a] hover:bg-gray-800 text-white text-xs font-bold py-2 rounded-md uppercase tracking-widest transition-colors">Add to Cart</button>
                                    <button class="w-8 h-8 border border-red-200 rounded-md flex items-center justify-center text-red-400 hover:bg-red-50 transition-colors shrink-0">
                                        <i class="ph ph-trash text-sm"></i>
                                    </button>
                                </div>
                            </div>
                        </div>
                        <!-- Wishlist Item 2 -->
                        <div class="flex gap-4 border border-gray-200 rounded-xl p-4 hover:shadow-md transition-shadow group">
                            <div class="w-20 h-20 bg-gray-100 rounded-lg overflow-hidden border border-gray-200 shrink-0">
                                <img src="https://placehold.co/160x160/e2e8f0/475569?text=Coat" class="w-full h-full object-cover mix-blend-multiply">
                            </div>
                            <div class="flex-1 min-w-0">
                                <h4 class="font-bold text-sm text-[#0f172a] truncate">Premium Lab Coat</h4>
                                <p class="text-xs text-gray-500 mb-1">MediQo Collection</p>
                                <p class="text-[#0f172a] font-extrabold">₹1,299</p>
                                <div class="flex gap-2 mt-3">
                                    <button class="flex-1 bg-[#0f172a] hover:bg-gray-800 text-white text-xs font-bold py-2 rounded-md uppercase tracking-widest transition-colors">Add to Cart</button>
                                    <button class="w-8 h-8 border border-red-200 rounded-md flex items-center justify-center text-red-400 hover:bg-red-50 transition-colors shrink-0">
                                        <i class="ph ph-trash text-sm"></i>
                                    </button>
                                </div>
                            </div>
                        </div>
                        <!-- Wishlist Item 3 -->
                        <div class="flex gap-4 border border-gray-200 rounded-xl p-4 hover:shadow-md transition-shadow group">
                            <div class="w-20 h-20 bg-gray-100 rounded-lg overflow-hidden border border-gray-200 shrink-0">
                                <img src="https://placehold.co/160x160/e2e8f0/475569?text=Shirt" class="w-full h-full object-cover mix-blend-multiply">
                            </div>
                            <div class="flex-1 min-w-0">
                                <h4 class="font-bold text-sm text-[#0f172a] truncate">Corporate Polo Shirt</h4>
                                <p class="text-xs text-gray-500 mb-1">Workon Collection</p>
                                <p class="text-[#0f172a] font-extrabold">₹749</p>
                                <div class="flex gap-2 mt-3">
                                    <button class="flex-1 bg-[#0f172a] hover:bg-gray-800 text-white text-xs font-bold py-2 rounded-md uppercase tracking-widest transition-colors">Add to Cart</button>
                                    <button class="w-8 h-8 border border-red-200 rounded-md flex items-center justify-center text-red-400 hover:bg-red-50 transition-colors shrink-0">
                                        <i class="ph ph-trash text-sm"></i>
                                    </button>
                                </div>
                            </div>
                        </div>
                        <!-- Wishlist Item 4 -->
                        <div class="flex gap-4 border border-gray-200 rounded-xl p-4 hover:shadow-md transition-shadow group">
                            <div class="w-20 h-20 bg-gray-100 rounded-lg overflow-hidden border border-gray-200 shrink-0">
                                <img src="https://placehold.co/160x160/e2e8f0/475569?text=Chef" class="w-full h-full object-cover mix-blend-multiply">
                            </div>
                            <div class="flex-1 min-w-0">
                                <h4 class="font-bold text-sm text-[#0f172a] truncate">Executive Chef Coat</h4>
                                <p class="text-xs text-gray-500 mb-1">Hostra Collection</p>
                                <p class="text-[#0f172a] font-extrabold">₹1,099</p>
                                <div class="flex gap-2 mt-3">
                                    <button class="flex-1 bg-[#0f172a] hover:bg-gray-800 text-white text-xs font-bold py-2 rounded-md uppercase tracking-widest transition-colors">Add to Cart</button>
                                    <button class="w-8 h-8 border border-red-200 rounded-md flex items-center justify-center text-red-400 hover:bg-red-50 transition-colors shrink-0">
                                        <i class="ph ph-trash text-sm"></i>
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- ===== ADDRESSES TAB ===== -->
            <div id="tab-addresses" class="tab-content">
                <div class="bg-white rounded-xl border border-gray-200 shadow-sm p-6">
                    <div class="flex items-center justify-between mb-6 border-b border-gray-100 pb-4">
                        <h3 class="font-heading font-bold text-[#0f172a] text-base uppercase tracking-wider">Saved Addresses</h3>
                        <button class="bg-[#c99355] hover:bg-yellow-600 text-white font-bold text-xs px-4 py-2 rounded-md uppercase tracking-widest transition-colors flex items-center gap-2">
                            <i class="ph ph-plus"></i> Add New
                        </button>
                    </div>
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <!-- Address 1 - Default -->
                        <div class="border-2 border-[#c99355] rounded-xl p-5 relative">
                            <span class="absolute top-4 right-4 bg-[#c99355] text-white text-[0.6rem] font-bold px-2 py-0.5 rounded-full uppercase">Default</span>
                            <div class="flex items-start gap-3 mb-4">
                                <div class="w-10 h-10 bg-orange-50 text-[#c99355] rounded-full flex items-center justify-center text-xl shrink-0">
                                    <i class="ph ph-buildings"></i>
                                </div>
                                <div>
                                    <h4 class="font-bold text-sm text-[#0f172a]">Apollo Hospital</h4>
                                    <p class="text-xs text-gray-500 mt-1 leading-relaxed">21 Greams Road, Thousand Lights,<br>Chennai, Tamil Nadu – 600006</p>
                                </div>
                            </div>
                            <div class="flex items-center gap-2 text-xs text-gray-500 mb-4">
                                <i class="ph ph-phone"></i> +91 99949 69811
                            </div>
                            <div class="flex gap-2">
                                <button class="flex-1 border border-gray-300 hover:border-[#0f172a] text-gray-600 hover:text-[#0f172a] text-xs font-bold py-2 rounded-md transition-colors">Edit</button>
                                <button class="flex-1 border border-red-200 hover:border-red-500 text-red-400 hover:text-red-500 text-xs font-bold py-2 rounded-md transition-colors">Remove</button>
                            </div>
                        </div>
                        <!-- Address 2 -->
                        <div class="border border-gray-200 rounded-xl p-5 hover:border-gray-300 transition-colors">
                            <div class="flex items-start gap-3 mb-4">
                                <div class="w-10 h-10 bg-gray-100 text-gray-600 rounded-full flex items-center justify-center text-xl shrink-0">
                                    <i class="ph ph-house"></i>
                                </div>
                                <div>
                                    <h4 class="font-bold text-sm text-[#0f172a]">Rajesh Kumar (Home)</h4>
                                    <p class="text-xs text-gray-500 mt-1 leading-relaxed">45/B Anna Nagar West,<br>Chennai, Tamil Nadu – 600040</p>
                                </div>
                            </div>
                            <div class="flex items-center gap-2 text-xs text-gray-500 mb-4">
                                <i class="ph ph-phone"></i> +91 98765 43210
                            </div>
                            <div class="flex gap-2">
                                <button class="flex-1 border border-gray-300 hover:border-[#0f172a] text-gray-600 hover:text-[#0f172a] text-xs font-bold py-2 rounded-md transition-colors">Set Default</button>
                                <button class="flex-1 border border-gray-300 hover:border-[#0f172a] text-gray-600 hover:text-[#0f172a] text-xs font-bold py-2 rounded-md transition-colors">Edit</button>
                                <button class="border border-red-200 hover:border-red-500 text-red-400 hover:text-red-500 text-xs font-bold px-3 py-2 rounded-md transition-colors"><i class="ph ph-trash"></i></button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- ===== PROFILE TAB ===== -->
            <div id="tab-profile" class="tab-content">
                <div class="bg-white rounded-xl border border-gray-200 shadow-sm p-6 lg:p-8">
                    <h3 class="font-heading font-bold text-[#0f172a] text-base uppercase tracking-wider mb-6 border-b border-gray-100 pb-4">Profile Settings</h3>

                    <!-- Avatar -->
                    <div class="flex items-center gap-6 mb-8 pb-8 border-b border-gray-100">
                        <div class="w-20 h-20 rounded-full bg-[#0f172a] flex items-center justify-center text-[#c99355] text-4xl shrink-0 border-2 border-[#c99355] shadow-md">
                            <i class="ph-fill ph-user-circle"></i>
                        </div>
                        <div>
                            <h4 class="font-bold text-[#0f172a] mb-1">Profile Photo</h4>
                            <p class="text-xs text-gray-500 mb-3">JPG, PNG or GIF (max 5MB)</p>
                            <div class="flex gap-3">
                                <button class="border border-gray-300 hover:border-[#0f172a] text-gray-600 hover:text-[#0f172a] text-xs font-bold px-4 py-2 rounded-md transition-colors flex items-center gap-1">
                                    <i class="ph ph-upload-simple"></i> Upload Photo
                                </button>
                                <button class="text-red-400 hover:text-red-500 text-xs font-bold transition-colors">Remove</button>
                            </div>
                        </div>
                    </div>

                    <form class="space-y-6">
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <div>
                                <label class="block text-xs font-bold text-[#0f172a] mb-1.5 uppercase tracking-wide">First Name *</label>
                                <input type="text" value="Rajesh" class="fm-input">
                            </div>
                            <div>
                                <label class="block text-xs font-bold text-[#0f172a] mb-1.5 uppercase tracking-wide">Last Name *</label>
                                <input type="text" value="Kumar" class="fm-input">
                            </div>
                        </div>
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <div>
                                <label class="block text-xs font-bold text-[#0f172a] mb-1.5 uppercase tracking-wide">Email Address *</label>
                                <input type="email" value="rajesh@hospital.com" class="fm-input">
                            </div>
                            <div>
                                <label class="block text-xs font-bold text-[#0f172a] mb-1.5 uppercase tracking-wide">Phone Number *</label>
                                <input type="tel" value="+91 99949 69811" class="fm-input">
                            </div>
                        </div>
                        <div>
                            <label class="block text-xs font-bold text-[#0f172a] mb-1.5 uppercase tracking-wide">Company / Organization</label>
                            <input type="text" value="Apollo Hospitals" class="fm-input">
                        </div>
                        <div>
                            <label class="block text-xs font-bold text-[#0f172a] mb-1.5 uppercase tracking-wide">GSTIN (Optional)</label>
                            <input type="text" placeholder="Enter GST number for B2B invoices" class="fm-input">
                        </div>
                        <div class="flex items-center justify-end gap-4 pt-4 border-t border-gray-100">
                            <button type="button" class="border border-gray-300 text-gray-600 text-sm font-bold px-6 py-3 rounded-md hover:border-[#0f172a] hover:text-[#0f172a] transition-colors uppercase tracking-widest">Cancel</button>
                            <button type="button" class="bg-[#0f172a] hover:bg-gray-800 text-white font-bold text-sm px-8 py-3 rounded-md transition-colors uppercase tracking-widest shadow-md">Save Changes</button>
                        </div>
                    </form>
                </div>
            </div>

            <!-- ===== CHANGE PASSWORD TAB ===== -->
            <div id="tab-password" class="tab-content">
                <div class="bg-white rounded-xl border border-gray-200 shadow-sm p-6 lg:p-8 max-w-lg">
                    <h3 class="font-heading font-bold text-[#0f172a] text-base uppercase tracking-wider mb-6 border-b border-gray-100 pb-4">Change Password</h3>
                    <form class="space-y-5">
                        <div>
                            <label class="block text-xs font-bold text-[#0f172a] mb-1.5 uppercase tracking-wide">Current Password *</label>
                            <input type="password" class="fm-input" placeholder="••••••••">
                        </div>
                        <div>
                            <label class="block text-xs font-bold text-[#0f172a] mb-1.5 uppercase tracking-wide">New Password *</label>
                            <input type="password" class="fm-input" placeholder="••••••••">
                        </div>
                        <div>
                            <label class="block text-xs font-bold text-[#0f172a] mb-1.5 uppercase tracking-wide">Confirm New Password *</label>
                            <input type="password" class="fm-input" placeholder="••••••••">
                        </div>
                        <div class="bg-blue-50 border border-blue-100 rounded-lg p-4 text-xs text-blue-700">
                            <i class="ph ph-info mr-1"></i> Password must be at least 8 characters with one uppercase letter and one number.
                        </div>
                        <button type="button" class="w-full bg-[#0f172a] hover:bg-gray-800 text-white font-bold text-sm py-3.5 rounded-md transition-colors uppercase tracking-widest shadow-md mt-2">
                            Update Password
                        </button>
                    </form>
                </div>
            </div>

        </div>
        <!-- End Right Content -->

    </div>
</div>

@endsection

@section('scripts')
<script>
    function showTab(tabName, clickedEl) {
        // Hide all tab contents
        document.querySelectorAll('.tab-content').forEach(el => el.classList.remove('active'));
        // Remove active from all sidebar links
        document.querySelectorAll('.sidebar-link').forEach(el => el.classList.remove('active'));
        // Show selected tab
        const tab = document.getElementById('tab-' + tabName);
        if (tab) tab.classList.add('active');
        // Mark clicked link as active
        if (clickedEl) clickedEl.classList.add('active');
    }
</script>
@endsection
