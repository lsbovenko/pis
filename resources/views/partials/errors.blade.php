<?php foreach ($errors->all() as $message):?>
<div class="alert alert-danger alert-dismissible" role="alert">
    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
        <span aria-hidden="true">×</span></button>
    <?php echo $message?>
</div>
<?php endforeach?>