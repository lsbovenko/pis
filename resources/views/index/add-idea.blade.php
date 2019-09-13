@extends('layouts.app')

@section('content')
    <div class="container bottom-padding">
        <div class="content-box add-new-idea">
            <div class="section-title">{{ trans('ideas.new_idea') }}</div>
            @include('partials.errors')
            <form method="post" action="{{ route('add-idea') }}" class="js-disable-after-submit">
                @include('index.partials.add-fields')
                <div class="row bottom-button">
                    <div class="col-md-12 text-right">
                        <button type="submit" class="btn_ btn-blue last">{{ trans('ideas.save') }}</button>
                    </div>
                </div>
            </form>

        </div>
    </div>
@endsection
