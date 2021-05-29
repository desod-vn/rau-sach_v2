<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;
use App\Models\Post;
use Carbon\Carbon;

class PostController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth', ['except' => ['index', 'show']]);
    }

    public function index()
    {
        $post = Post::query();

        $now = Carbon::now();
        
        $post = $post->latest()->simplePaginate(12);
    
        return view('post.index', compact('post', 'now'));
    }


    public function store(Request $request)
    {
        if(Gate::allows('isAdmin'))
        {
            $this->validate($request, [
                'name' => 'required|string|max:255|unique:posts',
                'image' => 'required|image|mimes:jpg,png,jpeg,gif|max:5120',
                'content' => 'required|string',
            ]);

            $post = new Post;

            $post->fill($request->all());

            if($request->has('image'))
            {
                $image = $request->file('image')->store('view');
                $post->image = $image;
            }

            $post->save();

            return redirect()->route('post.index')->with('message', 'Add new post successfully.');
            }
    }

    // public function show($id)
    // {
    //     //
    // }

    // public function edit(Post $post)
    // {
    //     return view('post.edit', compact('product'));
    // }


    // public function update(Request $request, Post $post)
    // {
    //     $this->validate($request, [
    //         'name' => 'required|string|max:255',
    //         'image' => 'image|mimes:jpg,png,jpeg,gif|max:5120',
    //         'content' => 'required|string',
    //     ]);

    //     $image = $post->image;

    //     $post->fill($request->all());

    //     if($request->has('image'))
    //     {
    //         Storage::delete($image);
    //         $image = $request->file('image')->store('view');
    //         $post->image = $image;
    //     }

    //     $post->save();

    //     return redirect()->route('post.index')->with('message', 'Update post successfully.');
    // }

    public function destroy(Post $post)
    {
        if(Gate::allows('isAdmin'))
        {
            $post->delete();
            
            return redirect()->route('post.index')->with('message', 'Remove product successfully.');
        }
    }
}
