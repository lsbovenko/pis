@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row page-header">
        <div class="col-sm-8">
            <h1>{{ trans('ideas.profile') }}</h1>
        </div>
    </div>
    <div class="row">
        <div class="col-md-6 col-md-offset-3">
            @if (Session::has('alert-success'))
                <div class="alert alert-success alert-dismissable">
                    <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
                    {{ Session::get('alert-success') }}
                </div>
            @endif
            @include('partials.errors')
            <form method="POST" action="{{ route('profile.update') }}">
                {{ csrf_field() }}
                <div class="form-group">
                    <label for="name">{{ trans('ideas.name') }}</label>
                    {{ Form::text('name',$user->name, ['class'=>'form-control']) }}
                </div>
                <div class="form-group">
                    <label for="surname">{{ trans('ideas.surname') }}</label>
                    {{ Form::text('surname',$user->last_name, ['class'=>'form-control']) }}
                </div>
                <div class="form-group">
                    <label for="email">{{ trans('ideas.email') }}</label>
                    {{ Form::text('email',$user->email, ['class'=>'form-control' , 'disabled' => true]) }}
                </div>
                <button type="submit" class="btn btn-primary pull-right">{{ trans('ideas.save') }}</button>
            </form>
        </div>
    </div>
    <hr>
    <div class="row">
        <div class="col-md-6 col-md-offset-3">
            <form method="POST" action="{{ route('profile.change-pass') }}">
                {{ csrf_field() }}
                <div class="form-group">
                    <label for="password">{{ trans('ideas.new_password') }}</label>
                    <input class="form-control" name="password" type="password" value="">
                </div>
                <div class="form-group">
                    <label for="password_confirmation">{{ trans('ideas.password_confirmation') }}</label>
                    <input class="form-control" name="password_confirmation" type="password" value="">
                </div>
                <button type="submit" class="btn btn-primary pull-right">{{ trans('ideas.change_password') }}</button>
            </form>
        </div>
    </div>
    <hr>
</div>
@endsection
