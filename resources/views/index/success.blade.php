@extends('layouts.app')

@section('content')
<div class="container bottom-padding">
    <div class="content-box add-new-idea">
        @include('partials.errors')
        <div class="section-title">{{ trans('ideas.idea_successfully_added') }}</div>
        <div class="text">{{ trans('ideas.published_after_approval') }}<br><br></div>
        <hr>
    </div>
</div>
@endsection
