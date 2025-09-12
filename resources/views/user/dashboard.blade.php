<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Dashboard do Usuário') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <h3 class="text-lg font-medium mb-4">Bem-vindo, {{ auth()->user()->name }}!</h3>
                    
                    <!-- Estatísticas do Usuário -->
                    <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-8">
                        <div class="bg-blue-50 p-4 rounded-lg">
                            <div class="flex items-center">
                                <div class="p-2 bg-blue-500 rounded-lg">
                                    <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z"></path>
                                    </svg>
                                </div>
                                <div class="ml-4">
                                    <p class="text-sm font-medium text-gray-600">Meus Comentários</p>
                                    <p class="text-2xl font-bold text-gray-900">{{ $userStats['total_comments'] }}</p>
                                </div>
                            </div>
                        </div>
                        
                        <div class="bg-green-50 p-4 rounded-lg">
                            <div class="flex items-center">
                                <div class="p-2 bg-green-500 rounded-lg">
                                    <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.746 0 3.332.477 4.5 1.253v13C19.832 18.477 18.246 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"></path>
                                    </svg>
                                </div>
                                <div class="ml-4">
                                    <p class="text-sm font-medium text-gray-600">Posts Recentes</p>
                                    <p class="text-2xl font-bold text-gray-900">{{ $userStats['recent_posts']->count() }}</p>
                                </div>
                            </div>
                        </div>
                        
                        <div class="bg-purple-50 p-4 rounded-lg">
                            <div class="flex items-center">
                                <div class="p-2 bg-purple-500 rounded-lg">
                                    <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                                    </svg>
                                </div>
                                <div class="ml-4">
                                    <p class="text-sm font-medium text-gray-600">Perfil</p>
                                    <p class="text-sm font-bold text-gray-900">Usuário</p>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Posts Recentes -->
                    <div class="mb-8">
                        <h4 class="text-lg font-medium mb-4">Posts Recentes do Blog</h4>
                        @if($userStats['recent_posts']->count() > 0)
                            <div class="space-y-4">
                                @foreach($userStats['recent_posts'] as $post)
                                    <div class="border rounded-lg p-4 hover:bg-gray-50">
                                        <h5 class="font-medium text-gray-900">
                                            <a href="{{ route('blog.show', $post->slug) }}" class="hover:text-blue-600">
                                                {{ $post->title }}
                                            </a>
                                        </h5>
                                        <p class="text-sm text-gray-600 mt-1">{{ Str::limit($post->excerpt, 100) }}</p>
                                        <p class="text-xs text-gray-500 mt-2">{{ $post->created_at->format('d/m/Y H:i') }}</p>
                                    </div>
                                @endforeach
                            </div>
                        @else
                            <p class="text-gray-600">Nenhum post encontrado.</p>
                        @endif
                    </div>

                    <!-- Meus Comentários -->
                    <div>
                        <h4 class="text-lg font-medium mb-4">Meus Comentários Recentes</h4>
                        @if($userStats['user_comments']->count() > 0)
                            <div class="space-y-4">
                                @foreach($userStats['user_comments'] as $comment)
                                    <div class="border rounded-lg p-4 hover:bg-gray-50">
                                        <p class="text-sm text-gray-900">{{ Str::limit($comment->content, 150) }}</p>
                                        <div class="mt-2 flex items-center justify-between">
                                            <p class="text-xs text-gray-600">
                                                Em: <a href="{{ route('blog.show', $comment->post->slug) }}" class="hover:text-blue-600">{{ $comment->post->title }}</a>
                                            </p>
                                            <span class="text-xs px-2 py-1 rounded-full 
                                                @if($comment->status === 'approved') bg-green-100 text-green-800
                                                @elseif($comment->status === 'rejected') bg-red-100 text-red-800
                                                @else bg-yellow-100 text-yellow-800 @endif">
                                                {{ ucfirst($comment->status) }}
                                            </span>
                                        </div>
                                        <p class="text-xs text-gray-500 mt-1">{{ $comment->created_at->format('d/m/Y H:i') }}</p>
                                    </div>
                                @endforeach
                            </div>
                        @else
                            <p class="text-gray-600">Você ainda não fez nenhum comentário.</p>
                        @endif
                    </div>

                    <!-- Links Úteis -->
                    <div class="mt-8 pt-6 border-t">
                        <h4 class="text-lg font-medium mb-4">Links Úteis</h4>
                        <div class="flex flex-wrap gap-4">
                            <a href="{{ route('blog.index') }}" class="inline-flex items-center px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700">
                                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 7v10a2 2 0 002 2h14a2 2 0 002-2V9a2 2 0 00-2-2H5a2 2 0 00-2-2z"></path>
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m7 7 5-5 5 5"></path>
                                </svg>
                                Ver Blog
                            </a>
                            <a href="{{ route('profile.edit') }}" class="inline-flex items-center px-4 py-2 bg-gray-600 text-white rounded-lg hover:bg-gray-700">
                                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                                </svg>
                                Editar Perfil
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>