@extends('layouts.email')

@section('content')
    <p>
        {{ trans('ideas.new_idea_published') }}
        <a href="{{ route('review-idea', ['id' => $idea->id]) }}">{{ trans('ideas.view') }}</a>.
    </p>
@endsection
