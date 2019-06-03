@extends('layouts.email')

@section('content')
    <p>
        Реализована очередная идея "{{ $idea->title }}".
        <a href="{{ route('review-idea', ['id' => $idea->id]) }}">Смотреть целиком</a>.
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
