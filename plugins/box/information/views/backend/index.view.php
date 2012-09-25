<h2><?php echo __('Information', 'information'); ?></h2>
<br />

<div class="tabbable">
    <ul class="nav nav-tabs">
        <li class="active"><a href="#system" data-toggle="tab"><?php echo __('System', 'information'); ?></a></li>
        <li><a href="#server" data-toggle="tab"><?php echo __('Server', 'information'); ?></a></li>                
        <li><a href="#security" data-toggle="tab"><?php echo __('Security', 'information'); ?></a></li>        
    </ul>

    <div class="tab-content">
        
        <div class="tab-pane active" id="system">

            <table class="table table-bordered">
                <thead>
                    <tr>
                        <td><?php echo __('Name', 'information'); ?></td>
                        <td><?php echo __('Value', 'information'); ?></td>
                    </tr>
                </thead>
                <tbody>
                    <tr>        
                        <td><?php echo __('System version', 'information'); ?></td>
                        <td><?php echo MONSTRA_VERSION; ?></td>
                    </tr>
                    <tr>        
                        <td><?php echo __('System version ID', 'information'); ?></td>
                        <td><?php echo MONSTRA_VERSION_ID; ?></td>
                    </tr>
                    <tr>        
                        <td><?php echo __('GZIP', 'information'); ?></td>
                        <td><?php if (MONSTRA_GZIP) { echo __('on', 'information'); } else { echo __('off', 'information'); } ?></td>
                    </tr>
                    <tr>        
                        <td><?php echo __('Debuging', 'information'); ?></td>
                        <td><?php if (Core::$environment == Core::DEVELOPMENT) { echo __('on', 'information'); } else { echo __('off', 'information'); } ?></td>
                    </tr>
                </tbody>
            </table>

        </div>

        <div class="tab-pane" id="server">

            <table class="table table-bordered">
                <thead>
                    <tr>
                        <td><?php echo __('Name', 'information'); ?></td>
                        <td><?php echo __('Value', 'information'); ?></td>
                    </tr>
                </thead>
                <tbody>
                    <tr>        
                        <td><?php echo __('PHP version', 'information'); ?></td>
                        <td><?php echo PHP_VERSION; ?></td>
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
        
        <div class="tab-pane" id="security">

            <?php clearstatcache(); ?>
            <table class="table table-bordered">
                <thead>
                    <tr>
                        <td colspan="2"><?php echo __('Security check results', 'information'); ?></td>
                    </tr>
                </thead>
                <tbody>
                    <?php if (File::writable(BOOT . DS . 'defines.php')) { ?>
                        <tr> 
                            <td><span class="badge badge-error" style="padding-left:5px; padding-right:5px;"><b>!</b></span> </td>         
                            <td><?php echo __('The configuration file has been found to be writable. We would advise you to remove all write permissions on defines.php on production systems.', 'information'); ?></td>
                        </tr>
                    <?php } ?>
                    <?php if (File::writable(MONSTRA . DS)) { ?>
                        <tr>       
                            <td><span class="badge badge-error" style="padding-left:5px; padding-right:5px;"><b>!</b></span> </td>            
                            <td><?php echo __('The Monstra core directory (":path") and/or files underneath it has been found to be writable. We would advise you to remove all write permissions. <br/>You can do this on unix systems with: <code>chmod -R a-w :path</code>', 'information', array(':path' => MONSTRA . DS)); ?></td>
                        </tr>
                    <?php } ?>
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
                    <?php if (Core::$environment == Core::DEVELOPMENT) { ?>
                        <tr>
                            <td><span class="badge badge-warning" style="padding-left:5px; padding-right:5px;"><b>!</b></span> </td>               
                            <td><?php echo __('Due to the type and amount of information an error might give intruders when Core::$environment = Core::DEVELOPMENT, we strongly advise setting Core::PRODUCTION in production systems.', 'information'); ?></td>
                        </tr>
                    <?php } ?>
                </tbody>
            </table>
        
        </div>

     </div>
</div>