<h2><?php echo __('Blocks', 'blocks'); ?></h2>
<br />

<?php if(Notification::get('success')) Alert::success(Notification::get('success')); ?>

<?php
    echo ( 
            Html::anchor(__('Create new block', 'blocks'), 'index.php?id=blocks&action=add_block', array('title' => __('Create new block', 'blocks'), 'class' => 'btn default btn-small')). Html::nbsp(3)
        ); 
?>

<br /><br />

<!-- Blocks_list -->
<table class="table table-bordered">
    <thead>
        <tr>
            <td><?php echo __('Blocks', 'blocks'); ?></td>
            <td width="40%"><?php echo __('Actions', 'blocks'); ?></td>
        </tr>
    </thead>
    <tbody>
    <?php if (count($blocks_list) != 0) foreach ($blocks_list as $block) { ?>
    <tr>
        <td><?php echo basename($block, '.block.html'); ?></td>
        <td>
            <div class="btn-toolbar">
                <div class="btn-group">
                    <?php echo Html::anchor(__('Edit', 'blocks'), 'index.php?id=blocks&action=edit_block&filename='.basename($block, '.block.html'), array('class' => 'btn btn-actions')); ?>
                    <a class="btn dropdown-toggle btn-actions" data-toggle="dropdown" href="#" style="font-family:arial;"><span class="caret"></span></a>
                    <ul class="dropdown-menu">
                        <li><?php echo Html::anchor(__('View Embed Code', 'blocks'), 'javascript:;', array('title' => __('View Embed Code', 'blocks'), 'onclick' => '$.monstra.blocks.embedCodes("'.basename($block, '.block.html').'");')); ?></li>
                    </ul>    
                    <?php echo Html::anchor(__('Delete', 'blocks'),
                              'index.php?id=blocks&action=delete_block&filename='.basename($block, '.block.html').'&token='.Security::token(),
                               array('class' => 'btn btn-actions', 'onclick' => "return confirmDelete('".__('Delete block: :block', 'blocks', array(':block' => basename($block, '.block.html')))."')"));
                    ?>
                </div>
            </div>
        </td>
    </tr>
    <?php } ?>
    </tbody>
</table>
<!-- /Blocks_list -->

<div id="embedCodes" class="modal hide fade">
<div class="modal-header">
<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
<h3><?php echo __('Embed Code', 'blocks'); ?></h3>
</div>
<div class="modal-body">
<p>
    <b><?php echo __('Shortcode', 'blocks'); ?></b><br>
    <code id="shortcode"></code>
    <br> <br>
    <b><?php echo __('PHP Code', 'blocks'); ?></b><br>
    <code id="phpcode"></code>
</p>
</div>
</div>