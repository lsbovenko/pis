@extends('layouts.email')

@section('content')
    <p>
        Реализована очередная идея "{{ $idea->title }}".
        <a href="{{ route('review-idea', ['id' => $idea->id]) }}">Смотреть целиком</a>.
    </p>
    <div>
        {!! $idea->description !!}
    </div>
@endsection
