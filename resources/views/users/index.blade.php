@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row page-header">
        <div class="col-sm-8">
            <h1>{{ trans('users.title') }}</h1>
        </div>
        <div class="col-sm-4">
            <a href="{{ route('users::create') }}">
                <button class="btn btn-primary h1" type="button">{{ trans('users.add_new') }}</button>
            </a>
        </div>
    </div>
    <div class="row">
        <div class="col-md-12">
            <table class="table">
                <thead>
                    <tr>
                        <th>{{ trans('users.name') }}</th>
                        <th>{{ trans('users.email') }}</th>
                        <th>{{ trans('users.active_ideas') }}</th>
                        <th>{{ trans('users.frozen_ideas') }}</th>
                        <th>{{ trans('users.completed_ideas') }}</th>
                        <th>{{ trans('users.role') }}</th>
                        <th>{{ trans('users.actions') }}</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td>...</td>
                        <td>...</td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>
    <hr>
</div>
@endsection
