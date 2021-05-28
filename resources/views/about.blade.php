@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="border-bottom bg-success text-light">
                    <div class="m-3 h2 font-weight-bold">
                        ABOUT US
                        <div class="mt-1 h5">
                            A post about our company and website
                        </div>
                    </div>
                </div>
                
                <div class="card-body">
                    
                </div>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="border-bottom bg-secondary text-light">
                    <div class="m-3 h2 font-weight-bold">
                        COMMENTS FROM CUSTOMERS
                    </div>
                </div>
                <div class="m-2 h5">
                    @auth
                        <form action="{{ route('about.comment') }}" method="POST">
                            @csrf
                            <div class="row p-2">
                                <div class="col-md-12">
                                        <div class="form-group">
                                            <label for="comment">YOUR COMMENT:</label>
                                            <textarea 
                                                class="form-control @error('comment') is-invalid @enderror" 
                                                id="comment"
                                                name="comment"
                                                rows="5"
                                                ></textarea>
                                            @error('comment')
                                                <span class="invalid-feedback" role="alert">
                                                    <strong>{{ $message }}</strong>
                                                </span>
                                            @enderror
                                        </div>
                                </div>
                                <div class="col-md-12 text-center mt-3 d-flex align-items-center justify-content-between">
                                    <button type="submit" class="btn btn-lg btn-primary" type="button">
                                        <i class="far fa-comment"></i> COMMENT
                                    </button>
                                </div>
                            </div>
                        </form>
                    @endauth
                </div>
                <div class="card-body">
                    @foreach ($comment as $item)
                        <div class="alert alert-info" role="alert">
                            <span class="alert-heading h4">{{ $item->user->name }}</span>
                            
                            <i class="fas fa-user-clock"></i>

                            {{ $item->created_at->diffForHumans($now) }}
                            <hr>
                            <p>{{ $item->comment }}</p>
                      </div>
                    @endforeach
                </div>
            </div>
        </div>
    </div>
</div>
@include('layouts.end')
@endsection
