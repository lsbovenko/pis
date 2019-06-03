@extends('layouts.email')

@section('content')
    <p>
        Для идеи "{{ $idea->title }}" был изменен статус : {{ $status->name }}.
    </p>
    @if($idea->details)
        <div>
            {{ $idea->details }}
        </div>
    @endif
@endsection
