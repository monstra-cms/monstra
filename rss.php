<?php
define('DS', DIRECTORY_SEPARATOR);
define('ROOT', rtrim(dirname(__FILE__), '\\/'));
define('BACKEND', false);
define('MONSTRA_ACCESS', true);

// Load bootstrap file
require_once(ROOT . DS . 'engine' . DS . '_init.php');

// Get all posts for blog parent page/post
$posts = Pages::$pages->select('[parent="'.Blog::$parent_page_name.'" and status="published"]', 5, 0, array('slug', 'title', 'author', 'date'), 'date', 'DESC');

// Date now
$now = date("D, d M Y H:i:s T");
ob_end_clean();
?>
<?php header('Content-type: text/xml; charset="utf-8"'); ?>
<?php echo'<?xml version="1.0" encoding="utf-8"?>'."\n"; ?>
<rss version="2.0" xmlns:content="http://purl.org/rss/1.0/modules/content/" xmlns:wfw="http://wellformedweb.org/CommentAPI/" xmlns:dc="http://purl.org/dc/elements/1.1/" xmlns:atom="http://www.w3.org/2005/Atom">
<channel>
<title>MonstraCMS::BLOG::RSS</title>
<link><?php echo Option::get('siteurl'); ?>/blog</link>
<description>The latest updates for <?php echo Option::get('sitename'); ?>.</description>
<language>en-us</language>
<pubDate><?php echo $now; ?></pubDate>
<lastBuildDate><?php echo $now; ?></lastBuildDate>
<atom:link href="<?php echo Option::get('siteurl'); ?>/rss.php" rel="self" type="application/rss+xml" />
<generator>Monstra</generator>
<?php foreach ($posts as $post) { ?>
<item>
<title><?php echo $post['title']; ?></title>
<link><?php echo Option::get('siteurl').'/blog/'.$post['slug']; ?></link>
<guid><?php echo Option::get('siteurl').'/blog/'.$post['slug']; ?></guid>
<pubDate><?php echo Date::format($post['date'], 'd M Y'); ?></pubDate>
<description><![CDATA[<?php echo Text::toHtml(Text::cut(File::getContent(STORAGE . DS . 'pages' . DS . $post['id'] . '.page.txt'), 300)); ?>]]></description>
<author><?php echo $post['author']; ?></author>
</item>
<?php } ?>
</channel>
</rss>
