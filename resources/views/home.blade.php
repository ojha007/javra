@extends('layouts.app')

@section('content')

    <div class="container">

        <ul class="list-group">
            @forelse($lessons as $lesson)

                <li class="list-group-item">
                    <a href="{{route('lessons.show',$lesson->id)}}">
                        {{$lesson->title}}
                    </a>
                </li>
            @empty
                <li>We are adding new Lessons</li>
            @endforelse
        </ul>
    </div>
@endsection
