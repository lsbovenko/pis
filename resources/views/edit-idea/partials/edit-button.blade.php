@role('superadmin')
    @if ($idea->isApproved())
        <div class="row">
            <div class="col-sm12">
                <div class="col-sm-3">
                    <a href="{{ route('edit-idea', ['id' => $idea->id]) }}">
                        <button type="button" class="btn btn-success pull-left">Редактировать</button>
                    </a>
                </div>
            </div>
        </div>
    @endif
@endrole