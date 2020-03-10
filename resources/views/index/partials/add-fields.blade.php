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
<div class="input-group-two">
    <div class="form-group">
        <label for="tags_select">{{ trans('ideas.available_tags') }}</label>
        <div class="dropdown customer-select">
            {{ Form::select('tags_select[]', $tagsList, '', [
            'class'=>'form-control',
            'id' => 'tags_select',
            'multiple' => true
            ]) }}
        </div>
    </div>
    <div class="form-group tagsinput">
        <label for="tags">{{ trans('ideas.added_tags') }}</label>
        {{ Form::text('tags', '', [
        'class'=>'form-control',
        'id' => 'tags',
        'placeholder' => trans('ideas.enter_new_tag')
        ]) }}
    </div>
</div>
{{ Form::hidden('tags_exclude', isset($tagsExclude) ? $tagsExclude : '', ['class'=>'form-control', 'id'=>'tags_exclude']) }}

<div class="form-group">
    <label for="search_similar_idea">{{ trans('ideas.add_similar_ideas') }}</label>
    <img src='{{ asset('/images/loader.gif') }}' class='loader-small'>
    {{ Form::text('search_similar_idea', '', ['class'=>'form-control', 'placeholder'=>trans('ideas.search'), 'id'=>'search_similar_idea']) }}
</div>

<div class="form-group tagsinput similar_ideas_id">
    <label for="similar_ideas_id">{{ trans('ideas.added_similar_ideas') }}</label>
    {{ Form::text('similar_ideas_id', '', ['class'=>'form-control', 'id' => 'similar_ideas_id']) }}
</div>

<div class="form-group">
    <label for="estimated_time">{{ trans('ideas.estimated_time') }}</label>
    <div class="htooltip">
        <i class="fa fa-question-circle"></i>
        <span class="htooltiptext">{{ trans('ideas.estimated_description') }}</span>
    </div>
    {{ Form::text('estimated_time', isset($idea) ? $idea->estimated_time : '', ['class'=>'form-control', 'placeholder'=>trans('ideas.estimated_example'), 'id'=>'estimated_time']) }}
</div>

{{ Form::hidden('similar_ideas_info', !empty($similarIdeasInfo) ? $similarIdeasInfo : '', ['class'=>'form-control', 'id'=>'similar_ideas_info']) }}
{{ Form::hidden('idea_id', !empty($idea) ? $idea->id : '', ['class'=>'form-control', 'id'=>'idea_id']) }}

@section('scripts')
    <script src="{!! asset('/vendor/summernote/summernote.js') !!}"></script>
    <script src="{!! asset('/vendor/summernote/lang/summernote-ru-RU.js') !!}"></script>
    <script src="{{ asset('/vendor/bootstrap-tagsinput/bootstrap-tagsinput.min.js') }}"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <link href="{{ asset('/vendor/summernote/summernote.css') }}" rel="stylesheet">
    <link href="{{ asset('/vendor/bootstrap-tagsinput/bootstrap-tagsinput.min.css') }}" rel="stylesheet">
    <link href="{{ asset('/css/custom-add-fields.css') }}" rel="stylesheet">
@stop