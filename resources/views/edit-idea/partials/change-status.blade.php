@if ($idea->isApproved() && Entrust::hasRole(['superadmin', 'admin']))
    <br />
    <form action="{{ route('change-status', ['id' => $idea->id]) }}" method="post" class="js-disable-after-submit">
        {{ csrf_field() }}
        {{ Form::hidden('activeStatusId', $activeStatusId, ['id' => 'hidden-active-status-id']) }}
        <div class="row" style="margin-top: 20px;">
            <div class="col-lg-8 col-md-8 col-xs-5">
                <div class="form-group">
                    {{ Form::select('status_id', $statuses, $status->id, ['class'=>'form-control', 'id' => 'select-status-id']) }}
                </div>
            </div>
            <div class="col-lg-3 col-md-3 col-xs-6">
                <div class="form-group">
                    <button type="submit" class="btn btn-success pull-left">{{ trans('ideas.change_status') }}</button>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-lg-12">
                <div class="form-group">
                    {{ Form::textarea('details', $idea->details, [
                        'class'=>'form-control',
                        'placeholder' => trans('ideas.enter_details'),
                        'id' => 'textarea-details']) }}
                </div>
            </div>
        </div>
    </form>
@endif