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
            'class'=>'btn form-control',
            'placeholder' => 'Выберите',
            'id' => 'idea_competency'
            ]) }}
        </div>
    </div>
    <div class="form-group">
        <label for="dropdownMenu2">Операционная Цель</label>
        <div class="dropdown customer-select">
            {{ Form::select('operational_goal_id[]', $operationalGoalsList, isset($idea) ? $idea->operationalGoals : '', [
            'class'=>'btn form-control',
            'placeholder' => 'Выберите',
            'id' => 'idea_goal'
            ]) }}
        </div>
    </div>
</div>
<div class="input-group-two">
    <div class="form-group">
        <label for="dropdownMenu3">Стратегическая Задача</label>
        <div class="dropdown customer-select">
            {{ Form::select('strategic_objective_id[]', $strategicObjectivesList, isset($idea) ? $idea->strategicObjectives : '', [
            'class'=>'btn form-control',
            'placeholder' => 'Выберите',
            'id' => 'idea_task'
            ]) }}
        </div>
    </div>
    <div class="form-group">
        <label for="dropdownMenu4">Отдел</label>
        <div class="dropdown customer-select">
            {{ Form::select('department_id[]', $departmentsList, isset($idea) ? $idea->departments : '', [
            'class'=>'btn form-control',
            'placeholder' => 'Выберите',
            'id' => 'idea_depart'
            ]) }}
        </div>
    </div>
</div>
<div class="input-group-two last">
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

@section('scripts')
    <script src="{!! asset('/vendor/summernote/summernote.js') !!}"></script>
    <script src="{!! asset('/vendor/summernote/lang/summernote-ru-RU.js') !!}"></script>
    <link href="{{ asset('/vendor/summernote/summernote.css') }}" rel="stylesheet">
@stop