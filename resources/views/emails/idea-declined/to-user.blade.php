@extends('layouts.email')

@section('content')
    <p>
        {{ trans('ideas.idea_declined_to_user', ['ideaTitle' => $idea->title]) }}: {{ $reason->text }}.
    </p>
@endsection
