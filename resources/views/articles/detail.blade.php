@extends("layouts.app")

@section("content")
    <div class="container">

        @if (session('info'))
            <div class="alert alert-info">
                {{ session('info') }}
            </div>
        @endif
        <div class="card mb-2 border-primary">
            <div class="card-body">
                <h5 class="card-title">{{ $article->title }}</h5>
                <div class="card-subtitle mb-2 text-muted small">
                    <b class="text-success">{{ $article->user->name }}</b>
                    {{ $article->created_at->diffForHumans() }}
                </div>
                <p class="card-text">{{ $article->body }}</p>
                <a class="btn btn-warning" href="{{ url("/articles/delete/$article->id") }}">Delete</a>
            </div>
        </div>
        <ul class="list-group mt-4">
            <li class="list-group-item active">
                Comments ( {{ count($article->comments) }} )
            </li>
            @foreach ($article->comments as $comment)
                <li class="list-group-item">
                    <a href="{{ url("/comments/delete/$comment->id") }}" class="btn-close float-end"></a>
                    <b class="text-success">{{ $article->user->name }}</b> -
                    {{ $comment->content }}
                </li>
            @endforeach
        </ul>
        <form action="{{ url("/comments/add") }}" method="post">
            @csrf
            <input type="hidden" name="article_id" value="{{ $article->id }}">
            <textarea name="content" class="form-control my-2"></textarea>
            <button class="btn btn-secondary">Add Comment</button>
        </form>
    </div>
@endsection