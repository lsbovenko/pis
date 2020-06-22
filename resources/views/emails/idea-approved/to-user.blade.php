@extends('layouts.email')

@section('content')
    <p>
        {{ trans('ideas.idea_approved_to_user', ['ideaTitle' => $idea->title]) }}.
        <a href="{{ route('review-idea', ['id' => $idea->id]) }}">{{ trans('ideas.view') }}</a>.
    </p>
@endsection
