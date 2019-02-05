@extends('layouts.email')

@section('content')
    <p>
        Пользователю {{ $likeAuthor->getFullName() }} понравилась ваша идея
        <a href="{{ route('review-idea', ['id' => $idea->id]) }}">
            {{ $idea->title }}
        </a>
    </p>
@endsection
