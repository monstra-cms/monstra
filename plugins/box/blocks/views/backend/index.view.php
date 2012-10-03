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
        <tr><td><?php echo __('Blocks', 'blocks'); ?></td><td width="30%"><?php echo __('Actions', 'blocks'); ?></td></tr>
    </thead>
    <tbody>
    <?php if (count($blocks_list) != 0) foreach ($blocks_list as $block) { ?>
    <tr>
        <td><?php echo basename($block, '.block.html'); ?></td>        
        <td>            
            <?php echo Html::anchor(__('Edit', 'blocks'), 'index.php?id=blocks&action=edit_block&filename='.basename($block, '.block.html'), array('class' => 'btn btn-actions')); ?>
            <?php echo Html::anchor(__('Delete', 'blocks'),
                      'index.php?id=blocks&action=delete_block&filename='.basename($block, '.block.html').'&token='.Security::token(),
                       array('class' => 'btn btn-actions', 'onclick' => "return confirmDelete('".__('Delete block: :block', 'blocks', array(':block' => basename($block, '.block.html')))."')"));
            ?>
        </td>
    </tr>
    <?php } ?>
    </tbody>
</table>
<!-- /Blocks_list -->