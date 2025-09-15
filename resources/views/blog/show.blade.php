@extends('blog.layout')

@section('title', $post->title)
@section('description', $post->excerpt ?: Str::limit(strip_tags($post->content), 160))
@section('keywords', $post->tags->pluck('name')->implode(', '))

@section('content')
<!-- Breadcrumb -->
<nav class="bg-gray-100 py-4">
    <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8">
        <ol class="flex items-center space-x-2 text-sm text-gray-600">
            <li><a href="{{ route('blog.index') }}" class="hover:text-blue-600">Início</a></li>
            <li><i class="fas fa-chevron-right text-xs"></i></li>
            <li><a href="{{ route('blog.category', $post->category) }}" class="hover:text-blue-600">{{ $post->category->name }}</a></li>
            <li><i class="fas fa-chevron-right text-xs"></i></li>
            <li class="text-gray-900 font-medium">{{ Str::limit($post->title, 50) }}</li>
        </ol>
    </div>
</nav>

<!-- Article Header -->
<article class="bg-white">
    <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 py-12">
        <!-- Post Meta -->
        <div class="mb-8">
            <div class="flex items-center mb-4">
                <span class="bg-blue-100 text-blue-800 text-sm font-semibold px-3 py-1 rounded">
                    {{ $post->category->name }}
                </span>
                <span class="text-gray-500 text-sm ml-4">
                    <i class="fas fa-calendar mr-1"></i>
                    {{ $post->created_at->format('d \d\e F \d\e Y') }}
                </span>
                <span class="text-gray-500 text-sm ml-4">
                    <i class="fas fa-eye mr-1"></i>
                    {{ $post->views ?? 0 }} visualizações
                </span>
            </div>
            
            <h1 class="text-3xl md:text-4xl lg:text-5xl font-bold text-gray-900 leading-tight mb-6">
                {{ $post->title }}
            </h1>
            
            @if($post->excerpt)
                <p class="text-xl text-gray-600 leading-relaxed mb-6">
                    {{ $post->excerpt }}
                </p>
            @endif
            
            <!-- Author Info -->
            <div class="flex items-center justify-between border-t border-b border-gray-200 py-4">
                <div class="flex items-center">
                    <div class="w-12 h-12 bg-blue-500 rounded-full flex items-center justify-center text-white font-semibold text-lg">
                        {{ substr($post->user->name, 0, 1) }}
                    </div>
                    <div class="ml-4">
                        <p class="text-gray-900 font-semibold">{{ $post->user->name }}</p>
                        <p class="text-gray-600 text-sm">Autor</p>
                    </div>
                </div>
                
                <!-- Social Share -->
                <div class="flex items-center space-x-3">
                    <span class="text-gray-600 text-sm">Compartilhar:</span>
                    <a href="https://twitter.com/intent/tweet?text={{ urlencode($post->title) }}&url={{ urlencode(request()->url()) }}" 
                       target="_blank" 
                       class="text-blue-400 hover:text-blue-600 transition-colors">
                        <i class="fab fa-twitter text-lg"></i>
                    </a>
                    <a href="https://www.facebook.com/sharer/sharer.php?u={{ urlencode(request()->url()) }}" 
                       target="_blank" 
                       class="text-blue-600 hover:text-blue-800 transition-colors">
                        <i class="fab fa-facebook text-lg"></i>
                    </a>
                    <a href="https://www.linkedin.com/sharing/share-offsite/?url={{ urlencode(request()->url()) }}" 
                       target="_blank" 
                       class="text-blue-700 hover:text-blue-900 transition-colors">
                        <i class="fab fa-linkedin text-lg"></i>
                    </a>
                    <button onclick="copyToClipboard('{{ request()->url() }}')" 
                            class="text-gray-600 hover:text-gray-800 transition-colors" 
                            title="Copiar link">
                        <i class="fas fa-link text-lg"></i>
                    </button>
                </div>
            </div>
        </div>
        
        <!-- Featured Image -->
        @if($post->featured_image)
            <div class="mb-8">
                <img src="{{ asset('storage/' . $post->featured_image) }}" 
                     alt="{{ $post->title }}" 
                     class="w-full h-64 md:h-96 object-cover rounded-lg shadow-lg">
            </div>
        @endif
        
        <!-- Post Content -->
        <div class="prose prose-lg max-w-none mb-12">
            <div class="text-gray-800 leading-relaxed">
                {!! $post->content !!}
            </div>
        </div>
        
        <!-- Tags -->
        @if($post->tags->count() > 0)
            <div class="mb-12">
                <h3 class="text-lg font-semibold text-gray-900 mb-4">Tags:</h3>
                <div class="flex flex-wrap gap-2">
                    @foreach($post->tags as $tag)
                        <a href="{{ route('blog.tag', $tag) }}" 
                           class="bg-gray-100 text-gray-700 px-3 py-1 rounded-full text-sm hover:bg-blue-100 hover:text-blue-800 transition-colors">
                            #{{ $tag->name }}
                        </a>
                    @endforeach
                </div>
            </div>
        @endif
        
        <!-- Related Posts -->
        @if($relatedPosts->count() > 0)
            <div class="border-t border-gray-200 pt-12 mb-12">
                <h3 class="text-2xl font-bold text-gray-900 mb-8">Artigos Relacionados</h3>
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                    @foreach($relatedPosts as $relatedPost)
                        <article class="bg-gray-50 rounded-lg overflow-hidden hover:shadow-md transition-shadow">
                            @if($relatedPost->featured_image)
                                <img src="{{ asset('storage/' . $relatedPost->featured_image) }}" 
                                     alt="{{ $relatedPost->title }}" 
                                     class="w-full h-32 object-cover">
                            @endif
                            <div class="p-4">
                                <h4 class="font-semibold text-gray-900 mb-2 hover:text-blue-600 transition-colors">
                                    <a href="{{ route('blog.show', $relatedPost) }}">
                                        {{ Str::limit($relatedPost->title, 60) }}
                                    </a>
                                </h4>
                                <p class="text-gray-600 text-sm mb-3">
                                    {{ $relatedPost->created_at->format('d/m/Y') }}
                                </p>
                                <a href="{{ route('blog.show', $relatedPost) }}" 
                                   class="text-blue-600 hover:text-blue-800 text-sm font-medium">
                                    Ler mais <i class="fas fa-arrow-right ml-1"></i>
                                </a>
                            </div>
                        </article>
                    @endforeach
                </div>
            </div>
        @endif
    </div>
</article>

<!-- Comments Section -->
<section class="bg-gray-50 py-12">
    <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8">
        <h3 class="text-2xl font-bold text-gray-900 mb-8">
            Comentários ({{ $post->comments->where('status', 'approved')->count() }})
        </h3>
        
        <!-- Comment Form -->
        <div class="bg-white rounded-lg shadow-sm p-6 mb-8">
            <h4 class="text-lg font-semibold text-gray-900 mb-4">Deixe seu comentário</h4>
            
            @if(session('comment_success'))
                <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded mb-4">
                    {{ session('comment_success') }}
                </div>
            @endif
            
            <form action="{{ route('comments.store') }}" method="POST">
                @csrf
                <input type="hidden" name="post_id" value="{{ $post->id }}">
                
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-4">
                    <div>
                        <label for="author_name" class="block text-sm font-medium text-gray-700 mb-2">Nome *</label>
                        <input type="text" name="author_name" id="author_name" value="{{ old('author_name') }}" 
                               class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500 @error('author_name') border-red-500 @enderror" 
                               required>
                        @error('author_name')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>
                    
                    <div>
                        <label for="author_email" class="block text-sm font-medium text-gray-700 mb-2">E-mail *</label>
                        <input type="email" name="author_email" id="author_email" value="{{ old('author_email') }}" 
                               class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500 @error('author_email') border-red-500 @enderror" 
                               required>
                        @error('author_email')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>
                </div>
                
                <div class="mb-4">
                    <label for="content" class="block text-sm font-medium text-gray-700 mb-2">Comentário *</label>
                    <textarea name="content" id="content" rows="4" 
                              class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500 @error('content') border-red-500 @enderror" 
                              placeholder="Escreva seu comentário..." 
                              required>{{ old('content') }}</textarea>
                    @error('content')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>
                
                <div class="flex items-center justify-between">
                    <p class="text-sm text-gray-600">
                        Seu comentário será revisado antes da publicação.
                    </p>
                    <button type="submit" 
                            class="bg-blue-600 text-white px-6 py-2 rounded-md hover:bg-blue-700 transition-colors">
                        Enviar Comentário
                    </button>
                </div>
            </form>
        </div>
        
        <!-- Comments List -->
        @if($post->comments->where('status', 'approved')->count() > 0)
            <div class="space-y-6">
                @foreach($post->comments->where('status', 'approved')->sortByDesc('created_at') as $comment)
                    <div class="bg-white rounded-lg shadow-sm p-6">
                        <div class="flex items-start justify-between mb-4">
                            <div class="flex items-center">
                                <div class="w-10 h-10 bg-blue-500 rounded-full flex items-center justify-center text-white font-semibold">
                                    {{ substr($comment->author_name, 0, 1) }}
                                </div>
                                <div class="ml-3">
                                    <h5 class="font-semibold text-gray-900">{{ $comment->author_name }}</h5>
                                    <p class="text-sm text-gray-600">{{ $comment->created_at->format('d/m/Y \à\s H:i') }}</p>
                                </div>
                            </div>
                        </div>
                        <p class="text-gray-800 leading-relaxed">
                            {{ $comment->content }}
                        </p>
                    </div>
                @endforeach
            </div>
        @else
            <div class="text-center py-8">
                <i class="fas fa-comments text-4xl text-gray-300 mb-4"></i>
                <h4 class="text-lg font-semibold text-gray-600 mb-2">Nenhum comentário ainda</h4>
                <p class="text-gray-500">Seja o primeiro a comentar este artigo!</p>
            </div>
        @endif
    </div>
</section>
@endsection

@push('scripts')
<script>
function copyToClipboard(text) {
    navigator.clipboard.writeText(text).then(function() {
        // Show success message
        const button = event.target.closest('button');
        const originalIcon = button.innerHTML;
        button.innerHTML = '<i class="fas fa-check text-lg"></i>';
        button.classList.add('text-green-600');
        
        setTimeout(() => {
            button.innerHTML = originalIcon;
            button.classList.remove('text-green-600');
        }, 2000);
    }).catch(function(err) {
        console.error('Erro ao copiar: ', err);
    });
}

// Auto-fill form if user is logged in
@auth
document.addEventListener('DOMContentLoaded', function() {
    const nameField = document.getElementById('author_name');
    const emailField = document.getElementById('author_email');
    
    if (nameField && !nameField.value) {
        nameField.value = '{{ Auth::user()->name ?? '' }}';
    }
    if (emailField && !emailField.value) {
        emailField.value = '{{ Auth::user()->email ?? '' }}';
    }
});
@endauth
</script>
@endpush