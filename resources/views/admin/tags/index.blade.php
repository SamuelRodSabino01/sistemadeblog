@extends('admin.layout')

@section('title', 'Tags')

@section('content')
<div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
    <div class="p-6 text-gray-900">
        <div class="flex justify-between items-center mb-6">
            <h1 class="text-2xl font-bold">Tags</h1>
            <a href="{{ route('admin.tags.create') }}" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">
                Nova Tag
            </a>
        </div>
        
        @if($tags->count() > 0)
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4 mb-6">
                @foreach($tags as $tag)
                    <div class="bg-white border border-gray-200 rounded-lg p-4 hover:shadow-md transition-shadow">
                        <div class="flex justify-between items-start mb-2">
                            <h3 class="text-lg font-semibold text-gray-900">{{ $tag->name }}</h3>
                            <span class="px-2 py-1 text-xs font-semibold rounded-full bg-blue-100 text-blue-800">
                                {{ $tag->posts_count }} posts
                            </span>
                        </div>
                        
                        <p class="text-sm text-gray-500 font-mono mb-2">{{ $tag->slug }}</p>
                        
                        @if($tag->description)
                            <p class="text-sm text-gray-600 mb-3">{{ Str::limit($tag->description, 80) }}</p>
                        @endif
                        
                        <div class="flex justify-between items-center text-xs text-gray-500 mb-3">
                            <span>Criada em {{ $tag->created_at->format('d/m/Y') }}</span>
                        </div>
                        
                        <div class="flex space-x-2 text-sm">
                            <a href="{{ route('admin.tags.show', $tag) }}" class="text-indigo-600 hover:text-indigo-900">Ver</a>
                            <a href="{{ route('admin.tags.edit', $tag) }}" class="text-yellow-600 hover:text-yellow-900">Editar</a>
                            <a href="{{ route('blog.tag', $tag) }}" target="_blank" class="text-green-600 hover:text-green-900">Visualizar</a>
                            @if($tag->posts_count == 0)
                                <form action="{{ route('admin.tags.destroy', $tag) }}" method="POST" class="inline" onsubmit="return confirm('Tem certeza que deseja excluir esta tag?')">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="text-red-600 hover:text-red-900">Excluir</button>
                                </form>
                            @else
                                <span class="text-gray-400" title="Não é possível excluir tag com posts">Excluir</span>
                            @endif
                        </div>
                    </div>
                @endforeach
            </div>
            
            <div class="mt-6">
                {{ $tags->links() }}
            </div>
            
            <!-- Tabela alternativa para telas menores -->
            <div class="md:hidden">
                <div class="overflow-x-auto">
                    <table class="min-w-full table-auto">
                        <thead class="bg-gray-50">
                            <tr>
                                <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Tag</th>
                                <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Posts</th>
                                <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Ações</th>
                            </tr>
                        </thead>
                        <tbody class="bg-white divide-y divide-gray-200">
                            @foreach($tags as $tag)
                                <tr>
                                    <td class="px-4 py-4">
                                        <div class="text-sm font-medium text-gray-900">{{ $tag->name }}</div>
                                        <div class="text-xs text-gray-500 font-mono">{{ $tag->slug }}</div>
                                    </td>
                                    <td class="px-4 py-4 whitespace-nowrap">
                                        <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-blue-100 text-blue-800">
                                            {{ $tag->posts_count }}
                                        </span>
                                    </td>
                                    <td class="px-4 py-4 whitespace-nowrap text-sm font-medium">
                                        <div class="flex flex-col space-y-1">
                                            <a href="{{ route('admin.tags.edit', $tag) }}" class="text-yellow-600 hover:text-yellow-900">Editar</a>
                                            @if($tag->posts_count == 0)
                                                <form action="{{ route('admin.tags.destroy', $tag) }}" method="POST" class="inline" onsubmit="return confirm('Tem certeza que deseja excluir esta tag?')">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" class="text-red-600 hover:text-red-900 text-left">Excluir</button>
                                                </form>
                                            @endif
                                        </div>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        @else
            <div class="text-center py-12">
                <svg class="mx-auto h-12 w-12 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 7h.01M7 3h5c.512 0 1.024.195 1.414.586l7 7a2 2 0 010 2.828l-7 7a2 2 0 01-2.828 0l-7-7A1.994 1.994 0 013 12V7a4 4 0 014-4z" />
                </svg>
                <h3 class="mt-2 text-sm font-medium text-gray-900">Nenhuma tag encontrada</h3>
                <p class="mt-1 text-sm text-gray-500">Comece criando sua primeira tag.</p>
                <div class="mt-6">
                    <a href="{{ route('admin.tags.create') }}" class="inline-flex items-center px-4 py-2 border border-transparent shadow-sm text-sm font-medium rounded-md text-white bg-indigo-600 hover:bg-indigo-700">
                        Criar Tag
                    </a>
                </div>
            </div>
        @endif
    </div>
</div>
@endsection