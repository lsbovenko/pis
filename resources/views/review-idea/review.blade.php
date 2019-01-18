@extends('layouts.app')

@section('content')
    <div class="container bottom-padding">
        <div class="content-box">
            <div class="idea">
                <div class="description col-md-9">
                    @if (Session::has('alert-success'))
                        <div class="alert alert-success alert-dismissable">
                            <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
                            {{ Session::get('alert-success') }}
                        </div>
                    @endif
                    @include('partials.errors')
                        @if ($idea->isDeclined())
                        <div class="idea-status">
                            <span class="rejected status">Откланено</span>
                        </div>
                        @endif
                    <div class="section-title">{{ $idea->title }}</div>
                    <div class="text">
                        {!! $idea->description !!}
                    </div>
                        @if ($idea->isDeclined())
                        <hr>
                        <div class="answer">
                            <div class="answer-name">
                                Причина отказа
                            </div>
                            <div class="answer-text">
                                @if ($idea->getDeclineReason())
                                    {{ $idea->getDeclineReason()->text }}
                                @endif
                            </div>
                        </div>
                            <div class="buttons">
                                <form action="{{ route('review-idea', ['id' => $idea->id]) }}" method="post">
                                    {{ csrf_field() }}
                                    <button  value="1" name="status" type="submit" class="accept">
                                        <span class="fa fa-check"></span> Принять
                                    </button>
                                </form>
                                <div class="lnr lnr-pencil" onclick="window.location.href='{{ route('edit-idea', ['id' => $idea->id]) }}'"></div>
                            </div>
                            @else
                            @role('superadmin')
                            @if ($idea->isNew())
                            <div class="buttons justify">
                                <div class="lnr lnr-pencil" onclick="window.location.href='{{ route('edit-idea', ['id' => $idea->id]) }}'"></div>
                                <form action="{{ route('review-idea', ['id' => $idea->id]) }}" method="post">
                                    {{ csrf_field() }}
                                    <button  value="1" name="status" type="submit" class="accept-blue">
                                        <span class="fa fa-check"></span> Принять
                                    </button>
                                </form>
                                <div class="reject popup-open">Отклонить</div>
                            </div>
                            @endif
                            @endrole
                        @endif
                        <hr>
                        <div class="support">
                            <div class="support-name">
                                <i class="zmdi zmdi-favorite"></i>
                                <span id="count_ideas_like">{{ $idea->likes_num }}</span> Поддерживают
                            </div>
                            <div class="support-text liked_users_{{ $idea->id }}">
                                @foreach($authUser['listUsersLike'] as $userName)
                                {{ $userName->name }} {{ $userName->last_name }}
                                @endforeach
                            </div>
                        </div>
                        <div class="buttons in-grid btn_like_{{ $idea->id }} add_like"
                             data-name="{{ $authUser['user']->name }} {{ $authUser['user']->last_name }}"
                             data-id="{{ $authUser['user']->id }}"
                             data-idea="{{ $idea->id }}"
                             id="{{ !empty($authUser['userLike']) ? 'remove_like_user' : 'add_like_user' }}">
                            <div class="i-support {{ !empty($authUser['userLike']) ? 'btn_liked' : '' }}">Я поддерживаю</div>
                        </div>

                        @include('review-idea.partials.pin-priority')
                        @include('edit-idea.partials.change-status')
                </div>
                <div class="information col-md-3">
                    <div data-user-name="{{ $user->getFullName() }}"><b>Автор</b></div>
                    <div class="block">
                        <b>{{ $user->getFullName() }}</b>
                        <div>{{ $user->position->name }}</div>
                        <a>Все идеи автора({{ $countUserIdea }})</a>
                    </div>
                    <div class="block">
                        <b>Создана</b>
                        <div>{{ $idea->created_at->format('d.m.Y') }}</div>
                    </div>
                    <div class="block">
                        <b>Основная компетенция:</b>
                        <div>
                            @foreach ($idea->coreCompetencies as $coreCompetency)
                                {{ $coreCompetency->name }}
                            @endforeach
                        </div>
                    </div>
                    <div class="block">
                        <b>Операционная цель:</b>
                        <div>
                            @foreach ($idea->operationalGoals as $goal)
                                {{ $goal->name }}
                            @endforeach
                        </div>
                    </div>
                    <div class="block">
                        <b>Стратегическая задача:</b>
                        <div>
                            @foreach ($idea->strategicObjectives as $strategicObjective)
                                {{ $strategicObjective->name }}
                            @endforeach
                        </div>
                    </div>
                    <div class="block">
                        <b>Отдел:</b>
                        <div>
                            @foreach ($idea->departments as $department)
                                {{ $department->name }}
                            @endforeach
                        </div>
                    </div>
                    <div class="block">
                        <b>Тип:</b>
                        <div>{{ $idea->type->name }}</div>
                    </div>
                </div>
                <script>
                    const ideaId = {{ $idea->id }};
                </script>
                <div class="reviews col-md-12" id="comment">
                    <comment></comment>
                </div>
            </div>
        </div>
    </div>
    <div class="modal-bg" style="display: none">
        <div class="container">
            <div class="content-box popup">
                <div class="x-close"></div>
                <div class="section-title">Отклонить идею</div>
                <div class="description-grey">Идея "{!! $idea->description !!}"</div>
                <form action="{{ route('review-idea', ['id' => $idea->id]) }}" method="post">
                    {{ csrf_field() }}
                    <div class="form-group">
                        <label for="caption">Причина отказа</label>
                        {{ Form::text('reason','', [
                        'class'=>'form-control',
                        'placeholder' => 'Укажите причину отклонения'
                        ]) }}
                    </div>
                    <div class="row bottom-button reject-popup">
                        <div class="col-md-12 col-sm-12 col-xs-12 text-right">
                            <button value="2" name="status" type="submit" class="btn_ btn-blue last">Отклонить</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection
@section('scripts')
    <script src="{{ mix('js/comment.js') }}?v={{ config('app.version') }}"></script>
@stop