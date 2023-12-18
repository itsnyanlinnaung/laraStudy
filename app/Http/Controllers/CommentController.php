<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Gate;
use Illuminate\Http\Request;
use App\Models\Comment;

class CommentController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function delete($id)
    {
        $comment = Comment::find($id);
        if( Gate::allows('delete-comment', $comment) )
        {
            $comment->delete();
            return back()->with('info','Comment Deleted');
        }

        return back()->with('info','Unauthorized!!!');
    }

    public function create(Request $request)
    {
        $request->validate([
            "article_id" => "required",
            "content" => "required",
        ]);

        $comment = new Comment;
        $comment->content = $request->content;
        $comment->article_id = $request->article_id;
        $comment->user_id = auth()->id();
        $comment->save();

        return back();
    }
}
