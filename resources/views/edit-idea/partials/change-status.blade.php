@if ($idea->isApproved())
    <br />
    <div class="row">
        <div class="col-sm12">
            <form action="{{ route('change-status', ['id' => $idea->id]) }}" method="post" class="js-disable-after-submit">
                {{ csrf_field() }}
                <div class="col-sm-3">
                    <button type="submit" class="btn btn-success pull-left">Изменить статус</button>
                </div>
                <div class="col-sm-5">
                    <div class="form-group">
                        {{ Form::select('status_id', $statuses, $status->id, ['class'=>'form-control']) }}
                    </div>
                </div>
            </form>
        </div>
    </div>
@endif