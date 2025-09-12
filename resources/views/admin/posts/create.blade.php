@extends('admin.layout')

@section('title', 'Criar Post')

@section('content')
<div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
    <div class="p-6 text-gray-900">
        <div class="flex justify-between items-center mb-6">
            <h1 class="text-2xl font-bold">Criar Novo Post</h1>
            <a href="{{ route('admin.posts.index') }}" class="bg-gray-500 hover:bg-gray-700 text-white font-bold py-2 px-4 rounded">
                Voltar
            </a>
        </div>
        
        <form action="{{ route('admin.posts.store') }}" method="POST" enctype="multipart/form-data">
            @csrf
            
            <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                <!-- Coluna Principal -->
                <div class="md:col-span-2 space-y-6">
                    <!-- Título -->
                    <div>
                        <label for="title" class="block text-sm font-medium text-gray-700 mb-2">Título</label>
                        <input type="text" name="title" id="title" value="{{ old('title') }}" 
                               class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 @error('title') border-red-500 @enderror" 
                               required>
                        @error('title')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>
                    
                    <!-- Slug -->
                    <div>
                        <label for="slug" class="block text-sm font-medium text-gray-700 mb-2">Slug (URL)</label>
                        <input type="text" name="slug" id="slug" value="{{ old('slug') }}" 
                               class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 @error('slug') border-red-500 @enderror">
                        @error('slug')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                        <p class="mt-1 text-sm text-gray-500">Deixe em branco para gerar automaticamente</p>
                    </div>
                    
                    <!-- Resumo -->
                    <div>
                        <label for="excerpt" class="block text-sm font-medium text-gray-700 mb-2">Resumo</label>
                        <textarea name="excerpt" id="excerpt" rows="3" 
                                  class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 @error('excerpt') border-red-500 @enderror">{{ old('excerpt') }}</textarea>
                        @error('excerpt')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>
                    
                    <!-- Conteúdo -->
                    <div>
                        <label for="content" class="block text-sm font-medium text-gray-700 mb-2">Conteúdo</label>
                        <textarea name="content" id="content" rows="15" 
                                  class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 @error('content') border-red-500 @enderror" 
                                  required>{{ old('content') }}</textarea>
                        @error('content')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>
                </div>
                
                <!-- Sidebar -->
                <div class="space-y-6">
                    <!-- Status -->
                    <div class="bg-gray-50 p-4 rounded-lg">
                        <h3 class="text-lg font-medium text-gray-900 mb-4">Publicação</h3>
                        
                        <div class="mb-4">
                            <label for="status" class="block text-sm font-medium text-gray-700 mb-2">Status</label>
                            <select name="status" id="status" 
                                    class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500">
                                <option value="draft" {{ old('status') === 'draft' ? 'selected' : '' }}>Rascunho</option>
                                <option value="published" {{ old('status') === 'published' ? 'selected' : '' }}>Publicado</option>
                            </select>
                        </div>
                        
                        <div class="flex space-x-2">
                            <button type="submit" class="flex-1 bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">
                                Salvar
                            </button>
                        </div>
                    </div>
                    
                    <!-- Categoria -->
                    <div class="bg-gray-50 p-4 rounded-lg">
                        <h3 class="text-lg font-medium text-gray-900 mb-4">Categoria</h3>
                        
                        <div>
                            <select name="category_id" id="category_id" 
                                    class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 @error('category_id') border-red-500 @enderror" 
                                    required>
                                <option value="">Selecione uma categoria</option>
                                @foreach($categories as $category)
                                    <option value="{{ $category->id }}" {{ old('category_id') == $category->id ? 'selected' : '' }}>
                                        {{ $category->name }}
                                    </option>
                                @endforeach
                            </select>
                            @error('category_id')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>
                    
                    <!-- Tags -->
                    <div class="bg-gray-50 p-4 rounded-lg">
                        <h3 class="text-lg font-medium text-gray-900 mb-4">Tags</h3>
                        
                        <div class="space-y-2 max-h-40 overflow-y-auto">
                            @foreach($tags as $tag)
                                <label class="flex items-center">
                                    <input type="checkbox" name="tags[]" value="{{ $tag->id }}" 
                                           class="rounded border-gray-300 text-indigo-600 shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50"
                                           {{ in_array($tag->id, old('tags', [])) ? 'checked' : '' }}>
                                    <span class="ml-2 text-sm text-gray-700">{{ $tag->name }}</span>
                                </label>
                            @endforeach
                        </div>
                    </div>
                    
                    <!-- Imagem Destacada -->
                    <div class="bg-gray-50 p-4 rounded-lg">
                        <h3 class="text-lg font-medium text-gray-900 mb-4">Imagem Destacada</h3>
                        
                        <div>
                            <input type="file" name="featured_image" id="featured_image" 
                                   class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 @error('featured_image') border-red-500 @enderror" 
                                   accept="image/*">
                            @error('featured_image')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                            <p class="mt-1 text-sm text-gray-500">Formatos aceitos: JPG, PNG, GIF (máx. 2MB)</p>
                        </div>
                    </div>
                </div>
            </div>
        </form>
    </div>
</div>

<script>
// Auto-gerar slug baseado no título
document.getElementById('title').addEventListener('input', function() {
    const title = this.value;
    const slug = title
        .toLowerCase()
        .replace(/[^a-z0-9\s-]/g, '')
        .replace(/\s+/g, '-')
        .replace(/-+/g, '-')
        .trim('-');
    
    document.getElementById('slug').value = slug;
});
</script>
@endsection