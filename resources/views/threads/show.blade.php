@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center mt-3">
            <div class="col-md-8 col-md-offset-2">
                <div class="card">
                    <div class="card-header">
                        <a href="#">{{ $thread->creator->name }} </a> posted:
                        {{$thread->title}}
                    </div>
                    <div class="card-body">
                        {{$thread->body}}
                    </div>
                </div>
            </div>
        </div>

        <div class="row justify-content-center">
            <div class="col-md-8 col-md-offset-2">
                @foreach($thread->replies as $reply)
                    @include('threads.replay')
                @endforeach
            </div>
        </div>
        @if(auth()->check())
        <div class="row justify-content-center">
            <div class="col-md-8 col-md-offset-2">
                <form method="POST" action="{{$thread->path() . '/replies'}}">
                    {{csrf_field()}}
                    <div class="form-group">
                        <label for="body">Body:</label>
                        <textarea name="body" id="" class="form-control" cols="30" rows="10" placeholder="Have something to say?"></textarea>
                    </div>
                    <button type="submit" class="btn btn-secondary">Post</button>
                </form>
            </div>
        </div>
        @else
        <p class="text-center">Please <a href="{{route('login')}}">sign in</a> to participate in this discussion.</p>
        @endif
    </div>
@endsection
