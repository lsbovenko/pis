@extends('layouts.email')

@section('content')
    <p>
        От вас откреплена реализация предложения "{{ $idea->title }}".
        <a href="{{ route('review-idea', ['id' => $idea->id]) }}">Смотреть целиком</a>.
    </p>
    <div>
        {!! $idea->description !!}
    </div>
@endsection
