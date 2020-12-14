@extends('layouts.app')

@section('content')
<div class="container bottom-padding">
    <div class="content-box add-new-idea edit">
        <div class="section-title">{{ trans('ideas.edit_idea') }}</div>
        <div class="description-grey">
            {{ trans('ideas.created') }}:
            {{ $idea->created_at->format('d.m.Y') }},
            @if ($user)
                {{ $user->getFullName() }},
                {{ $user->position->name }}
            @endif
        </div>

        @if (Session::has('alert-success'))
            <div class="alert alert-success alert-dismissable">
                <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
                {{ Session::get('alert-success') }}
            </div>
        @endif
        @include('partials.errors')
        <form method="POST" action="{{ route('edit-idea', ['id' => $idea->id]) }}" class="js-disable-after-submit">
            @include('index.partials.add-fields')
            <div class="row bottom-button">
                <div class="col-md-12 text-right">
                    <button type="button" class="btn_ btn-blue last" @click.prevent="onClickEditIdea" id="edit_idea_button">{{ trans('ideas.change') }}</button>
                    <button type="submit" hidden="hidden" id="edit_idea_submit"></button>
                </div>
            </div>
        </form>

    </div>
    <hr>
</div>
@endsection
