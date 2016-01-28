# Monstra
Monstra is a modern and lightweight Content Management System.   

[![Join the chat at https://gitter.im/monstra-cms/monstra](https://badges.gitter.im/Join%20Chat.svg)](https://gitter.im/monstra-cms/monstra?utm_source=badge&utm_medium=badge&utm_campaign=pr-badge&utm_content=badge)

## System Requirements
Operation system: Unix, Linux, Windows, Mac OS   
Middleware: PHP 5.3.2 or higher with PHP's [SimpleXML module](http://php.net/simplexml) and [Multibyte String module](http://php.net/mbstring)   
Webserver: Apache with [Mod Rewrite](http://httpd.apache.org/docs/current/mod/mod_rewrite.html) or Ngnix with [Rewrite Module](http://wiki.nginx.org/HttpRewriteModule)   

## Steps to Install
1. [Download the latest version.](http://monstra.org/download)
2. Unzip the contents to a new folder on your local computer.
3. Upload that whole folder with an FTP client to your host.
4. You may also need to recursively CHMOD the folder /storage/, /tmp/, /backups/ and /public/ to 755(or 777) if your host doesn't set it implicitly.
5. Also you may also need to recursively CHMOD the /install.php, /.htaccess and /sitemap.xml to 755(or 777) if your host doesn't set it implicitly.
6. Type http://example.org/install.php in the browser.

## Contributing
1. Help on the [Forum.](http://forum.monstra.org)
2. Donate to keep Monstra free. We will add you to Monstra [Sponsors Page.](http://monstra.org/contribute/sponsors)
3. Develop a new plugin.
4. Create a new theme.
5. Find and [report issues.](https://github.com/monstra-cms/monstra/issues)
6. Link back to [Monstra](http://monstra.org).

## Links
- [Site](http://monstra.org)
- [Forum](http://forum.monstra.org)
- [Documentation](http://monstra.org/documentation)
- [Github Repository](https://github.com/monstra-cms/monstra)

## License
See [LICENSE](https://github.com/monstra-cms/monstra/blob/master/LICENSE.md)
