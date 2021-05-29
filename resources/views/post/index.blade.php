@extends('layouts.app')

@section('content')
<div class="container">
    @if(session('message'))
    <div class="row">
        <div class="col-md-12">
            <div class="alert alert-info" role="alert">
                {{ session('message') }}
            </div>
        </div>
    </div>
    @endif
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="border-bottom bg-secondary text-light">
                    <div class="m-3 h2 font-weight-bold">
                        NEWS
                    </div>
                </div>
                @auth
                    @if(Auth::user()->role == 'admin')
                        <div class="m-2 h5">
                            <form action="{{ route('post.store') }}" method="POST" enctype="multipart/form-data">
                                @csrf
                                <div class="row p-2">
                                    <div class="col-md-12">
                                            <div class="form-group">
                                                <label for="name">TITLE:</label>
                                                <input 
                                                    type="text" 
                                                    class="form-control @error('name') is-invalid @enderror" 
                                                    name="name" 
                                                    id="name"
                                                    required 
                                                />
                                                @error('name')
                                                    <span class="invalid-feedback" role="alert">
                                                        <strong>{{ $message }}</strong>
                                                    </span>
                                                @enderror
                                            </div>

                                            <div class="form-group">
                                                <label for="image">IMAGE:</label>
                    
                                                <input 
                                                    id="image" 
                                                    type="file" 
                                                    class="form-control-file @error('image') is-invalid @enderror"
                                                    name="image" 
                                                    required 
                                                />
                
                                                @error('image')
                                                    <span class="invalid-feedback" role="alert">
                                                        <strong>{{ $message }}</strong>
                                                    </span>
                                                @enderror
                                            </div>

                                            <div class="form-group">
                                                <label for="content">CREATE YOUR POST:</label>
                                                <textarea 
                                                    class="form-control @error('content') is-invalid @enderror" 
                                                    id="content"
                                                    name="content"
                                                    rows="5"
                                                    ></textarea>
                                                @error('content')
                                                    <span class="invalid-feedback" role="alert">
                                                        <strong>{{ $message }}</strong>
                                                    </span>
                                                @enderror
                                            </div>
                                    </div>
                                    <div class="col-md-12 text-center mt-3 d-flex align-items-center justify-content-between">
                                        <button type="submit" class="btn btn-lg btn-primary" type="button">
                                            <i class="far fa-comment"></i> POST NEWS
                                        </button>
                                    </div>
                                </div>
                            </form>
                        </div>
                    @endif
                @endauth
            </div>
        </div>
    </div>
    <div class="row">
        @foreach ($post as $item)
            <div class="col-md-6">
                <div class="alert alert-info" role="alert">
                    <span class="alert-heading h4">{{ $item->name }}</span>
                    <hr>
                    <div class="row">
                        <div class="col-md-4">
                            <img class="cart--image" src="{{ asset($item->image) }}" alt="" />
                        </div>
                        <div class="col-md-8">
                            <p>{{ $item->content }}</p>
                        </div>
                    </div>
                    <div class="m-2 d-flex justify-content-between align-items-center">
                        @auth
                            @if(Auth::user()->role == 'admin')
                                <a href="{{ route('post.delete', ['post' => $item->id]) }}" class="btn btn-danger">
                                    REMOVE
                                </a>
                            @endif
                        @endauth
                        {{ $item->created_at->diffForHumans($now) }}
                    </div>
                    @auth
                        <form class="m-1" action="{{ route('post.comment') }}" method="POST">
                            @csrf
                            <input type="hidden" 
                                name="post"
                                value="{{ $item->id }}" 
                            />
                            <div class="input-group">
                                <input type="text" 
                                    name="comment" 
                                    class="form-control" 
                                />
                                <div class="input-group-append">
                                    <button type="submit" class="btn btn-secondary" type="button">
                                        <i class="far fa-comment"></i> COMMENT
                                    </button>
                                </div>
                            </div>
                        </form>
                    @endauth
                    @foreach ($item->comments as $comment)
                        <b>{{ $comment->user->name }}: </b>
                        {{ $comment->comment }}
                        @auth
                            @if(Auth::user()->role == 'admin')
                            <br />
                            <a href="{{ route('post.comment.delete', ['comment' => $comment->id]) }}" class="btn btn-outline-danger">
                                REMOVE
                            </a>
                            @endif
                        @endauth
                        <hr />
                    @endforeach
                </div>
            </div>
        @endforeach
    </div>
    <div class="mt-5 alert alert-dark" role="alert">
        <div class="d-flex align-items-center justify-content-center">
            {{ $post->links() }}
        </div>
    </div>
</div>

@include('layouts.end')
@endsection
