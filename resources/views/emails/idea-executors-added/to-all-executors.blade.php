@extends('layouts.email')

@section('content')
    <p>
        {{ trans('ideas.proposal_implementation_assigned') }} "{{ $idea->title }}".
        <a href="{{ route('review-idea', ['id' => $idea->id]) }}">{{ trans('ideas.watch_whole') }}</a>.
    </p>
    <div>
        {!! $idea->description !!}
    </div>
@endsection
