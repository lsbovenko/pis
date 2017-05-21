@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row page-header">
        <div class="col-sm-8">
            <h1>{{ trans('users.create.title') }}</h1>
        </div>
    </div>
    <div class="row">
        <div class="col-md-6 col-md-offset-3">
            <form method="POST" action="{{ action('UsersController@update') }}">
                {{ csrf_field() }}
                <div class="form-group">
                    <label for="name">{{ trans('users.name') }}</label>
                    {{ Form::text('name','', ['class'=>'form-control']) }}
                </div>
                <div class="form-group">
                    <label for="email">{{ trans('users.email') }}</label>
                    {{ Form::text('email','', ['class'=>'form-control']) }}
                </div>
                <div class="form-group">
                    <label for="department">{{ trans('users.department') }}</label>
                    {{ Form::select('department', $departments, 'S', ['class'=>'form-control']) }}

                </div>
                <div class="form-group">
                    <label for="department">{{ trans('users.role') }}</label>
                    {{ Form::select('role', $roles, 'S', ['class'=>'form-control']) }}
                </div>
                <button type="submit" class="btn btn-primary pull-right">Submit</button>
            </form>
        </div>
    </div>
    <hr>
</div>
@endsection
