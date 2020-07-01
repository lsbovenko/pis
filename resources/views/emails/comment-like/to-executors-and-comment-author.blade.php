@extends('layouts.email')

@section('content')
    <div>
        {{ trans('ideas.user') }} {{ $likeAuthor }} {{ trans('ideas.liked_comment') }}
    </div>
    <div>
        "{{ $comment->message }}"
    </div>
    <div>
        {{ trans('ideas.view') }} <a href="{{ route('review-idea', ['id' => $comment->idea->id]) }}">"{{ $comment->idea->title }}</a>"
    </div>
@endsection
