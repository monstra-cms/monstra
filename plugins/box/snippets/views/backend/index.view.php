<h2><?php echo __('Snippets', 'snippets'); ?></h2>
<br />

<?php if (Notification::get('success')) Alert::success(Notification::get('success')); ?>

<?php
    echo (
            Html::anchor(__('Create New Snippet', 'snippets'), 'index.php?id=snippets&action=add_snippet', array('title' => __('Create New Snippet', 'snippets'), 'class' => 'btn btn-small')). Html::nbsp(3)
        );
?>

<br /><br />

<!-- Snippets_list -->
<table class="table table-bordered">
    <thead>
        <tr>
            <th><?php echo __('Snippets', 'snippets'); ?></th>
            <th></th>
        </tr>
    </thead>
    <tbody>
    <?php if (count($snippets_list) != 0) foreach ($snippets_list as $snippet) { ?>
    <tr>
        <td><?php echo basename($snippet, '.snippet.php'); ?></td>
        <td>
            <div class="pull-right">
            <div class="btn-toolbar">
                <div class="btn-group">
                    <?php echo Html::anchor(__('Edit', 'snippets'), 'index.php?id=snippets&action=edit_snippet&filename='.basename($snippet, '.snippet.php'), array('class' => 'btn btn-actions btn-small')); ?>
                    <a class="btn dropdown-toggle btn-actions btn-small" data-toggle="dropdown" href="#" style="font-family:arial;"><span class="caret"></span></a>
                    <ul class="dropdown-menu">
                        <li><?php echo Html::anchor(__('View Embed Code', 'snippets'), 'javascript:;', array('title' => __('View Embed Code', 'snippets'), 'onclick' => '$.monstra.snippets.showEmbedCodes("'.basename($snippet, '.snippet.php').'");')); ?></li>
                    </ul>
                    <?php echo Html::anchor(__('Delete', 'snippets'),
                              'index.php?id=snippets&action=delete_snippet&filename='.basename($snippet, '.snippet.php').'&token='.Security::token(),
                               array('class' => 'btn btn-actions btn-small btn-actions-default', 'onclick' => "return confirmDelete('".__('Delete snippet: :snippet', 'snippets', array(':snippet' => basename($snippet, '.snippet.php')))."')"));
                    ?>
                </div>
            </div>
            </div>
        </td>
    </tr>
    <?php } ?>
    </tbody>
</table>
<!-- /Snippets_list -->

<div id="embedCodes" class="modal hide fade">
<div class="modal-header">
<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
<h3><?php echo __('Embed Code', 'snippets'); ?></h3>
</div>
<div class="modal-body">
<p>
    <b><?php echo __('Shortcode', 'snippets'); ?></b><br>
    <code id="shortcode"></code>
    <br> <br>
    <b><?php echo __('PHP Code', 'snippets'); ?></b><br>
    <code id="phpcode"></code>
</p>
</div>
</div>
