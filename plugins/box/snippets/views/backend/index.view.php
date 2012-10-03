<h2><?php echo __('Snippets', 'snippets'); ?></h2>
<br />

<?php if(Notification::get('success')) Alert::success(Notification::get('success')); ?>

<?php
    echo ( 
            Html::anchor(__('Create new snippet', 'snippets'), 'index.php?id=snippets&action=add_snippet', array('title' => __('Create new snippet', 'snippets'), 'class' => 'btn default btn-small')). Html::nbsp(3)
        ); 
?>

<br /><br />

<!-- Snippets_list -->
<table class="table table-bordered">
    <thead>
        <tr><td><?php echo __('Snippets', 'snippets'); ?></td><td width="30%"><?php echo __('Actions', 'snippets'); ?></td></tr>
    </thead>
    <tbody>
    <?php if (count($snippets_list) != 0) foreach ($snippets_list as $snippet) { ?>
    <tr>
        <td><?php echo basename($snippet, '.snippet.php'); ?></td>        
        <td>            
            <?php echo Html::anchor(__('Edit', 'snippets'), 'index.php?id=snippets&action=edit_snippet&filename='.basename($snippet, '.snippet.php'), array('class' => 'btn btn-actions')); ?>
            <?php echo Html::anchor(__('Delete', 'snippets'),
                      'index.php?id=snippets&action=delete_snippet&filename='.basename($snippet, '.snippet.php').'&token='.Security::token(),
                       array('class' => 'btn btn-actions', 'onclick' => "return confirmDelete('".__('Delete snippet: :snippet', 'snippets', array(':snippet' => basename($snippet, '.snippet.php')))."')"));
            ?>
        </td>
    </tr>
    <?php } ?>
    </tbody>
</table>
<!-- /Snippets_list -->