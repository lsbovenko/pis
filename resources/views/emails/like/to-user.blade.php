@extends('layouts.email')

@section('content')
    <p>
        Пользователю {{ $likeAuthor->getFullName() }} понравилась идея
        <a href="{{ route('review-idea', ['id' => $idea->id]) }}">
            {{ $idea->title }}
        </a>
    </p>
@endsection
