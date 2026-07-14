<header class="w-full font-sans shadow-sm z-50 relative">
    <!-- Top Row (Navy Blue) -->
    <div class="bg-[#0f172a] text-white py-3 px-4 lg:px-8">
        <div class="max-w-[1600px] mx-auto flex items-center justify-between gap-6">
            
            <!-- Logo Area -->
            <a href="{{ url('/') }}" class="flex items-center gap-2 shrink-0">
                <div class="text-4xl font-bold font-heading tracking-tighter leading-none hover:text-[#d99a5b] transition-colors">FM</div>
                <div class="flex flex-col justify-center mt-1">
                    <span class="text-xl font-bold font-heading leading-none tracking-widest">UNIFORMS</span>
                    <span class="text-[0.55rem] tracking-[0.18em] text-gray-300 mt-1 font-semibold uppercase">One Brand. Every Professional.</span>
                </div>
            </a>

            <!-- Search Bar -->
            <div class="hidden md:flex flex-1 max-w-2xl relative" id="global-search">
                <form method="GET" action="{{ route('shop') }}" class="w-full">
                    <input type="text" name="search" placeholder="Search for products, categories or brands..." 
                           class="w-full text-sm text-gray-800 py-2.5 pl-4 pr-10 rounded-sm focus:outline-none focus:ring-2 focus:ring-[#d99a5b]"
                           value="{{ request('search') }}">
                    <button type="submit" class="absolute right-3 top-1/2 -translate-y-1/2">
                        <i class="ph ph-magnifying-glass text-gray-500 text-lg cursor-pointer"></i>
                    </button>
                </form>
            </div>

            <!-- Right Actions -->
            <div class="flex items-center gap-6 shrink-0">
                <!-- Bulk Order -->
                <a href="{{ url('/bulkorder') }}" class="hidden lg:flex items-center gap-2 hover:text-[#d99a5b] transition-colors">
                    <i class="ph ph-briefcase text-2xl"></i>
                    <div class="flex flex-col text-xs">
                        <span class="font-bold text-sm">Bulk Order</span>
                        <span class="text-gray-400">Get Quote</span>
                    </div>
                </a>
                
                <!-- My Account -->
                <a href="{{ url('/account') }}" class="hidden lg:flex items-center gap-2 hover:text-[#d99a5b] transition-colors">
                    <i class="ph ph-user text-2xl"></i>
                    <div class="flex flex-col text-xs">
                        <span class="font-bold text-sm">My Account</span>
                        <span class="text-gray-400">Login / Register</span>
                    </div>
                </a>
                
                <!-- Wishlist -->
                <a href="{{ url('/wishlist') }}" class="hover:text-[#d99a5b] transition-colors relative flex items-center">
                    <i class="ph ph-heart text-2xl"></i>
                </a>

                <!-- Cart -->
                <a href="{{ url('/cart') }}" class="hover:text-[#d99a5b] transition-colors relative flex items-center">
                    <i class="ph ph-shopping-cart text-2xl"></i>
                </a>

                <!-- Mobile Menu Toggle -->
                <button class="md:hidden ml-2" id="mobile-menu-btn"><i class="ph ph-list text-2xl"></i></button>
            </div>
            
        </div>
    </div>

    <!-- Bottom Row (White) -->
    <div class="bg-white border-b border-gray-200" id="brand-strip">
        <div class="max-w-[1600px] mx-auto px-4 lg:px-8 flex items-center justify-between overflow-x-auto hide-scrollbar">
            
            <!-- Navigation Links -->
            <nav class="flex items-center gap-8 text-sm font-bold text-gray-700 whitespace-nowrap" id="nav-brand-links">
                <a href="{{ url('/') }}" class="py-4 border-b-[3px] border-transparent hover:text-[#d99a5b] transition-colors">Home</a>
                <a href="{{ url('/categories') }}" class="py-4 border-b-[3px] border-transparent hover:text-[#d99a5b] transition-colors nav-brand-link" data-brand="categories" data-color="#d99a5b">Categories</a>
                <a href="{{ url('/shop') }}" class="py-4 border-b-[3px] border-transparent hover:text-[#d99a5b] transition-colors">Shop</a>
                <a href="{{ url('/customize') }}" class="py-4 border-b-[3px] border-transparent hover:text-[#d99a5b] transition-colors">Customize</a>
                <a href="{{ url('/bulkorder') }}" class="py-4 border-b-[3px] border-transparent hover:text-[#d99a5b] transition-colors">Bulk Orders</a>
                <a href="{{ url('/blog') }}" class="py-4 border-b-[3px] border-transparent hover:text-[#d99a5b] transition-colors">Blog</a>
                <a href="{{ url('/about') }}" class="py-4 border-b-[3px] border-transparent hover:text-[#d99a5b] transition-colors">About Us</a>
                <a href="{{ url('/contact') }}" class="py-4 border-b-[3px] border-transparent hover:text-[#d99a5b] transition-colors">Contact Us</a>
            </nav>

            <!-- Get Bulk Quote Button -->
            <a href="{{ url('/bulkorder') }}" class="hidden lg:inline-block bg-[#d99a5b] hover:bg-[#c48a4d] text-white font-bold text-xs px-6 py-2.5 uppercase tracking-wide rounded-sm transition-colors shrink-0">
                GET BULK QUOTE
            </a>
            
        </div>
    </div>

    <!-- Mobile Menu Overlay -->
    <div id="mobile-menu" class="hidden fixed inset-0 bg-[#0f172a] z-[60] overflow-y-auto pt-20 px-6">
        <button id="mobile-close-btn" class="absolute top-6 right-6 text-white hover:text-[#d99a5b]"><i class="ph ph-x text-3xl"></i></button>
        <div class="flex flex-col gap-6 text-white text-lg font-heading font-bold">
            <a href="{{ url('/') }}" class="border-b border-gray-800 pb-3">Home</a>
            <a href="{{ url('/categories') }}" class="text-[#d99a5b] border-b border-gray-800 pb-3">Categories</a>
            <a href="{{ url('/shop') }}" class="border-b border-gray-800 pb-3">Ready Designs</a>
            <a href="{{ url('/customize') }}" class="border-b border-gray-800 pb-3">Customize</a>
            <a href="{{ url('/bulkorder') }}" class="border-b border-gray-800 pb-3">Bulk Orders</a>
            <a href="{{ url('/blog') }}" class="border-b border-gray-800 pb-3">Blog</a>
            <a href="{{ url('/about') }}" class="border-b border-gray-800 pb-3">About Us</a>
            <a href="{{ url('/contact') }}" class="border-b border-gray-800 pb-3">Contact Us</a>
            <a href="{{ url('/account') }}" class="border-b border-gray-800 pb-3">My Account</a>
        </div>
    </div>
</header>

<script>
    document.addEventListener('DOMContentLoaded', () => {
        // Mobile Menu Toggle
        const btn = document.getElementById('mobile-menu-btn');
        const closeBtn = document.getElementById('mobile-close-btn');
        const menu = document.getElementById('mobile-menu');
        if (btn && menu) {
            btn.addEventListener('click', () => menu.classList.remove('hidden'));
            if (closeBtn) closeBtn.addEventListener('click', () => menu.classList.add('hidden'));
        }
        
        // Active Brand Highlight
        const path = window.location.pathname;
        const links = document.querySelectorAll('.nav-brand-link');
        links.forEach(link => {
            const brand = link.getAttribute('data-brand');
            const color = link.getAttribute('data-color');
            if (brand && (path.includes(brand) || (brand === 'categories' && path.includes('categories')))) {
                link.style.color = color;
                link.style.borderColor = color;
            }
        });
    });
</script>

