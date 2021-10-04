@extends('layouts.app')

@section('content')

    <div class="container">

        <div class="card">
            <div class="card-body">
                <h5 class="card-title">Lesson #{{$lesson->id}}</h5>
                <p class="card-text">{{$lesson->name}}</p>
                @include('message')
                <form method="post" action="{{route('comments.store')}}">
                    @csrf
                    <div class="form-group">
                        <input type="hidden" value="{{$lesson->id}}" name="lesson_id">
                        <label for="body">Review of Lesson:</label>
                        <textarea id="body" name="body" class="form-control" required>{{old('body')}}</textarea>
                        <button type="submit" class="btn btn-success btn-block m-2">Add Comment</button>
                    </div>
                </form>
                @if($prev)
                    <a href="{{route('lessons.show',$prev->id)}}"
                       class="btn btn-primary btn-sm pull-left">Prev</a>
                @endif
                @if($next)
                    <a href="{{route('lessons.show',$next->id)}}"
                       class="btn btn-primary btn-sm pull-right">Next</a>
                @endif
            </div>
        </div>
    </div>
@endsection
