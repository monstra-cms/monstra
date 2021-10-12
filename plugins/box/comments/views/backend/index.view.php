<h2><?php echo __('Comments', 'comments'); ?></h2>
<br />
<!-- Records_list -->
<div class="row">
<div class="col-md-11">
<form method="GET">
    <div class="form-group">
    <?php echo Form::hidden('id', "comments"); ?>
        <select class="form-control" onchange="this.form.submit()" name="page">
        <option value=''> Tous</option>
        <?php 
            foreach($pages as $page){
            echo "<option value='".$page["slug"]."' ".($current["slug"] == $page["slug"] ? "selected" : "" ).">".$page["title"]."</option>";
        }?>
        </select>
    </div>
</form>
</div>
<div class="col-md-1">

<?php 
if($current["slug"] != ""){
    if($current["no_comments"] != true){

    echo Html::anchor(__('Disable', 'comments'),
                      'index.php?id=comments&page='.$current['slug'].'&action=disable_comments&token='.Security::token(),
                       array('class' => 'btn btn-actions btn-danger'));
            
    }else{
    echo Html::anchor(__('Enable', 'comments'),
                      'index.php?id=comments&page='.$current['slug'].'&action=enable_comments&token='.Security::token(),
                       array('class' => 'btn btn-actions btn-success'));
            

    }
}
 ?>

</div></div>


<table class="table table-striped">
    <thead>
        <tr>
            <td><?php echo __('Page', 'comments'); ?></td>
            <td><?php echo __('Message', 'comments'); ?></td>
            <td><?php echo __('Username', 'comments'); ?></td>
            <td><?php echo __('Email', 'comments'); ?></td>
            <td><?php echo __('Date', 'comments'); ?></td>
            <td width="15%"><?php echo __('Actions', 'comments'); ?></td>
        </tr>
    </thead>
    <tbody>
    <?php if (count($records) > 0) foreach ($records as $record) { ?>
    <tr>
        <td><?php echo Html::toText($record['page']); ?></td>
        <td><?php echo Html::toText($record['message']); ?></td>
        <td><?php echo Html::toText($record['username']); ?></td>
        <td><?php echo Html::toText($record['email']); ?></td>
        <td><?php echo Date::format($record['date']); ?></td>
        <td>
            <?php echo Html::anchor(__('Delete', 'comments'),
                      'index.php?id=comments&page='.$current['slug'].'&action=delete_record&record_id='.$record['id'].'&token='.Security::token(),
                       array('class' => 'btn btn-actions', 'onclick' => "return confirmDelete('".__('Delete record', 'comments')."')"));
            ?>
        </td>
    </tr>
    <?php } ?>
    </tbody>
</table>
<!-- /Records_list -->