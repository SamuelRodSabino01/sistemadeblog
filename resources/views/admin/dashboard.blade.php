@extends('admin.layout')

@section('title', 'Dashboard')

@section('content')
<div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
    <div class="p-6 text-gray-900">
        <h1 class="text-2xl font-bold mb-6">Dashboard</h1>
        
        <!-- Estatísticas -->
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-8">
            <div class="bg-blue-50 p-6 rounded-lg">
                <div class="flex items-center">
                    <div class="p-2 bg-blue-500 rounded-lg">
                        <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                        </svg>
                    </div>
                    <div class="ml-4">
                        <p class="text-sm font-medium text-gray-600">Total de Posts</p>
                        <p class="text-2xl font-bold text-gray-900">{{ $stats['total_posts'] }}</p>
                    </div>
                </div>
            </div>
            
            <div class="bg-green-50 p-6 rounded-lg">
                <div class="flex items-center">
                    <div class="p-2 bg-green-500 rounded-lg">
                        <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                        </svg>
                    </div>
                    <div class="ml-4">
                        <p class="text-sm font-medium text-gray-600">Posts Publicados</p>
                        <p class="text-2xl font-bold text-gray-900">{{ $stats['published_posts'] }}</p>
                    </div>
                </div>
            </div>
            
            <div class="bg-yellow-50 p-6 rounded-lg">
                <div class="flex items-center">
                    <div class="p-2 bg-yellow-500 rounded-lg">
                        <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                        </svg>
                    </div>
                    <div class="ml-4">
                        <p class="text-sm font-medium text-gray-600">Rascunhos</p>
                        <p class="text-2xl font-bold text-gray-900">{{ $stats['draft_posts'] }}</p>
                    </div>
                </div>
            </div>
            
            <div class="bg-purple-50 p-6 rounded-lg">
                <div class="flex items-center">
                    <div class="p-2 bg-purple-500 rounded-lg">
                        <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z"></path>
                        </svg>
                    </div>
                    <div class="ml-4">
                        <p class="text-sm font-medium text-gray-600">Comentários</p>
                        <p class="text-2xl font-bold text-gray-900">{{ $stats['total_comments'] }}</p>
                    </div>
                </div>
            </div>
        </div>
        
        <!-- Estatísticas adicionais -->
        <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-8">
            <div class="bg-white border border-gray-200 p-6 rounded-lg">
                <h3 class="text-lg font-semibold mb-2">Categorias</h3>
                <p class="text-3xl font-bold text-indigo-600">{{ $stats['total_categories'] }}</p>
            </div>
            
            <div class="bg-white border border-gray-200 p-6 rounded-lg">
                <h3 class="text-lg font-semibold mb-2">Tags</h3>
                <p class="text-3xl font-bold text-indigo-600">{{ $stats['total_tags'] }}</p>
            </div>
            
            <div class="bg-white border border-gray-200 p-6 rounded-lg">
                <h3 class="text-lg font-semibold mb-2">Comentários Pendentes</h3>
                <p class="text-3xl font-bold text-red-600">{{ $stats['pending_comments'] }}</p>
            </div>
        </div>
        
        <!-- Posts recentes e comentários -->
        <div class="grid grid-cols-1 lg:grid-cols-2 gap-8">
            <!-- Posts recentes -->
            <div class="bg-white border border-gray-200 rounded-lg p-6">
                <h3 class="text-lg font-semibold mb-4">Posts Recentes</h3>
                <div class="space-y-4">
                    @forelse($recent_posts as $post)
                        <div class="flex items-center justify-between p-3 bg-gray-50 rounded">
                            <div>
                                <h4 class="font-medium">{{ Str::limit($post->title, 40) }}</h4>
                                <p class="text-sm text-gray-600">por {{ $post->user->name }} • {{ $post->created_at->diffForHumans() }}</p>
                            </div>
                            <span class="px-2 py-1 text-xs rounded {{ $post->status === 'published' ? 'bg-green-100 text-green-800' : 'bg-yellow-100 text-yellow-800' }}">
                                {{ $post->status === 'published' ? 'Publicado' : 'Rascunho' }}
                            </span>
                        </div>
                    @empty
                        <p class="text-gray-500">Nenhum post encontrado.</p>
                    @endforelse
                </div>
                <div class="mt-4">
                    <a href="{{ route('admin.posts.index') }}" class="text-indigo-600 hover:text-indigo-800 text-sm font-medium">Ver todos os posts →</a>
                </div>
            </div>
            
            <!-- Comentários recentes -->
            <div class="bg-white border border-gray-200 rounded-lg p-6">
                <h3 class="text-lg font-semibold mb-4">Comentários Recentes</h3>
                <div class="space-y-4">
                    @forelse($recent_comments as $comment)
                        <div class="p-3 bg-gray-50 rounded">
                            <div class="flex items-center justify-between mb-2">
                                <span class="font-medium text-sm">{{ $comment->user ? $comment->user->name : $comment->author_name }}</span>
                                <span class="px-2 py-1 text-xs rounded {{ $comment->status === 'approved' ? 'bg-green-100 text-green-800' : 'bg-yellow-100 text-yellow-800' }}">
                                    {{ $comment->status === 'approved' ? 'Aprovado' : 'Pendente' }}
                                </span>
                            </div>
                            <p class="text-sm text-gray-600 mb-1">{{ Str::limit($comment->content, 80) }}</p>
                            <p class="text-xs text-gray-500">em "{{ Str::limit($comment->post->title, 30) }}" • {{ $comment->created_at->diffForHumans() }}</p>
                        </div>
                    @empty
                        <p class="text-gray-500">Nenhum comentário encontrado.</p>
                    @endforelse
                </div>
            </div>
        </div>
    </div>
</div>
@endsection