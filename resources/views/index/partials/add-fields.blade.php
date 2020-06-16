{{ csrf_field() }}
<div class="form-group">
    <label for="caption">{{ trans('ideas.headline') }}</label>
    {{ Form::text('title',isset($idea) ? $idea->title : '', [
    'class'=>'form-control',
    'id' => 'idea_title',
    'placeholder' => trans('ideas.create_headline')
    ]) }}
</div>
<div class="form-group description">
    <label for="summernote">{{ trans('ideas.description') }}</label>
    {{ Form::textarea('description', isset($idea) ? $idea->description : '', [
    'class'=>'form-control',
    'id' => 'summernote'
    ]) }}
</div>
<div class="input-group-two">
    <div class="form-group">
        <label for="dropdownMenu1">{{ trans('ideas.core_competency') }}</label>
        <div class="dropdown customer-select">
            {{ Form::select('core_competency_id[]', $coreCompetenciesList, isset($idea) ? $idea->coreCompetencies : '', [
            'class'=>'form-control',
            'id' => 'idea_competency',
            'multiple' => true
            ]) }}
        </div>
    </div>
    <div class="form-group">
        <label for="dropdownMenu2">{{ trans('ideas.operational_goal') }}</label>
        <div class="dropdown customer-select">
            {{ Form::select('operational_goal_id[]', $operationalGoalsList, isset($idea) ? $idea->operationalGoals : '', [
            'class'=>'form-control',
            'id' => 'idea_goal',
            'multiple' => true
            ]) }}
        </div>
    </div>
</div>
<div class="input-group-two">
    <div class="form-group">
        <label for="dropdownMenu4">{{ trans('ideas.department') }}</label>
        <div class="dropdown customer-select">
            {{ Form::select('department_id[]', $departmentsList, isset($idea) ? $idea->departments : '', [
            'class'=>'form-control',
            'id' => 'idea_depart',
            'multiple' => true
            ]) }}
        </div>
    </div>
    <div class="form-group">
        <label for="dropdownMenu5">{{ trans('ideas.type') }}</label>
        <div class="dropdown customer-select">
            {{ Form::select('type_id', $typesList, isset($idea) ? $idea->type->id : '', [
            'class'=>'btn form-control',
            'placeholder' => trans('ideas.choose'),
            'id' => 'idea_type'
            ]) }}
        </div>
    </div>
</div>
<div id="event_bus" class="form-group">
    <label for="tag">Tags</label>
    <div id="popular_tag"></div>
    <div id="tag"></div>
</div>
<div class="form-group">
    <label for="similar_idea">Similar ideas</label>
    <div id="similar_idea"></div>
</div>

<div class="form-group">
    <label for="estimated_time">{{ trans('ideas.estimated_time') }}</label>
    <div class="htooltip">
        <i class="fa fa-question-circle"></i>
        <span class="htooltiptext">{{ trans('ideas.estimated_description') }}</span>
    </div>
    {{ Form::text('estimated_time', isset($idea) ? $idea->estimated_time : '', ['class'=>'form-control', 'placeholder'=>trans('ideas.estimated_example'), 'id'=>'estimated_time']) }}
</div>

{{ Form::hidden('idea_id', !empty($idea) ? $idea->id : '', ['class'=>'form-control', 'id'=>'idea_id']) }}
{{ Form::hidden('popular_tags', '', ['class'=>'form-control', 'id'=>'popular_tags']) }}
{{ Form::hidden('tags', '', ['class'=>'form-control', 'id'=>'tags']) }}
{{ Form::hidden('similar_ideas', '', ['class'=>'form-control', 'id'=>'similar_ideas']) }}

@section('scripts')
    <script src="{!! asset('/vendor/summernote/summernote.js') !!}"></script>
    <script src="{!! asset('/vendor/summernote/lang/summernote-ru-RU.js') !!}"></script>
    <script src="{{ asset('/vendor/bootstrap-tagsinput/bootstrap-tagsinput.min.js') }}"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <link href="{{ asset('/vendor/summernote/summernote.css') }}" rel="stylesheet">
    <link href="{{ asset('/vendor/bootstrap-tagsinput/bootstrap-tagsinput.min.css') }}" rel="stylesheet">
    <link href="{{ asset('/css/custom-add-fields.css') }}" rel="stylesheet">
@stop