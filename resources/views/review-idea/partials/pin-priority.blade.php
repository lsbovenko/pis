@if ($idea->isApproved() && Entrust::hasRole(['superadmin', 'admin']))
    <div class="row">
        <div class="col-lg-12">
            @if ($idea->is_priority === 1)
                <form action="{{ route('change-priority-reason', ['id' => $idea->id]) }}" method="post" class="js-disable-after-submit">
                    {{ csrf_field() }}
                    <div class="row">
                        <div class="col-lg-12">
                            <div class="form-group">
                                <label for="select-status-id">{{ trans('ideas.explanatory_note') }}</label>
                                {{ Form::textarea(
                            'reason_priority',
                            $priorityReason !== null ? $priorityReason->text : '', [
                                    'class'=>'form-control custom-form-item',
                                    'placeholder' =>
                                    trans('ideas.explanatory_note'),
                                    'rows' => 5,
                                ]
                            ) }}
                            </div>
                            <div class="form-group">
                                <button type="submit" class="btn btn-success pull-left">{{ trans('ideas.change_note') }}</button>
                                <a href="{{ route('unpin-priority', ['id' => $idea->id]) }}" class="btn btn-danger pull-left mg-left-10">{{ trans('ideas.not_priority') }}</a>
                            </div>
                        </div>
                    </div>
                </form>
            @else
                <form action="{{ route('pin-priority', ['id' => $idea->id]) }}" method="post" class="js-disable-after-submit">
                    {{ csrf_field() }}
                    <div class="row">
                        <div class="col-lg-12">
                            <div class="form-group">
                                <label for="select-status-id">{{ trans('ideas.explanatory_note') }}</label>
                                {{ Form::textarea(
                                        'reason_priority',
                                        $priorityReason !== null ? $priorityReason->text : '',
                                        [
                                            'class'=>'form-control custom-form-item',
                                            'placeholder' => trans('ideas.explanatory_note'),
                                            'style' => 'height:66px;'
                                        ]
                                    )
                                }}
                            </div>
                        </div>
                        <div class="button-in-line">
                            @role('superadmin')
                            @if(!$idea->isDeclined() and !$idea->isNew())
                                    <div class="lnr lnr-pencil"
                                         onclick="window.location.href='{{ route('edit-idea', ['id' => $idea->id]) }}'"></div>
                            @endif
                            @endrole

                            <button type="submit" class="btn btn-outline-star pull-left">
                                <i class="zmdi zmdi-star-outline"></i>
                                <span>{{ trans('ideas.pin_as_priority') }}</span>
                            </button>
                        </div>
                    </div>
                </form>
            @endif
        </div>
    </div>
@endif
