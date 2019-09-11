@extends('layouts.email')

@section('content')
    <p>
        {{ trans('ideas.idea_changed_status_to_user', ['ideaTitle' => $idea->title]) }}: {{ $status->name }}.
    </p>
    @if($idea->details)
        <div>
            {{ $idea->details }}
        </div>
    @endif
@endsection
