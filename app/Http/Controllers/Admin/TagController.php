<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Tag;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class TagController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $tags = Tag::withCount('posts')
            ->orderBy('name')
            ->paginate(15);
            
        return view('admin.tags.index', compact('tags'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('admin.tags.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255|unique:tags'
        ]);

        $data = $request->all();
        $data['slug'] = Str::slug($request->name);
        
        Tag::create($data);
        
        return redirect()->route('admin.tags.index')
            ->with('success', 'Tag criada com sucesso!');
    }

    /**
     * Display the specified resource.
     */
    public function show(Tag $tag)
    {
        $tag->load(['posts' => function($query) {
            $query->with(['user', 'category'])->orderBy('created_at', 'desc');
        }]);
        
        return view('admin.tags.show', compact('tag'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Tag $tag)
    {
        return view('admin.tags.edit', compact('tag'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Tag $tag)
    {
        $request->validate([
            'name' => 'required|string|max:255|unique:tags,name,' . $tag->id
        ]);

        $data = $request->all();
        $data['slug'] = Str::slug($request->name);
        
        $tag->update($data);
        
        return redirect()->route('admin.tags.index')
            ->with('success', 'Tag atualizada com sucesso!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Tag $tag)
    {
        if ($tag->posts()->count() > 0) {
            return redirect()->route('admin.tags.index')
                ->with('error', 'Não é possível excluir uma tag que possui posts associados.');
        }
        
        $tag->delete();
        
        return redirect()->route('admin.tags.index')
            ->with('success', 'Tag excluída com sucesso!');
    }
}
