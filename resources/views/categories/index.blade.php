@extends('layouts.app')

@section('content')
<div class="container bottom-padding">
    <div class="content-box admin-category">
        <div class="section-title">Категории</div>
        <table class="table">
            <thead>
            <tr>
                <th>Имя</th>
                <th class="text-right">Действия</th>
            </tr>
            </thead>
            <tbody>
            <tr>
                <td>Статусы</td>
                <td><a href="{{ route('categories.statuses.index') }}"><span class="lnr lnr-pencil"></span></a></td>
            </tr>
            <tr>
                <td>Отделы</td>
                <td><a href="{{ route('categories.department.index') }}"><span class="lnr lnr-pencil"></span></a></td>
            </tr>
            <tr>
                <td>Должности</td>
                <td><a href="{{ route('categories.position.index') }}"><span class="lnr lnr-pencil"></span></a></td>
            </tr>
            <tr>
                <td>Основные компетенции</td>
                <td><a href="{{ route('categories.core-competency.index') }}"><span class="lnr lnr-pencil"></span></a></td>
            </tr>
            <tr>
                <td>Операционные цели</td>
                <td><a href="{{ route('categories.operational-goal.index') }}"><span class="lnr lnr-pencil"></span></a></td>
            </tr>
            <tr>
                <td>Стратегические задачи</td>
                <td><a href="{{ route('categories.strategic-objective.index') }}"><span class="lnr lnr-pencil"></span></a></td>
            </tr>
            <tr>
                <td>Типы</td>
                <td><a href="{{ route('categories.type.index') }}"><span class="lnr lnr-pencil"></span></a></td>
            </tr>
            </tbody>
        </table>
    </div>
    <hr>
</div>
@endsection
