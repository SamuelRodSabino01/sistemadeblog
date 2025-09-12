@extends('blog.layout')

@section('title', 'Tag: ' . $tag->name)
@section('description', $tag->description ?: 'Posts com a tag ' . $tag->name)
@section('keywords', $tag->name . ', blog, artigos')

@section('content')
<!-- Tag Header -->
<div class="bg-gradient-to-r from-green-600 to-teal-600 text-white py-16">
    <div class="max-w-6xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="text-center">
            <nav class="mb-4">
                <ol class="flex items-center justify-center space-x-2 text-sm text-green-100">
                    <li><a href="{{ route('blog.index') }}" class="hover:text-white">Início</a></li>
                    <li><i class="fas fa-chevron-right text-xs"></i></li>
                    <li class="text-white font-medium">#{{ $tag->name }}</li>
                </ol>
            </nav>
            
            <div class="mb-4">
                <span class="inline-block bg-white bg-opacity-20 text-white px-4 py-2 rounded-full text-lg font-semibold">
                    #{{ $tag->name }}
                </span>
            </div>
            
            <h1 class="text-4xl md:text-5xl font-bold mb-4">Posts com a tag "{{ $tag->name }}"</h1>
            
            @if($tag->description)
                <p class="text-xl text-green-100 max-w-3xl mx-auto leading-relaxed">
                    {{ $tag->description }}
                </p>
            @endif
            
            <div class="mt-6 flex items-center justify-center space-x-6 text-green-100">
                <span class="flex items-center">
                    <i class="fas fa-newspaper mr-2"></i>
                    {{ $posts->total() }} {{ $posts->total() == 1 ? 'artigo' : 'artigos' }}
                </span>
                <span class="flex items-center">
                    <i class="fas fa-calendar mr-2"></i>
                    Tag criada em {{ $tag->created_at->format('M Y') }}
                </span>
            </div>
        </div>
    </div>
</div>

<!-- Posts Grid -->
<div class="bg-gray-50 py-12">
    <div class="max-w-6xl mx-auto px-4 sm:px-6 lg:px-8">
        @if($posts->count() > 0)
            <!-- Filter and Sort -->
            <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center mb-8 bg-white p-4 rounded-lg shadow-sm">
                <div class="mb-4 sm:mb-0">
                    <h2 class="text-lg font-semibold text-gray-900">
                        Mostrando {{ $posts->count() }} de {{ $posts->total() }} artigos
                    </h2>
                    <p class="text-gray-600 text-sm mt-1">
                        Página {{ $posts->currentPage() }} de {{ $posts->lastPage() }}
                    </p>
                </div>
                
                <div class="flex items-center space-x-4">
                    <div class="relative">
                        <select onchange="window.location.href=this.value" 
                                class="appearance-none bg-white border border-gray-300 rounded-md px-4 py-2 pr-8 focus:outline-none focus:ring-2 focus:ring-green-500">
                            <option value="{{ route('blog.tag', ['tag' => $tag, 'sort' => 'latest']) }}" 
                                    {{ request('sort') == 'latest' || !request('sort') ? 'selected' : '' }}>
                                Mais recentes
                            </option>
                            <option value="{{ route('blog.tag', ['tag' => $tag, 'sort' => 'oldest']) }}" 
                                    {{ request('sort') == 'oldest' ? 'selected' : '' }}>
                                Mais antigos
                            </option>
                            <option value="{{ route('blog.tag', ['tag' => $tag, 'sort' => 'popular']) }}" 
                                    {{ request('sort') == 'popular' ? 'selected' : '' }}>
                                Mais populares
                            </option>
                        </select>
                        <i class="fas fa-chevron-down absolute right-2 top-1/2 transform -translate-y-1/2 text-gray-400 pointer-events-none"></i>
                    </div>
                    
                    <div class="flex items-center space-x-2">
                        <button onclick="toggleView('grid')" 
                                id="grid-btn" 
                                class="p-2 rounded-md transition-colors view-toggle active">
                            <i class="fas fa-th-large"></i>
                        </button>
                        <button onclick="toggleView('list')" 
                                id="list-btn" 
                                class="p-2 rounded-md transition-colors view-toggle">
                            <i class="fas fa-list"></i>
                        </button>
                    </div>
                </div>
            </div>
            
            <!-- Posts Grid View -->
            <div id="grid-view" class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8 mb-12">
                @foreach($posts as $post)
                    <article class="bg-white rounded-lg shadow-sm overflow-hidden hover:shadow-lg transition-shadow duration-300">
                        @if($post->featured_image)
                            <div class="relative">
                                <img src="{{ asset('storage/' . $post->featured_image) }}" 
                                     alt="{{ $post->title }}" 
                                     class="w-full h-48 object-cover">
                                <div class="absolute top-4 left-4">
                                    <span class="bg-white bg-opacity-90 text-gray-800 text-xs font-semibold px-2 py-1 rounded">
                                        {{ $post->created_at->format('d M') }}
                                    </span>
                                </div>
                            </div>
                        @endif
                        
                        <div class="p-6">
                            <div class="flex items-center justify-between mb-3">
                                <span class="bg-blue-100 text-blue-800 text-sm font-semibold px-2 py-1 rounded">
                                    {{ $post->category->name }}
                                </span>
                                <div class="flex items-center text-gray-500 text-sm">
                                    <i class="fas fa-eye mr-1"></i>
                                    {{ $post->views ?? 0 }}
                                </div>
                            </div>
                            
                            <h3 class="text-xl font-bold text-gray-900 mb-3 leading-tight">
                                <a href="{{ route('blog.show', $post) }}" 
                                   class="hover:text-blue-600 transition-colors">
                                    {{ $post->title }}
                                </a>
                            </h3>
                            
                            @if($post->excerpt)
                                <p class="text-gray-600 mb-4 leading-relaxed">
                                    {{ Str::limit($post->excerpt, 120) }}
                                </p>
                            @endif
                            
                            <!-- Post Tags -->
                            <div class="mb-4">
                                <div class="flex flex-wrap gap-1">
                                    @foreach($post->tags->take(3) as $postTag)
                                        <span class="bg-green-100 text-green-800 text-xs px-2 py-1 rounded-full {{ $postTag->id == $tag->id ? 'bg-green-200 font-semibold' : '' }}">
                                            #{{ $postTag->name }}
                                        </span>
                                    @endforeach
                                    @if($post->tags->count() > 3)
                                        <span class="text-gray-500 text-xs px-2 py-1">
                                            +{{ $post->tags->count() - 3 }} mais
                                        </span>
                                    @endif
                                </div>
                            </div>
                            
                            <div class="flex items-center justify-between">
                                <div class="flex items-center">
                                    <div class="w-8 h-8 bg-blue-500 rounded-full flex items-center justify-center text-white text-sm font-semibold">
                                        {{ substr($post->user->name, 0, 1) }}
                                    </div>
                                    <div class="ml-2">
                                        <p class="text-gray-900 text-sm font-medium">{{ $post->user->name }}</p>
                                        <p class="text-gray-500 text-xs">{{ $post->created_at->format('d/m/Y') }}</p>
                                    </div>
                                </div>
                                
                                <a href="{{ route('blog.show', $post) }}" 
                                   class="text-blue-600 hover:text-blue-800 text-sm font-medium">
                                    Ler mais <i class="fas fa-arrow-right ml-1"></i>
                                </a>
                            </div>
                        </div>
                    </article>
                @endforeach
            </div>
            
            <!-- Posts List View -->
            <div id="list-view" class="space-y-6 mb-12 hidden">
                @foreach($posts as $post)
                    <article class="bg-white rounded-lg shadow-sm overflow-hidden hover:shadow-md transition-shadow">
                        <div class="flex flex-col md:flex-row">
                            @if($post->featured_image)
                                <div class="md:w-1/3">
                                    <img src="{{ asset('storage/' . $post->featured_image) }}" 
                                         alt="{{ $post->title }}" 
                                         class="w-full h-48 md:h-full object-cover">
                                </div>
                            @endif
                            
                            <div class="flex-1 p-6">
                                <div class="flex items-center justify-between mb-3">
                                    <div class="flex items-center space-x-4">
                                        <span class="bg-blue-100 text-blue-800 text-sm font-semibold px-2 py-1 rounded">
                                            {{ $post->category->name }}
                                        </span>
                                        <span class="text-gray-500 text-sm">
                                            {{ $post->created_at->format('d \d\e F \d\e Y') }}
                                        </span>
                                    </div>
                                    <div class="flex items-center text-gray-500 text-sm">
                                        <i class="fas fa-eye mr-1"></i>
                                        {{ $post->views ?? 0 }} visualizações
                                    </div>
                                </div>
                                
                                <h3 class="text-2xl font-bold text-gray-900 mb-3">
                                    <a href="{{ route('blog.show', $post) }}" 
                                       class="hover:text-blue-600 transition-colors">
                                        {{ $post->title }}
                                    </a>
                                </h3>
                                
                                @if($post->excerpt)
                                    <p class="text-gray-600 mb-4 leading-relaxed">
                                        {{ Str::limit($post->excerpt, 200) }}
                                    </p>
                                @endif
                                
                                <!-- Post Tags -->
                                <div class="mb-4">
                                    <div class="flex flex-wrap gap-2">
                                        @foreach($post->tags as $postTag)
                                            <a href="{{ route('blog.tag', $postTag) }}" 
                                               class="bg-green-100 text-green-800 text-sm px-3 py-1 rounded-full hover:bg-green-200 transition-colors {{ $postTag->id == $tag->id ? 'bg-green-200 font-semibold' : '' }}">
                                                #{{ $postTag->name }}
                                            </a>
                                        @endforeach
                                    </div>
                                </div>
                                
                                <div class="flex items-center justify-between">
                                    <div class="flex items-center">
                                        <div class="w-10 h-10 bg-blue-500 rounded-full flex items-center justify-center text-white font-semibold">
                                            {{ substr($post->user->name, 0, 1) }}
                                        </div>
                                        <div class="ml-3">
                                            <p class="text-gray-900 font-medium">{{ $post->user->name }}</p>
                                            <p class="text-gray-500 text-sm">Autor</p>
                                        </div>
                                    </div>
                                    
                                    <a href="{{ route('blog.show', $post) }}" 
                                       class="bg-blue-600 text-white px-4 py-2 rounded-md hover:bg-blue-700 transition-colors">
                                        Ler artigo completo
                                    </a>
                                </div>
                            </div>
                        </div>
                    </article>
                @endforeach
            </div>
            
            <!-- Pagination -->
            <div class="flex justify-center">
                {{ $posts->appends(request()->query())->links() }}
            </div>
        @else
            <!-- Empty State -->
            <div class="text-center py-16">
                <div class="max-w-md mx-auto">
                    <i class="fas fa-tag text-6xl text-gray-300 mb-6"></i>
                    <h3 class="text-2xl font-bold text-gray-900 mb-4">Nenhum artigo encontrado</h3>
                    <p class="text-gray-600 mb-8">
                        Ainda não há artigos publicados com a tag "{{ $tag->name }}".
                    </p>
                    <a href="{{ route('blog.index') }}" 
                       class="bg-blue-600 text-white px-6 py-3 rounded-md hover:bg-blue-700 transition-colors">
                        <i class="fas fa-arrow-left mr-2"></i>
                        Voltar ao início
                    </a>
                </div>
            </div>
        @endif
    </div>
</div>

<!-- Related Tags -->
@if($relatedTags->count() > 0)
<section class="bg-white py-12">
    <div class="max-w-6xl mx-auto px-4 sm:px-6 lg:px-8">
        <h3 class="text-2xl font-bold text-gray-900 mb-8 text-center">Tags Relacionadas</h3>
        <div class="flex flex-wrap justify-center gap-3">
            @foreach($relatedTags as $relatedTag)
                <a href="{{ route('blog.tag', $relatedTag) }}" 
                   class="bg-gray-100 text-gray-700 px-4 py-2 rounded-full hover:bg-green-100 hover:text-green-800 transition-colors">
                    #{{ $relatedTag->name }}
                    <span class="text-gray-500 text-sm ml-1">({{ $relatedTag->posts_count }})</span>
                </a>
            @endforeach
        </div>
    </div>
</section>
@endif

<!-- Popular Tags Cloud -->
@if($popularTags->count() > 0)
<section class="bg-gray-50 py-12">
    <div class="max-w-6xl mx-auto px-4 sm:px-6 lg:px-8">
        <h3 class="text-2xl font-bold text-gray-900 mb-8 text-center">Nuvem de Tags</h3>
        <div class="text-center">
            @foreach($popularTags as $popularTag)
                @php
                    $size = min(max($popularTag->posts_count, 1), 10);
                    $fontSize = 'text-' . ($size > 5 ? 'xl' : ($size > 3 ? 'lg' : 'base'));
                @endphp
                <a href="{{ route('blog.tag', $popularTag) }}" 
                   class="inline-block {{ $fontSize }} {{ $popularTag->id == $tag->id ? 'text-green-600 font-bold' : 'text-gray-600 hover:text-green-600' }} m-2 transition-colors">
                    #{{ $popularTag->name }}
                </a>
            @endforeach
        </div>
    </div>
</section>
@endif
@endsection

@push('scripts')
<script>
function toggleView(view) {
    const gridView = document.getElementById('grid-view');
    const listView = document.getElementById('list-view');
    const gridBtn = document.getElementById('grid-btn');
    const listBtn = document.getElementById('list-btn');
    
    if (view === 'grid') {
        gridView.classList.remove('hidden');
        listView.classList.add('hidden');
        gridBtn.classList.add('active');
        listBtn.classList.remove('active');
        localStorage.setItem('blog_view_preference', 'grid');
    } else {
        gridView.classList.add('hidden');
        listView.classList.remove('hidden');
        gridBtn.classList.remove('active');
        listBtn.classList.add('active');
        localStorage.setItem('blog_view_preference', 'list');
    }
}

// Load saved view preference
document.addEventListener('DOMContentLoaded', function() {
    const savedView = localStorage.getItem('blog_view_preference');
    if (savedView) {
        toggleView(savedView);
    }
});
</script>

<style>
.view-toggle {
    @apply bg-gray-100 text-gray-600 hover:bg-gray-200;
}

.view-toggle.active {
    @apply bg-green-600 text-white;
}
</style>
@endpush