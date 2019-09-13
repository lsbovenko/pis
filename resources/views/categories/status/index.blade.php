@extends('layouts.app')

@section('content')
<div class="container bottom-padding">
    <div class="content-box admin-category">
        <div class="section-title">
            {{ $title }}
        </div>
        <?php foreach ($errors->all() as $message):?>
        <div class="alert alert-danger alert-dismissible" role="alert">
            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                <span aria-hidden="true">×</span></button>
            <?php echo $message?>
        </div>
        <?php endforeach?>
        <table class="table">
            <thead>
            <tr>
                <th>{{ trans('ideas.name') }}</th>
                <th class="text-right">{{ trans('ideas.actions') }}</th>
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
                        <a style="text-decoration: none;" href="{{ route($route . '.delete', ['id' => $item->id]) }}">
                            <span class="lnr lnr-trash"></span>
                        </a>
                    </td>
                </tr>
            @endforeach
            <tr>
                <td></td>
                <td>
                    <a href="{{ route($route . '.create') }}">
                        <button class="btn_ btn-blue last" type="button">{{ trans('ideas.add') }}</button>
                    </a>
                </td>
            </tr>
            </tbody>
        </table>
    </div>
    <hr>
</div>
@endsection
