@if ($idea->approve_status === 1)
    <br />
    <div class="row">
        @if ($idea->is_priority === 1)
            <form action="{{ route('change-priority-reason', ['id' => $idea->id]) }}" method="post" class="js-disable-after-submit">
                {{ csrf_field() }}
                <div class="col-sm-12">
                    <div class="row">
                        <div class="col-sm-3">
                            <button type="submit" class="btn btn-success pull-left">Изменить резюме</button>
                        </div>
                        <div class="col-sm-9">
                            {{ Form::text(
                            'reason_priority',
                            $priorityReason !== null ? $priorityReason->text : '',
                             ['class'=>'form-control', 'placeholder' => 'Управляющее резюме']) }}
                        </div>
                    </div>
                </div>
            </form>
        @else
            <form action="{{ route('pin-priority', ['id' => $idea->id]) }}" method="post" class="js-disable-after-submit">
                {{ csrf_field() }}
                <div class="col-sm-12">
                    <div class="row">
                        <div class="col-sm-3">
                            <button type="submit" class="btn btn-success pull-left"> Закрепить как приоритетное</button>
                        </div>
                        <div class="col-sm-9">
                            {{ Form::text(
                            'reason_priority',
                            $priorityReason !== null ? $priorityReason->text : '',
                             ['class'=>'form-control', 'placeholder' => 'Управляющее резюме']) }}
                        </div>
                    </div>
                </div>
            </form>
        @endif
    </div>
@endif
