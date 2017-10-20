@extends('layouts.app')

@section('content')
<div class="container">

    <div class="row">
        <div class="col-md-6 col-md-offset-3">
            @include('partials.errors')
            <div class="alert alert-success alert-dismissable">
                Спасибо. Ваша идея успешно добавлена.
            </div>
            <p>Идя будет опубликована только после одобрения администратора.</p>
        </div>
    </div>
    <hr>
</div>
@endsection
