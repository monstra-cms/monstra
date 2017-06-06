<div class="vertical-align margin-bottom-1">
    <div class="text-left row-phone">
        <h2><?php echo __('Pages', 'pages'); ?></h2>
    </div>
    <div class="text-right row-phone">
        <?php
            echo (
                Html::anchor(__('Create New Page', 'pages'), 'index.php?id=pages&action=add_page', array('title' => __('Create New Page', 'pages'), 'class' => 'btn btn-phone btn-primary')). Html::nbsp(3).
                Html::anchor(__('Edit 404 Page', 'pages'), 'index.php?id=pages&action=edit_page&name=error404', array('title' => __('Create New Page', 'pages'), 'class' => 'btn btn-phone btn-default'))
            );
        ?>
    </div>
</div>

<div class="table-responsive">
<table class="table table-bordered">
    <thead>
        <tr>
            <th width="3%"></th>
            <th><?php echo __('Name', 'pages'); ?></th>
            <th class="visible-lg hidden-xs"><?php echo __('Author', 'pages'); ?></th>
            <th class="visible-lg hidden-xs"><?php echo __('Status', 'pages'); ?></th>
            <th class="visible-lg"><?php echo __('Access', 'pages'); ?></th>
            <th class="visible-lg hidden-xs"><?php echo __('Date', 'pages'); ?></th>
            <th></th>
        </tr>
    </thead>
    <tbody>
    <?php
        if (count($pages) != 0) {
                foreach ($pages as $page) {
                    if ($page['parent'] != '') { $dash = Html::arrow('right').'&nbsp;&nbsp;'; } else { $dash = ""; }
     ?>
     <?php if ($page['slug'] != 'error404') { ?>
     <?php
        $expand = PagesAdmin::$pages->select('[slug="'.(string) $page['parent'].'"]', null);
        if ($page['parent'] !== '' && isset($expand['expand']) && $expand['expand'] == '1') { $visibility = 'style="display:none;"'; } else { $visibility = ''; }
     ?>
     <tr <?php echo $visibility; ?> <?php if (trim($page['parent']) !== '') {?> rel="children_<?php echo $page['parent']; ?>" <?php } ?>>
        <td>
        <?php
            if (count(PagesAdmin::$pages->select('[parent="'.(string) $page['slug'].'"]', 'all')) > 0) {
                if (isset($page['expand']) && $page['expand'] == '1') {
                    echo '<a href="javascript:;" class="btn-expand parent" token="'.Security::token().'" rel="'.$page['slug'].'">+</a>';
                } else {
                    echo '<a href="javascript:;" class="btn-expand parent" token="'.Security::token().'" rel="'.$page['slug'].'">-</a>';
                }
            }
        ?>
        </td>
        <td>
            <?php
                $_parent = (trim($page['parent']) == '') ? '' : $page['parent'];
                $parent  = (trim($page['parent']) == '') ? '' : $page['parent'].'/';
                echo (trim($page['parent']) == '') ? '' : '&nbsp;';
                echo $dash.Html::anchor(Html::toText($page['title']), $site_url.'/'.$parent.$page['slug'], array('target' => '_blank', 'rel' => 'children_'.$_parent));
            ?>
        </td>
        <td class="visible-lg hidden-xs">
            <?php echo $page['author']; ?>
        </td>
        <td class="visible-lg hidden-xs">
            <?php echo $page['status']; ?>
        </td>
        <td class="visible-lg">
            <?php echo $page['access']; ?>
        </td>
        <td class="visible-lg hidden-xs">
            <?php echo Date::format($page['date'], "j.n.Y"); ?>
        </td>
        <td>
            <div class="pull-right">
                <div class="btn-group">
                  <?php echo Html::anchor(__('Edit', 'pages'), 'index.php?id=pages&action=edit_page&name='.$page['slug'], array('class' => 'btn btn-primary')); ?>
                  <button type="button" class="btn btn-primary dropdown-toggle" data-toggle="dropdown">
                    <span class="caret"></span>
                    <span class="sr-only">Toggle Dropdown</span>
                  </button>
                  <ul class="dropdown-menu" role="menu">
                        <?php if ($page['parent'] == '') { ?>
                            <li><a href="index.php?id=pages&action=add_page&parent_page=<?php echo $page['slug']; ?>" title="<?php echo __('Create New Page', 'pages'); ?>"><?php echo __('Add', 'pages'); ?></a></li>
                        <?php } ?>
                        <li><?php echo Html::anchor(__('Clone', 'pages'), 'index.php?id=pages&action=clone_page&name='.$page['slug'].'&token='.Security::token(), array('title' => __('Clone', 'pages'))); ?></li>
                        <li class="divider"></li>
                        <li class="dropdown-header"><?php echo __('Status', 'pages'); ?></li>
                        <li><a href="index.php?id=pages&action=update_status&slug=<?php echo $page['slug']; ?>&status=published&token=<?php echo Security::token(); ?>"><?php echo __('Published', 'pages'); ?> <?php if ($page['_status'] == 'published') { ?><i class="glyphicon glyphicon-ok"></i><?php } ?></a></li>
                        <li><a href="index.php?id=pages&action=update_status&slug=<?php echo $page['slug']; ?>&status=draft&token=<?php echo Security::token(); ?>"><?php echo __('Draft', 'pages'); ?> <?php if ($page['_status'] == 'draft') { ?><i class="glyphicon glyphicon-ok"></i><?php } ?></a></li>
                        <li class="dropdown-header"><?php echo __('Access', 'pages'); ?></li>
                        <li><a href="index.php?id=pages&action=update_access&slug=<?php echo $page['slug']; ?>&access=public&token=<?php echo Security::token(); ?>"><?php echo __('Public', 'pages'); ?> <?php if ($page['_access'] == 'public') { ?><i class="glyphicon glyphicon-ok"></i><?php } ?></a></li>
                        <li><a href="index.php?id=pages&action=update_access&slug=<?php echo $page['slug']; ?>&access=registered&token=<?php echo Security::token(); ?>"><?php echo __('Registered', 'pages'); ?> <?php if ($page['_access'] == 'registered') { ?><i class="glyphicon glyphicon-ok"></i><?php } ?></a></li>
                  </ul>
                </div>

                <?php echo Html::anchor(__('Delete', 'pages'),
                           'index.php?id=pages&action=delete_page&name='.$page['slug'].'&token='.Security::token(),
                           array('class' => 'btn btn-danger btn-actions btn-actions-default', 'onclick' => "return confirmDelete('".__("Delete page: :page", 'pages', array(':page' => Html::toText($page['title'])))."')"));
                ?>
            </div>
        </td>
     </tr>

     <?php } ?>
    <?php
            }
        }
    ?>
    </tbody>
</table>
</div>

<form>
    <input type="hidden" name="url" value="<?php echo Option::get('siteurl'); ?>/admin/index.php?id=pages">
</form>
