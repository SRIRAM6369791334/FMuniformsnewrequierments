@extends('layouts.app')

@section('title', $blog->title . ' | FM Uniforms Blog')

@section('styles')
<style>
    /* Rich blog content typography */
    .prose-blog { line-height: 1.85; color: #334155; font-size: 1rem; }
    .prose-blog p { margin-bottom: 1.5rem; }
    .prose-blog h2 { font-size: 1.75rem; font-weight: 900; margin: 2.5rem 0 1rem; color: #051121; letter-spacing: -0.5px; font-family: 'Outfit', sans-serif; }
    .prose-blog h3 { font-size: 1.4rem; font-weight: 800; margin: 2rem 0 0.75rem; color: #051121; font-family: 'Outfit', sans-serif; }
    .prose-blog h4 { font-size: 1.15rem; font-weight: 700; margin: 1.5rem 0 0.5rem; color: #475569; }
    .prose-blog ul, .prose-blog ol { padding-left: 1.5rem; margin-bottom: 1.5rem; }
    .prose-blog li { margin-bottom: 0.5rem; }
    .prose-blog blockquote { border-left: 4px solid #b78a46; padding: 1rem 1.5rem; background: #fefce8; margin: 2rem 0; border-radius: 0 0.5rem 0.5rem 0; font-style: italic; color: #051121; font-size: 1.1rem; }
    .prose-blog strong { color: #051121; font-weight: 700; }
    .prose-blog a { color: #b78a46; text-decoration: underline; }
    .prose-blog table { width: 100%; border-collapse: collapse; margin: 2rem 0; border-radius: 0.5rem; overflow: hidden; border: 1px solid #e2e8f0; }
    .prose-blog table th { background: #051121; color: white; padding: 12px 16px; text-align: left; font-size: 0.75rem; text-transform: uppercase; letter-spacing: 0.1em; }
    .prose-blog table td { padding: 12px 16px; border-bottom: 1px solid #f1f5f9; font-size: 0.9rem; }
    .prose-blog table tr:last-child td { border-bottom: none; }
    .prose-blog table tr:nth-child(even) { background: #f8fafc; }
    .prose-blog img { width: 100%; border-radius: 0.75rem; margin: 1.5rem 0; }
</style>
@endsection

@section('content')

{{-- Breadcrumb --}}
<div class="max-w-[1400px] mx-auto px-4 lg:px-8 py-4 text-xs text-gray-500">
    <a href="{{ url('/') }}" class="hover:text-[#b78a46] transition-colors">Home</a>
    <i class="ph ph-caret-right mx-1 text-[10px]"></i>
    <a href="{{ url('/blog') }}" class="hover:text-[#b78a46] transition-colors">Blog</a>
    <i class="ph ph-caret-right mx-1 text-[10px]"></i>
    <span class="text-gray-800 font-semibold">{{ Str::limit($blog->title, 50) }}</span>
</div>

{{-- Main Content --}}
<div class="bg-[#f4f5f7] py-10 px-4">
    <div class="max-w-[1400px] mx-auto">
        <div class="flex flex-col lg:flex-row gap-8">

            {{-- Article --}}
            <article class="flex-1 min-w-0">

                {{-- Hero Image --}}
                <div class="rounded-xl overflow-hidden mb-6 shadow-sm border border-gray-200 aspect-[16/7]">
                    <img src="{{ $blog->image ? config('app.main_url') . 'images/blogs/' . $blog->image : 'https://placehold.co/1200x500/051121/b78a46?text=FM+Uniforms' }}"
                         alt="{{ $blog->title }}"
                         class="w-full h-full object-cover">
                </div>

                {{-- Article Header --}}
                <div class="bg-white rounded-xl border border-gray-200 shadow-sm p-8 mb-6">
                    <div class="flex items-center gap-3 mb-5">
                        <span class="text-[0.6rem] font-bold uppercase tracking-widest text-[#b78a46] bg-orange-50 px-3 py-1.5 rounded-full border border-orange-100">
                            <i class="ph ph-calendar-blank mr-1"></i>{{ $blog->created_at->format('d M Y') }}
                        </span>
                        @if($blog->category)
                        <span class="text-[0.6rem] font-bold uppercase tracking-widest text-[#051121] bg-gray-100 px-3 py-1.5 rounded-full">
                            {{ $blog->category->name }}
                        </span>
                        @endif
                    </div>

                    <h1 class="text-2xl lg:text-3xl font-heading font-extrabold text-[#051121] leading-tight tracking-tight mb-5">{{ $blog->title }}</h1>

                    @if($blog->meta_description)
                    <p class="text-base text-gray-500 leading-relaxed border-l-4 border-[#b78a46] pl-4 italic">{{ $blog->meta_description }}</p>
                    @endif
                </div>

                {{-- Article Body --}}
                <div class="bg-white rounded-xl border border-gray-200 shadow-sm p-8 mb-6">
                    <div class="prose-blog">
                        {!! $blog->content !!}
                    </div>
                </div>

                {{-- Author / Published by --}}
                <div class="bg-white rounded-xl border border-gray-200 shadow-sm p-6 flex items-center gap-5">
                    <div class="w-14 h-14 rounded-full bg-[#051121] flex items-center justify-center text-[#b78a46] text-2xl shrink-0">
                        <i class="ph-fill ph-user-circle"></i>
                    </div>
                    <div>
                        <div class="text-[0.6rem] text-gray-400 uppercase tracking-widest font-bold mb-1">Published by</div>
                        <div class="font-heading font-bold text-[#051121] text-sm">{{ $blog->category->name ?? 'FM Uniforms Editorial' }}</div>
                        <div class="text-xs text-gray-500 mt-0.5">Specialist in Uniform Design &amp; Quality</div>
                    </div>
                    <div class="ml-auto">
                        <a href="{{ url('/blog') }}" class="text-[0.7rem] font-bold uppercase tracking-widest text-[#051121] hover:text-[#b78a46] transition-colors flex items-center gap-1">
                            <i class="ph ph-arrow-left"></i> All Posts
                        </a>
                    </div>
                </div>
            </article>

            {{-- Sidebar --}}
            <aside class="lg:w-80 shrink-0">
                <div class="sticky top-24 space-y-5">

                    {{-- Latest Posts Widget --}}
                    <div class="bg-white rounded-xl border border-gray-200 shadow-sm p-6">
                        <h4 class="font-heading font-bold text-[#051121] text-sm uppercase tracking-widest mb-5 pb-3 border-b border-gray-100">Latest Posts</h4>
                        @php
                            $latestBlogs = \App\Models\Blog::with('category')->where('id', '!=', $blog->id)->latest()->take(4)->get();
                        @endphp
                        <div class="space-y-4">
                            @foreach($latestBlogs as $latestBlog)
                            <a href="{{ url('/blog/' . $latestBlog->slug) }}" class="flex gap-3 group hover:bg-gray-50 p-2 -mx-2 rounded-lg transition-all">
                                <div class="w-16 h-16 rounded-lg overflow-hidden bg-gray-100 border border-gray-200 shrink-0">
                                    <img src="{{ $latestBlog->image ? config('app.main_url') . 'images/blogs/' . $latestBlog->image : 'https://placehold.co/80x80/051121/b78a46?text=FM' }}"
                                         alt="{{ $latestBlog->title }}"
                                         class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-300">
                                </div>
                                <div class="flex-1 min-w-0">
                                    <h5 class="text-xs font-bold text-[#051121] leading-snug line-clamp-2 group-hover:text-[#b78a46] transition-colors">{{ $latestBlog->title }}</h5>
                                    <p class="text-[0.65rem] text-gray-400 mt-1">{{ $latestBlog->created_at->format('d M Y') }}</p>
                                </div>
                            </a>
                            @endforeach
                        </div>
                    </div>

                    {{-- Categories Widget --}}
                    <div class="bg-white rounded-xl border border-gray-200 shadow-sm p-6">
                        <h4 class="font-heading font-bold text-[#051121] text-sm uppercase tracking-widest mb-5 pb-3 border-b border-gray-100">Categories</h4>
                        @php
                            $categories = \App\Models\Category::withCount('blogs')->get();
                        @endphp
                        <div class="space-y-2">
                            @foreach($categories as $category)
                                @if($category->blogs_count > 0)
                                <a href="{{ route('blog.category', ['slug' => $category->slug]) }}"
                                   class="flex items-center justify-between px-4 py-2.5 bg-gray-50 hover:bg-[#051121] hover:text-white text-sm font-semibold text-gray-600 rounded-lg transition-all group">
                                    <span>{{ $category->name }}</span>
                                    <span class="text-[0.6rem] font-bold bg-gray-200 group-hover:bg-white/20 text-gray-600 group-hover:text-white px-2 py-0.5 rounded-full transition-all">{{ $category->blogs_count }}</span>
                                </a>
                                @endif
                            @endforeach
                        </div>
                    </div>

                    {{-- Tags Widget --}}
                    @php
                        $allTags = collect();
                        foreach(\App\Models\Blog::all() as $blogItem) {
                            if($blogItem->meta_key) {
                                $tags = explode(',', $blogItem->meta_key);
                                foreach($tags as $tag) { $allTags->push(trim($tag)); }
                            }
                        }
                        $uniqueTags = $allTags->unique()->take(10);
                    @endphp
                    @if($uniqueTags->count() > 0)
                    <div class="bg-white rounded-xl border border-gray-200 shadow-sm p-6">
                        <h4 class="font-heading font-bold text-[#051121] text-sm uppercase tracking-widest mb-5 pb-3 border-b border-gray-100">Tags</h4>
                        <div class="flex flex-wrap gap-2">
                            @foreach($uniqueTags as $tag)
                            <a href="{{ url('/blog?search=' . $tag) }}"
                               class="text-[0.65rem] font-bold uppercase tracking-wide px-3 py-1.5 bg-gray-100 hover:bg-[#051121] hover:text-white text-gray-600 rounded-full transition-all">
                                {{ $tag }}
                            </a>
                            @endforeach
                        </div>
                    </div>
                    @endif

                    {{-- CTA Widget --}}
                    <div class="bg-[#051121] text-white rounded-xl p-6 text-center">
                        <div class="w-12 h-12 bg-[#b78a46]/20 rounded-full flex items-center justify-center mx-auto mb-4 text-[#b78a46] text-2xl">
                            <i class="ph ph-briefcase"></i>
                        </div>
                        <h4 class="font-heading font-bold text-base mb-2">Need a Bulk Quote?</h4>
                        <p class="text-gray-400 text-xs leading-relaxed mb-4">Get customized uniforms for your team, hospital, or institution.</p>
                        <a href="{{ url('/bulkorder') }}" class="block w-full bg-[#b78a46] hover:bg-[#9b7337] text-white font-bold text-xs py-3 rounded-md uppercase tracking-widest transition-colors">
                            Get a Quote
                        </a>
                    </div>

                </div>
            </aside>

        </div>
    </div>
</div>

@endsection
