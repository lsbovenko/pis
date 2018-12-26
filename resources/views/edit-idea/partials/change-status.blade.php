@if ($idea->isApproved() && Entrust::hasRole(['superadmin', 'admin']))
    <br />
    <div class="row" style="margin-top: 20px;   ">
        <form action="{{ route('change-status', ['id' => $idea->id]) }}" method="post" class="js-disable-after-submit">
            {{ csrf_field() }}
            <div class="col-lg-8">
                <div class="form-group">
                    {{ Form::select('status_id', $statuses, $status->id, ['class'=>'form-control']) }}
                </div>
            </div>
            <div class="col-lg-3">
                <div class="form-group">
                    <button type="submit" class="btn btn-success pull-left">Изменить статус</button>
                </div>
            </div>
        </form>
    </div>
@endif