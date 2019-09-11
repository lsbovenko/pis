@extends('layouts.email')

@section('content')
    <p>
        {{ trans('ideas.idea_approved_to_user', ['ideaTitle' => $idea->title]) }}
    </p>
@endsection
