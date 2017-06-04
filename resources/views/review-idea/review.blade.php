@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row page-header">
        <div class="col-sm-8">
            <h1>{{ $idea->title }}</h1>
        </div>
    </div>

    <div class="container-fluid">
        @if (Session::has('alert-success'))
            <div class="alert alert-success alert-dismissable">
                <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
                {{ Session::get('alert-success') }}
            </div>
        @endif
        @include('partials.errors')
        <div class="row">
            <div class="panel panel-default">
                <div class="panel-heading">Создана : {{ $idea->created_at->format('d.m.Y') }}
                    Пользователь {{ $user->name }}, {{ $user->position->name }}
                </div>

                <div class="panel-body">
                    <p><b>Основная компетенция:</b> {{ $idea->coreCompetency->name }}</p>
                    <p><b>Оперативная цель:</b> {{ $idea->operationalGoal->name }}</p>
                    <p><b>Стратегическая цель:</b> {{ $idea->strategicObjective->name }}</p>
                    <p><b>Отдел:</b> {{ $idea->department->name }}</p>
                    <p><b>Тип:</b> {{ $idea->type->name }}</p>
                </div>
                <div class="panel-body">
                    {{ $idea->description }}
                </div>
            </div>
            @include('review-idea.partials.approve')
            @include('review-idea.partials.pin-priority')
            @include('review-idea.partials.unpin-priority')
            @include('edit-idea.partials.change-status')
            @include('edit-idea.partials.edit-button')
        </div>
    </div>
    <hr>
</div>
@endsection
