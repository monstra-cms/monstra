<h2><?php echo __('Information', 'information'); ?></h2>
<br>

<div class="tabbable">
    <ul class="nav nav-tabs">
        <li class="active"><a href="#system" data-toggle="tab"><?php echo __('System', 'information'); ?></a></li>
        <li><a href="#server" data-toggle="tab"><?php echo __('Server', 'information'); ?></a></li>
        <li><a href="#directory-permissions" data-toggle="tab"><?php echo __('Directory Permissions', 'information'); ?></a></li>
        <li><a href="#security" data-toggle="tab"><?php echo __('Security', 'information'); ?></a></li>
    </ul>

    <div class="tab-content">

        <div class="tab-pane active" id="system">

            <table class="table table-bordered">
                <thead>
                    <tr>
                        <th><?php echo __('Name', 'information'); ?></th>
                        <th><?php echo __('Value', 'information'); ?></th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td><?php echo __('Monstra version', 'information'); ?></td>
                        <td><?php echo Monstra::VERSION; ?></td>
                    </tr>
                    <tr>
                        <td><?php echo __('GZIP', 'information'); ?></td>
                        <td><?php if (MONSTRA_GZIP) { echo __('on', 'information'); } else { echo __('off', 'information'); } ?></td>
                    </tr>
                    <tr>
                        <td><?php echo __('Debugging', 'information'); ?></td>
                        <td><?php if (Monstra::$environment == Monstra::DEVELOPMENT) { echo __('on', 'information'); } else { echo __('off', 'information'); } ?></td>
                    </tr>
                </tbody>
            </table>

        </div>

        <div class="tab-pane" id="server">

            <table class="table table-bordered">
                <thead>
                    <tr>
                        <th><?php echo __('Name', 'information'); ?></th>
                        <th><?php echo __('Value', 'information'); ?></th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td><?php echo __('PHP version', 'information'); ?></td>
                        <td><?php echo PHP_VERSION; ?></td>
                    </tr>
                    <tr>
                        <td><?php echo __('PHP Built On', 'information'); ?></td>
                        <td><?php echo php_uname(); ?></td>
                    </tr>
                    <tr>
                        <td><?php echo __('Web Server', 'information'); ?></td>
                        <td><?php echo (isset($_SERVER['SERVER_SOFTWARE'])) ? $_SERVER['SERVER_SOFTWARE'] : @getenv('SERVER_SOFTWARE'); ?></td>
                    </tr>
                    <tr>
                        <td><?php echo __('WebServer to PHP Interface', 'information'); ?></td>
                        <td><?php echo php_sapi_name(); ?></td>
                    </tr>
                    <tr>
                        <td><?php echo __('SimpleXML module', 'information'); ?></td>
                        <td><?php if (in_array('SimpleXML', $php_modules)) { echo __('Installed', 'information'); } else { echo __('Not Installed', 'information'); } ?></td>
                    </tr>
                    <tr>
                        <td><?php echo __('DOM module', 'information'); ?></td>
                        <td><?php if (in_array('dom', $php_modules)) { echo __('Installed', 'information'); } else { echo __('Not Installed', 'information'); } ?></td>
                    </tr>
                    <?php

                        if (function_exists('apache_get_modules')) {
                            if ( ! in_array('mod_rewrite',apache_get_modules())) {
                                echo '<tr><td>'.__('Apache Mod Rewrite', 'information').'</td><td>'.__('Not Installed', 'information').'</td></tr>';
                            } else {
                                echo '<tr><td>'.__('Apache Mod Rewrite', 'information').'</td><td>'.__('Installed', 'information').'</td></tr>';
                            }
                        } else {
                            echo '<tr><td>'.__('Apache Mod Rewrite', 'information').'</td><td>'.__('Installed', 'information').'</td></tr>';
                        }

                    ?>
                </tbody>
            </table>

        </div>

        <div class="tab-pane" id="directory-permissions">

            <table class="table table-bordered">
                <thead>
                    <tr>
                        <th><?php echo __('Directory', 'information'); ?></th>
                        <th><?php echo __('Status', 'information'); ?></th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td><?php echo STORAGE ?></td>
                        <td><?php if (Dir::writable(STORAGE)) { ?><span class="badge badge-success"><?php echo __('Writable', 'information'); ?></span><?php } else { ?><span class="badge badge-error"><?php echo __('Unwritable', 'information'); ?></span><?php } ?></td>
                    </tr>
                    <tr>
                        <td><?php echo ROOT . DS . 'tmp'; ?></td>
                        <td><?php if (Dir::writable(ROOT . DS . 'tmp')) { ?><span class="badge badge-success"><?php echo __('Writable', 'information'); ?></span><?php } else { ?><span class="badge badge-error"><?php echo __('Unwritable', 'information'); ?></span><?php } ?></td>
                    </tr>
                    <tr>
                        <td><?php echo ROOT . DS . 'backups' ?></td>
                        <td><?php if (Dir::writable(ROOT . DS . 'backups')) { ?><span class="badge badge-success"><?php echo __('Writable', 'information'); ?></span><?php } else { ?><span class="badge badge-error"><?php echo __('Unwritable', 'information'); ?></span><?php } ?></td>
                    </tr>
                    <tr>
                        <td><?php echo ROOT . DS . 'public' ?></td>
                        <td><?php if (Dir::writable(ROOT . DS . 'public')) { ?><span class="badge badge-success"><?php echo __('Writable', 'information'); ?></span><?php } else { ?><span class="badge badge-error"><?php echo __('Unwritable', 'information'); ?></span><?php } ?></td>
                    </tr>
                    <tr>
                        <td><?php echo PLUGINS ?></td>
                        <td><?php if (Dir::writable(PLUGINS)) { ?><span class="badge badge-success"><?php echo __('Writable', 'information'); ?></span><?php } else { ?><span class="badge badge-error"><?php echo __('Unwritable', 'information'); ?></span><?php } ?></td>
                    </tr>
                    <tr>
                        <td><?php echo ROOT . DS . 'admin' ?></td>
                        <td><?php if (Dir::writable(ROOT . DS . 'admin')) { ?><span class="badge badge-success"><?php echo __('Writable', 'information'); ?></span><?php } else { ?><span class="badge badge-error"><?php echo __('Unwritable', 'information'); ?></span><?php } ?></td>
                    </tr>
                </tbody>
            </table>

        </div>

        <div class="tab-pane" id="security">

            <?php clearstatcache(); ?>
            <table class="table table-bordered">
                <thead>
                    <tr>
                        <th colspan="2"><?php echo __('Security check results', 'information'); ?></th>
                    </tr>
                </thead>
                <tbody>
                    <?php if (File::writable(ROOT . DS . '.htaccess')) { ?>
                        <tr>
                            <td><span class="badge badge-error" style="padding-left:5px; padding-right:5px;"><b>!</b></span> </td>
                            <td><?php echo __('The Monstra .htaccess file has been found to be writable. We would advise you to remove all write permissions. <br/>You can do this on unix systems with: <code>chmod a-w :path</code>', 'information', array(':path' => ROOT . DS . '.htaccess')); ?></td>
                        </tr>
                    <?php } ?>
                    <?php if (File::writable(ROOT . DS . 'index.php')) { ?>
                        <tr>
                            <td><span class="badge badge-error" style="padding-left:5px; padding-right:5px;"><b>!</b></span> </td>
                            <td><?php echo __('The Monstra index.php file has been found to be writable. We would advise you to remove all write permissions. <br/>You can do this on unix systems with: <code>chmod a-w :path</code>', 'information', array(':path' => ROOT . DS . 'index.php')); ?></td>
                        </tr>
                    <?php } ?>
                    <?php if (Monstra::$environment == Monstra::DEVELOPMENT) { ?>
                        <tr>
                            <td><span class="badge badge-warning" style="padding-left:5px; padding-right:5px;"><b>!</b></span> </td>
                            <td><?php echo __('Due to the type and amount of information an error might give intruders when Monstra::$environment = Monstra::DEVELOPMENT, we strongly advise setting Monstra::PRODUCTION in production systems.', 'information'); ?></td>
                        </tr>
                    <?php } ?>
                </tbody>
            </table>

        </div>

     </div>
</div>
