@if ($idea->isApproved() && Entrust::hasRole(['superadmin', 'admin']))
    <br />
    <div class="row">
        <div class="col-lg-12">
            @if ($idea->is_priority === 1)
                <form action="{{ route('change-priority-reason', ['id' => $idea->id]) }}" method="post" class="js-disable-after-submit">
                    {{ csrf_field() }}
                    <div class="row">
                        <div class="col-lg-12">
                            <div class="form-group">
                                {{ Form::textarea(
                            'reason_priority',
                            $priorityReason !== null ? $priorityReason->text : '', [
                                    'class'=>'form-control',
                                    'placeholder' =>
                                    'Пояснительная записка',
                                    'rows' => 5,
                                ]
                            ) }}
                            </div>
                            <div class="form-group">
                                <button type="submit" class="btn btn-success pull-left">Изменить записку</button>
                                <a href="{{ route('unpin-priority', ['id' => $idea->id]) }}" class="btn btn-danger pull-left mg-left-10">Не приоритетное</a>
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
                                {{ Form::textarea(
                                        'reason_priority',
                                        $priorityReason !== null ? $priorityReason->text : '',
                                        [
                                            'class'=>'form-control',
                                            'placeholder' => 'Пояснительная записка',
                                            'style' => 'height:66px;'
                                        ]
                                    )
                                }}
                            </div>
                        </div>
                        <div class="col-lg-12">
                            <div class="form-group">
                                <button type="submit" class="btn btn-success pull-left">Закрепить как приоритетное</button>
                            </div>
                        </div>
                    </div>
                </form>
            @endif
        </div>
    </div>
@endif