@if ($idea->isApproved() && Entrust::hasRole(['superadmin', 'admin']))
    <form action="{{ route('change-status', ['id' => $idea->id]) }}" method="post" class="js-disable-after-submit">
        {{ csrf_field() }}
        {{ Form::hidden('activeStatusId', $activeStatusId, ['id' => 'hidden-active-status-id']) }}

        <div class="flex-row">
            <div class="form-group executors-select calc-length select-wrapper">
                <label for="select-status-id">{{ trans('ideas.status') }}</label>
                {{ Form::select('status_id', $statuses, $status->id, ['class'=>'form-control', 'id' => 'select-status-id']) }}
            </div>
            <button type="submit" class="accept-blue icon-btn">
                <i class="zmdi zmdi-check"></i>
            </button>
        </div>
        <div class="row">
            <div class="col-lg-12">
                {{ Form::textarea('details', $idea->details, [
                    'class'=>'form-control custom-form-item',
                    'placeholder' => trans('ideas.enter_details'),
                    'id' => 'textarea-details']) }}
            </div>
        </div>
    </form>
@endif
