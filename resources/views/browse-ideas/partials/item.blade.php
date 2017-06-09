<div class="row">
    <div class="col-md-12">
        <div class="row">
            <div class="col-md-12">
                <h3>{{ $idea->title }}</h3>
            </div>
        </div>
        @unless ($idea->isDeclined() )
            <div class="row">
                <div class="col-md-3 col-md-offset-9">
                    <h4 class="pull-right text-muted">{{ $idea->status->name }}</h4>
                </div>
            </div>
        @endunless

        <p>{{ str_limit($idea->description, $limit = 150, $end = '...') }}</p>
        <div class="row">
            <div class="col-md-8">
                Создана : {{ $idea->created_at->format('d.m.Y') }}, {{ $idea->user->name }}, {{ $idea->user->position->name }}
            </div>
            <div class="col-md-4">
                <div class="row">
                    <div class="col-md-6">
                        <a class="btn btn-primary pull-right" href="{{ route('edit-idea', ['id' => $idea->id]) }}">Редактировать</a>
                    </div>
                    <div class="col-md-6">
                        <a class="btn btn-primary pull-right" href="{{ route('review-idea', ['id' => $idea->id]) }}">Подробности</a>
                    </div>
                </div>
            </div>
        </div>

    </div>
</div>
<hr>