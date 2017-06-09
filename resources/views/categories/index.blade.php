@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row page-header">
        <div class="col-sm-8">
            <h1>Категории</h1>
        </div>
    </div>
    <div class="row">
        <div class="col-md-12">
            <table class="table">
                <thead>
                    <tr>
                        <th>Имя</th>
                        <th>Действия</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td>Статусы</td>
                        <td><a href="">Редактировать</a></td>
                    </tr>
                    <tr>
                        <td>Отделы</td>
                        <td><a href="">Редактировать</a></td>
                    </tr>
                    <tr>
                        <td>Основные компетенции</td>
                        <td><a href="">Редактировать</a></td>
                    </tr>
                    <tr>
                        <td>Оперативные цели</td>
                        <td><a href="">Редактировать</a></td>
                    </tr>
                    <tr>
                        <td>Стратегические цели</td>
                        <td><a href="">Редактировать</a></td>
                    </tr>
                    <tr>
                        <td>Типы</td>
                        <td><a href="">Редактировать</a></td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>
    <hr>
</div>
@endsection
