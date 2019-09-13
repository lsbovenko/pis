@extends('layouts.email')

@section('content')
    <p>
        {!! trans('ideas.reset_pass', ['route_password_reset' => route('password.reset', ['token' => $token])]) !!}
    </p>
@endsection
