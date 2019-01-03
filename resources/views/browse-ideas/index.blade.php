@extends('layouts.app')

@section('content')
    {{--<div class="container">
        <div class="row">
            <div class="col-md-6">
                <h1 class="page-header">{{ $title }}
                    <small>({{ $ideas->total() }})</small>
                </h1>
            </div>

        </div>
        <div class="row">
            @main('partials.top-users', ['users' => $topUsers, 'title' => 'Идеи за все время'])
            @main('partials.top-users', ['users' => $topUsersByCompletedIdeas, 'title' => 'Реализованные за все время'])
            @main('partials.top-users', ['users' => $topUsersLast3Month, 'title' => 'Идеи за 90 дней'])
            @main('partials.top-users', ['users' => $topUsersByCompletedIdeasLast3Month, 'title' => 'Реализованные за 90 дней'])
        </div>

        @main('browse-ideas.partials.filter')

        @foreach ($ideas as $idea)
            @main('browse-ideas.partials.item')
        @endforeach

        @unless($ideas->count())
            Ничего не найдено.
        @endunless

        <div class="row text-center">
            <div class="col-lg-12">
                {{ $ideas->render() }}
            </div>
        </div>
    </div>--}}
@endsection
@section('scripts')
<script src="{{ mix('js/app.js') }}"></script>
@stop