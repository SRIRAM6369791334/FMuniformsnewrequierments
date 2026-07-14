@extends('layouts.app')

@section('content')
    <!-- Main Content -->
    <section class="max-w-[1200px] mx-auto px-4 py-16 lg:py-20 relative z-20">
        
        <div class="flex flex-col lg:flex-row gap-12 lg:gap-16">
            
            <!-- Left: Features List -->
            <div class="lg:w-1/2 pt-6">
                <h2 class="text-2xl font-heading font-extrabold text-brand-navy mb-8">Why Partner with FM Uniforms?</h2>
                
                <div class="space-y-8">
                    <div class="flex items-start gap-4">
                        <div class="w-12 h-12 rounded-full bg-brand-gold/10 text-brand-gold flex items-center justify-center text-2xl shrink-0 border border-brand-gold/20">
                            <i class="ph-fill ph-factory"></i>
                        </div>
                        <div>
                            <h3 class="font-bold text-brand-navy mb-1 text-lg">Direct from Manufacturer</h3>
                            <p class="text-sm text-gray-600">Cut out the middleman. We manufacture 100% of our garments in our own ISO-certified factory, ensuring unmatched quality control and aggressive pricing.</p>
                        </div>
                    </div>

                    <div class="flex items-start gap-4">
                        <div class="w-12 h-12 rounded-full bg-brand-gold/10 text-brand-gold flex items-center justify-center text-2xl shrink-0 border border-brand-gold/20">
                            <i class="ph-fill ph-users"></i>
                        </div>
                        <div>
                            <h3 class="font-bold text-brand-navy mb-1 text-lg">Dedicated Account Manager</h3>
                            <p class="text-sm text-gray-600">Get a single point of contact who understands your brand guidelines, handles your inventory planning, and coordinates swift deliveries.</p>
                        </div>
                    </div>

                    <div class="flex items-start gap-4">
                        <div class="w-12 h-12 rounded-full bg-brand-gold/10 text-brand-gold flex items-center justify-center text-2xl shrink-0 border border-brand-gold/20">
                            <i class="ph-fill ph-t-shirt"></i>
                        </div>
                        <div>
                            <h3 class="font-bold text-brand-navy mb-1 text-lg">Sizing Camps & Fit Assurance</h3>
                            <p class="text-sm text-gray-600">For large teams (100+ employees), we conduct on-site physical sizing camps to ensure every team member gets the perfect fit before production begins.</p>
                        </div>
                    </div>

                    <div class="flex items-start gap-4">
                        <div class="w-12 h-12 rounded-full bg-brand-gold/10 text-brand-gold flex items-center justify-center text-2xl shrink-0 border border-brand-gold/20">
                            <i class="ph-fill ph-storefront"></i>
                        </div>
                        <div>
                            <h3 class="font-bold text-brand-navy mb-1 text-lg">Custom Web Portals</h3>
                            <p class="text-sm text-gray-600">For hospitals and schools, we build custom e-commerce landing pages allowing your employees/parents to order approved uniform kits directly.</p>
                        </div>
                    </div>
                </div>

            </div>

            <!-- Right: Bulk Order Form -->
            <div class="lg:w-1/2">
                <div class="bg-white p-8 lg:p-10 rounded-xl shadow-[0_20px_50px_rgba(15,23,42,0.1)] border border-gray-100 relative overflow-hidden">
                    <!-- Accent Line -->
                    <div class="absolute top-0 left-0 right-0 h-1.5 bg-brand-gold"></div>
                    
                    <div class="text-center mb-8">
                        <h3 class="text-2xl font-heading font-extrabold text-brand-navy mb-2 tracking-tight">Request a Bulk Quote</h3>
                        <p class="text-sm text-gray-500">Fill out the details below and our institutional sales team will contact you.</p>
                    </div>

                    <form class="space-y-5" action="{{ url('/bulkorder') }}" method="POST">
                        @csrf
                        <!-- Organization Details -->
                        <div class="space-y-4">
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                <div>
                                    <label class="block text-xs font-bold text-brand-navy mb-1.5 uppercase tracking-wide">First Name</label>
                                    <input type="text" name="first_name" class="w-full border border-gray-300 px-4 py-3 text-sm rounded-md focus:outline-none focus:border-brand-gold focus:ring-1 focus:ring-brand-gold bg-gray-50 focus:bg-white transition-colors" required>
                                </div>
                                <div>
                                    <label class="block text-xs font-bold text-brand-navy mb-1.5 uppercase tracking-wide">Last Name</label>
                                    <input type="text" name="last_name" class="w-full border border-gray-300 px-4 py-3 text-sm rounded-md focus:outline-none focus:border-brand-gold focus:ring-1 focus:ring-brand-gold bg-gray-50 focus:bg-white transition-colors" required>
                                </div>
                            </div>

                            <div>
                                <label class="block text-xs font-bold text-brand-navy mb-1.5 uppercase tracking-wide">Organization / Company Name *</label>
                                <input type="text" name="company_name" class="w-full border border-gray-300 px-4 py-3 text-sm rounded-md focus:outline-none focus:border-brand-gold focus:ring-1 focus:ring-brand-gold bg-gray-50 focus:bg-white transition-colors" required>
                            </div>

                            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                <div>
                                    <label class="block text-xs font-bold text-brand-navy mb-1.5 uppercase tracking-wide">Official Email *</label>
                                    <input type="email" name="email" class="w-full border border-gray-300 px-4 py-3 text-sm rounded-md focus:outline-none focus:border-brand-gold focus:ring-1 focus:ring-brand-gold bg-gray-50 focus:bg-white transition-colors" required>
                                </div>
                                <div>
                                    <label class="block text-xs font-bold text-brand-navy mb-1.5 uppercase tracking-wide">Phone Number *</label>
                                    <input type="tel" name="phone" class="w-full border border-gray-300 px-4 py-3 text-sm rounded-md focus:outline-none focus:border-brand-gold focus:ring-1 focus:ring-brand-gold bg-gray-50 focus:bg-white transition-colors" required>
                                </div>
                            </div>
                        </div>

                        <hr class="border-gray-200">

                        <!-- Requirement Details -->
                        <div class="space-y-4">
                            <div>
                                <label class="block text-xs font-bold text-brand-navy mb-1.5 uppercase tracking-wide">Industry Type *</label>
                                <div class="grid grid-cols-2 gap-3">
                                    <label class="border border-gray-200 rounded-md p-3 flex items-center cursor-pointer hover:bg-gray-50 transition-colors">
                                        <input type="radio" name="industry" value="Healthcare" class="text-brand-gold focus:ring-brand-gold mr-3">
                                        <span class="text-sm font-medium text-brand-navy">Healthcare (MediQo)</span>
                                    </label>
                                    <label class="border border-gray-200 rounded-md p-3 flex items-center cursor-pointer hover:bg-gray-50 transition-colors">
                                        <input type="radio" name="industry" value="Hospitality" class="text-brand-gold focus:ring-brand-gold mr-3">
                                        <span class="text-sm font-medium text-brand-navy">Hospitality (Hostra)</span>
                                    </label>
                                    <label class="border border-gray-200 rounded-md p-3 flex items-center cursor-pointer hover:bg-gray-50 transition-colors">
                                        <input type="radio" name="industry" value="Corporate" class="text-brand-gold focus:ring-brand-gold mr-3">
                                        <span class="text-sm font-medium text-brand-navy">Corporate (Workon)</span>
                                    </label>
                                    <label class="border border-gray-200 rounded-md p-3 flex items-center cursor-pointer hover:bg-gray-50 transition-colors">
                                        <input type="radio" name="industry" value="School" class="text-brand-gold focus:ring-brand-gold mr-3">
                                        <span class="text-sm font-medium text-brand-navy">School (Scholix)</span>
                                    </label>
                                </div>
                            </div>

                            <div>
                                <label class="block text-xs font-bold text-brand-navy mb-1.5 uppercase tracking-wide">Estimated Quantity *</label>
                                <select name="quantity" class="w-full border border-gray-300 px-4 py-3 text-sm rounded-md focus:outline-none focus:border-brand-gold focus:ring-1 focus:ring-brand-gold bg-gray-50 focus:bg-white transition-colors" required>
                                    <option value="" disabled selected>Select quantity range</option>
                                    <option value="50 - 100 sets">50 - 100 sets</option>
                                    <option value="101 - 500 sets">101 - 500 sets</option>
                                    <option value="501 - 1000 sets">501 - 1000 sets</option>
                                    <option value="1000+ sets">1000+ sets</option>
                                </select>
                            </div>

                            <div>
                                <label class="block text-xs font-bold text-brand-navy mb-1.5 uppercase tracking-wide">Briefly describe your requirements</label>
                                <textarea name="description" rows="3" class="w-full border border-gray-350 px-4 py-3 text-sm rounded-md focus:outline-none focus:border-brand-gold focus:ring-1 focus:ring-brand-gold bg-gray-50 focus:bg-white transition-colors" placeholder="E.g., Need 200 sets of navy blue scrubs with hospital logo embroidered on left chest."></textarea>
                            </div>
                        </div>

                        <button type="submit" class="w-full bg-brand-gold hover:bg-yellow-600 text-white font-bold text-sm px-4 py-4 rounded-md transition-all uppercase tracking-widest mt-6 shadow-[0_10px_20px_rgba(201,147,85,0.2)] hover:shadow-[0_5px_10px_rgba(201,147,85,0.2)] hover:translate-y-[2px]">
                            SUBMIT ENQUIRY
                        </button>
                    </form>
                </div>
            </div>

        </div>
    </section>
@endsection