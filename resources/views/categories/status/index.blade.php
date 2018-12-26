@extends('layouts.app')

@section('content')
<div class="container bottom-padding">
    <div class="content-box admin-category">
        <div class="section-title">
            {{ $title }}
        </div>
        <table class="table">
            <thead>
            <tr>
                <th>Имя</th>
                <th class="text-right">Действия</th>
            </tr>
            </thead>
            <tbody>
            @foreach($items as $item)
                <tr class="@if (!$item->is_active)danger @endif">
                    <td>{{ $item->name }}</td>
                    <td>
                        <a style="text-decoration: none;" href="{{ route($route . '.edit', ['id' => $item->id]) }}">
                            <span class="lnr lnr-pencil"></span>
                        </a>
                        <a style="text-decoration: none;" href="{{ route('categories.type.delete', ['id' => $item->id]) }}">
                            <span class="lnr lnr-trash"></span>
                        </a>
                    </td>
                </tr>
            @endforeach
            <tr>
                <td></td>
                <td>
                    <a href="{{ route($route . '.create') }}">
                        <button class="btn_ btn-blue last" type="button">Добавить</button>
                    </a>
                </td>
            </tr>
            </tbody>
        </table>
    </div>
    <hr>
</div>
@endsection
