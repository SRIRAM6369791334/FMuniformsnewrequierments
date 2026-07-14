@extends('layouts.app')

@section('title', 'Blog | FM Uniforms')

@section('content')

{{-- Breadcrumb --}}
<div class="max-w-[1400px] mx-auto px-4 lg:px-8 py-4 text-xs text-gray-500">
    <a href="{{ url('/') }}" class="hover:text-[#b78a46] transition-colors">Home</a>
    <i class="ph ph-caret-right mx-1 text-[10px]"></i>
    <span class="text-gray-800 font-semibold">Blog</span>
</div>

{{-- Hero --}}
<div class="bg-[#051121] text-white py-12 px-4">
    <div class="max-w-[1400px] mx-auto flex flex-col md:flex-row items-start md:items-center justify-between gap-4">
        <div>
            <div class="text-[0.65rem] text-[#b78a46] tracking-[0.2em] uppercase font-bold mb-2"><i class="ph ph-newspaper mr-1"></i> FM Uniforms Journal</div>
            <h1 class="text-3xl lg:text-4xl font-heading font-extrabold tracking-tight">Uniform Insights &amp; Industry News</h1>
            <p class="text-gray-400 text-sm mt-2 max-w-lg">Tips, trends, care guides and stories from the world of professional uniforms.</p>
        </div>
    </div>
</div>

{{-- Category Filter Tabs --}}
<div class="bg-white border-b border-gray-200 sticky top-0 z-30 shadow-sm">
    <div class="max-w-[1400px] mx-auto px-4 lg:px-8 flex items-center gap-2 overflow-x-auto hide-scrollbar py-3">
        <button class="blog-filter-btn active shrink-0 text-[0.7rem] font-bold uppercase tracking-widest px-4 py-2 rounded-full border border-[#051121] bg-[#051121] text-white transition-all" data-filter="*">All Posts</button>
        @foreach($allCategories as $category)
            <button class="blog-filter-btn shrink-0 text-[0.7rem] font-bold uppercase tracking-widest px-4 py-2 rounded-full border border-gray-300 text-gray-600 hover:border-[#051121] hover:text-[#051121] transition-all" data-filter=".{{ $category['filter_class'] }}">{{ $category['name'] }}</button>
        @endforeach
    </div>
</div>

{{-- Blog Grid --}}
<div class="bg-[#f4f5f7] py-12 px-4">
    <div class="max-w-[1400px] mx-auto">
        <div class="blog-grid grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
            @forelse($blogs as $blog)
                <article class="blog-card {{ $blog->filter_class }} bg-white rounded-xl overflow-hidden border border-gray-200 shadow-sm hover:shadow-md transition-all hover:-translate-y-1 flex flex-col">
                    <a href="{{ url('/blog/' . $blog->slug) }}" class="block overflow-hidden aspect-[16/9]">
                        <img src="{{ $blog->image ? env('MAIN_URL') . 'images/blogs/' . $blog->image : 'https://placehold.co/640x360/051121/b78a46?text=FM+Uniforms' }}"
                             alt="{{ $blog->title }}"
                             class="w-full h-full object-cover hover:scale-105 transition-transform duration-500">
                    </a>
                    <div class="p-6 flex flex-col flex-1">
                        <div class="flex items-center gap-3 mb-3">
                            <span class="text-[0.6rem] font-bold uppercase tracking-widest text-[#b78a46] bg-orange-50 px-2.5 py-1 rounded-full border border-orange-100">
                                {{ $blog->created_at->format('d M Y') }}
                            </span>
                        </div>
                        <h2 class="font-heading font-bold text-[#051121] text-base leading-snug mb-2 line-clamp-2 flex-1">
                            <a href="{{ url('/blog/' . $blog->slug) }}" class="hover:text-[#b78a46] transition-colors">{{ $blog->title }}</a>
                        </h2>
                        <p class="text-sm text-gray-500 leading-relaxed line-clamp-3 mb-5">{{ Str::limit(strip_tags($blog->content), 140) }}</p>
                        <a href="{{ url('/blog/' . $blog->slug) }}" class="inline-flex items-center gap-2 text-[0.7rem] font-bold uppercase tracking-widest text-[#051121] hover:text-[#b78a46] transition-colors mt-auto">
                            Read Article <i class="ph ph-arrow-right"></i>
                        </a>
                    </div>
                </article>
            @empty
                <div class="col-span-3 text-center py-20">
                    <div class="w-16 h-16 bg-gray-100 rounded-full flex items-center justify-center mx-auto mb-4 text-3xl text-gray-400">
                        <i class="ph ph-newspaper"></i>
                    </div>
                    <h3 class="font-heading font-bold text-[#051121] text-xl mb-2">No Posts Yet</h3>
                    <p class="text-sm text-gray-500">Check back soon for industry insights and uniform tips.</p>
                </div>
            @endforelse
        </div>
    </div>
</div>

@endsection

@section('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function () {
        const filterBtns = document.querySelectorAll('.blog-filter-btn');
        const cards = document.querySelectorAll('.blog-card');

        filterBtns.forEach(btn => {
            btn.addEventListener('click', function () {
                const filter = this.dataset.filter;

                // Update active state
                filterBtns.forEach(b => {
                    b.classList.remove('active', 'bg-[#051121]', 'text-white', 'border-[#051121]');
                    b.classList.add('border-gray-300', 'text-gray-600');
                });
                this.classList.add('active', 'bg-[#051121]', 'text-white', 'border-[#051121]');
                this.classList.remove('border-gray-300', 'text-gray-600');

                // Filter cards
                cards.forEach(card => {
                    if (filter === '*' || card.classList.contains(filter.replace('.', ''))) {
                        card.style.display = 'flex';
                    } else {
                        card.style.display = 'none';
                    }
                });
            });
        });

        // Check URL filter param
        const urlParams = new URLSearchParams(window.location.search);
        const filterParam = urlParams.get('filter');
        if (filterParam) {
            const matchBtn = document.querySelector('[data-filter=".' + filterParam + '"]');
            if (matchBtn) matchBtn.click();
        }
    });
</script>
@endsection
