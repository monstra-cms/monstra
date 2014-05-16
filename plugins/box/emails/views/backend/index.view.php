<div class="vertical-align margin-bottom-1">
    <div class="text-left row-phone">
        <h2><?php echo __('Emails', 'emails'); ?></h2>
    </div>    
    <div class="text-right row-phone">
        <?php
            echo (
                Html::anchor(__('Edit Layout', 'emails'), 'index.php?id=emails&action=edit_email_template&filename=layout', array('title' => __('Edit Layout', 'emails'), 'class' => 'btn btn-phone btn-primary'))
            );
        ?>
    </div>
</div>

<table class="table table-bordered">
    <thead>
        <tr>
            <th><?php echo __('Email templates', 'emails'); ?></th>
            <th></th>
        </tr>
    </thead>
    <tbody>
    <?php if (count($email_templates_list) != 0) foreach ($email_templates_list as $email_template) { ?>
        <?php if ($email_template != 'layout.email.php') { ?>
        <tr>
            <td><?php echo basename($email_template, '.email.php'); ?></td>
            <td>
                <div class="pull-right">            
                    <div class="btn-group">
                        <?php echo Html::anchor(__('Edit', 'emails'), 'index.php?id=emails&action=edit_email_template&filename='.basename($email_template, '.email.php'), array('class' => 'btn btn-primary')); ?>
                    </div>         
                </div>
            </td>
        </tr>
        <?php } ?>
    <?php } ?>
    </tbody>
</table>
