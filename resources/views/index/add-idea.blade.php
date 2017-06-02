@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row page-header">
        <div class="col-sm-8">
            <h1>Добавить идею</h1>
        </div>
    </div>
    <div class="row">
        <div class="col-md-6 col-md-offset-3">
            @include('partials.errors')
            <form method="POST" action="{{ route('add-idea') }}" class="js-disable-after-submit">
                {{ csrf_field() }}
                <div class="form-group">
                    <label for="name">Заголовок</label>
                    {{ Form::text('title','', ['class'=>'form-control']) }}
                </div>
                <div class="form-group">
                    <label for="email">Описание</label>
                    {{ Form::textarea('description','', ['class'=>'form-control']) }}
                </div>
                <div class="form-group">
                    <label for="department">Основная компетенция</label>
                    {{ Form::select('core_competency_id', $coreCompetenciesList, '', ['class'=>'form-control']) }}
                </div>
                <div class="form-group">
                    <label for="department">Оперативная цель</label>
                    {{ Form::select('operational_goal_id', $operationalGoalsList, '', ['class'=>'form-control']) }}
                </div>
                <div class="form-group">
                    <label for="department">Стратегическая цель</label>
                    {{ Form::select('strategic_objective_id', $strategicObjectivesList, '', ['class'=>'form-control']) }}
                </div>
                <div class="form-group">
                    <label for="department">Отдел</label>
                    {{ Form::select('department_id', $departmentsList, '', ['class'=>'form-control']) }}

                </div>
                <div class="form-group">
                    <label for="department">Тип</label>
                    {{ Form::select('type_id', $typesList, '', ['class'=>'form-control']) }}
                </div>
                <button type="submit" class="btn btn-primary pull-right">Добавить</button>
            </form>
        </div>
    </div>
    <hr>
</div>
@endsection
