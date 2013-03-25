<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="utf-8">
<title>Error</title>
<style type="text/css">
#gelato-error {
    background:#eee;
    color:0;
    width:95%;
    font-size:14px;
    font-family:Verdana, Arial, Helvetica, "Nimbus Sans", FreeSans, Malayalam, sans-serif;
    margin:20px auto;

    -webkit-box-shadow: 1px 1px 18px rgba(50, 50, 50, 0.75);
    -moz-box-shadow:    1px 1px 18px rgba(50, 50, 50, 0.75);
    box-shadow:         1px 1px 18px rgba(50, 50, 50, 0.75);

    -webkit-border-radius: 5px;
    -moz-border-radius: 5px;
    border-radius: 5px;


}

#gelato-error pre {
    font-family:"Andale Mono", "Courier New", Courier;
    font-size:12px;
    margin:0;
    padding:0;
}

#gelato-error a {
    color:#cc0a0a;
    text-decoration:none;
}

#gelato-error .error {
    background:#cc0a0a;
    color:#fff;
    font-size:24px;
    font-weight:700;
    padding:10px;

    -moz-border-radius-topleft: 5px;
    -webkit-border-top-left-radius: 5px;
     border-top-left-radius: 5px;
    -moz-border-radius-topright: 5px;
    -webkit-border-top-right-radius: 5px;
    border-top-right-radius: 5px;
}

#gelato-error .body {
    border:0 solid #ccc;
    padding:10px;
}

#gelato-error .code {
    background:#fff;
    border:1px solid #ccc;
    overflow:auto;
}

#gelato-error .heading {
    background:#444;
    color:#fff;
    font-size:18px;
    font-weight:700;
    padding:10px;
}

#gelato-error .line {
    background:#777;
    color:#fff;
    padding-left:4px;
    padding-right:4px;
}

#gelato-error .highlighted {
    background:#fceb71;
    border-top:1px solid #ccc;
    border-bottom:1px solid #ccc;
}

#gelato-error .backtrace {
    background:#fff;
    margin-bottom:10px;
    border:1px solid #ccc;
    padding:10px;
}

#gelato-error .backtrace ol {
    padding-left:40px;
}

#gelato-error table {
    border-spacing:0;
    border-collapse:collapse;
    border-color:#ddd;
    border-style:solid;
    border-width:0 0 1px 1px;
}

#gelato-error td {
    font-size:14px;
    background:#fff;
    border-color:#ddd;
    border-style:solid;
    border-width:1px 1px 0 0;
    margin:0;
    padding:4px;
}

.pull-right {
    float:right;
}
</style>
<body>
<div id="gelato-error">

    <div class="error">
    <?php echo $error['type']; ?><?php if(isset($error['code'])): ?> <span style="color:#e1e1e1;padding:0px">[<?php echo $error['code']; ?>]</span><?php endif; ?>
    <span class="pull-right">Gelato</span>
    </div>
    <div class="body">
    <strong>Message:</strong> <?php echo htmlspecialchars($error['message'], ENT_COMPAT, 'UTF-8', false); ?>

    <?php if(!empty($error['file'])): ?>
    <br><br>
    <strong>Location:</strong> <?php echo $error['file']; ?> (line <?php echo $error['line']; ?>)
    <?php endif; ?>

    <?php if(!empty($error['highlighted'])): ?>
    <br><br>
    <div class="code">
    <?php foreach($error['highlighted'] as $line): ?>
    <pre<?php if($line['highlighted']): ?> class="highlighted"<?php endif; ?>><span class="line"><?php echo $line['number']; ?></span> <?php echo $line['code']; ?></pre>
    <?php endforeach; ?>
    </div>
    <?php endif; ?>
    </div>

    <?php if(!empty($error['backtrace'])): ?>
    <div class="heading">
    Backtrace <a href="#" onclick="return toggle('backtrace', this);" style="float:right">+</a>
    </div>
    <div class="body" style="display:none;" id="backtrace">
    <?php foreach($error['backtrace'] as $trace): ?>
    <div class="backtrace">
    <p><strong>Function:</strong> <?php echo $trace['function']; ?></p>
    <?php if(!empty($trace['arguments'])): $id =  md5(uniqid('', true)); ?>
    <p><strong>Arguments: [<a href="#" onclick="return toggle('<?php echo $id; ?>', this);">+</a>]</strong></p>
    <div style="display:none" id="<?php echo $id; ?>">
    <ol>
    <?php foreach($trace['arguments'] as $arg): ?>
    <li><pre><?php echo $arg; ?></pre></li>
    <?php endforeach; ?>
    </ol>
    </div>
    <?php endif; ?>
    <?php if(!empty($trace['location'])): $id = md5(uniqid('', true)); ?>
    <p><strong>Location:</strong> <?php echo $trace['location']['file']; ?> (<a href="#" onclick="return toggle('<?php echo $id; ?>');">line <?php echo $trace['location']['line']; ?></a>)</p>
    <div class="code" style="display:none" id="<?php echo $id; ?>">
    <?php foreach($trace['location']['code'] as $line): ?>
    <pre<?php if($line['highlighted']): ?> class="highlighted"<?php endif; ?>><span class="line"><?php echo $line['number']; ?></span> <?php echo $line['code']; ?></pre>
    <?php endforeach; ?>
    </div>
    <?php endif; ?>
    </div>
    <?php endforeach; ?>
    </div>
    <?php endif; ?>

    <div class="heading">
    Superglobals <a href="#" onclick="return toggle('superglobals', this);" style="float:right">+</a>
    </div>
    <div class="body" style="display:none;" id="superglobals">

    <?php if(!empty($_SERVER)): ?>
    <p><b>$_SERVER [<a href="#" onclick="return toggle('_server', this);">+</a>]</b></p>
    <div id="_server" style="display:none">
    <table width="100%">
    <?php foreach($_SERVER as $k => $v): ?>
    <tr>
    <td width="15%"><?php echo htmlspecialchars($k); ?></td>
    <td width="85%"><pre><?php ob_start(); var_dump($v); echo htmlspecialchars(ob_get_clean()); ?></pre></td>
    </tr>
    <?php endforeach; ?>
    </table>
    </div>
    <?php endif; ?>

    <?php if(!empty($_GET)): ?>
    <p><b>$_GET [<a href="#" onclick="return toggle('_get', this);">+</a>]</b></p>
    <div id="_get" style="display:none">
    <table width="100%">
    <?php foreach($_GET as $k => $v): ?>
    <tr>
    <td width="15%"><?php echo htmlspecialchars($k); ?></td>
    <td width="85%"><pre><?php ob_start(); var_dump($v); echo htmlspecialchars(ob_get_clean()); ?></pre></td>
    </tr>
    <?php endforeach; ?>
    </table>
    </div>
    <?php endif; ?>

    <?php if(!empty($_POST)): ?>
    <p><b>$_POST [<a href="#" onclick="return toggle('_post', this);">+</a>]</b></p>
    <div id="_post" style="display:none">
    <table width="100%">
    <?php foreach($_POST as $k => $v): ?>
    <tr>
    <td width="15%"><?php echo htmlspecialchars($k); ?></td>
    <td width="85%"><pre><?php ob_start(); var_dump($v); echo htmlspecialchars(ob_get_clean()); ?></pre></td>
    </tr>
    <?php endforeach; ?>
    </table>
    </div>
    <?php endif; ?>

    <?php if(!empty($_FILES)): ?>
    <p><b>$_FILES [<a href="#" onclick="return toggle('_files', this);">+</a>]</b></p>
    <div id="_files" style="display:none">
    <table width="100%">
    <?php foreach($_FILES as $k => $v): ?>
    <tr>
    <td width="15%"><?php echo htmlspecialchars($k); ?></td>
    <td width="85%"><pre><?php ob_start(); var_dump($v); echo htmlspecialchars(ob_get_clean()); ?></pre></td>
    </tr>
    <?php endforeach; ?>
    </table>
    </div>
    <?php endif; ?>

    <?php if(!empty($_COOKIE)): ?>
    <p><b>$_COOKIE [<a href="#" onclick="return toggle('_cookie', this);">+</a>]</b></p>
    <div id="_cookie" style="display:none">
    <table width="100%">
    <?php foreach($_COOKIE as $k => $v): ?>
    <tr>
    <td width="15%"><?php echo htmlspecialchars($k); ?></td>
    <td width="85%"><?php ob_start(); var_dump($v); echo htmlspecialchars(ob_get_clean()); ?></td>
    </tr>
    <?php endforeach; ?>
    </table>
    </div>
    <?php endif; ?>

    <?php if(!empty($_SESSION)): ?>
    <p><b>$_SESSION [<a href="#" onclick="return toggle('_session', this);">+</a>]</b></p>
    <div id="_session" style="display:none">
    <table width="100%">
    <?php foreach($_SESSION as $k => $v): ?>
    <tr>
    <td width="15%"><?php echo htmlspecialchars($k); ?></td>
    <td width="85%"><pre><?php ob_start(); var_dump($v); echo htmlspecialchars(ob_get_clean()); ?></pre></td>
    </tr>
    <?php endforeach; ?>
    </table>
    </div>
    <?php endif; ?>

    <?php if(!empty($_ENV)): ?>
    <p><b>$_ENV [<a href="#" onclick="return toggle('_env', this);">+</a>]</b></p>
    <div id="_env" style="display:none">
    <table width="100%">
    <?php foreach($_ENV as $k => $v): ?>
    <tr>
    <td width="15%"><?php echo htmlspecialchars($k); ?></td>
    <td width="85%"><pre><?php ob_start(); var_dump($v); echo htmlspecialchars(ob_get_clean()); ?></pre></td>
    </tr>
    <?php endforeach; ?>
    </table>
    </div>
    <?php endif; ?>
    </div>

    <div class="heading">
    Included Files <a href="#" onclick="return toggle('files', this);" style="float:right">+</a>
    </div>
    <div class="body" style="display:none;" id="files">
    <table width="100%">
    <?php foreach(get_included_files() as $k => $v): ?>
    <tr>
    <td width="5%"><?php echo $k + 1; ?></td>
    <td width="95%"><?php echo $v; ?></td>
    </tr>
    <?php endforeach; ?>
    </table>
    </div>
    <div style="padding-top:20px;padding-bottom:20px; padding-left:10px;"><a href="http://gelato.monstra.org">Gelato Library</a></div>
</div>

<script type="text/javascript">
function toggle(id, link)
{
    var div = document.getElementById(id);

    if (div.style.display == "none") {
        if (link != null) {
            link.innerHTML    = '-';
        }
        div.style.display = "block";
    } else {
        if (link != null) {
            link.innerHTML    = '+';
        }
        div.style.display = "none";
    }

    return false;
}
</script>
</body>
</html>
