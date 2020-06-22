@extends('layouts.email')

@section('content')
    <p>
        {{ trans('ideas.idea_declined_to_user', ['ideaTitle' => $idea->title]) }}: {{ $reason->text }}.
        <a href="{{ route('review-idea', ['id' => $idea->id]) }}">{{ trans('ideas.view') }}</a>.
    </p>
@endsection
