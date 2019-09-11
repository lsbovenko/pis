<div class="row">
    <div class="col-md-12">
        <div class="row">
            <div class="col-md-12">
                <a href="{{ route('review-idea', ['id' => $idea->id]) }}">
                    <h3>
                        {{ $idea->title }}
                        @if ($showApproveStatus)
                            @if ($idea->isDeclined())
                                ({{ trans('ideas.rejected_idea') }})
                            @elseif ($idea->isNew())
                                ({{ trans('ideas.not_yet_approved') }})
                            @else
                                ({{ trans('ideas.approved') }})
                            @endif
                        @endif
                    </h3>
                </a>
            </div>
        </div>
        @unless ($idea->isDeclined() )
            <div class="row">
                <div class="col-md-3 col-md-offset-9">
                    <h4 class="pull-right text-muted">{{ $idea->status->name }}</h4>
                </div>
            </div>
        @endunless

        <p>
            @php
                echo str_limit(strip_tags($idea->description), $limit = 150, $end = '...')
            @endphp
        </p>
        <div class="row">
            <div class="col-md-8">
                {{ trans('ideas.created') }}: {{ $idea->created_at->format('d.m.Y') }}, {{ $idea->user->getFullName() }}, {{ $idea->user->position->name }}
            </div>
            <div class="col-md-4">
                <div class="row">
                    <div class="col-md-6">
                        @role('superadmin')
                            @if(!$idea->isDeclined())
                                <a class="btn btn-primary pull-right" href="{{ route('edit-idea', ['id' => $idea->id]) }}">{{ trans('ideas.edit') }}</a>
                            @endif
                        @endrole
                    </div>
                    <div class="col-md-6">
                        <a class="btn btn-primary pull-right" href="{{ route('review-idea', ['id' => $idea->id]) }}">{{ trans('ideas.details') }}</a>
                    </div>
                </div>
            </div>
        </div>

    </div>
</div>
<hr>