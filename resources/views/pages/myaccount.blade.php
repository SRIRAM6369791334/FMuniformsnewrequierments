<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>My Account | FM Uniforms</title>
    <meta name="description" content="Manage your FM Uniforms account, orders, addresses and profile.">

    <!-- Google Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@400;500;600;700;800&family=Inter:wght@400;500;600&display=swap" rel="stylesheet">

    <!-- Phosphor Icons -->
    <script src="https://unpkg.com/@phosphor-icons/web"></script>

    <!-- Tailwind CSS -->
    <script src="https://cdn.tailwindcss.com"></script>
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    fontFamily: {
                        sans: ['Inter', 'sans-serif'],
                        heading: ['Montserrat', 'sans-serif'],
                    },
                    colors: {
                        brand: {
                            navy: '#0f172a',
                            gold: '#c99355',
                            mediqo: '#145c75',
                            hostra: '#7c1c2b',
                            workon: '#16a34a',
                            scholix: '#2563eb',
                            light: '#f4f5f7',
                            border: '#e2e8f0',
                        }
                    }
                }
            }
        }
    </script>
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
            background: #doc;
            box-shadow: 0 0 0 3px rgba(201,147,85,0.12);
        }
    </style>

    <!-- Local CSS (Moved from source CSS folder to protect other pages) -->
    <link rel="stylesheet" href="{{ asset('myaccount-theme/css/index.css') }}">
    <link rel="stylesheet" href="{{ asset('myaccount-theme/css/responsive.css') }}">
</head>
<body class="bg-[#f4f5f7] font-sans text-gray-800">



    <!-- ===== TOP NAVIGATION (matches index.html exactly) ===== -->

    <div class="max-w-[1400px] mx-auto px-4 lg:px-8 py-4 text-xs text-gray-500">
        <a href="index.html" class="hover:text-brand-gold transition-colors">Home</a>
        <i class="ph ph-caret-right mx-1 text-[10px]"></i>
        <span class="text-brand-gold font-semibold">My Account</span>
    </div>

    <!-- ===== MAIN LAYOUT ===== -->
    <div class="max-w-[1400px] mx-auto px-4 lg:px-8 pb-20">
        <div class="flex flex-col lg:flex-row gap-8">

            <!-- ===== LEFT SIDEBAR ===== -->
            <aside class="lg:w-72 shrink-0">

                <!-- Profile Card -->
                <div class="bg-brand-navy rounded-xl p-6 mb-4 text-white relative overflow-hidden shadow-xl">
                    <div class="absolute top-0 right-0 w-32 h-32 bg-brand-gold/10 rounded-full blur-2xl"></div>
                    <div class="relative z-10 flex items-center gap-4">
                        <div class="w-16 h-16 rounded-full bg-brand-gold/20 border-2 border-brand-gold flex items-center justify-center text-brand-gold text-3xl shrink-0">
                            <i class="ph-fill ph-user-circle"></i>
                        </div>
                        <div>
                            <h2 class="font-heading font-bold text-lg leading-tight">Rajesh Kumar</h2>
                            <p class="text-gray-400 text-xs mt-0.5">rajesh@hospital.com</p>
                            <span class="inline-block mt-2 bg-brand-gold/20 text-brand-gold text-[0.6rem] font-bold px-2 py-0.5 rounded-full uppercase tracking-widest border border-brand-gold/30">MediQo B2B</span>
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
                    <div class="px-4 py-3 border-b border-gray-100 hidden lg:block">
                        <span class="text-[0.6rem] text-gray-400 font-bold uppercase tracking-widest">Account Menu</span>
                    </div>
                    <nav class="p-2 flex flex-row lg:flex-col overflow-x-auto gap-1 lg:space-y-1 scrollbar-none whitespace-nowrap">
                        <a href="#" onclick="showTab('dashboard', this)" class="sidebar-link active flex items-center gap-2 px-3.5 py-2.5 lg:px-4 lg:py-3 rounded-lg text-xs lg:text-sm font-semibold transition-all">
                            <i class="ph ph-squares-four text-lg lg:text-xl text-brand-gold"></i> Dashboard
                        </a>
                        <a href="#" onclick="showTab('orders', this)" class="sidebar-link flex items-center gap-2 px-3.5 py-2.5 lg:px-4 lg:py-3 rounded-lg text-xs lg:text-sm font-semibold text-gray-600 hover:bg-gray-50 transition-all">
                            <i class="ph ph-package text-lg lg:text-xl"></i> My Orders
                            <span class="ml-1 lg:ml-auto bg-brand-gold text-white text-[0.55rem] lg:text-[0.6rem] font-bold px-1.5 py-0.5 rounded-full">12</span>
                        </a>
                        <a href="#" onclick="showTab('wishlist', this)" class="sidebar-link flex items-center gap-2 px-3.5 py-2.5 lg:px-4 lg:py-3 rounded-lg text-xs lg:text-sm font-semibold text-gray-600 hover:bg-gray-50 transition-all">
                            <i class="ph ph-heart text-lg lg:text-xl"></i> Wishlist
                            <span class="ml-1 lg:ml-auto bg-gray-200 text-gray-600 text-[0.55rem] lg:text-[0.6rem] font-bold px-1.5 py-0.5 rounded-full">4</span>
                        </a>
                        <a href="#" onclick="showTab('addresses', this)" class="sidebar-link flex items-center gap-2 px-3.5 py-2.5 lg:px-4 lg:py-3 rounded-lg text-xs lg:text-sm font-semibold text-gray-600 hover:bg-gray-50 transition-all">
                            <i class="ph ph-map-pin text-lg lg:text-xl"></i> Addresses
                        </a>
                        <a href="#" onclick="showTab('profile', this)" class="sidebar-link flex items-center gap-2 px-3.5 py-2.5 lg:px-4 lg:py-3 rounded-lg text-xs lg:text-sm font-semibold text-gray-600 hover:bg-gray-50 transition-all">
                            <i class="ph ph-user-gear text-lg lg:text-xl"></i> Profile Settings
                        </a>
                        <a href="#" onclick="showTab('password', this)" class="sidebar-link flex items-center gap-2 px-3.5 py-2.5 lg:px-4 lg:py-3 rounded-lg text-xs lg:text-sm font-semibold text-gray-600 hover:bg-gray-50 transition-all">
                            <i class="ph ph-lock-key text-lg lg:text-xl"></i> Change Password
                        </a>
                        <div class="border-l lg:border-l-0 lg:border-t border-gray-100 pl-1 lg:pl-0 lg:mt-1 lg:pt-1">
                            <a href="login-register.html" class="flex items-center gap-2 px-3.5 py-2.5 lg:px-4 lg:py-3 rounded-lg text-xs lg:text-sm font-semibold text-red-500 hover:bg-red-50 transition-all">
                                <i class="ph ph-sign-out text-lg lg:text-xl"></i> Logout
                            </a>
                        </div>
                    </nav>
                </div>

                <!-- Help Card -->
                <div class="bg-white rounded-xl border border-gray-200 p-5 mt-4 shadow-sm hidden lg:block">
                    <div class="flex items-center gap-3 mb-3">
                        <div class="w-10 h-10 bg-orange-50 text-brand-gold rounded-full flex items-center justify-center text-xl shrink-0">
                            <i class="ph ph-headset"></i>
                        </div>
                        <div>
                            <h4 class="font-bold text-sm text-brand-navy">Need Help?</h4>
                            <p class="text-xs text-gray-500">Mon – Sat, 9am to 6pm</p>
                        </div>
                    </div>
                    <a href="contact.html" class="block text-center w-full bg-brand-navy hover:bg-gray-800 text-white text-xs font-bold py-2.5 rounded-md uppercase tracking-widest transition-colors">
                        Contact Support
                    </a>
                </div>
            </aside>

            <!-- ===== RIGHT CONTENT AREA ===== -->
            <div class="flex-1 min-w-0">

                <!-- ===== DASHBOARD TAB ===== -->
                <div id="tab-dashboard" class="tab-content active">

                    <!-- Welcome Banner -->
                    <div class="bg-gradient-to-r from-brand-navy to-[#1e293b] rounded-xl p-6 lg:p-8 mb-6 text-white relative overflow-hidden shadow-xl">
                        <div class="absolute inset-0 bg-[url('https://placehold.co/1200x300/0f172a/0f172a?text=Pattern')] opacity-10 bg-cover mix-blend-overlay"></div>
                        <div class="absolute top-0 right-0 w-64 h-64 bg-brand-gold/10 rounded-full blur-3xl"></div>
                        <div class="relative z-10 flex flex-col md:flex-row items-start md:items-center justify-between gap-6">
                            <div>
                                <div class="text-[0.65rem] text-brand-gold tracking-[0.2em] uppercase font-bold mb-2"><i class="ph ph-hand-waving mr-1"></i> Welcome Back</div>
                                <h1 class="text-2xl lg:text-3xl font-heading font-extrabold tracking-tight mb-1">Good Afternoon, Rajesh!</h1>
                                <p class="text-gray-400 text-sm">You have <span class="text-brand-gold font-bold">2 orders</span> awaiting delivery. Track them below.</p>
                            </div>
                            <a href="#" onclick="showTab('orders', document.querySelector('[onclick*=orders]'))" class="bg-brand-gold hover:bg-yellow-600 text-white font-bold text-xs px-6 py-3 rounded-md uppercase tracking-widest transition-colors shadow-lg shadow-yellow-700/20 whitespace-nowrap flex items-center gap-2">
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
                            <div class="text-2xl font-heading font-extrabold text-brand-navy">12</div>
                            <div class="text-xs text-gray-500 mt-0.5 uppercase tracking-wide font-medium">Total Orders</div>
                        </div>
                        <div class="bg-white rounded-xl p-5 border border-gray-200 shadow-sm hover-lift">
                            <div class="flex items-center justify-between mb-3">
                                <div class="w-10 h-10 bg-green-50 text-green-600 rounded-full flex items-center justify-center text-xl">
                                    <i class="ph ph-check-circle"></i>
                                </div>
                                <span class="text-[0.6rem] text-green-600 bg-green-50 font-bold px-2 py-0.5 rounded-full">Done</span>
                            </div>
                            <div class="text-2xl font-heading font-extrabold text-brand-navy">9</div>
                            <div class="text-xs text-gray-500 mt-0.5 uppercase tracking-wide font-medium">Delivered</div>
                        </div>
                        <div class="bg-white rounded-xl p-5 border border-gray-200 shadow-sm hover-lift">
                            <div class="flex items-center justify-between mb-3">
                                <div class="w-10 h-10 bg-orange-50 text-brand-gold rounded-full flex items-center justify-center text-xl">
                                    <i class="ph ph-truck"></i>
                                </div>
                                <span class="text-[0.6rem] text-brand-gold bg-orange-50 font-bold px-2 py-0.5 rounded-full">Active</span>
                            </div>
                            <div class="text-2xl font-heading font-extrabold text-brand-navy">2</div>
                            <div class="text-xs text-gray-500 mt-0.5 uppercase tracking-wide font-medium">In Transit</div>
                        </div>
                        <div class="bg-white rounded-xl p-5 border border-gray-200 shadow-sm hover-lift">
                            <div class="flex items-center justify-between mb-3">
                                <div class="w-10 h-10 bg-red-50 text-red-500 rounded-full flex items-center justify-center text-xl">
                                    <i class="ph ph-heart"></i>
                                </div>
                                <span class="text-[0.6rem] text-red-500 bg-red-50 font-bold px-2 py-0.5 rounded-full">Saved</span>
                            </div>
                            <div class="text-2xl font-heading font-extrabold text-brand-navy">4</div>
                            <div class="text-xs text-gray-500 mt-0.5 uppercase tracking-wide font-medium">Wishlist Items</div>
                        </div>
                    </div>

                    <!-- Recent Orders -->
                    <div class="bg-white rounded-xl border border-gray-200 shadow-sm mb-6">
                        <div class="px-6 py-4 border-b border-gray-100 flex items-center justify-between">
                            <h3 class="font-heading font-bold text-brand-navy text-base uppercase tracking-wider">Recent Orders</h3>
                            <a href="#" onclick="showTab('orders', document.querySelector('[onclick*=orders]'))" class="text-xs text-brand-gold font-bold hover:underline">View All →</a>
                        </div>
                        <div class="overflow-x-auto scrollbar-none">
                            <table class="w-full min-w-[800px] text-sm table-responsive">
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
                                        <td class="px-6 py-4 font-bold text-brand-navy">#FM-2408</td>
                                        <td class="px-4 py-4 col-items">
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
                                        <td class="px-4 py-4 font-bold text-brand-navy">₹5,394</td>
                                        <td class="px-4 py-4">
                                            <span class="badge-shipped text-[0.65rem] font-bold px-2.5 py-1 rounded-full uppercase tracking-wide">Shipped</span>
                                        </td>
                                        <td class="px-4 py-4">
                                            <button onclick="showInvoice('#FM-2408')" class="text-brand-gold hover:text-yellow-600 font-bold text-xs uppercase tracking-wider">Track</button>
                                        </td>
                                    </tr>
                                    <tr class="hover:bg-gray-50/50 transition-colors">
                                        <td class="px-6 py-4 font-bold text-brand-navy">#FM-2391</td>
                                        <td class="px-4 py-4 col-items">
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
                                        <td class="px-4 py-4 font-bold text-brand-navy">₹12,750</td>
                                        <td class="px-4 py-4">
                                            <span class="badge-delivered text-[0.65rem] font-bold px-2.5 py-1 rounded-full uppercase tracking-wide">Delivered</span>
                                        </td>
                                        <td class="px-4 py-4">
                                            <button class="text-brand-navy hover:text-brand-gold font-bold text-xs uppercase tracking-wider">Reorder</button>
                                        </td>
                                    </tr>
                                    <tr class="hover:bg-gray-50/50 transition-colors">
                                        <td class="px-6 py-4 font-bold text-brand-navy">#FM-2374</td>
                                        <td class="px-4 py-4 col-items">
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
                                        <td class="px-4 py-4 font-bold text-brand-navy">₹8,990</td>
                                        <td class="px-4 py-4">
                                            <span class="badge-delivered text-[0.65rem] font-bold px-2.5 py-1 rounded-full uppercase tracking-wide">Delivered</span>
                                        </td>
                                        <td class="px-4 py-4">
                                            <button class="text-brand-navy hover:text-brand-gold font-bold text-xs uppercase tracking-wider">Reorder</button>
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>

                    <!-- Quick Actions -->
                    <div class="grid grid-cols-2 md:grid-cols-4 gap-4">
                        <a href="bulk-order.html" class="hover-lift bg-white rounded-xl p-5 border border-gray-200 shadow-sm flex flex-col items-center text-center gap-3 group">
                            <div class="w-12 h-12 bg-orange-50 text-brand-gold rounded-full flex items-center justify-center text-2xl group-hover:bg-brand-gold group-hover:text-white transition-colors">
                                <i class="ph ph-package-plus"></i>
                            </div>
                            <div>
                                <h4 class="font-bold text-sm text-brand-navy">New Bulk Order</h4>
                                <p class="text-xs text-gray-400 mt-0.5">Request B2B quote</p>
                            </div>
                        </a>
                        <a href="customize-corporate.html" class="hover-lift bg-white rounded-xl p-5 border border-gray-200 shadow-sm flex flex-col items-center text-center gap-3 group">
                            <div class="w-12 h-12 bg-blue-50 text-blue-600 rounded-full flex items-center justify-center text-2xl group-hover:bg-blue-600 group-hover:text-white transition-colors">
                                <i class="ph ph-needle"></i>
                            </div>
                            <div>
                                <h4 class="font-bold text-sm text-brand-navy">Customize</h4>
                                <p class="text-xs text-gray-400 mt-0.5">Add logo & branding</p>
                            </div>
                        </a>
                        <a href="#" onclick="showTab('addresses', document.querySelector('[onclick*=addresses]'))" class="hover-lift bg-white rounded-xl p-5 border border-gray-200 shadow-sm flex flex-col items-center text-center gap-3 group">
                            <div class="w-12 h-12 bg-green-50 text-green-600 rounded-full flex items-center justify-center text-2xl group-hover:bg-green-600 group-hover:text-white transition-colors">
                                <i class="ph ph-map-pin-plus"></i>
                            </div>
                            <div>
                                <h4 class="font-bold text-sm text-brand-navy">Addresses</h4>
                                <p class="text-xs text-gray-400 mt-0.5">Manage delivery points</p>
                            </div>
                        </a>
                        <a href="contact.html" class="hover-lift bg-white rounded-xl p-5 border border-gray-200 shadow-sm flex flex-col items-center text-center gap-3 group">
                            <div class="w-12 h-12 bg-purple-50 text-purple-600 rounded-full flex items-center justify-center text-2xl group-hover:bg-purple-600 group-hover:text-white transition-colors">
                                <i class="ph ph-headset"></i>
                            </div>
                            <div>
                                <h4 class="font-bold text-sm text-brand-navy">Support</h4>
                                <p class="text-xs text-gray-400 mt-0.5">Talk to our team</p>
                            </div>
                        </a>
                    </div>
                </div>

                <!-- ===== ORDERS TAB ===== -->
                <div id="tab-orders" class="tab-content">
                    <div class="bg-white rounded-xl border border-gray-200 shadow-sm">
                        <div class="px-6 py-4 border-b border-gray-100 flex items-center justify-between flex-wrap gap-3">
                            <h3 class="font-heading font-bold text-brand-navy uppercase tracking-wider">All Orders</h3>
                            <div class="flex gap-2">
                                <select class="border border-gray-200 text-sm text-gray-600 px-3 py-2 rounded-md bg-gray-50 focus:outline-none focus:border-brand-gold">
                                    <option>All Status</option>
                                    <option>Delivered</option>
                                    <option>Shipped</option>
                                    <option>Processing</option>
                                    <option>Cancelled</option>
                                </select>
                                <input type="text" placeholder="Search order ID…" class="border border-gray-200 text-sm text-gray-600 px-3 py-2 rounded-md bg-gray-50 focus:outline-none focus:border-brand-gold w-40">
                            </div>
                        </div>
                        <div class="overflow-x-auto scrollbar-none">
                            <table class="w-full min-w-[800px] text-sm table-responsive">
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
                                    <!-- Order Row 1 -->
                                    <tr class="hover:bg-gray-50/50 transition-colors">
                                        <td class="px-6 py-4"><span class="font-bold text-brand-navy">#FM-2408</span></td>
                                        <td class="px-4 py-4 col-items">
                                            <div class="font-semibold text-gray-800">Premium Scrub Set</div>
                                            <div class="text-xs text-gray-400">Navy × 3</div>
                                        </td>
                                        <td class="px-4 py-4 text-gray-500">15 Jun 2024</td>
                                        <td class="px-4 py-4 font-bold text-brand-navy">₹5,394</td>
                                        <td class="px-4 py-4"><span class="badge-shipped text-[0.65rem] font-bold px-2.5 py-1 rounded-full">Shipped</span></td>
                                        <td class="px-4 py-4 flex gap-2">
                                            <button onclick="showInvoice('#FM-2408')" class="text-brand-gold hover:underline font-bold text-xs">Track</button>
                                            <span class="text-gray-300">|</span>
                                            <button onclick="showInvoice('#FM-2408')" class="text-gray-500 hover:underline font-bold text-xs">Invoice</button>
                                        </td>
                                    </tr>
                                    <!-- Order Row 2 -->
                                    <tr class="hover:bg-gray-50/50 transition-colors">
                                        <td class="px-6 py-4"><span class="font-bold text-brand-navy">#FM-2391</span></td>
                                        <td class="px-4 py-4 col-items">
                                            <div class="font-semibold text-gray-800">Lab Coat (Custom Embroidery)</div>
                                            <div class="text-xs text-gray-400">White × 5</div>
                                        </td>
                                        <td class="px-4 py-4 text-gray-500">2 Jun 2024</td>
                                        <td class="px-4 py-4 font-bold text-brand-navy">₹12,750</td>
                                        <td class="px-4 py-4"><span class="badge-delivered text-[0.65rem] font-bold px-2.5 py-1 rounded-full">Delivered</span></td>
                                        <td class="px-4 py-4 flex gap-2">
                                            <button class="text-brand-navy hover:text-brand-gold font-bold text-xs">Reorder</button>
                                            <span class="text-gray-300">|</span>
                                            <button onclick="showInvoice('#FM-2391')" class="text-gray-500 hover:underline font-bold text-xs">Invoice</button>
                                        </td>
                                    </tr>
                                    <!-- Order Row 3 -->
                                    <tr class="hover:bg-gray-50/50 transition-colors">
                                        <td class="px-6 py-4"><span class="font-bold text-brand-navy">#FM-2374</span></td>
                                        <td class="px-4 py-4 col-items">
                                            <div class="font-semibold text-gray-800">Corporate Formal Shirt</div>
                                            <div class="text-xs text-gray-400">Sky Blue × 10</div>
                                        </td>
                                        <td class="px-4 py-4 text-gray-500">18 May 2024</td>
                                        <td class="px-4 py-4 font-bold text-brand-navy">₹8,990</td>
                                        <td class="px-4 py-4"><span class="badge-delivered text-[0.65rem] font-bold px-2.5 py-1 rounded-full">Delivered</span></td>
                                        <td class="px-4 py-4 flex gap-2">
                                            <button class="text-brand-navy hover:text-brand-gold font-bold text-xs">Reorder</button>
                                            <span class="text-gray-300">|</span>
                                            <button onclick="showInvoice('#FM-2374')" class="text-gray-500 hover:underline font-bold text-xs">Invoice</button>
                                        </td>
                                    </tr>
                                    <!-- Order Row 4 -->
                                    <tr class="hover:bg-gray-50/50 transition-colors">
                                        <td class="px-6 py-4"><span class="font-bold text-brand-navy">#FM-2360</span></td>
                                        <td class="px-4 py-4 col-items">
                                            <div class="font-semibold text-gray-800">Chef Coat (Bulk)</div>
                                            <div class="text-xs text-gray-400">White × 25</div>
                                        </td>
                                        <td class="px-4 py-4 text-gray-500">5 May 2024</td>
                                        <td class="px-4 py-4 font-bold text-brand-navy">₹22,500</td>
                                        <td class="px-4 py-4"><span class="badge-processing text-[0.65rem] font-bold px-2.5 py-1 rounded-full">Processing</span></td>
                                        <td class="px-4 py-4">
                                            <button onclick="showInvoice('#FM-2360')" class="text-gray-500 hover:underline font-bold text-xs">Invoice</button>
                                        </td>
                                    </tr>
                                    <!-- Order Row 5 -->
                                    <tr class="hover:bg-gray-50/50 transition-colors">
                                        <td class="px-6 py-4"><span class="font-bold text-brand-navy">#FM-2341</span></td>
                                        <td class="px-4 py-4 col-items">
                                            <div class="font-semibold text-gray-800">School Shirt (Boys)</div>
                                            <div class="text-xs text-gray-400">White × 50</div>
                                        </td>
                                        <td class="px-4 py-4 text-gray-500">12 Apr 2024</td>
                                        <td class="px-4 py-4 font-bold text-brand-navy">₹14,000</td>
                                        <td class="px-4 py-4"><span class="badge-cancelled text-[0.65rem] font-bold px-2.5 py-1 rounded-full">Cancelled</span></td>
                                        <td class="px-4 py-4">
                                            <button class="text-brand-navy hover:text-brand-gold font-bold text-xs">Reorder</button>
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
                        <h3 class="font-heading font-bold text-brand-navy text-base uppercase tracking-wider mb-6 border-b border-gray-100 pb-4">My Wishlist</h3>
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                            <!-- Wishlist Item 1 -->
                            <div class="flex gap-4 border border-gray-200 rounded-xl p-4 hover:shadow-md transition-shadow group">
                                <div class="w-20 h-20 bg-gray-100 rounded-lg overflow-hidden border border-gray-200 shrink-0">
                                    <img src="https://placehold.co/160x160/e2e8f0/475569?text=Scrub" class="w-full h-full object-cover mix-blend-multiply">
                                </div>
                                <div class="flex-1 min-w-0">
                                    <h4 class="font-bold text-sm text-brand-navy truncate">Premium Scrub Top</h4>
                                    <p class="text-xs text-gray-500 mb-1">MediQo Collection</p>
                                    <p class="text-brand-navy font-extrabold">₹899</p>
                                    <div class="flex gap-2 mt-3">
                                        <button class="flex-1 bg-brand-navy hover:bg-gray-800 text-white text-xs font-bold py-2 rounded-md uppercase tracking-widest transition-colors">Add to Cart</button>
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
                                    <h4 class="font-bold text-sm text-brand-navy truncate">Premium Lab Coat</h4>
                                    <p class="text-xs text-gray-500 mb-1">MediQo Collection</p>
                                    <p class="text-brand-navy font-extrabold">₹1,299</p>
                                    <div class="flex gap-2 mt-3">
                                        <button class="flex-1 bg-brand-navy hover:bg-gray-800 text-white text-xs font-bold py-2 rounded-md uppercase tracking-widest transition-colors">Add to Cart</button>
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
                                    <h4 class="font-bold text-sm text-brand-navy truncate">Corporate Polo Shirt</h4>
                                    <p class="text-xs text-gray-500 mb-1">Workon Collection</p>
                                    <p class="text-brand-navy font-extrabold">₹749</p>
                                    <div class="flex gap-2 mt-3">
                                        <button class="flex-1 bg-brand-navy hover:bg-gray-800 text-white text-xs font-bold py-2 rounded-md uppercase tracking-widest transition-colors">Add to Cart</button>
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
                                    <h4 class="font-bold text-sm text-brand-navy truncate">Executive Chef Coat</h4>
                                    <p class="text-xs text-gray-500 mb-1">Hostra Collection</p>
                                    <p class="text-brand-navy font-extrabold">₹1,099</p>
                                    <div class="flex gap-2 mt-3">
                                        <button class="flex-1 bg-brand-navy hover:bg-gray-800 text-white text-xs font-bold py-2 rounded-md uppercase tracking-widest transition-colors">Add to Cart</button>
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
                    <div class="bg-white rounded-xl border border-gray-200 shadow-sm p-4 sm:p-6">
                        <!-- Saved Addresses View -->
                        <div id="saved-addresses-container">
                            <div class="flex items-center justify-between mb-6 border-b border-gray-100 pb-4">
                                <h3 class="font-heading font-bold text-brand-navy text-base uppercase tracking-wider">Saved Addresses</h3>
                                <button onclick="showAddressForm('add')" class="bg-brand-gold hover:bg-yellow-600 text-white font-bold text-xs px-4 py-2 rounded-md uppercase tracking-widest transition-colors flex items-center gap-2">
                                    <i class="ph ph-plus"></i> Add New
                                </button>
                            </div>
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                <!-- Address 1 -->
                                <div class="border-2 border-brand-gold rounded-xl p-5 relative">
                                    <span class="absolute top-4 right-4 bg-brand-gold text-white text-[0.6rem] font-bold px-2 py-0.5 rounded-full uppercase">Default</span>
                                    <div class="flex items-start gap-3 mb-4">
                                        <div class="w-10 h-10 bg-orange-50 text-brand-gold rounded-full flex items-center justify-center text-xl shrink-0">
                                            <i class="ph ph-buildings"></i>
                                        </div>
                                        <div>
                                            <h4 class="font-bold text-sm text-brand-navy">Apollo Hospital</h4>
                                            <p class="text-xs text-gray-500 mt-1 leading-relaxed">21 Greams Road, Thousand Lights,<br>Chennai, Tamil Nadu – 600006</p>
                                        </div>
                                    </div>
                                    <div class="flex items-center gap-2 text-xs text-gray-500 mb-4">
                                        <i class="ph ph-phone"></i> +91 99949 69811
                                    </div>
                                    <div class="flex gap-2">
                                        <button onclick="showAddressForm('edit', 'Apollo Hospital', '21 Greams Road, Thousand Lights', 'Chennai', 'Tamil Nadu', '600006', '+91 99949 69811', '1')" class="flex-1 border border-gray-300 hover:border-brand-navy text-gray-600 hover:text-brand-navy text-xs font-bold py-2 rounded-md transition-colors">Edit</button>
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
                                            <h4 class="font-bold text-sm text-brand-navy">Rajesh Kumar (Home)</h4>
                                            <p class="text-xs text-gray-500 mt-1 leading-relaxed">45/B Anna Nagar West,<br>Chennai, Tamil Nadu – 600040</p>
                                        </div>
                                    </div>
                                    <div class="flex items-center gap-2 text-xs text-gray-500 mb-4">
                                        <i class="ph ph-phone"></i> +91 98765 43210
                                    </div>
                                    <div class="flex gap-2">
                                        <button class="flex-1 border border-gray-300 hover:border-brand-navy text-gray-600 hover:text-brand-navy text-xs font-bold py-2 rounded-md transition-colors">Set Default</button>
                                        <button onclick="showAddressForm('edit', 'Rajesh Kumar (Home)', '45/B Anna Nagar West', 'Chennai', 'Tamil Nadu', '600040', '+91 98765 43210', '2')" class="flex-1 border border-gray-300 hover:border-brand-navy text-gray-600 hover:text-brand-navy text-xs font-bold py-2 rounded-md transition-colors">Edit</button>
                                        <button class="border border-red-200 hover:border-red-500 text-red-400 hover:text-red-500 text-xs font-bold px-3 py-2 rounded-md transition-colors"><i class="ph ph-trash"></i></button>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Address Form Container (Add / Edit Address) -->
                        <div id="address-form-container" class="hidden">
                            <h3 id="address-form-title" class="font-heading font-bold text-brand-navy text-base uppercase tracking-wider mb-6 border-b border-gray-100 pb-4">Add New Address</h3>
                            <form class="space-y-6">
                                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                                    <div>
                                        <label class="block text-xs font-bold text-brand-navy mb-1.5 uppercase tracking-wide">First Name *</label>
                                        <input type="text" id="address_first_name" placeholder="John" class="fm-input">
                                    </div>
                                    <div>
                                        <label class="block text-xs font-bold text-brand-navy mb-1.5 uppercase tracking-wide">Last Name *</label>
                                        <input type="text" id="address_last_name" placeholder="Doe" class="fm-input">
                                    </div>
                                </div>
                                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                                    <div>
                                        <label class="block text-xs font-bold text-brand-navy mb-1.5 uppercase tracking-wide">Phone Number *</label>
                                        <input type="tel" id="address_phone" placeholder="9876543210" class="fm-input">
                                    </div>
                                    <div>
                                        <label class="block text-xs font-bold text-brand-navy mb-1.5 uppercase tracking-wide">Address Type *</label>
                                        <select id="address_type" class="fm-input bg-gray-50 focus:bg-white">
                                            <option value="1">Billing Address</option>
                                            <option value="2">Shipping Address</option>
                                        </select>
                                    </div>
                                </div>
                                <div>
                                    <label class="block text-xs font-bold text-brand-navy mb-1.5 uppercase tracking-wide">Address Line 1 *</label>
                                    <textarea id="address_line_one" rows="2" placeholder="Street Address, P.O. box, company name" class="fm-input"></textarea>
                                </div>
                                <div>
                                    <label class="block text-xs font-bold text-brand-navy mb-1.5 uppercase tracking-wide">Address Line 2 (Optional)</label>
                                    <textarea id="address_line_two" rows="2" placeholder="Apartment, suite, unit, building, floor, etc." class="fm-input"></textarea>
                                </div>
                                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                                    <div>
                                        <label class="block text-xs font-bold text-brand-navy mb-1.5 uppercase tracking-wide">Landmark (Optional)</label>
                                        <input type="text" id="address_landmark" placeholder="e.g. near Apollo Hospital" class="fm-input">
                                    </div>
                                    <div>
                                        <label class="block text-xs font-bold text-brand-navy mb-1.5 uppercase tracking-wide">Area / Locality</label>
                                        <input type="text" id="address_area" placeholder="e.g. Thousand Lights" class="fm-input">
                                    </div>
                                </div>
                                <div class="grid grid-cols-1 md:grid-cols-4 gap-6">
                                    <div class="md:col-span-2">
                                        <label class="block text-xs font-bold text-brand-navy mb-1.5 uppercase tracking-wide">City *</label>
                                        <input type="text" id="address_city" placeholder="Chennai" class="fm-input">
                                    </div>
                                    <div>
                                        <label class="block text-xs font-bold text-brand-navy mb-1.5 uppercase tracking-wide">State *</label>
                                        <input type="text" id="address_state" placeholder="Tamil Nadu" class="fm-input">
                                    </div>
                                    <div>
                                        <label class="block text-xs font-bold text-brand-navy mb-1.5 uppercase tracking-wide">Pincode *</label>
                                        <input type="text" id="address_pincode" placeholder="600006" class="fm-input">
                                    </div>
                                </div>
                                <div class="flex flex-col-reverse sm:flex-row items-stretch sm:items-center justify-end gap-3 pt-4 border-t border-gray-100">
                                    <button type="button" onclick="hideAddressForm()" class="w-full sm:w-auto border border-gray-300 text-gray-600 text-sm font-bold px-6 py-3 rounded-md hover:border-brand-navy hover:text-brand-navy transition-colors uppercase tracking-widest text-center">Cancel</button>
                                    <button type="button" onclick="hideAddressForm()" class="w-full sm:w-auto bg-brand-navy hover:bg-gray-800 text-white font-bold text-sm px-8 py-3 rounded-md transition-colors uppercase tracking-widest shadow-md text-center">Save Address</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>

                <div id="tab-profile" class="tab-content">
                    <div class="bg-white rounded-xl border border-gray-200 shadow-sm p-4 sm:p-6 lg:p-8">
                        <h3 class="font-heading font-bold text-brand-navy text-base uppercase tracking-wider mb-6 border-b border-gray-100 pb-4">Profile Settings</h3>
                        


                        <form class="space-y-6">
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                                <div>
                                    <label class="block text-xs font-bold text-brand-navy mb-1.5 uppercase tracking-wide">First Name *</label>
                                    <input type="text" value="Rajesh" class="fm-input">
                                </div>
                                <div>
                                    <label class="block text-xs font-bold text-brand-navy mb-1.5 uppercase tracking-wide">Last Name *</label>
                                    <input type="text" value="Kumar" class="fm-input">
                                </div>
                            </div>
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                                <div>
                                    <label class="block text-xs font-bold text-brand-navy mb-1.5 uppercase tracking-wide">Email Address *</label>
                                    <input type="email" value="rajesh@hospital.com" class="fm-input">
                                </div>
                                <div>
                                    <label class="block text-xs font-bold text-brand-navy mb-1.5 uppercase tracking-wide">Phone Number *</label>
                                    <input type="tel" value="+91 99949 69811" class="fm-input">
                                </div>
                            </div>
                            <div>
                                <label class="block text-xs font-bold text-brand-navy mb-1.5 uppercase tracking-wide">Company / Organization</label>
                                <input type="text" value="Apollo Hospitals" class="fm-input">
                            </div>
                            <div>
                                <label class="block text-xs font-bold text-brand-navy mb-1.5 uppercase tracking-wide">GSTIN (Optional)</label>
                                <input type="text" placeholder="Enter GST number for B2B invoices" class="fm-input">
                            </div>
                            <div class="flex flex-col-reverse sm:flex-row items-stretch sm:items-center justify-end gap-3 pt-4 border-t border-gray-100">
                                <button type="button" class="w-full sm:w-auto border border-gray-300 text-gray-600 text-sm font-bold px-6 py-3 rounded-md hover:border-brand-navy hover:text-brand-navy transition-colors uppercase tracking-widest text-center">Cancel</button>
                                <button type="button" class="w-full sm:w-auto bg-brand-navy hover:bg-gray-800 text-white font-bold text-sm px-8 py-3 rounded-md transition-colors uppercase tracking-widest shadow-md text-center">Save Changes</button>
                            </div>
                        </form>
                    </div>
                </div>

                <!-- ===== CHANGE PASSWORD TAB ===== -->
                <div id="tab-password" class="tab-content">
                    <div class="bg-white rounded-xl border border-gray-200 shadow-sm p-4 sm:p-6 lg:p-8 max-w-lg">
                        <h3 class="font-heading font-bold text-brand-navy text-base uppercase tracking-wider mb-6 border-b border-gray-100 pb-4">Change Password</h3>
                        <form class="space-y-5">
                            <div>
                                <label class="block text-xs font-bold text-brand-navy mb-1.5 uppercase tracking-wide">Current Password *</label>
                                <input type="password" class="fm-input" placeholder="••••••••">
                            </div>
                            <div>
                                <label class="block text-xs font-bold text-brand-navy mb-1.5 uppercase tracking-wide">New Password *</label>
                                <input type="password" class="fm-input" placeholder="••••••••">
                            </div>
                            <div>
                                <label class="block text-xs font-bold text-brand-navy mb-1.5 uppercase tracking-wide">Confirm New Password *</label>
                                <input type="password" class="fm-input" placeholder="••••••••">
                            </div>
                            <div class="bg-blue-50 border border-blue-100 rounded-lg p-4 text-xs text-blue-700">
                                <i class="ph ph-info mr-1"></i> Password must be at least 8 characters with one uppercase letter and one number.
                            </div>
                            <button type="button" class="w-full bg-brand-navy hover:bg-gray-800 text-white font-bold text-sm py-3.5 rounded-md transition-colors uppercase tracking-widest shadow-md mt-2">
                                Update Password
                            </button>
                        </form>
                    </div>
                </div>

            </div>
            <!-- End Right Content -->

        </div>
    </div>

    <!-- ===== FULL PREMIUM FOOTER (matches index.html) ===== -->
    <div id="fm-footer"></div>

    <!-- ===== TAB SWITCHING SCRIPT ===== -->
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
            // Prevent default navigation
            if (window.event) window.event.preventDefault();
        }
    </script>
    <!-- Common Components -->
    <script src="{{ asset('myaccount-theme/js/components/header.js') }}"></script>
    <script src="{{ asset('myaccount-theme/js/components/footer.js') }}"></script>
    <!-- Global Header JS -->
    <script>
        document.addEventListener('DOMContentLoaded', () => {
            // Mobile Menu
            const btn = document.getElementById('mobile-menu-btn');
            const closeBtn = document.getElementById('mobile-close-btn');
            const menu = document.getElementById('mobile-menu');
            if (btn && menu) {
                btn.addEventListener('click', () => menu.classList.remove('hidden'));
                if (closeBtn) closeBtn.addEventListener('click', () => menu.classList.add('hidden'));
            }
            
            // Active Brand Highlight (Using custom colors)
            const path = window.location.pathname;
            const links = document.querySelectorAll('.nav-brand-link');
            links.forEach(link => {
                const brand = link.getAttribute('data-brand');
                const color = link.getAttribute('data-color');
                if (brand && path.includes(brand)) {
                    link.style.color = color;
                    link.style.borderColor = color;
                }
            });

            // Hide strip/search based on page
            const hideStripPages = ['index.html', 'about.html', 'contact.html', 'myaccount.html', 'bulk-order.html'];
            const isHidePage = hideStripPages.some(p => path.includes(p));
            if(isHidePage) {
                const strip = document.getElementById('brand-strip');
                const search = document.getElementById('global-search');
                if(strip) strip.style.display = 'none';
                if(search) search.style.visibility = 'hidden';
            }
        });
    </script>

    <!-- ===== INVOICE DETAIL MODAL ===== -->
    <div id="invoice-modal" class="fixed inset-0 z-[100] bg-black/60 backdrop-blur-sm hidden flex items-center justify-center p-4 animate-fade-in">
        <div id="invoice-modal-content" class="bg-white rounded-2xl premium-shadow max-w-4xl w-full max-h-[90vh] overflow-y-auto relative animate-slide-up">
            
            <!-- Gold Gradient Accent Line at the Top -->
            <div class="h-2 w-full gold-gradient-bar no-print"></div>

            <!-- Sticky Modal Control Bar (Hidden on Print) -->
            <div class="sticky top-0 bg-white/95 backdrop-blur-md border-b border-gray-100 px-6 py-4 flex items-center justify-between no-print z-20">
                <div class="flex items-center gap-2">
                    <span class="w-2.5 h-2.5 rounded-full bg-brand-gold"></span>
                    <span class="font-heading font-bold text-brand-navy text-sm uppercase tracking-widest">Tax Invoice Detail</span>
                </div>
                <div class="flex items-center gap-3">
                    <button onclick="printInvoice()" class="bg-brand-navy hover:bg-gray-800 text-white font-bold text-xs px-5 py-2.5 rounded-lg uppercase tracking-widest flex items-center gap-2 transition-all hover:scale-105 active:scale-95 shadow-md shadow-slate-900/10">
                        <i class="ph ph-printer text-base"></i> Print Invoice
                    </button>
                    <button onclick="hideInvoice()" class="w-8 h-8 rounded-full bg-gray-100 hover:bg-gray-200 flex items-center justify-center text-gray-500 hover:text-gray-800 transition-colors">
                        <i class="ph ph-x text-lg"></i>
                    </button>
                </div>
            </div>

            <!-- Tax Invoice Document Area -->
            <div class="p-5 md:p-8 lg:p-12 relative" id="invoice-document">
                <!-- Watermark Background Logo -->
                <div class="absolute inset-0 flex items-center justify-center pointer-events-none opacity-[0.02]">
                    <div class="text-[18rem] font-bold font-heading select-none">FM</div>
                </div>

                <!-- Header: Logo & Title -->
                <div class="relative z-10 flex flex-col md:flex-row justify-between items-start md:items-center gap-6 border-b border-gray-200 pb-8 mb-8">
                    <!-- Brand Logo -->
                    <div class="flex items-center gap-2">
                        <div class="text-brand-navy text-5xl font-bold font-heading tracking-tighter leading-none">FM</div>
                        <div class="flex flex-col justify-center mt-1">
                            <span class="text-brand-navy text-2xl font-bold font-heading leading-none tracking-widest">UNIFORMS</span>
                            <span class="text-[0.55rem] tracking-[0.18em] text-gray-400 mt-1 font-semibold uppercase">One Brand. Every Professional.</span>
                        </div>
                    </div>
                    <!-- Tax Invoice Label & Details -->
                    <div class="text-right">
                        <span class="inline-block bg-green-50 text-green-700 text-[0.65rem] font-bold px-3 py-1 rounded-full uppercase tracking-wider mb-2 border border-green-200/50"><i class="ph ph-check-circle mr-1 align-middle"></i> Paid</span>
                        <h1 class="text-3xl font-heading font-extrabold text-brand-navy tracking-tight uppercase">TAX INVOICE</h1>
                        <p class="text-xs text-gray-500 mt-1">FM Uniforms Pvt. Ltd.<br>12 Corporate Hub, GST Road, Chennai - 600032</p>
                    </div>
                </div>

                <!-- Details Panel (3 Cards) -->
                <div class="relative z-10 grid grid-cols-1 md:grid-cols-3 gap-6 mb-8">
                    <div class="bg-[#f8fafc] border border-gray-100 p-5 rounded-xl">
                        <span class="block text-[0.65rem] font-bold text-gray-400 uppercase tracking-widest mb-2 flex items-center gap-1"><i class="ph ph-info text-xs"></i> Invoice Info</span>
                        <div class="text-sm text-gray-700 space-y-1">
                            <div>Invoice No: <span class="font-bold text-brand-navy">INV-2024-2408</span></div>
                            <div>Date: <span class="font-semibold text-gray-900">15 Jun 2024</span></div>
                            <div>Order ID: <span id="invoice-order-id" class="font-semibold text-gray-900">#FM-2408</span></div>
                            <div>Payment: <span class="font-semibold text-gray-900">NEFT / B2B Portal</span></div>
                        </div>
                    </div>
                    <div class="bg-[#f8fafc] border border-gray-100 p-5 rounded-xl">
                        <span class="block text-[0.65rem] font-bold text-gray-400 uppercase tracking-widest mb-2 flex items-center gap-1"><i class="ph ph-buildings text-xs"></i> Billed To</span>
                        <div class="text-sm text-gray-700 space-y-0.5">
                            <div class="font-bold text-gray-900">Apollo Hospitals Group</div>
                            <div>GSTIN: <span class="font-semibold text-brand-navy">33AAAAA1111A1Z1</span></div>
                            <div class="text-xs text-gray-500 leading-normal">21 Greams Road, Thousand Lights, Chennai, TN - 600006</div>
                        </div>
                    </div>
                    <div class="bg-[#f8fafc] border border-gray-100 p-5 rounded-xl">
                        <span class="block text-[0.65rem] font-bold text-gray-400 uppercase tracking-widest mb-2 flex items-center gap-1"><i class="ph ph-truck text-xs"></i> Shipped To</span>
                        <div class="text-sm text-gray-700 space-y-0.5">
                            <div class="font-bold text-gray-900">Central Pharmacy (Store-A)</div>
                            <div class="text-xs text-gray-500 leading-normal">Apollo Hospital Compound, Chennai, TN - 600006</div>
                            <div class="text-xs font-semibold text-gray-600 mt-1">Phone: +91 99949 69811</div>
                        </div>
                    </div>
                </div>

                <!-- Invoice Table -->
                <div class="relative z-10 border border-gray-200 rounded-xl overflow-x-auto mb-8 scrollbar-none">
                    <table class="w-full min-w-[650px] text-left text-sm">
                        <thead>
                            <tr class="bg-brand-navy text-white text-[0.65rem] font-bold uppercase tracking-widest border-b border-brand-navy">
                                <th class="px-6 py-4">Item & Description</th>
                                <th class="px-4 py-4 text-center">Collection</th>
                                <th class="px-4 py-4 text-center">Qty</th>
                                <th class="px-4 py-4 text-right">Unit Price</th>
                                <th class="px-4 py-4 text-right">GST (18%)</th>
                                <th class="px-6 py-4 text-right">Total Amount</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-100 text-gray-700">
                            <tr class="hover:bg-slate-50/50 transition-colors">
                                <td class="px-6 py-5">
                                    <span class="font-bold text-brand-navy block">Premium Scrub Set (Navy Blue)</span>
                                    <span class="text-xs text-gray-400 block mt-0.5">Sizes: Medium × 2, Large × 1</span>
                                </td>
                                <td class="px-4 py-5 text-center">
                                    <span class="inline-block bg-sky-50 text-[#145c75] text-[0.6rem] font-bold px-2 py-0.5 rounded-full uppercase tracking-wider border border-sky-100">MediQo</span>
                                </td>
                                <td class="px-4 py-5 text-center font-semibold text-gray-900">3</td>
                                <td class="px-4 py-5 text-right font-medium">₹1,525.42</td>
                                <td class="px-4 py-5 text-right font-medium">₹274.58</td>
                                <td class="px-6 py-5 text-right font-bold text-brand-navy">₹5,394.00</td>
                            </tr>
                            <tr class="hover:bg-slate-50/50 transition-colors">
                                <td class="px-6 py-5">
                                    <span class="font-bold text-brand-navy block">Embroidery Customization</span>
                                    <span class="text-xs text-gray-400 block mt-0.5">Left chest logo stitching for Apollo Hospitals</span>
                                </td>
                                <td class="px-4 py-5 text-center">
                                    <span class="inline-block bg-amber-50 text-[#c99355] text-[0.6rem] font-bold px-2 py-0.5 rounded-full uppercase tracking-wider border border-amber-100">Custom</span>
                                </td>
                                <td class="px-4 py-5 text-center font-semibold text-gray-900">3</td>
                                <td class="px-4 py-5 text-right font-medium">₹0.00</td>
                                <td class="px-4 py-5 text-right font-medium">₹0.00</td>
                                <td class="px-6 py-5 text-right font-semibold text-green-600 uppercase text-xs tracking-wider">FREE</td>
                            </tr>
                        </tbody>
                    </table>
                </div>

                <!-- Summary Totals -->
                <div class="relative z-10 flex flex-col md:flex-row justify-between gap-8 text-sm">
                    <div class="max-w-md">
                        <span class="block text-[0.65rem] font-bold text-gray-400 uppercase tracking-widest mb-2 flex items-center gap-1"><i class="ph ph-file-text text-xs"></i> Terms & Notes</span>
                        <p class="text-xs text-gray-500 leading-relaxed bg-[#f8fafc] border border-gray-100 p-4 rounded-xl">
                            Invoice generated automatically by FM Uniforms B2B portal. 18% GST (9% CGST and 9% SGST) has been applied to applicable categories. Goods once sold can only be exchanged within 7 days of delivery under unused conditions.
                        </p>
                    </div>
                    <div class="w-full md:w-80 shrink-0 bg-[#0f172a] rounded-2xl text-white p-6 relative overflow-hidden shadow-lg shadow-slate-900/20">
                        <!-- Design Accent Circles Inside Card -->
                        <div class="absolute -right-8 -top-8 w-24 h-24 bg-brand-gold/10 rounded-full blur-xl"></div>
                        <div class="absolute -left-8 -bottom-8 w-24 h-24 bg-brand-gold/10 rounded-full blur-xl"></div>
                        
                        <div class="relative z-10 space-y-2.5">
                            <div class="flex justify-between text-xs text-gray-400">
                                <span>Subtotal (Excl. GST):</span>
                                <span class="font-medium text-white">₹4,576.26</span>
                            </div>
                            <div class="flex justify-between text-xs text-gray-400">
                                <span>CGST (9%):</span>
                                <span class="font-medium text-white">₹408.87</span>
                            </div>
                            <div class="flex justify-between text-xs text-gray-400">
                                <span>SGST (9%):</span>
                                <span class="font-medium text-white">₹408.87</span>
                            </div>
                            <div class="flex justify-between text-xs text-gray-400">
                                <span>Shipping & Handling:</span>
                                <span class="text-green-400 font-bold uppercase text-[10px] tracking-wider">FREE</span>
                            </div>
                            <div class="h-[1px] bg-slate-800 my-2"></div>
                            <div class="flex justify-between items-baseline pt-2">
                                <span class="text-sm font-bold text-gray-300">Grand Total:</span>
                                <span class="text-2xl font-heading font-black text-brand-gold">₹5,394.00</span>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Footer Signatures -->
                <div class="relative z-10 flex justify-between items-end mt-12 pt-8 border-t border-gray-100">
                    <div class="text-[10px] text-gray-400 max-w-sm leading-normal">
                        * This is a computer-generated tax invoice and requires no physical seal or signature.
                    </div>
                    <div class="text-center w-48 border-t border-gray-200 pt-3">
                        <span class="block font-bold text-brand-navy text-xs uppercase tracking-wider">Authorized Signatory</span>
                        <span class="text-[10px] text-gray-400 mt-1 block">FM Uniforms Pvt. Ltd.</span>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- ===== JS FORM & MODAL CONTROLS ===== -->
    <script>
        function showAddressForm(mode, name = '', street = '', city = '', state = '', pincode = '', phone = '', type = '1') {
            document.getElementById('saved-addresses-container').classList.add('hidden');
            document.getElementById('address-form-container').classList.remove('hidden');
            
            const titleEl = document.getElementById('address-form-title');
            if (mode === 'add') {
                titleEl.textContent = 'Add New Address';
                document.getElementById('address_first_name').value = '';
                document.getElementById('address_last_name').value = '';
                document.getElementById('address_phone').value = '';
                document.getElementById('address_line_one').value = '';
                document.getElementById('address_line_two').value = '';
                document.getElementById('address_landmark').value = '';
                document.getElementById('address_area').value = '';
                document.getElementById('address_city').value = '';
                document.getElementById('address_state').value = '';
                document.getElementById('address_pincode').value = '';
                document.getElementById('address_type').value = '1';
            } else {
                titleEl.textContent = 'Edit Address';
                const nameParts = name.split(' ');
                document.getElementById('address_first_name').value = nameParts[0] || '';
                document.getElementById('address_last_name').value = nameParts.slice(1).join(' ') || '';
                document.getElementById('address_phone').value = phone;
                document.getElementById('address_line_one').value = street;
                document.getElementById('address_line_two').value = '';
                document.getElementById('address_landmark').value = '';
                document.getElementById('address_area').value = '';
                document.getElementById('address_city').value = city;
                document.getElementById('address_state').value = state;
                document.getElementById('address_pincode').value = pincode;
                document.getElementById('address_type').value = type;
            }
        }
        
        function hideAddressForm() {
            document.getElementById('address-form-container').classList.add('hidden');
            document.getElementById('saved-addresses-container').classList.remove('hidden');
        }
        
        function showInvoice(orderId) {
            document.getElementById('invoice-order-id').textContent = orderId;
            document.getElementById('invoice-modal').classList.remove('hidden');
            document.getElementById('invoice-modal').classList.add('flex');
            document.body.style.overflow = 'hidden';
        }
        
        function hideInvoice() {
            document.getElementById('invoice-modal').classList.add('hidden');
            document.getElementById('invoice-modal').classList.remove('flex');
            document.body.style.overflow = '';
        }
        
        function printInvoice() {
            window.print();
        }
    </script>

    <!-- Local JS (Moved from source JS folder to protect other pages) -->
    <script src="{{ asset('myaccount-theme/js/index.js') }}"></script>
    <script src="{{ asset('myaccount-theme/js/main.js') }}"></script>
</body>
</html>
