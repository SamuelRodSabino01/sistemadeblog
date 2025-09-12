<?php

namespace App\Http\Controllers;

use App\Models\Comment;
use App\Models\Post;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CommentController extends Controller
{
    public function store(Request $request, Post $post)
    {
        $request->validate([
            'content' => 'required|string|max:1000',
            'author_name' => 'required_without:user_id|string|max:255',
            'author_email' => 'required_without:user_id|email|max:255'
        ]);
        
        $data = [
            'content' => $request->content,
            'post_id' => $post->id,
            'status' => 'pending'
        ];
        
        if (Auth::check()) {
            $data['user_id'] = Auth::id();
        } else {
            $data['author_name'] = $request->author_name;
            $data['author_email'] = $request->author_email;
        }
        
        Comment::create($data);
        
        return redirect()->back()
            ->with('success', 'Comentário enviado com sucesso! Aguarde aprovação.');
    }
    
    public function approve(Comment $comment)
    {
        $comment->update(['status' => 'approved']);
        
        return redirect()->back()
            ->with('success', 'Comentário aprovado com sucesso!');
    }
    
    public function reject(Comment $comment)
    {
        $comment->update(['status' => 'rejected']);
        
        return redirect()->back()
            ->with('success', 'Comentário rejeitado.');
    }
    
    public function destroy(Comment $comment)
    {
        $comment->delete();
        
        return redirect()->back()
            ->with('success', 'Comentário excluído com sucesso!');
    }
}
