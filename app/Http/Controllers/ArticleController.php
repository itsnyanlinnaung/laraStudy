<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Gate;
use App\Models\Article;
use Illuminate\Http\Request;

class ArticleController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth')->except(['index','detail']);
    }

    public function index()
    {
        $data = Article::latest()->paginate(5);
        return view("articles.index",["articles" => $data]);
    }

    public function detail($id)
    {
        $data = Article::find($id);
        return view("articles.detail",["article" => $data]);
    }

    public function add()
    {
        $data = [
            ["id" => 1, "name" => "Tech"],
            ["id" => 2, "name" => "Sports"],
        ];
        return view('articles.add',['categories' => $data]);
    }

    public function create()
    {
        $validator = validator(request()->all(),[
            'title' => 'required',
            'body' => 'required',
            'category_id' => 'required',
        ]);

        if($validator->fails())
        {
            return back()->withErrors($validator);
        }

        $article = new Article;
        $article->title = request()->title;
        $article->body = request()->body;
        $article->category_id = request()->category_id;
        $article->user_id = auth()->id();
        $article->save();

        return redirect('/articles');
    }

    public function delete($id)
    {
        // $comment = Comment::find($id);
        // if( Gate::allows('delete-comment', $comment) )
        // {
        //     $comment->delete();
        //     return back()->with('info','Comment Deleted');
        // }

        // return back()->with('info','Unauthorized!!!');

        $article = Article::find($id);

        if( Gate::allows('delete-article', $article) )
        {
            $article->delete();
            return redirect('/articles')->with('info','Article Deleted');
        }

        return back()->with('info', 'Unauthorized!!!');
    }

    public function edit($id)
    {
        $article = Article::find($id);

    }
}

