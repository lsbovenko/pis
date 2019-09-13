@extends('layouts.email')

@section('content')
    <p>
        {{ trans('ideas.new_idea_added') }} "{{ $idea->title }}". {{ trans('ideas.moderated_soon') }}
    </p>
@endsection
