@extends('layouts.app')

@section('content')
    <div class="container bottom-padding">
        <div class="content-box">
            <div class="idea">
                <div class="description col-md-9">
                    @if (Session::has('alert-success'))
                        <div class="alert alert-success alert-dismissable">
                            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                <span aria-hidden="true">×</span>
                            </button>
                            {{ Session::get('alert-success') }}
                        </div>
                    @endif

                    @include('partials.errors')

                    @if ($idea->isDeclined())
                        <div class="idea-status">
                            <span class="rejected status">{{ trans('ideas.rejected') }}</span>
                        </div>
                    @endif

                    <div class="section-title">{{ $idea->title }}</div>
                    <div class="{{ $status->slug }} status">{{ $status->name }}</div>
                    @if ($status->id == $completedStatusId  && $idea->details)
                        <div class="text">
                            {{ $idea->details }}
                        </div>
                        <hr>
                    @endif
                    <div class="text">
                        {!! $idea->description !!}
                    </div>
                    @if ($idea->isDeclined())
                        <div class="answer">
                            <div class="answer-name">{{ trans('ideas.rejection_reason') }}</div>
                            <div class="answer-text">
                                @if ($idea->getDeclineReason())
                                    {{ $idea->getDeclineReason()->text }}
                                @endif
                            </div>
                        </div>
                        <div class="mg-top-10 buttons">
                            <div class="lnr lnr-pencil"
                                 onclick="window.location.href='{{ route('edit-idea', ['id' => $idea->id]) }}'"></div>
                        </div>
                    @else
                        @role('superadmin')
                        <hr>
                        <form action="{{ route('edit-idea-executors', ['id' => $idea->id]) }}" method="post">
                            {{ csrf_field() }}
                            <div class="row">
                                <div class="col-lg-8 col-md-8 col-xs-5">
                                    <div class="form-group executors-select">
                                        <label for="executors_select">{{ trans('ideas.executors') }}</label>
                                        <div class="dropdown customer-select">
                                            {{ Form::select('executors_select[]', $executorsList, isset($idea) ? $idea->executors : '', [
                                            'class'=>'selectpicker',
                                            'id' => 'executors_select',
                                            'multiple' => true,
                                            'data-live-search' => 'true',
                                            'data-none-selected-text' => trans('ideas.choose_executors')
                                            ]) }}
                                        </div>
                                    </div>
                                </div>
                                <div class="col-lg-3 col-md-3 col-xs-6">
                                    <div class="buttons justify executors-button">
                                        <button type="submit" class="accept-blue">
                                            {{ trans('ideas.assign_executors') }}
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </form>
                        @if ($idea->isNew())
                            <div class="buttons justify">
                                <div class="lnr lnr-pencil"
                                     onclick="window.location.href='{{ route('edit-idea', ['id' => $idea->id]) }}'"></div>
                                <form action="{{ route('review-idea', ['id' => $idea->id]) }}" method="post">
                                    {{ csrf_field() }}
                                    <button value="1" name="status" type="submit" class="accept-blue">
                                        <span class="fa fa-check"></span> {{ trans('ideas.accept') }}
                                    </button>
                                </form>
                                <div class="reject popup-open" data-toggle="modal" data-target="#myModal">{{ trans('ideas.reject') }}
                                </div>
                            </div>
                        @endif
                        @endrole
                    @endif

                    @if ($idea->isApproved())
                        <hr>
                        <div class="support">
                            <div class="support-name">
                                <i class="zmdi zmdi-favorite"></i>
                                <span id="count_ideas_like">{{ $idea->likes_num }}</span> {{ trans('ideas.like') }}
                            </div>
                            <div class="support-text liked_users_{{ $idea->id }}">
                                @foreach($authUser['listUsersLike'] as $i => $userName)
                                    {{ $userName->name }} {{ $userName->last_name }}@if($i + 1 != $idea->likes_num),@endif
                                @endforeach
                            </div>
                        </div>
                        <div class="mg-top-10">
                            <div class="mg-top-0 buttons in-grid btn_like_{{ $idea->id }} add_like left"
                                 data-name="{{ $authUser['user']->name }} {{ $authUser['user']->last_name }}"
                                 data-id="{{ $authUser['user']->id }}"
                                 data-idea="{{ $idea->id }}"
                                 id="{{ !empty($authUser['userLike']) ? 'remove_like_user' : 'add_like_user' }}">
                                <div class="i-support {{ !empty($authUser['userLike']) ? 'btn_liked' : '' }}">
                                    {{ !empty($authUser['userLike']) ? trans('ideas.i_don\'t_like') : trans('ideas.i_like') }}
                                </div>
                            </div>
                            @role('superadmin')
                            @if(!$idea->isDeclined() and !$idea->isNew())
                                <div class="buttons justify">
                                    <div class="lnr lnr-pencil"
                                         onclick="window.location.href='{{ route('edit-idea', ['id' => $idea->id]) }}'"></div>
                                </div>
                            @endif
                            @endrole
                            @include('review-idea.partials.approve')
                            @include('review-idea.partials.pin-priority')
                            @include('edit-idea.partials.change-status')
                            @include('review-idea.partials.declined')
                        </div>
                    @endif
                </div>
                <div class="information col-md-3">
                    @if ($user)
                        <div class="block">
                            <b>{{ trans('ideas.author') }}</b>
                            <div><b>{{ $user->getFullName() }}</b></div>
                            <div>{{ $user->position->name }}</div>
                        </div>
                    @else
                        <div class="block">
                            <b>{{ trans('ideas.author') }}</b>
                            <div><b>{{ trans('ideas.anonym') }}</b></div>
                        </div>
                    @endif
                    @if ($idea->created_at)
                        <div class="block">
                            <b>{{ trans('ideas.created') }}</b>
                            <div>{{ $idea->created_at->format('d.m.Y') }}</div>
                        </div>
                    @endif
                    @if ($status->id == $completedStatusId)
                        @if ($idea->completed_at)
                            <div class="block">
                                <b>{{ trans('ideas.implemented') }}</b>
                                <div>{{ $idea->completed_at->format('d.m.Y') }}</div>
                            </div>
                            @if ($idea->created_at)
                                <div class="block">
                                    <b>{{ trans('ideas.implemented_in_days') }}</b>
                                    <div>{{ intdiv($idea->completed_at->timestamp - $idea->created_at->timestamp, 24*60*60) }}</div>
                                </div>
                            @endif
                        @endif
                    @endif
                    <div class="block">
                        <b>{{ trans('ideas.core_competency') }}:</b>
                        <div>
                            @foreach ($idea->coreCompetencies as $coreCompetency)
                                {{ $coreCompetency->name }}
                                <br>
                            @endforeach
                        </div>
                    </div>
                    <div class="block">
                        <b>{{ trans('ideas.operational_goal') }}:</b>
                        <div>
                            @foreach ($idea->operationalGoals as $goal)
                                {{ $goal->name }}
                                <br>
                            @endforeach
                        </div>
                    </div>
                    <div class="block">
                        <b>{{ trans('ideas.department') }}:</b>
                        <div>
                            @foreach ($idea->departments as $department)
                                {{ $department->name }}
                                <br>
                            @endforeach
                        </div>
                    </div>
                    <div class="block">
                        <b>{{ trans('ideas.type') }}:</b>
                        <div>{{ $idea->type->name }}</div>
                    </div>
                    @if (count($idea->executors))
                        <div class="block">
                            <b>{{ trans('ideas.executors') }}:</b>
                            <div>
                                @foreach ($idea->executors as $executor)
                                    {{ $executor->getFullName() }}
                                    <br>
                                @endforeach
                            </div>
                        </div>
                    @endif
                    @if (count($idea->tags))
                        <div class="block">
                            <b>{{ trans('ideas.tag') }}:</b>
                            <div>
                                @foreach ($idea->tags as $tag)
                                    {{ $tag->name }}
                                    <br>
                                @endforeach
                            </div>
                        </div>
                    @endif
                </div>
                <script>
                    const ideaId = {{ $idea->id }};
                </script>
                <div class="reviews col-md-12" id="comment">
                    @if ($idea->isApproved())
                        <comment></comment>
                    @endif
                </div>
            </div>
        </div>
    </div>
    <!-- Modal -->
    <div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                    <h4 class="modal-title" id="myModalLabel">{{ trans('ideas.reject_idea') }}</h4>
                </div>
                <div class="modal-body">
                    <form action="{{ route('review-idea', ['id' => $idea->id]) }}" method="post">
                        {{ csrf_field() }}
                        <div class="form-group">
                            <label for="caption">{{ trans('ideas.rejection_reason') }}</label>
                            {{ Form::text('reason','', [
                            'class'=>'form-control',
                            'placeholder' => trans('ideas.reason_for_rejection')
                            ]) }}
                        </div>
                        <div class="row bottom-button reject-popup">
                            <div class="col-md-12 col-sm-12 col-xs-12 text-right">
                                <button value="2" name="status" type="submit" class="btn btn-success">{{ trans('ideas.reject') }}</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
@section('scripts')
    <script src="{{ mix('js/comment.js') }}?v={{ config('app.version') }}"></script>
    <script src="{{ asset('/vendor/bootstrap-select/bootstrap-select.min.js') }}"></script>
    <link href="{{ asset('/vendor/bootstrap-select/bootstrap-select.min.css') }}" rel="stylesheet">
@stop