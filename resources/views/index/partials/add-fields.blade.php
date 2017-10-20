{{ csrf_field() }}
<div class="form-group">
    <label for="name">Заголовок</label>
    {{ Form::text('title',isset($idea) ? $idea->title : '', ['class'=>'form-control']) }}
</div>
<div class="form-group">
    <label for="email">Описание</label>
    {{ Form::textarea('description', isset($idea) ? $idea->description : '', ['class'=>'form-control', 'id' => 'description']) }}
</div>
<div class="form-group">
    <label for="department">Основная компетенция</label>
    {{ Form::select('core_competency_id[]', $coreCompetenciesList, isset($idea) ? $idea->coreCompetencies : '', ['class'=>'form-control', 'multiple' => true]) }}
</div>
<div class="form-group">
    <label for="department">Операционная цель</label>
    {{ Form::select('operational_goal_id[]', $operationalGoalsList, isset($idea) ? $idea->operationalGoals : '', ['class'=>'form-control', 'multiple' => true]) }}
</div>
<div class="form-group">
    <label for="department">Стратегическая задача</label>
    {{ Form::select('strategic_objective_id[]', $strategicObjectivesList, isset($idea) ? $idea->strategicObjectives : '', ['class'=>'form-control', 'multiple' => true]) }}
</div>
<div class="form-group">
    <label for="department">Отдел</label>
    {{ Form::select('department_id[]', $departmentsList, isset($idea) ? $idea->departments : '', ['class'=>'form-control', 'multiple' => true]) }}
</div>
<div class="form-group">
    <label for="department">Тип</label>
    {{ Form::select('type_id', $typesList, isset($idea) ? $idea->type->id : '', ['class'=>'form-control']) }}
</div>

@section('scripts')
    <script src="{!! asset('/vendor/summernote/summernote.js') !!}"></script>
    <script src="{!! asset('/vendor/summernote/lang/summernote-ru-RU.js') !!}"></script>
    <link href="{{ asset('/vendor/summernote/summernote.css') }}" rel="stylesheet">
@stop

@section('inline-scripts')
    <script type="text/javascript">
        $(document).ready(function() {
            $('#description').summernote({
                height:300,
                lang: 'ru-RU',
                toolbar: [
                    ['style', ['style']],
                    ['font', ['bold', 'underline', 'clear']],
                    ['color', ['color']],
                    ['para', ['ul', 'ol', 'paragraph']],
                    ['table', ['table']],
                    ['insert', ['link']]
                ]
            });
        });
    </script>
@stop