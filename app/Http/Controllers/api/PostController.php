<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Models\Post;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Storage;

class PostController extends Controller
{ 
    // Get all blog posts
    public function index(Request $request)
    {
        $posts = Post::with('category')->get();
        return response()->json($posts);
    }
    // Get blog posts by category
    public function getBlogByCategory($id)
    {
        if($id){
            $posts = Post::with('category')->where('category_id',$id)->get();
            return response()->json($posts);
        }
    }

    // Get a specific blog post by ID
    public function show($id)
    {
        $post = Post::with(['category', 'user'])->where('id', $id)->firstOrFail();
        // $post->created_at = \Carbon\Carbon::parse($post->created_at)->timezone('Africa/Cairo')->format('d.m.Y');
        return response()->json($post);
    }
    // Create a new blog post
    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'content' => 'required|string',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'category_id' => 'required|integer',
        ]);
        
        $imagePath = null;
        if ($request->hasFile('image')) {
            $imagePath = $request->file('image')->store('posts', 'public');
        }
    
        $post = Post::create([
            'title' => $request->title,
            'content' => $request->content,
            'image_path' => $imagePath,
            'category_id' => $request->category_id,
            'user_id' => auth()->user()->id,
        ]);
        // $post = Post::create($request->all());

        return response()->json($post, 201);
    }


    // Update a blog post
    public function update(Request $request, $id)
    {
        // $img = '';
        // if ($request->hasFile('image')){
        //     $img = $request->file();
        // }else{
        //     $img = 'No File'; 
        // }
        // return response()->json([
        //     'all_request' => $request->all(),
        //     'files' => $img,
        //     'id' => $id,
        // ]);
        $request->validate([
            'title' => 'required|string|max:255',
            'content' => 'required|string',
            'category_id' => 'required|integer',
        ]);
    
        $post = Post::findOrFail($id);
    
        if ($request->hasFile('image')) {
            if ($post->image_path) {
                Storage::disk('public')->delete($post->image_path);
            }
            $imagePath = $request->file('image')->store('posts', 'public');
            $post->image_path = $imagePath;
        }
    
        $post->title = $request->title;
        $post->content = $request->content;
        $post->category_id = $request->category_id;
        $post->user_id = auth()->user()->id;
    
        $post->save();
    
        return response()->json($post);
    }

    // Delete a blog post
    public function destroy($id)
    {
        $post = Post::findOrFail($id);
        if ($post->image_path) {
            Storage::disk('public')->delete($post->image_path);
        }
        $post->delete();

        return response()->json(null, 204);
    }
}
