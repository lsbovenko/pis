@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row page-header">
        <div class="col-sm-8">
            <h1>{{ $idea->title }}</h1>
        </div>
    </div>

    <div class="container-fluid">
        @include('partials.errors')
        <div class="row">
            <div class="panel panel-default">
                <div class="panel-heading">Создана : {{ $idea->created_at->format('d.m.Y') }}
                    Пользователь {{ $user->name }},
                </div>

                <div class="panel-body">
                    <p><b>Основная компетенция:</b> {{ $coreCompetency->name }}</p>
                    <p><b>Оперативная цель:</b> {{ $operationalGoal->name }}</p>
                    <p><b>Стратегическая цель:</b> {{ $strategicObjective->name }}</p>
                    <p><b>Отдел:</b> {{ $department->name }}</p>
                    <p><b>Тип:</b> {{ $type->name }}</p>
                </div>
                <div class="panel-body">
                    {{ $idea->description }}
                </div>
            </div>
            <div class="row">
                <form action="{{ route('review-idea', ['id' => $idea->id]) }}" method="post">
                    {{ csrf_field() }}
                    <div class="col-sm-1">
                        <button @if ($idea->approve_status != 0) disabled @endif value="1" name="status" type="submit" class="btn btn-success pull-left">Принять</button>
                    </div>
                    <div class="col-sm-6">
                        <div class="row">
                            <div class="col-sm-3">
                                <button @if ($idea->approve_status != 0) disabled @endif  value="2" name="status" type="submit" class="btn btn-danger pull-left">Отклонить</button>
                            </div>
                            <div class="col-sm-9">
                                {{ Form::text('reason','', ['class'=>'form-control', 'placeholder' => 'Укажите причину отклонения']) }}
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <hr>
</div>
@endsection
