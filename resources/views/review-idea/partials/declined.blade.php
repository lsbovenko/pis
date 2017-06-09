@if ($idea->isDeclined())
    <br />
    <div class="row">
        <div class="col-sm12">
            <div class="alert alert-danger">
                Отклонена по причине: {{ $idea->getDeclineReason()->text }}
            </div>
        </div>
    </div>
@endif
