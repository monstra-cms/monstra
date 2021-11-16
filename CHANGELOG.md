Monstra 3.0.4, 2018-07-21
------------------------
- Added Privacy policy page
- Fixed User Security by adding a check that compares POST id with SESSION
id for none admin edits
- Fixed ability to read robots.txt
- Stylesheet: Changed minified URIs to eliminate query strings
- FilesManager: added alphabetical order for files and directories
- Localization: Major Fixes for ES locale

Monstra 3.0.3, 2016-01-29
------------------------
- Improved Monstra Security
- Minimum PHP version for Monstra is 5.3.2
- Admin: Fixed 404 error when using certain server configurations
- Localization: Major Fixes for SR, KA-GE, and ES
- Install Script Fixes

Monstra 3.0.2, 2015-10-16
------------------------
- Added Monstra MIT LICENSE instead of GNU GENERAL PUBLIC LICENSE v3
- Code standards fixes.
- Localization: Major Fixes for ES and SR

Monstra 3.0.1, 2014-08-10
------------------------
- Minimum php is 5.3
- Themes Plugin: Imposible to create new CSS - fixed
- Themes Plugin: js and css counter does not recalculate - fixed
- Error in Monstra Notifications - fixed
- Updated plugins url from plugins.monstra.org to monstra.org/download/plugins

Monstra 3.0.0, 2014-08-01
------------------------
- Mobile Ready! Monstra fully responsive for mobile devices, tablets, and normal computer screens.
- Twitter Bootstrap updated to 3.1.1
- Idiorm updated to 1.4.1
- jQuery updated to 2.1.0
- Admin: New Modern User Interface
- Site: New default theme
- Layout fixes according to World Wide Web Consortium (W3C) Standards
- Prefetch DNS to reduce look up times
- Files Manager: added ability to create & rename directories.
- Files Manager: Maximum upload file size message - added.
- Files Manager: Bootstrap fileinput.js updated to 3.0.0
- Files Manager: File Info Popup
- Backup: Restore Site from Backup added
- Plugins Manager: Uploading new plugins via the admin panel added
- Plugins Manager: Read plugin help(README.MD) ability added.
- Responsive Chocolat Lightbox instead of TB Lightbox
- Blog Plugin as a part of Monstra CMS
- CodeMirror Plugin as a part of Monstra CMS
- Markdown Plugin as a part of Monstra CMS
- MarkItUp Color Pallete fixes
- Site Url without trailing slashes
- Admin Help Section - added.
- Pages Plugin: tags field added.
- Pages Plugin: Meta Title added.
- Sitemap Errors Fixes.
- Monstra automatically renames files - fixed
- Monstra Dashboard created and set as default Plugin for Admin Panel
- Ink Framework for Monstra Email Templates
- iCheck plugin for checkboxes added.
- Emails Manager Plugin added.
- HubSpot Messaging Library added for notifications
- Gelato: Unzip Functionality added.
- Gelato: Number Class new method convertToBytes() added.
- Gelato: ErroHandler styles updates
- Users Plugin getGravatarURL() improve
- Plugin API - Actions - Closure support added.
- Plugin API - Filters - Closure support added.
- Core: Better statuses notification (error,success,warning)
- Core: Store user_email in Session
- Core: Javascript may be broken if there is no break line - fixed
- Core: Added ability to avoid caching JS/CSS by the browser.
- Core: Monstra automatically rename files Issue - fixed
- Sandbox Plugin cleanup
- New Flags: Japanese(JA), Indonesian(ID), Chinese(ZH-CN), Turkish(TR) added.
- Localization: Japanese(JA), Indonesian(ID), Chinese(ZH-CN), Turkish(TR) translations added.
- Localization: Major Fixes

Monstra 2.3.1, 2013-12-25
------------------------
- Localization: Major Fixes
- Gelato: Image.php Major Fixes
- Sitemap: Errors #175 - fixes
- New favicon added #182 - by bernte
- Layouts: General Fixes - by bernte
- Installer: SERVER_PORT issue - fixed by KANekT
- Gelato: Number Class - updated bytes format (JEDEC & IEC 60027) by mbarzda
- Email Layout: footer fixes

Monstra 2.3.0, 2013-12-19
------------------------
- Update Twitter Bootstrap to 2.3.2
- Security: Added limits for login attempts #104
- Security: Obfuscate users email to prevent spam-bots from sniffing it.
- Core: Added ability to map Monstra Engine Directory.
- Core: Maintenance Mode Improvements
- Core: ORM::configure - driver options added
- Gelato: Image.php fix for PNG files
- Gelato: Number.php: Undefined offset fix
- XMLDB: error select for empty table fix
- Plugin API: Stylesheet.php updates - sourcecode misses a linebreak after minified css
- Files Manager: jasny bootstrap-fileupload - added #89
- Users Plugin: login page fixes
- Users Plugin: Deleting users - fixed by Oleg Gatseluk #158
- Pages Plugin: General method getPages() created #123
- Pages Plugin: page expand ajax bug #115 - fixed
- Pages Plugin: Improved available() method to show only published pages
- Pages Plugin: Bug with pages renaming - fixed
- Monstra Email Templates #164
- Localization: Major Fixes
- Localization: PL added
- Localization: NL added
- .htaccess SEO improvements

Monstra 2.2.1, 2013-04-06
------------------------
- Update Gelato to 1.0.3
- Error Handler turned off for Production environment
- Localization: Farsi(fa) translations fixes.
- Pages Manager: fix translates #107
- Missing Translation on Login Page - fixed #106
- Lithuanian flag and other languages fixes. Thanks to mbarzda

Monstra 2.2.0, 2013-03-25
------------------------
- Mobile Ready! Monstra fully responsive for mobile devices, tablets, and normal computer screens.
- Improved Monstra Architecture!
- New Stand-alone Monstra Library (Gelato) was created! Totally improved old classes and added new classes!
- Monstra Library with new useful classes - ClassLoader, ErrorHandler, Log, MinifyJS, MinifyCSS, MinifyHTML, Token, Registry.
- Adopted PSR-0 PSR-1 PSR-2
- Localization: Farsi(fa), Magyar(hu), Français(fr), Spanish(es), Serbian(sr-yu), Slovakian(sk) translations added. Thanks to Abdulhalim, Lez, Neri, Mapadesign, Hugomano and Nakome.
- Idiorm Updated to 1.3.0
- jQuery Updated to 1.9.1
- Twitter Bootstrap Updated to 2.3.0
- Default Theme: Social Meta Tags - added.
- Default Theme: Hook "theme_meta" - added.
- Admin Default Theme: Added missing meta tags.
- Improve Installer Usability. Flags Added.
- Default Site Email added.
- PHPMailer added.
- Pages Manager: added ability to quickly update page status and page access.
- Intstaller Layout: Added missing meta tags.
- Filesmanager plugin: added ability to view images.
- Filesmanager Plugin: forbidden types array - updated.
- CSRF detection text - updated.
- Engine Uri: code improvements.
- XMLDB: Table Class - fixed select method. Thanks to DmitriyMX
- Bootstrap CSS: Icons url - fixed.
- Plugins Manager: buttons confirm dialog message - fixed.
- Pages Manager: page cloning problem - fixed.
- Localizations: translations fixes.

Monstra 2.1.3, 2012-12-09
------------------------
- Pages Plugin: New shortcodes added - page_author, page_slug, page_url page_available, page_breadcrumbs, page_date, page_content.
- Pages Plugin: add ability to get content for specific page.
- XMLDB: New method factory() added.
- Twitter Bootstrap updated to Version 2.2.2
- Sitemap Plugin: `_blank` removed.
- Filesmanager Plugin: fixes.
- Backup Plugin: fixes.

Monstra 2.1.2, 2012-12-05
------------------------
- Blocks Plugin: added ability create and render inline content blocks with {block_inline} and {block_inline_create}
- Site Module: methods keywords() and description() fixes.
- Pages Plugin: pages.js fixes.
- Admin main index.php fixes.

Monstra 2.1.1, 2012-11-30
------------------------
- Plugins: Minify bug #71 - fixed.
- Menu Plugin: bug with categories #70 - fixed.
- Localization: IT translations - fixed.

Monstra 2.1.0, 2012-11-29
------------------------
- Localization: PT-BR, UK translations added.
- Default theme: hook "theme_header" added.
- System Plugin: new action "admin_system_extra_index_template_actions" added.
- Shortcodes API: new delete() clear() exists() methods added.
- Options API: new exists() method added.
- Core: new constant VERSION - added.
- Core: added ability to load: defines, actions, filters, shortcodes for current environment.
- Defines: deprecated constants: MONSTRA_GZIP_STYLES, MONSTRA_VERSION, MONSTRA_VERSION_ID, MONSTRA_SITEURL, MONSTRA_MOBILE deleted.
- Box Plugins: used Core::VERSION to compare Monstra CMS version.
- Installer: use version_compare() function to compare php versions.
- Installer: Get system timezone with date_default_timezone_get() function.
- Admin Default Theme: general improvements.
- Users Plugin: user profile editing fixed.
- Shortcodes API: bug with similar shortcode names fixed.
- Site: template() method improvements. Added ability to get template from specific theme.
- Menu Plugin: added ability to select children pages.
- Snippets Plugin: added ability to add parameters for snippets.
- Themes Plugin: added ability to add parameters for chunks.
- Pages Plugin: pages expand/collapse feature added.
- Pages Plugin: pages "access" feature added.
- Pages Plugin: tab "seo" changed to "metadata"
- Pages Table: "expand, "access" fields added.
- Information Plugin: new "Directory Permissions" tab added.
- Twitter Bootstrap updated to Version 2.2.1
- MarkitUp! updated to Version 1.1.13
- Sitemap Plugin: links title issue fixed.
- Core: Init Site module on frontend only.
- Core: IDIORM optimization.
- Site Class: code optimization.
- Sitemap Plugin: bug with priority fixed.
- File .gitignore added.
- Monstra logo updated.
- README: general updates
- Pages Plugin: "delete" action fixes.
- Plugins Manager: add ability to Cleanup minify with new plugin installation or plugin uninstallation.
- MarkitUp Plugin: unnecessary files removed.
- XMLDB: select() method fixes.
- XMLDB: new method existsField() added.
- Information Plugin: shows "PHP Built On", "Web Server", "WebServer to PHP Interface" information.
- Installer: general fixes.
- Blocks Plugin: view embed codes feature added.
- Snippets Plugin: view embed codes feature added.
- Text Helper: method strpSlashes() fixed.
- Text Helper: new method increment() added.
- Pages Plugin: method robots() fixes.
- Pages Plugin: improved page author detection.
- Pages Plugin: add, edit, delete, clone actions improvements.
- Users Plugin: apply "content" filter for "about_me" field.
- Plugin API: Stylesheet and Javascript load() methods - fixed.
- Pages Plugin: Page editing date issue - fixed.
- Localization: EN, RU, IT, LT, DE translations fixed.
- Imformation Plugin: config file(defines.php) checking removed.
- Box Plugins: general code refactoring.

Monstra 2.0.1, 2012-10-18
------------------------
- Localization: DE, LT, IT translations added
- Validation Helper: Updated email, ip and url methods with filter_var instead preg_match function.
- Localization: EN, RU translations fixed
- Users Plugin: field "about_me" fixed

Monstra 2.0.0, 2012-10-09
------------------------
- Idiorm Added! Idiorm - a lightweight nearly-zero-configuration object-relational mapper and fluent query builder for PHP5.
- Added Crypt Capthca Plugin
- Users Plugin: Added ability to close users frontend registration. Updated frontend and backend templates. Using Capthca Plugin instead of Captca Helper for more secure.
- Admin Password Reset Page: Capthca Plugin added.
- Backup Plugin: Loading state button added. Shows "Creating..." while site backups create.
- Pages Plugin: Added new actions: admin_pages_action_add, admin_pages_action_edit, admin_pages_action_clone, admin_pages_action_delete
- Pages Plugin: Updated date() method - added ability to set date format.
- Pages Plugin: UI and Logic updates.
- Users Plugin: Email templates added.
- Users Table: Added new fields: hash, about_me
- Users Plugin: Admin - New User Registration Validation - Fixed
- Users Plugin: Added ability to set "about me" information.
- Improved Password Reset Logic.
- Information Plugin: Added new tab "Server" with common server information.
- Box Plugins: CSRF vulnerability resolved.
- Sitemap Plugin: Basic search engine optimization.
- Improved Menu Plugin. Added ability to manage items categories.
- Improved Admin Theme - built with best frontend optimization practice. Updated architecture and User Interface. Admin theme more responsive now!
- Added Twitter Bootstrap 2.1.1.
- Added Twitter Bootstrap icons.
- Dir Helper: Fixed size() method.
- New Default Theme: built with best frontend optimization practice.
- Options API: Updated get() method. Return empty string if option value doesnt exists.
- CSS variables: Added - @theme_site_url @theme_admin_url
- CSS variables: Deleted - @theme_url
- Themes Plugin: Added ability to create/edit/clone JavaScripts. Added ability to change admin theme in one click.
- Apply filter 'content' to Blocks.
- Array Helper: get() method improved. New methods keyExists() isAssoc() set() delete() random() added.
- Plugin API: Fixed Javascript and Stylesheet class.
- Plugin API: Added ability to set view file from current theme folder.
- New options theme_admin_name, theme_site_name, users_frontend_registration added.
- Form Helper: Custom Macros - added
- Install Script Improvments.
- Monstra Localization Improvments. Added locales array to I18N class.
- Translates updates.
- Path updates.
- And a lot of general engine improvements.

Monstra 1.3.1, 2012-09-02
------------------------
- Fix Plugins Output

Monstra 1.3.0, 2012-09-01
------------------------
- Improve Multi-user system. Front-end registration, authorization, profile editing added.
- Improve Default Monstra theme.
- Security: Fix Script Insertion Vulnerability.
- Blocks and Snippets plugins code fix. Issue #35, Issue #34
- XMLDB: new method updateField()
- Plugin API: path updates.
- Dir Helper: new method size()
- Filesmanager: shows directory size.
- Security Helper: update safeName() method.
- Pages Plugin: new method children() Get children pages for a specific parent page.
- Update translates.
- And a lot of general engine improvements.

Monstra 1.2.1, 2012-08-09
------------------------
- Admin styles: add .error class
- Fix translates
- Security: fix Cross Site Request Forgery
- Site Module: fix template() function
- Html Helper: fix nbsp() function
- Site Module: fix template() function

Monstra 1.2.0, 2012-07-03
------------------------
- Improve I18N
- Improve Monstra Check Version: set priority 9999
- XMLDB: fix updateWhere function
- Fix Agent Helper
- Sitemap: use time() instead of mktime()
- Security Helper: add Tokenizer

Monstra 1.1.6, 2012-06-12
------------------------
- Sitemap Plugin: return content instead of displaying.
- Improve content filtering.

Monstra 1.1.5, 2012-06-10
------------------------
- Improve Monstra Error Handler
- Cookie Helper: fix set() function

Monstra 1.1.4, 2012-06-09
------------------------
- Improve Monstra Error Handler

Monstra 1.1.3, 2012-06-06
------------------------
- Improve Monstra Error Handler

Monstra 1.1.2, 2012-06-05
------------------------
- Remove Fatal Error Handler
- File helper: fix writable() function

Monstra 1.1.1, 2012-06-04
------------------------
- Fix error reporting!
- Themes Plugin: fix Chunk class

Monstra 1.1.0, 2012-06-02
------------------------
- Menu plugin: added ability to add plugins(components) to site menu.
- Improve installation script: add ability to change Monstra language.
- Improve installation script: better error checking.
- Improve monstra check version
- Update Users table autoincrement value to 0
- Pages Plugin: return empty meta robots if current component is not pages
- Html Helper: fix arrow() function.
- XMLDB: fix select function.
- Themes Plugin: fix theme navigation item order. set 2
- Time Zones updates
- Fix translates

Monstra 1.0.1, 2012-04-26
------------------------
- Cleanup minify during saving the theme
- add new css variables: @site_url and @theme_url
- Remove deprecated @url css variable

Monstra 1.0.0, 2012-04-24
------------------------
- Initial release
