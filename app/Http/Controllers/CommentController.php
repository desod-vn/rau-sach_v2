<?php

namespace App\Http\Controllers;

use App\Models\Comment;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;
use Illuminate\Support\Facades\Gate;
use Illuminate\Http\Request;

class CommentController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
        $comment = Comment::query()->latest()->get();
        // $comment->user;
        $now = Carbon::now();

        return view('about', compact('comment', 'now'));

    }

    
    public function store(Request $request)
    {
        $this->middleware('auth');

        $this->validate($request, [
            'comment' => 'required|string',
        ]);

        $comment = new Comment;

        $comment->comment = $request->comment;
        $comment->user_id = Auth::user()->id;

        $comment->save();

        return redirect()->route('about')->with('message', 'Add new comment successfully.');
    }

   
    public function destroy(Comment $comment)
    {
        $this->middleware('auth');
        if(Gate::allows('isAdmin'))
        {
            $comment->delete();

            return redirect()->route('about')->with('message', 'Remove comment successfully.');
        }
    }
}
