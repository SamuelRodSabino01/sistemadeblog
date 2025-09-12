<?php

namespace App\Http\Controllers;

use App\Models\Post;
use App\Models\Category;
use App\Models\Tag;
use App\Models\Comment;
use Illuminate\Http\Request;

class BlogController extends Controller
{
    public function index()
    {
        $posts = Post::published()
            ->with(['user', 'category', 'tags'])
            ->orderBy('published_at', 'desc')
            ->paginate(10);
            
        $categories = Category::withCount('posts')
            ->orderBy('name')
            ->get();
            
        $tags = Tag::withCount('posts')
            ->orderBy('name')
            ->get();
            
        // Posts em destaque
        $featuredPosts = Post::published()
            ->where('featured', true)
            ->with(['user', 'category', 'tags'])
            ->orderBy('published_at', 'desc')
            ->limit(3)
            ->get();
            
        // Estatísticas para o dashboard público
        $stats = [
            'total_posts' => Post::published()->count(),
            'total_categories' => Category::count(),
            'total_tags' => Tag::count(),
            'total_comments' => Comment::where('status', 'approved')->count(),
        ];
            
        return view('blog.index', compact('posts', 'categories', 'tags', 'stats', 'featuredPosts'));
    }
    
    public function show(Post $post)
    {
        if ($post->status !== 'published') {
            abort(404);
        }
        
        $post->load(['user', 'category', 'tags', 'comments' => function($query) {
            $query->where('status', 'approved')
                  ->with('user')
                  ->orderBy('created_at', 'desc');
        }]);
        
        $related_posts = Post::published()
            ->where('id', '!=', $post->id)
            ->where('category_id', $post->category_id)
            ->with(['user', 'category'])
            ->limit(3)
            ->get();
            
        return view('blog.show', compact('post', 'related_posts'));
    }
    
    public function category(Category $category)
    {
        $posts = Post::published()
            ->where('category_id', $category->id)
            ->with(['user', 'category', 'tags'])
            ->orderBy('published_at', 'desc')
            ->paginate(10);
            
        return view('blog.category', compact('posts', 'category'));
    }
    
    public function tag(Tag $tag)
    {
        $posts = $tag->posts()
            ->published()
            ->with(['user', 'category', 'tags'])
            ->orderBy('published_at', 'desc')
            ->paginate(10);
            
        return view('blog.tag', compact('posts', 'tag'));
    }
    
    public function search(Request $request)
    {
        $query = $request->get('q');
        
        if (empty($query)) {
            return redirect()->route('blog.index');
        }
        
        $posts = Post::published()
            ->where(function($q) use ($query) {
                $q->where('title', 'like', '%' . $query . '%')
                  ->orWhere('content', 'like', '%' . $query . '%')
                  ->orWhere('excerpt', 'like', '%' . $query . '%');
            })
            ->with(['user', 'category', 'tags'])
            ->orderBy('published_at', 'desc')
            ->paginate(10);
            
        return view('blog.search', compact('posts', 'query'));
    }
}
