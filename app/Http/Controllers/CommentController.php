<?php

namespace App\Http\Controllers;

use App\Models\Comment;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;
use Illuminate\Support\Facades\Gate;
use Illuminate\Http\Request;

class CommentController extends Controller
{


    
    public function store(Request $request)
    {
        $this->middleware('auth');

        $this->validate($request, [
            'comment' => 'required|string',
        ]);

        $comment = new Comment;

        $comment->comment = $request->comment;
        $comment->user_id = Auth::user()->id;
        $comment->post_id = $request->post;


        $comment->save();

        return redirect()->route('post.index')->with('message', 'Add new comment successfully.');
    }

   
    public function destroy(Comment $comment)
    {
        $this->middleware('auth');
        if(Gate::allows('isAdmin'))
        {
            $comment->delete();

            return redirect()->route('post.index')->with('message', 'Remove comment successfully.');
        }
    }
}
