@extends('layouts.app')

@section('content')
<div class="container bottom-padding">
    <div class="content-box admin-category">
        <div class="section-title">{{ trans('ideas.categories') }}</div>
        <table class="table">
            <thead>
            <tr>
                <th>{{ trans('ideas.name') }}</th>
                <th class="text-right">{{ trans('ideas.actions') }}</th>
            </tr>
            </thead>
            <tbody>
            <tr>
                <td>{{ trans('ideas.statuses') }}</td>
                <td><a href="{{ route('categories.statuses.index') }}"><span class="lnr lnr-pencil"></span></a></td>
            </tr>
            <tr>
                <td>{{ trans('ideas.departments') }}</td>
                <td><a href="{{ route('categories.department.index') }}"><span class="lnr lnr-pencil"></span></a></td>
            </tr>
            <tr>
                <td>{{ trans('ideas.positions') }}</td>
                <td><a href="{{ route('categories.position.index') }}"><span class="lnr lnr-pencil"></span></a></td>
            </tr>
            <tr>
                <td>{{ trans('ideas.core_competencies') }}</td>
                <td><a href="{{ route('categories.core-competency.index') }}"><span class="lnr lnr-pencil"></span></a></td>
            </tr>
            <tr>
                <td>{{ trans('ideas.operational_goals') }}</td>
                <td><a href="{{ route('categories.operational-goal.index') }}"><span class="lnr lnr-pencil"></span></a></td>
            </tr>
            <tr>
                <td>{{ trans('ideas.strategic_objectives') }}</td>
                <td><a href="{{ route('categories.strategic-objective.index') }}"><span class="lnr lnr-pencil"></span></a></td>
            </tr>
            <tr>
                <td>{{ trans('ideas.types') }}</td>
                <td><a href="{{ route('categories.type.index') }}"><span class="lnr lnr-pencil"></span></a></td>
            </tr>
            </tbody>
        </table>
    </div>
    <hr>
</div>
@endsection
