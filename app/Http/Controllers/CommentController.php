<?php

namespace App\Http\Controllers;

use App\Models\Comment;
use Illuminate\Http\Request;

class CommentController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $comments = Comment::all();
        return view('comments.index', compact('comments'));
    }

    public function store(Request $request, $blogId)
    {
//        $request->validate([
//            'content' => 'required|text|max:500',
//        ]);

        Comment::create([
            'content' => $request->input('content'),
            'user_id' => auth()->id(),
            'blog_id' => $blogId,
        ]);

        return redirect()->route('blogs.index')->with('success', 'Comment added successfully!');
    }

    public function destroy($id)
    {
        $comment = Comment::findOrFail($id);
        $comment->delete();
        return redirect()->route('blogs.index');
    }
}
