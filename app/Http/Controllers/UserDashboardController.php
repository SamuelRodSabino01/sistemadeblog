<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Post;
use App\Models\Comment;

class UserDashboardController extends Controller
{
    public function index()
    {
        $user = auth()->user();
        
        // Estatísticas do usuário
        $userStats = [
            'total_comments' => Comment::where('user_id', $user->id)->count(),
            'recent_posts' => Post::where('status', 'published')
                ->orderBy('created_at', 'desc')
                ->limit(5)
                ->get(),
            'user_comments' => Comment::where('user_id', $user->id)
                ->with('post')
                ->orderBy('created_at', 'desc')
                ->limit(5)
                ->get()
        ];
        
        return view('user.dashboard', compact('userStats'));
    }
}
