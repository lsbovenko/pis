@if ($idea->isDeclined())
    <br />
    <div class="row">
        <div class="col-sm12">
            <div class="alert alert-danger">
                {{ trans('ideas.rejected_for_a_reason') }}:
                    @if ($idea->getDeclineReason())
                        {{ $idea->getDeclineReason()->text }}
                    @endif
            </div>
        </div>
    </div>
@endif
