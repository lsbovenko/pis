@extends('layouts.email')

@section('content')
    <p>
        {{ trans('ideas.idea_implemented') }} "{{ $idea->title }}".
        <a href="{{ route('review-idea', ['id' => $idea->id]) }}">{{ trans('ideas.watch_whole') }}</a>.
    </p>
    @if($idea->details)
        <div>
            {{ $idea->details }}
        </div>
    @endif
    <div>
        {!! $idea->description !!}
    </div>
@endsection
