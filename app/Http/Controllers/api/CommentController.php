<?php

namespace App\Http\Controllers\Api;

use App\Models\Comment;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class CommentController extends Controller
{
    /**
     * Display a listing of the comments.
     */
    public function index()
    {
        $comments = Comment::all();
        return response()->json($comments);
    }

    /**
     * Store a newly created comment in storage.
     */
    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'post_id' => 'required|exists:posts,id',
            'username' => 'required|string|max:255',
            'picture' => 'required|string',
            'comment' => 'required|string',
        ]);

        $comment = Comment::create($validatedData);

        return response()->json(['message' => 'Comment created successfully!', 'data' => $comment], 201);
    }

    /**
     * Display the specified comment.
     */
    public function getCommentsByPost($id)
    {
        $comment = Comment::where('post_id',$id)->get();
        return response()->json($comment);
    }
    
    public function show($id)
    {
        $comment = Comment::findOrFail($id);
        return response()->json($comment);
    }

    /**
     * Update the specified comment in storage.
     */
    public function update(Request $request, $id)
    {
        $validatedData = $request->validate([
            'post_id' => 'required|exists:posts,id',
            'username' => 'required|string|max:255',
            'picture' => 'required|string',
            'comment' => 'required|string',
        ]);

        $comment = Comment::findOrFail($id);
        $comment->update($validatedData);

        return response()->json(['message' => 'Comment updated successfully!', 'data' => $comment]);
    }

    /**
     * Remove the specified comment from storage.
     */
    public function destroy($id)
    {
        $comment = Comment::findOrFail($id);
        $comment->delete();

        return response()->json(['message' => 'Comment deleted successfully!']);
    }
}
