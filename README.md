# Monstra
[![Join the chat at https://gitter.im/Monstra/Monstra](https://badges.gitter.im/Join%20Chat.svg)](https://gitter.im/Monstra/Monstra?utm_source=badge&utm_medium=badge&utm_campaign=pr-badge&utm_content=badge)

Monstra is Modern Open Source Flat-File Content Management site.  
Content in Monstra is just a simple files written with markdown syntax in pages folder.   
You simply create markdown files in the pages folder and that becomes a page.

## Requirements
PHP 5.5.9 or higher with PHP's [Multibyte String module](http://php.net/mbstring)   
Apache with [Mod Rewrite](http://httpd.apache.org/docs/current/mod/mod_rewrite.html)  

## Installation

#### Using (S)FTP

[Download the latest version.](http://monstra.org/download)  

Unzip the contents to a new folder on your local computer, and upload to your webhost using the (S)FTP client of your choice. After you’ve done this, be sure to chmod the following directories (with containing files) to 777, so they are readable and writable by Monstra:  
* `cache/`
* `config/`
* `storage/`
* `themes/`
* `plugins/`

#### Using Composer

You can easily install Monstra with Composer.

```
composer create-project monstra-cms/monstra
```

## Contributing
1. Help on the [Forum.](http://forum.Monstra.org)
2. Develop a new plugin.
3. Create a new theme.
4. Find and [report issues.](https://github.com/Monstra/Monstra/issues)
5. Link back to [Monstra](http://monstra.org).

## Links
- [Site](http://monstra.org)
- [Forum](http://forum.Monstra.org)
- [Documentation](http://monstra.org/documentation)
- [Github Repository](https://github.com/Monstra/Monstra)

## License
See [LICENSE](https://github.com/Monstra/Monstra/blob/master/LICENSE.md)
