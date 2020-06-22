@extends('layouts.email')

@section('content')
    <p>
        {{ trans('ideas.idea_changed_status_to_user', ['ideaTitle' => $idea->title]) }}: {{ $status->name }}.
        <a href="{{ route('review-idea', ['id' => $idea->id]) }}">{{ trans('ideas.view') }}</a>.
    </p>
    @if($idea->details)
        <div style="font-weight: bold;">
            <span>{{ trans('ideas.resolution') }}:</span><br><br>
            <span style="font-style: italic;">{{ $idea->details }}</span>
        </div>
    @endif
@endsection
