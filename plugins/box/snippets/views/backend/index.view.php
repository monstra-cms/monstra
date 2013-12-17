<div>
    <div class="pull-left">
        <h2><?php echo __('Snippets', 'snippets'); ?></h2>
    </div>
    <div class="pull-right">
        <br>
        <?php
            echo (
                    Html::anchor(__('Create New Snippet', 'snippets'), 'index.php?id=snippets&action=add_snippet', array('title' => __('Create New Snippet', 'snippets'), 'class' => 'btn btn-primary')). Html::nbsp(3)
                );
        ?>
    </div>
    <div class="clearfix"></div>
</div>

<br>

<?php if (Notification::get('success')) Alert::success(Notification::get('success')); ?>

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
                <div class="btn-group">
                    <?php echo Html::anchor(__('Edit', 'snippets'), 'index.php?id=snippets&action=edit_snippet&filename='.basename($snippet, '.snippet.php'), array('class' => 'btn btn-primary')); ?>
                    <button type="button" class="btn btn-primary dropdown-toggle" data-toggle="dropdown">
                        <span class="caret"></span>
                        <span class="sr-only">Toggle Dropdown</span>
                    </button>
                    <ul class="dropdown-menu" role="menu">
                        <li><?php echo Html::anchor(__('View Embed Code', 'snippets'), 'javascript:;', array('title' => __('View Embed Code', 'snippets'), 'onclick' => '$.monstra.snippets.showEmbedCodes("'.basename($snippet, '.snippet.php').'");')); ?></li>
                    </ul>
                </div>   
                <?php echo Html::anchor(__('Delete', 'snippets'),
                    'index.php?id=snippets&action=delete_snippet&filename='.basename($snippet, '.snippet.php').'&token='.Security::token(),
                    array('class' => 'btn btn-danger', 'onclick' => "return confirmDelete('".__('Delete snippet: :snippet', 'snippets', array(':snippet' => basename($snippet, '.snippet.php')))."')"));
                ?>
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
