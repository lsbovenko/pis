{{ csrf_field() }}
<div class="form-group">
    <label for="caption">Заголовок</label>
    {{ Form::text('title',isset($idea) ? $idea->title : '', [
    'class'=>'form-control',
    'id' => 'idea_title',
    'placeholder' => 'Придумайте заголовок, например купить новый диван для кухни'
    ]) }}
</div>
<div class="form-group description">
    <label for="summernote">Описание</label>
    {{ Form::textarea('description', isset($idea) ? $idea->description : '', [
    'class'=>'form-control',
    'id' => 'summernote'
    ]) }}
</div>
<div class="input-group-two">
    <div class="form-group">
        <label for="dropdownMenu1">Основная Компетенция</label>
        <div class="dropdown customer-select">
            {{ Form::select('core_competency_id[]', $coreCompetenciesList, isset($idea) ? $idea->coreCompetencies : '', [
            'class'=>'form-control',
            'id' => 'idea_competency',
            'multiple' => true
            ]) }}
        </div>
    </div>
    <div class="form-group">
        <label for="dropdownMenu2">Операционная Цель</label>
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
        <label for="dropdownMenu4">Отдел</label>
        <div class="dropdown customer-select">
            {{ Form::select('department_id[]', $departmentsList, isset($idea) ? $idea->departments : '', [
            'class'=>'form-control',
            'id' => 'idea_depart',
            'multiple' => true
            ]) }}
        </div>
    </div>
    <div class="form-group">
        <label for="dropdownMenu5">Тип</label>
        <div class="dropdown customer-select">
            {{ Form::select('type_id', $typesList, isset($idea) ? $idea->type->id : '', [
            'class'=>'btn form-control',
            'placeholder' => 'Выберите',
            'id' => 'idea_type'
            ]) }}
        </div>
    </div>
</div>
<div class="input-group-two">
    <div class="form-group">
        <label for="tags_select">Доступные тэги</label>
        <div class="dropdown customer-select">
            {{ Form::select('tags_select[]', $tagsList, '', [
            'class'=>'form-control',
            'id' => 'tags_select',
            'multiple' => true
            ]) }}
        </div>
    </div>
    <div class="form-group tagsinput">
        <label for="tags">Добавленные тэги</label>
        {{ Form::text('tags', '', [
        'class'=>'form-control',
        'id' => 'tags',
        'placeholder' => 'Введите новый тэг либо выберите из списка'
        ]) }}
    </div>
</div>
{{ Form::hidden('tags_exclude', isset($tagsExclude) ? $tagsExclude : '', ['class'=>'form-control', 'id'=>'tags_exclude']) }}

@section('scripts')
    <script src="{!! asset('/vendor/summernote/summernote.js') !!}"></script>
    <script src="{!! asset('/vendor/summernote/lang/summernote-ru-RU.js') !!}"></script>
    <script src="{{ asset('/vendor/bootstrap-tagsinput/bootstrap-tagsinput.min.js') }}"></script>
    <link href="{{ asset('/vendor/summernote/summernote.css') }}" rel="stylesheet">
    <link href="{{ asset('/vendor/bootstrap-tagsinput/bootstrap-tagsinput.min.css') }}" rel="stylesheet">
    <link href="{{ asset('/css/custom-add-fields.css') }}" rel="stylesheet">
@stop