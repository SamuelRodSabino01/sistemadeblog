@extends('blog.layout')

@section('title', 'Início')
@section('description', 'Bem-vindo ao nosso blog! Descubra artigos interessantes sobre tecnologia, desenvolvimento e muito mais.')

@section('content')
<!-- Hero Section -->
<section class="gradient-bg text-white py-20">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 text-center">
        <h1 class="text-4xl md:text-6xl font-bold mb-6">
            Bem-vindo ao nosso Blog
        </h1>
        <p class="text-xl md:text-2xl mb-8 text-blue-100 max-w-3xl mx-auto">
            Descubra artigos interessantes sobre tecnologia, desenvolvimento e muito mais. 
            Compartilhamos conhecimento e experiências para ajudar você a crescer.
        </p>
        <div class="flex flex-col sm:flex-row gap-4 justify-center">
            <a href="#posts" class="bg-white text-blue-600 px-8 py-3 rounded-lg font-semibold hover:bg-blue-50 transition-colors">
                Ver Artigos
            </a>
            <a href="{{ route('blog.search') }}" class="border-2 border-white text-white px-8 py-3 rounded-lg font-semibold hover:bg-white hover:text-blue-600 transition-colors">
                Buscar Posts
            </a>
        </div>
    </div>
</section>

<!-- Stats Section -->
<section class="py-16 bg-white">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="grid grid-cols-2 md:grid-cols-4 gap-8 text-center">
            <div>
                <div class="text-3xl md:text-4xl font-bold text-blue-600 mb-2">{{ $stats['total_posts'] }}</div>
                <div class="text-gray-600 font-medium">Artigos Publicados</div>
            </div>
            <div>
                <div class="text-3xl md:text-4xl font-bold text-green-600 mb-2">{{ $stats['total_categories'] }}</div>
                <div class="text-gray-600 font-medium">Categorias</div>
            </div>
            <div>
                <div class="text-3xl md:text-4xl font-bold text-purple-600 mb-2">{{ $stats['total_tags'] }}</div>
                <div class="text-gray-600 font-medium">Tags</div>
            </div>
            <div>
                <div class="text-3xl md:text-4xl font-bold text-orange-600 mb-2">{{ $stats['total_comments'] }}</div>
                <div class="text-gray-600 font-medium">Comentários</div>
            </div>
        </div>
    </div>
</section>

<!-- Featured Posts -->
@if($featuredPosts->count() > 0)
<section class="py-16 bg-gray-50">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="text-center mb-12">
            <h2 class="text-3xl md:text-4xl font-bold text-gray-900 mb-4">
                Posts em Destaque
            </h2>
            <p class="text-xl text-gray-600 max-w-2xl mx-auto">
                Confira nossos artigos mais populares e recentes
            </p>
        </div>
        
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
            @foreach($featuredPosts as $post)
                <article class="bg-white rounded-lg shadow-md overflow-hidden hover:shadow-lg transition-shadow">
                    @if($post->featured_image)
                        <div class="aspect-w-16 aspect-h-9">
                            <img src="{{ asset('storage/' . $post->featured_image) }}" 
                                 alt="{{ $post->title }}" 
                                 class="w-full h-48 object-cover">
                        </div>
                    @endif
                    
                    <div class="p-6">
                        <div class="flex items-center mb-3">
                            <span class="bg-blue-100 text-blue-800 text-xs font-semibold px-2.5 py-0.5 rounded">
                                {{ $post->category->name }}
                            </span>
                            <span class="text-gray-500 text-sm ml-auto">
                                {{ $post->created_at->format('d/m/Y') }}
                            </span>
                        </div>
                        
                        <h3 class="text-xl font-bold text-gray-900 mb-3 hover:text-blue-600 transition-colors">
                            <a href="{{ route('blog.show', $post) }}">
                                {{ $post->title }}
                            </a>
                        </h3>
                        
                        @if($post->excerpt)
                            <p class="text-gray-600 mb-4 line-clamp-3">
                                {{ $post->excerpt }}
                            </p>
                        @endif
                        
                        <div class="flex items-center justify-between">
                            <div class="flex items-center text-sm text-gray-500">
                                <i class="fas fa-user mr-1"></i>
                                {{ $post->user->name }}
                            </div>
                            <a href="{{ route('blog.show', $post) }}" 
                               class="text-blue-600 hover:text-blue-800 font-medium text-sm">
                                Ler mais <i class="fas fa-arrow-right ml-1"></i>
                            </a>
                        </div>
                    </div>
                </article>
            @endforeach
        </div>
    </div>
</section>
@endif

<!-- Recent Posts -->
<section id="posts" class="py-16 bg-white">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex justify-between items-center mb-12">
            <div>
                <h2 class="text-3xl md:text-4xl font-bold text-gray-900 mb-4">
                    Artigos Recentes
                </h2>
                <p class="text-xl text-gray-600">
                    Fique por dentro das últimas publicações
                </p>
            </div>
            <a href="{{ route('blog.search') }}" 
               class="hidden sm:inline-flex items-center bg-blue-600 text-white px-6 py-3 rounded-lg hover:bg-blue-700 transition-colors">
                Ver Todos <i class="fas fa-arrow-right ml-2"></i>
            </a>
        </div>
        
        @if($posts->count() > 0)
            <div class="space-y-8">
                @foreach($posts as $post)
                    <article class="flex flex-col md:flex-row bg-white border border-gray-200 rounded-lg overflow-hidden hover:shadow-md transition-shadow">
                        @if($post->featured_image)
                            <div class="md:w-1/3">
                                <img src="{{ asset('storage/' . $post->featured_image) }}" 
                                     alt="{{ $post->title }}" 
                                     class="w-full h-48 md:h-full object-cover">
                            </div>
                        @endif
                        
                        <div class="flex-1 p-6">
                            <div class="flex items-center mb-3">
                                <span class="bg-blue-100 text-blue-800 text-xs font-semibold px-2.5 py-0.5 rounded">
                                    {{ $post->category->name }}
                                </span>
                                <span class="text-gray-500 text-sm ml-4">
                                    <i class="fas fa-calendar mr-1"></i>
                                    {{ $post->created_at->format('d/m/Y') }}
                                </span>
                                <span class="text-gray-500 text-sm ml-4">
                                    <i class="fas fa-user mr-1"></i>
                                    {{ $post->user->name }}
                                </span>
                            </div>
                            
                            <h3 class="text-2xl font-bold text-gray-900 mb-3 hover:text-blue-600 transition-colors">
                                <a href="{{ route('blog.show', $post) }}">
                                    {{ $post->title }}
                                </a>
                            </h3>
                            
                            @if($post->excerpt)
                                <p class="text-gray-600 mb-4 line-clamp-3">
                                    {{ $post->excerpt }}
                                </p>
                            @endif
                            
                            @if($post->tags->count() > 0)
                                <div class="flex flex-wrap gap-2 mb-4">
                                    @foreach($post->tags->take(3) as $tag)
                                        <a href="{{ route('blog.tag', $tag) }}" 
                                           class="text-xs bg-gray-100 text-gray-700 px-2 py-1 rounded hover:bg-gray-200 transition-colors">
                                            #{{ $tag->name }}
                                        </a>
                                    @endforeach
                                    @if($post->tags->count() > 3)
                                        <span class="text-xs text-gray-500">+{{ $post->tags->count() - 3 }} mais</span>
                                    @endif
                                </div>
                            @endif
                            
                            <div class="flex items-center justify-between">
                                <div class="flex items-center space-x-4 text-sm text-gray-500">
                                    <span>
                                        <i class="fas fa-comments mr-1"></i>
                                        {{ $post->comments->where('status', 'approved')->count() }} comentários
                                    </span>
                                    <span>
                                        <i class="fas fa-eye mr-1"></i>
                                        {{ $post->views ?? 0 }} visualizações
                                    </span>
                                </div>
                                <a href="{{ route('blog.show', $post) }}" 
                                   class="text-blue-600 hover:text-blue-800 font-medium">
                                    Ler artigo completo <i class="fas fa-arrow-right ml-1"></i>
                                </a>
                            </div>
                        </div>
                    </article>
                @endforeach
            </div>
            
            <!-- Pagination -->
            <div class="mt-12">
                {{ $posts->links() }}
            </div>
        @else
            <div class="text-center py-12">
                <i class="fas fa-newspaper text-6xl text-gray-300 mb-4"></i>
                <h3 class="text-xl font-semibold text-gray-600 mb-2">Nenhum post encontrado</h3>
                <p class="text-gray-500">Volte em breve para ver novos artigos!</p>
            </div>
        @endif
    </div>
</section>

<!-- Categories Section -->
@if($categories->count() > 0)
<section id="categories" class="py-16 bg-gray-50">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="text-center mb-12">
            <h2 class="text-3xl md:text-4xl font-bold text-gray-900 mb-4">
                Explore por Categoria
            </h2>
            <p class="text-xl text-gray-600 max-w-2xl mx-auto">
                Encontre artigos organizados por temas do seu interesse
            </p>
        </div>
        
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
            @foreach($categories as $category)
                <a href="{{ route('blog.category', $category) }}" 
                   class="bg-white p-6 rounded-lg shadow-md hover:shadow-lg transition-shadow group">
                    <div class="flex items-center justify-between mb-4">
                        <h3 class="text-xl font-semibold text-gray-900 group-hover:text-blue-600 transition-colors">
                            {{ $category->name }}
                        </h3>
                        <span class="bg-blue-100 text-blue-800 text-sm font-semibold px-2.5 py-0.5 rounded">
                            {{ $category->posts_count }} posts
                        </span>
                    </div>
                    @if($category->description)
                        <p class="text-gray-600 mb-4">
                            {{ Str::limit($category->description, 100) }}
                        </p>
                    @endif
                    <div class="text-blue-600 group-hover:text-blue-800 font-medium">
                        Ver artigos <i class="fas fa-arrow-right ml-1"></i>
                    </div>
                </a>
            @endforeach
        </div>
    </div>
</section>
@endif

<!-- Newsletter Section -->
<section class="py-16 bg-blue-600">
    <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 text-center">
        <h2 class="text-3xl md:text-4xl font-bold text-white mb-4">
            Fique por dentro das novidades
        </h2>
        <p class="text-xl text-blue-100 mb-8">
            Receba nossos melhores artigos diretamente no seu e-mail
        </p>
        <form class="flex flex-col sm:flex-row gap-4 max-w-md mx-auto">
            <input type="email" 
                   placeholder="Seu melhor e-mail" 
                   class="flex-1 px-4 py-3 rounded-lg border-0 focus:outline-none focus:ring-2 focus:ring-blue-300">
            <button type="submit" 
                    class="bg-white text-blue-600 px-8 py-3 rounded-lg font-semibold hover:bg-blue-50 transition-colors">
                Inscrever-se
            </button>
        </form>
        <p class="text-blue-200 text-sm mt-4">
            Não enviamos spam. Cancele a inscrição a qualquer momento.
        </p>
    </div>
</section>
@endsection

@push('styles')
<style>
    .line-clamp-3 {
        display: -webkit-box;
        -webkit-line-clamp: 3;
        -webkit-box-orient: vertical;
        overflow: hidden;
    }
</style>
@endpush