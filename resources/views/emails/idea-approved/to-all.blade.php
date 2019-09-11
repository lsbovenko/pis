@extends('layouts.email')

@section('content')
    <p>
        {{ trans('ideas.new_idea_added') }} "{{ $idea->title }}".
        <a href="{{ route('review-idea', ['id' => $idea->id]) }}">{{ trans('ideas.watch_whole') }}</a>.
    </p>
    <div>
        {!! $idea->description !!}
    </div>
@endsection
