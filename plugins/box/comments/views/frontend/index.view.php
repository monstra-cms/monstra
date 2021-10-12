<div class="row">
<div class="col-md-12">
<h2><?php echo __('Comments', 'comments'); ?></h2>
</div>
</div>
<div class="row">
<div class="col-md-12">
<?php if(Notification::get('success')) Alert::success(Notification::get('success')); ?>
</div>
</div>



<div class="row">
<div class="col-md-7">
<?php foreach($records as $record) { ?>
 <div class="panel panel-default">
  <div class="panel-heading"><?php echo Html::toText($record['username']); ?> </div>
  <div class="panel-body"><?php echo Html::toText($record['message']); ?></div>
  <div class="panel-footer" style="text-align: right"><?php echo Date::format($record['date']); ?></div>
</div>

<?php } ?>



</div>

