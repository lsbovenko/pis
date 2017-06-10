{{ csrf_field() }}
<div class="form-group">
    <label for="name">Имя</label>
    {{ Form::text('name',isset($item) ? $item->name : '', ['class'=>'form-control']) }}
</div>