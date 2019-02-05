@extends('layouts.email')

@section('content')
    <p>
        {{ $comment->user->getFullName() }}
        Добавил(а) новый комментарий к <a href="{{ route('review-idea', ['id' => $comment->idea->id]) }}">"{{ $comment->idea->title }}</a>".
    </p>
    <div>
        "{{ $comment->message }}"
    </div>
@endsection
