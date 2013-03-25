<h2><?php echo __('Menu', 'menu'); ?></h2>
<br />

<?php if ($menu->count() == 0) { ?>
<h3><?php echo __('Category', 'menu'); ?>: <?php echo 'default'; ?></h3>
<br />
<?php
    echo (
            Html::anchor(__('Create New Item', 'menu'), 'index.php?id=menu&action=add', array('title' => __('Create New Item', 'menu'), 'class' => 'btn btn-small'))
        );
?>
<br /><br />
<?php } ?>

<?php

    foreach ($categories as $category) {

        $items = $menu->select('[category="'.$category.'"]', 'all', null, array('id', 'name', 'link', 'target', 'order', 'category'), 'order', 'ASC');

        $category_to_add = ($category == '') ? '' : '&category='.$category;

?>

<h3><?php echo __('Category', 'menu'); ?>: <?php echo ($category == '') ? 'default' : $category; ?></h3>
<br />
<?php
    echo (
            Html::anchor(__('Create New Item', 'menu'), 'index.php?id=menu&action=add'.$category_to_add , array('title' => __('Create New Item', 'menu'), 'class' => 'btn btn-small'))
        );
?>
<br /><br />

<table class="table table-bordered">
    <thead>
        <tr>
            <th><?php echo __('Name', 'menu'); ?></th>
            <th class="span2"><?php echo __('Order', 'menu'); ?></th>
            <th></th>
        </tr>
    </thead>
    <tbody>
        <?php foreach ($items as $item) { ?>
        <?php

            $item['link'] = Html::toText($item['link']);
            $item['name'] = Html::toText($item['name']);

            $pos = strpos($item['link'], 'http://');
            if ($pos === false) {
                $link = Option::get('siteurl').$item['link'];
            } else {
                $link = $item['link'];
            }
        ?>
        <tr>
            <td>
                <a target="_blank" href="<?php echo $link; ?>"><?php echo $item['name']; ?></a>
            </td>
            <td>
                <?php echo $item['order']; ?>
            </td>
            <td>
                <div class="pull-right">
                <?php echo Html::anchor(__('Edit', 'menu'), 'index.php?id=menu&action=edit&item_id='.$item['id'], array('class' => 'btn btn-small')); ?>
                <?php echo Html::anchor(__('Delete', 'menu'),
                           'index.php?id=menu&delete_item='.$item['id'],
                           array('class' => 'btn btn-small', 'onclick' => "return confirmDelete('".__('Delete item :name', 'menu', array(':name' => $item['name']))."')"));
                 ?>
             </div>
            </td>
        </tr>
        <?php } ?>
    </tbody>
</table>
<br />
<?php } ?>
