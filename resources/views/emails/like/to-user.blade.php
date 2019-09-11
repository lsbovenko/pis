@extends('layouts.email')

@section('content')
    <p>
        {{ trans('ideas.like_to_user', ['likeAuthorFullName' => $likeAuthor->getFullName()]) }}
        <a href="{{ route('review-idea', ['id' => $idea->id]) }}">
            {{ $idea->title }}
        </a>
    </p>
@endsection
