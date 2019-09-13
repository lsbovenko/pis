@extends('layouts.email')

@section('content')
    <p>
        {{ $comment->user->getFullName() }}
        {{ trans('ideas.new_comment') }} <a href="{{ route('review-idea', ['id' => $comment->idea->id]) }}">"{{ $comment->idea->title }}</a>".
    </p>
    <div>
        "{{ $comment->message }}"
    </div>
@endsection
