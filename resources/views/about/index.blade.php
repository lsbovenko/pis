@extends('layouts.app')

@section('content')
    <div class="container bottom-padding">
        <div class="content-box">
            <div class="idea">
                <div class="description col-md-12">
                    <div class="section-title">{{ trans('ideas.about_title') }}</div>
                    <div class="text about-ul">
                        {!! trans('ideas.about_text', ['route_add_idea' => route('add-idea')]) !!}
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
