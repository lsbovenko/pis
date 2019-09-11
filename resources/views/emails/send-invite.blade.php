@extends('layouts.email')

@section('content')
    <p>
        {!! trans('ideas.send_invite', ['route_invite' => route('invite', ['code' => $code])]) !!}
    </p>
@endsection
