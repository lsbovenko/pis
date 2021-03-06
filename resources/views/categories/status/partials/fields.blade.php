{{ csrf_field() }}
<div class="form-group">
    <label for="name">{{ trans('ideas.name') }}</label>
    {{ Form::text('name', isset($item) ? $item->name : '', ['class'=>'form-control']) }}
</div>
<div class="form-group">
    <label class="inbtn">
        <input name="is_active" type="hidden" value="0">
        {{ Form::checkbox('is_active', true, isset($item) ? $item->is_active : false) }}
        <span class="inbtn__indicator"></span>
        &nbsp; {{ trans('ideas.is_active') }}?
    </label>
</div>