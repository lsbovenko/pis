<div class="col-md-3">
    <div class="panel panel-default">
        <div class="panel-heading">
            {{ $title }}:
        </div>
        <div class="panel-body">
            @foreach ($users as $user)
                <span class="pull-right">
                    {{ $user->last_name }} {{ $user->name }} ({{ $user->number }})
                </span>
                <br />
            @endforeach
        </div>
    </div>
</div>