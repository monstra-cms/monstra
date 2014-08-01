<table>
    <tr>
        <td></td>
    </tr>
    <?php foreach ($users as $user) { ?>
    <tr>
        <td>
            <a href="<?php echo Site::url(); ?>/users/<?php echo $user['id']; ?>"><?php echo $user['login']; ?></a>
        </td>
    </tr>
    <?php } ?>
</table>