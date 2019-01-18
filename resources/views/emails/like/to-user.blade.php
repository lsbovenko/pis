@extends('layouts.email')

@section('content')
    <p>
        Пользователю {{ $idea->user->geFullName() }} понравилась ваша идея
        <a href="{{ route('review-idea', ['id' => $idea->id]) }}">
            {{ $idea->title }}
        </a>
    </p>
@endsection
