@extends('layouts.app')

@section('content')
    <div class="bg-white border-b border-gray-200 pt-16 pb-12">
        <div class="max-w-[1200px] mx-auto px-4 text-center">
            <span class="text-brand-gold text-xs font-bold uppercase tracking-widest mb-3 block"><i class="ph ph-headset mr-1"></i> We're here to help</span>
            <h1 class="text-4xl lg:text-5xl font-heading font-extrabold text-brand-navy mb-4 tracking-tight">Contact Our Team</h1>
            <p class="text-gray-550 max-w-2xl mx-auto">Have a question about sizing, customization, or corporate orders? Reach out to us and our support team will get back to you within 24 hours.</p>
        </div>
    </div>

    <!-- Contact Section -->
    <section class="max-w-[1200px] mx-auto px-4 py-16">
        <div class="flex flex-col lg:flex-row gap-12 lg:gap-20">
            
            <!-- Left Info Panel -->
            <div class="lg:w-1/3">
                
                <h2 class="text-2xl font-heading font-bold text-brand-navy mb-8">Get In Touch</h2>
                
                <!-- Contact Cards -->
                <div class="space-y-6">
                    <div class="bg-white border border-gray-200 p-6 rounded-xl flex items-start gap-4 shadow-sm hover:shadow-md transition-shadow">
                        <div class="w-12 h-12 bg-orange-50 text-brand-gold rounded-full flex items-center justify-center text-2xl shrink-0">
                            <i class="ph ph-phone-call"></i>
                        </div>
                        <div>
                            <h4 class="font-bold text-sm text-brand-navy uppercase tracking-widest mb-1">Phone</h4>
                            <p class="text-sm text-gray-600 mb-2">Mon-Sat from 9am to 6pm.</p>
                            <a href="tel:+919994969811" class="text-base font-bold text-brand-navy hover:text-brand-gold transition-colors">+91 99949 69811</a>
                        </div>
                    </div>

                    <div class="bg-white border border-gray-200 p-6 rounded-xl flex items-start gap-4 shadow-sm hover:shadow-md transition-shadow">
                        <div class="w-12 h-12 bg-orange-50 text-brand-gold rounded-full flex items-center justify-center text-2xl shrink-0">
                            <i class="ph ph-envelope-simple-open"></i>
                        </div>
                        <div>
                            <h4 class="font-bold text-sm text-brand-navy uppercase tracking-widest mb-1">Email</h4>
                            <p class="text-sm text-gray-600 mb-2">Our friendly team is here to help.</p>
                            <a href="mailto:hello@fmuniforms.com" class="text-base font-bold text-brand-navy hover:text-brand-gold transition-colors">hello@fmuniforms.com</a>
                            <div class="mt-2 pt-2 border-t border-gray-100">
                                <span class="text-xs text-gray-400">B2B: <a href="mailto:sales@fmuniforms.com" class="text-brand-gold font-medium">sales@fmuniforms.com</a></span>
                            </div>
                        </div>
                    </div>

                    <div class="bg-white border border-gray-200 p-6 rounded-xl flex items-start gap-4 shadow-sm hover:shadow-md transition-shadow">
                        <div class="w-12 h-12 bg-orange-50 text-brand-gold rounded-full flex items-center justify-center text-2xl shrink-0">
                            <i class="ph ph-map-pin-line"></i>
                        </div>
                        <div>
                            <h4 class="font-bold text-sm text-brand-navy uppercase tracking-widest mb-1">Office / Factory</h4>
                            <p class="text-sm text-gray-655 leading-relaxed">
                                123 Industrial Estate, Main Road<br>
                                Karur, Tamil Nadu<br>
                                India - 639002
                            </p>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Right Form Panel -->
            <div class="lg:w-2/3">
                <div class="bg-white p-8 lg:p-12 rounded-xl shadow-[0_10px_40px_rgba(15,23,42,0.08)] border border-gray-100">
                    <h3 class="text-xl font-heading font-bold text-brand-navy mb-6">Send us a Message</h3>
                    
                    <form class="space-y-6" action="{{ url('/contact') }}" method="POST">
                        @csrf
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <div>
                                <label class="block text-xs font-bold text-brand-navy mb-2 uppercase tracking-wide">First Name *</label>
                                <input type="text" name="first_name" class="w-full border border-gray-300 px-4 py-3 text-sm rounded-md focus:outline-none focus:border-brand-gold focus:ring-1 focus:ring-brand-gold bg-gray-50 focus:bg-white transition-all" placeholder="John" required>
                            </div>
                            <div>
                                <label class="block text-xs font-bold text-brand-navy mb-2 uppercase tracking-wide">Last Name *</label>
                                <input type="text" name="last_name" class="w-full border border-gray-300 px-4 py-3 text-sm rounded-md focus:outline-none focus:border-brand-gold focus:ring-1 focus:ring-brand-gold bg-gray-50 focus:bg-white transition-all" placeholder="Doe" required>
                            </div>
                        </div>

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <div>
                                <label class="block text-xs font-bold text-brand-navy mb-2 uppercase tracking-wide">Email Address *</label>
                                <input type="email" name="email" class="w-full border border-gray-300 px-4 py-3 text-sm rounded-md focus:outline-none focus:border-brand-gold focus:ring-1 focus:ring-brand-gold bg-gray-50 focus:bg-white transition-all" placeholder="john@example.com" required>
                            </div>
                            <div>
                                <label class="block text-xs font-bold text-brand-navy mb-2 uppercase tracking-wide">Phone Number</label>
                                <input type="tel" name="phone" class="w-full border border-gray-300 px-4 py-3 text-sm rounded-md focus:outline-none focus:border-brand-gold focus:ring-1 focus:ring-brand-gold bg-gray-50 focus:bg-white transition-all" placeholder="+91">
                            </div>
                        </div>

                        <div>
                            <label class="block text-xs font-bold text-brand-navy mb-2 uppercase tracking-wide">Subject / Enquiry Type *</label>
                            <select name="subject" class="w-full border border-gray-300 px-4 py-3 text-sm rounded-md focus:outline-none focus:border-brand-gold focus:ring-1 focus:ring-brand-gold bg-gray-50 focus:bg-white transition-all appearance-none" required>
                                <option value="" disabled selected>Select an option</option>
                                <option value="General Enquiry">General Enquiry</option>
                                <option value="Order Status / Tracking">Order Status / Tracking</option>
                                <option value="Returns & Exchanges">Returns & Exchanges</option>
                                <option value="Customization Request">Customization Request</option>
                                <option value="Feedback / Complaints">Feedback / Complaints</option>
                            </select>
                        </div>

                        <div>
                            <label class="block text-xs font-bold text-brand-navy mb-2 uppercase tracking-wide">Your Message *</label>
                            <textarea name="message" rows="5" class="w-full border border-gray-300 px-4 py-3 text-sm rounded-md focus:outline-none focus:border-brand-gold focus:ring-1 focus:ring-brand-gold bg-gray-50 focus:bg-white transition-all" placeholder="How can we help you?" required></textarea>
                        </div>

                        <button type="submit" class="bg-brand-navy hover:bg-gray-800 text-white font-bold text-sm px-8 py-4 rounded-md transition-all uppercase tracking-widest shadow-md hover:shadow-lg w-full md:w-auto">
                            Send Message
                        </button>
                    </form>
                </div>
            </div>

        </div>
    </section>
@endsection
