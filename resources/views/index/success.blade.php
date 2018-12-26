@extends('layouts.app')

@section('content')
<div class="container bottom-padding">
    <div class="content-box add-new-idea">
        @include('partials.errors')
        <div class="section-title">Спасибо. Ваша идея успешно добавлена.</div>
        <div class="text">Идея будет опубликована только после одобрения администратором.<br><br></div>
        <hr>
    </div>
</div>
@endsection
