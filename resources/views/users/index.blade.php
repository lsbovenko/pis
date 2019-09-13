@extends('layouts.app')

@section('content')
<div class="container">
    <div class="content-box admin-category">
        <div class="section-title">{{ trans('ideas.list_of_users') }}</div>
        <div class="description-grey">{{ trans('ideas.users') }}: {{ $users->count() }}</div>
        <table class="table">
            <thead>
            <tr>
                <th>{{ trans('ideas.name') }}</th>
                <th>{{ trans('ideas.surname') }}</th>
                <th>{{ trans('ideas.email') }}</th>
                <th>{{ trans('ideas.active_ideas') }}</th>
                <th>{{ trans('ideas.on_pause') }}</th>
                <th>{{ trans('ideas.completed_ideas') }}</th>
                <th>{{ trans('ideas.role') }}</th>
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
