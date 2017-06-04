{{ csrf_field() }}
<div class="form-group">
    <label for="name">Заголовок</label>
    {{ Form::text('title',isset($idea) ? $idea->title : '', ['class'=>'form-control']) }}
</div>
<div class="form-group">
    <label for="email">Описание</label>
    {{ Form::textarea('description', isset($idea) ? $idea->description : '', ['class'=>'form-control']) }}
</div>
<div class="form-group">
    <label for="department">Основная компетенция</label>
    {{ Form::select('core_competency_id', $coreCompetenciesList, isset($idea) ? $idea->coreCompetency->id : '', ['class'=>'form-control']) }}
</div>
<div class="form-group">
    <label for="department">Оперативная цель</label>
    {{ Form::select('operational_goal_id', $operationalGoalsList, isset($idea) ? $idea->operationalGoal->id : '', ['class'=>'form-control']) }}
</div>
<div class="form-group">
    <label for="department">Стратегическая цель</label>
    {{ Form::select('strategic_objective_id', $strategicObjectivesList, isset($idea) ? $idea->strategicObjective->id : '', ['class'=>'form-control']) }}
</div>
<div class="form-group">
    <label for="department">Отдел</label>
    {{ Form::select('department_id', $departmentsList, isset($idea) ? $idea->department->id : '', ['class'=>'form-control']) }}

</div>
<div class="form-group">
    <label for="department">Тип</label>
    {{ Form::select('type_id', $typesList, isset($idea) ? $idea->type->id : '', ['class'=>'form-control']) }}
</div>