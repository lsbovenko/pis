@extends('layouts.app')

@section('content')
<div class="container">
    <div class="content-box admin-category">
        <div class="section-title">Список пользователей</div>
        <div class="description-grey">Пользователей: {{ $users->count() }}</div>
        <table class="table">
            <thead>
            <tr>
                <th>{{ trans('users.name') }}</th>
                <th>{{ trans('last_name') }}</th>
                <th>{{ trans('users.email') }}</th>
                <th>{{ trans('users.active_ideas') }}</th>
                <th>{{ trans('users.frozen_ideas') }}</th>
                <th>{{ trans('users.completed_ideas') }}</th>
                <th>{{ trans('users.role') }}</th>
            </tr>
            </thead>
            <tbody>
            @foreach ($users as $user)
                <tr class="@if (!$user->is_active)danger @endif">
                    <td>{{ $user->name }}</td>
                    <td>{{ $user->last_name }}</td>
                    <td>{{ $user->email }}</td>
                    <td>{{ $user->countActiveIdeas() }}</td>
                    <td>{{ $user->countFrozenIdeas() }}</td>
                    <td>{{ $user->countCompletedIdeas() }}</td>
                    <td>{{ $user->roles()->first()->display_name }}</td>
                </tr>
            @endforeach

            </tbody>
        </table>
    </div>
    <hr>
    {{ $users->render() }}
</div>
@endsection
