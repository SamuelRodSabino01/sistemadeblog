@extends('admin.layout')

@section('title', $post->title)

@section('content')
<div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
    <div class="p-6 text-gray-900">
        <div class="flex justify-between items-center mb-6">
            <h1 class="text-2xl font-bold">{{ $post->title }}</h1>
            <div class="flex space-x-2">
                @if($post->status === 'published')
                    <a href="{{ route('blog.show', $post) }}" target="_blank" class="bg-green-500 hover:bg-green-700 text-white font-bold py-2 px-4 rounded">
                        Ver no Site
                    </a>
                @endif
                <a href="{{ route('admin.posts.edit', $post) }}" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">
                    Editar
                </a>
                <a href="{{ route('admin.posts.index') }}" class="bg-gray-500 hover:bg-gray-700 text-white font-bold py-2 px-4 rounded">
                    Voltar
                </a>
            </div>
        </div>
        
        <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
            <!-- Conteúdo Principal -->
            <div class="lg:col-span-2">
                <!-- Imagem Destacada -->
                @if($post->featured_image)
                    <div class="mb-6">
                        <img src="{{ asset('storage/' . $post->featured_image) }}" alt="{{ $post->title }}" class="w-full h-64 object-cover rounded-lg shadow-md">
                    </div>
                @endif
                
                <!-- Resumo -->
                @if($post->excerpt)
                    <div class="mb-6 p-4 bg-gray-50 rounded-lg border-l-4 border-blue-500">
                        <h3 class="text-lg font-semibold text-gray-900 mb-2">Resumo</h3>
                        <p class="text-gray-700 italic">{{ $post->excerpt }}</p>
                    </div>
                @endif
                
                <!-- Conteúdo -->
                <div class="prose max-w-none">
                    <h3 class="text-lg font-semibold text-gray-900 mb-4">Conteúdo</h3>
                    <div class="bg-white p-6 rounded-lg border border-gray-200">
                        {!! $post->content !!}
                    </div>
                </div>
                
                <!-- Comentários -->
                @if($post->comments->count() > 0)
                    <div class="mt-8">
                        <h3 class="text-lg font-semibold text-gray-900 mb-4">Comentários ({{ $post->comments->count() }})</h3>
                        
                        <div class="space-y-4">
                            @foreach($post->comments->sortByDesc('created_at') as $comment)
                                <div class="bg-gray-50 p-4 rounded-lg border {{ $comment->status === 'pending' ? 'border-yellow-300 bg-yellow-50' : ($comment->status === 'approved' ? 'border-green-300 bg-green-50' : 'border-red-300 bg-red-50') }}">
                                    <div class="flex justify-between items-start mb-2">
                                        <div>
                                            <h4 class="font-semibold text-gray-900">{{ $comment->author_name }}</h4>
                                            <p class="text-sm text-gray-600">{{ $comment->author_email }}</p>
                                            <p class="text-xs text-gray-500">{{ $comment->created_at->format('d/m/Y H:i') }}</p>
                                        </div>
                                        <div class="flex items-center space-x-2">
                                            <span class="px-2 py-1 text-xs font-semibold rounded-full 
                                                {{ $comment->status === 'approved' ? 'bg-green-100 text-green-800' : 
                                                   ($comment->status === 'pending' ? 'bg-yellow-100 text-yellow-800' : 'bg-red-100 text-red-800') }}">
                                                {{ $comment->status === 'approved' ? 'Aprovado' : ($comment->status === 'pending' ? 'Pendente' : 'Rejeitado') }}
                                            </span>
                                            
                                            @if($comment->status === 'pending')
                                                <div class="flex space-x-1">
                                                    <form action="{{ route('admin.comments.approve', $comment) }}" method="POST" class="inline">
                                                        @csrf
                                                        <button type="submit" class="text-green-600 hover:text-green-900 text-xs">
                                                            Aprovar
                                                        </button>
                                                    </form>
                                                    <form action="{{ route('admin.comments.reject', $comment) }}" method="POST" class="inline">
                                                        @csrf
                                                        <button type="submit" class="text-red-600 hover:text-red-900 text-xs">
                                                            Rejeitar
                                                        </button>
                                                    </form>
                                                </div>
                                            @endif
                                            
                                            <form action="{{ route('admin.comments.destroy', $comment) }}" method="POST" class="inline" onsubmit="return confirm('Tem certeza que deseja excluir este comentário?')">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="text-red-600 hover:text-red-900 text-xs">
                                                    Excluir
                                                </button>
                                            </form>
                                        </div>
                                    </div>
                                    <p class="text-gray-700">{{ $comment->content }}</p>
                                </div>
                            @endforeach
                        </div>
                    </div>
                @endif
            </div>
            
            <!-- Sidebar -->
            <div class="space-y-6">
                <!-- Informações do Post -->
                <div class="bg-gray-50 p-4 rounded-lg">
                    <h3 class="text-lg font-medium text-gray-900 mb-4">Informações</h3>
                    
                    <div class="space-y-3 text-sm">
                        <div>
                            <span class="font-medium text-gray-700">Status:</span>
                            <span class="ml-2 px-2 py-1 text-xs font-semibold rounded-full {{ $post->status === 'published' ? 'bg-green-100 text-green-800' : 'bg-yellow-100 text-yellow-800' }}">
                                {{ $post->status === 'published' ? 'Publicado' : 'Rascunho' }}
                            </span>
                        </div>
                        
                        <div>
                            <span class="font-medium text-gray-700">Autor:</span>
                            <span class="ml-2 text-gray-600">{{ $post->user->name }}</span>
                        </div>
                        
                        <div>
                            <span class="font-medium text-gray-700">Categoria:</span>
                            <span class="ml-2 text-gray-600">{{ $post->category->name }}</span>
                        </div>
                        
                        <div>
                            <span class="font-medium text-gray-700">Slug:</span>
                            <span class="ml-2 text-gray-600 font-mono text-xs">{{ $post->slug }}</span>
                        </div>
                        
                        <div>
                            <span class="font-medium text-gray-700">Criado em:</span>
                            <span class="ml-2 text-gray-600">{{ $post->created_at->format('d/m/Y H:i') }}</span>
                        </div>
                        
                        <div>
                            <span class="font-medium text-gray-700">Atualizado em:</span>
                            <span class="ml-2 text-gray-600">{{ $post->updated_at->format('d/m/Y H:i') }}</span>
                        </div>
                    </div>
                </div>
                
                <!-- Tags -->
                @if($post->tags->count() > 0)
                    <div class="bg-gray-50 p-4 rounded-lg">
                        <h3 class="text-lg font-medium text-gray-900 mb-4">Tags</h3>
                        
                        <div class="flex flex-wrap gap-2">
                            @foreach($post->tags as $tag)
                                <span class="px-3 py-1 bg-blue-100 text-blue-800 text-sm rounded-full">
                                    {{ $tag->name }}
                                </span>
                            @endforeach
                        </div>
                    </div>
                @endif
                
                <!-- Estatísticas -->
                <div class="bg-gray-50 p-4 rounded-lg">
                    <h3 class="text-lg font-medium text-gray-900 mb-4">Estatísticas</h3>
                    
                    <div class="space-y-3">
                        <div class="flex justify-between">
                            <span class="text-sm font-medium text-gray-700">Visualizações:</span>
                            <span class="text-sm text-gray-600">{{ $post->views ?? 0 }}</span>
                        </div>
                        
                        <div class="flex justify-between">
                            <span class="text-sm font-medium text-gray-700">Comentários:</span>
                            <span class="text-sm text-gray-600">{{ $post->comments->count() }}</span>
                        </div>
                        
                        <div class="flex justify-between">
                            <span class="text-sm font-medium text-gray-700">Aprovados:</span>
                            <span class="text-sm text-green-600">{{ $post->comments->where('status', 'approved')->count() }}</span>
                        </div>
                        
                        <div class="flex justify-between">
                            <span class="text-sm font-medium text-gray-700">Pendentes:</span>
                            <span class="text-sm text-yellow-600">{{ $post->comments->where('status', 'pending')->count() }}</span>
                        </div>
                        
                        <div class="flex justify-between">
                            <span class="text-sm font-medium text-gray-700">Tags:</span>
                            <span class="text-sm text-gray-600">{{ $post->tags->count() }}</span>
                        </div>
                    </div>
                </div>
                
                <!-- Ações Rápidas -->
                <div class="bg-gray-50 p-4 rounded-lg">
                    <h3 class="text-lg font-medium text-gray-900 mb-4">Ações</h3>
                    
                    <div class="space-y-2">
                        <a href="{{ route('admin.posts.edit', $post) }}" class="block w-full text-center bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">
                            Editar Post
                        </a>
                        
                        @if($post->status === 'published')
                            <a href="{{ route('blog.show', $post) }}" target="_blank" class="block w-full text-center bg-green-500 hover:bg-green-700 text-white font-bold py-2 px-4 rounded">
                                Ver no Site
                            </a>
                        @endif
                        
                        <form action="{{ route('admin.posts.destroy', $post) }}" method="POST" onsubmit="return confirm('Tem certeza que deseja excluir este post?')">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="block w-full bg-red-500 hover:bg-red-700 text-white font-bold py-2 px-4 rounded">
                                Excluir Post
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection