@extends('layouts.app')

@section('content')
    <div class="container bottom-padding">
        <div class="content-box add-new-idea">
            <div class="section-title">{{ $title }}</div>
            @include('partials.errors')
            <form method="POST" action="{{ $route }}">
                @include('categories.status.partials.fields')
                <div class="row bottom-button">
                    @if(isset($deleteRoute))
                        <div class="col-md-6 col-sm-6 col-xs-12 text-left">
                            <a href="{{ $deleteRoute }}">
                                <button class="btn_ btn-outline-red">{{ trans('ideas.remove') }}</button>
                            </a>
                        </div>
                    @endif
                    <div class="col-md-6 col-sm-6 col-xs-12 text-left"></div>
                        <div class="col-md-6 col-sm-6 col-xs-12 text-right">
                            <button type="submit" class="btn_ btn-blue last">{{ trans('ideas.save') }}</button>
                        </div>
                </div>
            </form>
        </div>
        <hr>
    </div>
@endsection