@extends('layouts.email')

@section('content')
    <p>
        {{ trans('ideas.proposal_implementation_detached') }} "{{ $idea->title }}".
        <a href="{{ route('review-idea', ['id' => $idea->id]) }}">{{ trans('ideas.view') }}</a>.
    </p>
    <div>
        {!! $idea->description !!}
    </div>
@endsection
