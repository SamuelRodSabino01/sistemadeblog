<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Post;
use App\Models\Category;
use App\Models\Tag;
use App\Models\Comment;
use App\Models\User;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index()
    {
        $stats = [
            'total_posts' => Post::count(),
            'published_posts' => Post::where('status', 'published')->count(),
            'draft_posts' => Post::where('status', 'draft')->count(),
            'total_categories' => Category::count(),
            'total_tags' => Tag::count(),
            'total_comments' => Comment::count(),
            'pending_comments' => Comment::where('status', 'pending')->count(),
            'total_users' => User::count()
        ];
        
        $recent_posts = Post::with(['user', 'category'])
            ->orderBy('created_at', 'desc')
            ->limit(5)
            ->get();
            
        $recent_comments = Comment::with(['post', 'user'])
            ->orderBy('created_at', 'desc')
            ->limit(5)
            ->get();
            
        return view('admin.dashboard', compact('stats', 'recent_posts', 'recent_comments'));
    }
}
