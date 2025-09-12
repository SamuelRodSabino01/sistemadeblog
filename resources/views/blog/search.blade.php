@extends('blog.layout')

@section('title', 'Busca: ' . request('q'))
@section('description', 'Resultados da busca por "' . request('q') . '" no blog')
@section('keywords', 'busca, pesquisa, ' . request('q'))

@section('content')
<!-- Search Header -->
<div class="bg-gradient-to-r from-purple-600 to-pink-600 text-white py-16">
    <div class="max-w-6xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="text-center">
            <nav class="mb-4">
                <ol class="flex items-center justify-center space-x-2 text-sm text-purple-100">
                    <li><a href="{{ route('blog.index') }}" class="hover:text-white">Início</a></li>
                    <li><i class="fas fa-chevron-right text-xs"></i></li>
                    <li class="text-white font-medium">Busca</li>
                </ol>
            </nav>
            
            <h1 class="text-4xl md:text-5xl font-bold mb-6">Resultados da Busca</h1>
            
            <!-- Search Form -->
            <div class="max-w-2xl mx-auto mb-6">
                <form action="{{ route('blog.search') }}" method="GET" class="relative">
                    <input type="text" 
                           name="q" 
                           value="{{ request('q') }}" 
                           placeholder="Digite sua busca..." 
                           class="w-full px-6 py-4 text-gray-900 text-lg rounded-full border-0 focus:outline-none focus:ring-4 focus:ring-white focus:ring-opacity-30 shadow-lg">
                    <button type="submit" 
                            class="absolute right-2 top-1/2 transform -translate-y-1/2 bg-purple-600 text-white px-6 py-2 rounded-full hover:bg-purple-700 transition-colors">
                        <i class="fas fa-search"></i>
                    </button>
                </form>
            </div>
            
            @if(request('q'))
                <p class="text-xl text-purple-100">
                    Buscando por: <strong>"{{ request('q') }}"</strong>
                </p>
                
                @if(isset($posts) && $posts->total() > 0)
                    <div class="mt-4 flex items-center justify-center space-x-6 text-purple-100">
                        <span class="flex items-center">
                            <i class="fas fa-search mr-2"></i>
                            {{ $posts->total() }} {{ $posts->total() == 1 ? 'resultado encontrado' : 'resultados encontrados' }}
                        </span>
                        <span class="flex items-center">
                            <i class="fas fa-clock mr-2"></i>
                            Busca realizada em {{ number_format(microtime(true) - LARAVEL_START, 3) }}s
                        </span>
                    </div>
                @endif
            @endif
        </div>
    </div>
</div>

<!-- Search Results -->
<div class="bg-gray-50 py-12">
    <div class="max-w-6xl mx-auto px-4 sm:px-6 lg:px-8">
        @if(request('q'))
            @if(isset($posts) && $posts->count() > 0)
                <!-- Filter and Sort -->
                <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center mb-8 bg-white p-4 rounded-lg shadow-sm">
                    <div class="mb-4 sm:mb-0">
                        <h2 class="text-lg font-semibold text-gray-900">
                            Mostrando {{ $posts->count() }} de {{ $posts->total() }} resultados
                        </h2>
                        <p class="text-gray-600 text-sm mt-1">
                            Página {{ $posts->currentPage() }} de {{ $posts->lastPage() }}
                        </p>
                    </div>
                    
                    <div class="flex items-center space-x-4">
                        <div class="relative">
                            <select onchange="window.location.href=this.value" 
                                    class="appearance-none bg-white border border-gray-300 rounded-md px-4 py-2 pr-8 focus:outline-none focus:ring-2 focus:ring-purple-500">
                                <option value="{{ route('blog.search', ['q' => request('q'), 'sort' => 'relevance']) }}" 
                                        {{ request('sort') == 'relevance' || !request('sort') ? 'selected' : '' }}>
                                    Mais relevantes
                                </option>
                                <option value="{{ route('blog.search', ['q' => request('q'), 'sort' => 'latest']) }}" 
                                        {{ request('sort') == 'latest' ? 'selected' : '' }}>
                                    Mais recentes
                                </option>
                                <option value="{{ route('blog.search', ['q' => request('q'), 'sort' => 'oldest']) }}" 
                                        {{ request('sort') == 'oldest' ? 'selected' : '' }}>
                                    Mais antigos
                                </option>
                                <option value="{{ route('blog.search', ['q' => request('q'), 'sort' => 'popular']) }}" 
                                        {{ request('sort') == 'popular' ? 'selected' : '' }}>
                                    Mais populares
                                </option>
                            </select>
                            <i class="fas fa-chevron-down absolute right-2 top-1/2 transform -translate-y-1/2 text-gray-400 pointer-events-none"></i>
                        </div>
                        
                        <!-- Filter by Category -->
                        @if($categories->count() > 0)
                            <div class="relative">
                                <select onchange="window.location.href=this.value" 
                                        class="appearance-none bg-white border border-gray-300 rounded-md px-4 py-2 pr-8 focus:outline-none focus:ring-2 focus:ring-purple-500">
                                    <option value="{{ route('blog.search', ['q' => request('q'), 'sort' => request('sort')]) }}">
                                        Todas as categorias
                                    </option>
                                    @foreach($categories as $category)
                                        <option value="{{ route('blog.search', ['q' => request('q'), 'sort' => request('sort'), 'category' => $category->id]) }}" 
                                                {{ request('category') == $category->id ? 'selected' : '' }}>
                                            {{ $category->name }}
                                        </option>
                                    @endforeach
                                </select>
                                <i class="fas fa-chevron-down absolute right-2 top-1/2 transform -translate-y-1/2 text-gray-400 pointer-events-none"></i>
                            </div>
                        @endif
                    </div>
                </div>
                
                <!-- Search Results List -->
                <div class="space-y-6 mb-12">
                    @foreach($posts as $post)
                        <article class="bg-white rounded-lg shadow-sm overflow-hidden hover:shadow-md transition-shadow">
                            <div class="flex flex-col md:flex-row">
                                @if($post->featured_image)
                                    <div class="md:w-1/4">
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
                                           class="hover:text-purple-600 transition-colors">
                                            {!! $post->highlighted_title ?? $post->title !!}
                                        </a>
                                    </h3>
                                    
                                    <p class="text-gray-600 mb-4 leading-relaxed">
                                        {!! $post->highlighted_excerpt ?? ($post->excerpt ? Str::limit($post->excerpt, 200) : Str::limit(strip_tags($post->content), 200)) !!}
                                    </p>
                                    
                                    <!-- Post Tags -->
                                    @if($post->tags->count() > 0)
                                        <div class="mb-4">
                                            <div class="flex flex-wrap gap-2">
                                                @foreach($post->tags->take(5) as $tag)
                                                    <a href="{{ route('blog.tag', $tag) }}" 
                                                       class="bg-purple-100 text-purple-800 text-sm px-3 py-1 rounded-full hover:bg-purple-200 transition-colors">
                                                        #{{ $tag->name }}
                                                    </a>
                                                @endforeach
                                                @if($post->tags->count() > 5)
                                                    <span class="text-gray-500 text-sm px-2 py-1">
                                                        +{{ $post->tags->count() - 5 }} mais
                                                    </span>
                                                @endif
                                            </div>
                                        </div>
                                    @endif
                                    
                                    <div class="flex items-center justify-between">
                                        <div class="flex items-center">
                                            <div class="w-10 h-10 bg-purple-500 rounded-full flex items-center justify-center text-white font-semibold">
                                                {{ substr($post->user->name, 0, 1) }}
                                            </div>
                                            <div class="ml-3">
                                                <p class="text-gray-900 font-medium">{{ $post->user->name }}</p>
                                                <p class="text-gray-500 text-sm">Autor</p>
                                            </div>
                                        </div>
                                        
                                        <a href="{{ route('blog.show', $post) }}" 
                                           class="bg-purple-600 text-white px-4 py-2 rounded-md hover:bg-purple-700 transition-colors">
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
                <!-- No Results -->
                <div class="text-center py-16">
                    <div class="max-w-md mx-auto">
                        <i class="fas fa-search text-6xl text-gray-300 mb-6"></i>
                        <h3 class="text-2xl font-bold text-gray-900 mb-4">Nenhum resultado encontrado</h3>
                        <p class="text-gray-600 mb-8">
                            Não encontramos nenhum artigo para "<strong>{{ request('q') }}</strong>".
                        </p>
                        
                        <!-- Search Suggestions -->
                        <div class="bg-white rounded-lg p-6 shadow-sm mb-8">
                            <h4 class="text-lg font-semibold text-gray-900 mb-4">Sugestões:</h4>
                            <ul class="text-left text-gray-600 space-y-2">
                                <li><i class="fas fa-check text-green-500 mr-2"></i>Verifique a ortografia das palavras</li>
                                <li><i class="fas fa-check text-green-500 mr-2"></i>Tente usar palavras-chave diferentes</li>
                                <li><i class="fas fa-check text-green-500 mr-2"></i>Use termos mais gerais</li>
                                <li><i class="fas fa-check text-green-500 mr-2"></i>Tente usar sinônimos</li>
                            </ul>
                        </div>
                        
                        <a href="{{ route('blog.index') }}" 
                           class="bg-purple-600 text-white px-6 py-3 rounded-md hover:bg-purple-700 transition-colors">
                            <i class="fas fa-arrow-left mr-2"></i>
                            Voltar ao início
                        </a>
                    </div>
                </div>
            @endif
        @else
            <!-- Search Instructions -->
            <div class="text-center py-16">
                <div class="max-w-2xl mx-auto">
                    <i class="fas fa-search text-6xl text-gray-300 mb-6"></i>
                    <h3 class="text-2xl font-bold text-gray-900 mb-4">Faça sua busca</h3>
                    <p class="text-gray-600 mb-8">
                        Digite palavras-chave no campo de busca acima para encontrar artigos relacionados.
                    </p>
                    
                    <!-- Popular Searches -->
                    @if($popularSearches->count() > 0)
                        <div class="bg-white rounded-lg p-6 shadow-sm mb-8">
                            <h4 class="text-lg font-semibold text-gray-900 mb-4">Buscas populares:</h4>
                            <div class="flex flex-wrap justify-center gap-2">
                                @foreach($popularSearches as $search)
                                    <a href="{{ route('blog.search', ['q' => $search]) }}" 
                                       class="bg-gray-100 text-gray-700 px-3 py-2 rounded-full text-sm hover:bg-purple-100 hover:text-purple-800 transition-colors">
                                        {{ $search }}
                                    </a>
                                @endforeach
                            </div>
                        </div>
                    @endif
                    
                    <!-- Browse Categories -->
                    @if($categories->count() > 0)
                        <div class="bg-white rounded-lg p-6 shadow-sm">
                            <h4 class="text-lg font-semibold text-gray-900 mb-4">Ou navegue por categoria:</h4>
                            <div class="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-4">
                                @foreach($categories as $category)
                                    <a href="{{ route('blog.category', $category) }}" 
                                       class="bg-gray-50 rounded-lg p-4 text-center hover:bg-purple-50 hover:border-purple-200 border border-transparent transition-all">
                                        <h5 class="font-semibold text-gray-900 mb-2">{{ $category->name }}</h5>
                                        <p class="text-gray-600 text-sm">
                                            {{ $category->posts_count }} {{ $category->posts_count == 1 ? 'artigo' : 'artigos' }}
                                        </p>
                                    </a>
                                @endforeach
                            </div>
                        </div>
                    @endif
                </div>
            </div>
        @endif
    </div>
</div>

<!-- Recent Posts -->
@if($recentPosts->count() > 0)
<section class="bg-white py-12">
    <div class="max-w-6xl mx-auto px-4 sm:px-6 lg:px-8">
        <h3 class="text-2xl font-bold text-gray-900 mb-8 text-center">Artigos Recentes</h3>
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
            @foreach($recentPosts as $recentPost)
                <article class="bg-gray-50 rounded-lg overflow-hidden hover:shadow-md transition-shadow">
                    @if($recentPost->featured_image)
                        <img src="{{ asset('storage/' . $recentPost->featured_image) }}" 
                             alt="{{ $recentPost->title }}" 
                             class="w-full h-32 object-cover">
                    @endif
                    <div class="p-4">
                        <span class="text-blue-600 text-sm font-medium">{{ $recentPost->category->name }}</span>
                        <h4 class="font-semibold text-gray-900 mb-2 mt-1 hover:text-purple-600 transition-colors">
                            <a href="{{ route('blog.show', $recentPost) }}">
                                {{ Str::limit($recentPost->title, 60) }}
                            </a>
                        </h4>
                        <p class="text-gray-600 text-sm mb-3">
                            {{ $recentPost->created_at->format('d/m/Y') }}
                        </p>
                        <a href="{{ route('blog.show', $recentPost) }}" 
                           class="text-purple-600 hover:text-purple-800 text-sm font-medium">
                            Ler mais <i class="fas fa-arrow-right ml-1"></i>
                        </a>
                    </div>
                </article>
            @endforeach
        </div>
    </div>
</section>
@endif
@endsection

@push('scripts')
<script>
// Auto-focus search input
document.addEventListener('DOMContentLoaded', function() {
    const searchInput = document.querySelector('input[name="q"]');
    if (searchInput && !searchInput.value) {
        searchInput.focus();
    }
});

// Search suggestions
const searchInput = document.querySelector('input[name="q"]');
if (searchInput) {
    let timeout;
    searchInput.addEventListener('input', function() {
        clearTimeout(timeout);
        timeout = setTimeout(() => {
            // Here you could implement search suggestions via AJAX
            console.log('Search suggestions for:', this.value);
        }, 300);
    });
}

// Highlight search terms in results
function highlightSearchTerms() {
    const searchTerm = '{{ request("q") }}';
    if (!searchTerm) return;
    
    const terms = searchTerm.toLowerCase().split(' ');
    const articles = document.querySelectorAll('article h3, article p');
    
    articles.forEach(element => {
        let html = element.innerHTML;
        terms.forEach(term => {
            if (term.length > 2) {
                const regex = new RegExp(`(${term})`, 'gi');
                html = html.replace(regex, '<mark class="bg-yellow-200 px-1 rounded">$1</mark>');
            }
        });
        element.innerHTML = html;
    });
}

// Call highlight function after page load
document.addEventListener('DOMContentLoaded', highlightSearchTerms);
</script>
@endpush