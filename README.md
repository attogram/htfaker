# htfaker

[![Latest Stable Version](https://poser.pugx.org/attogram/htfaker/v/stable)](https://packagist.org/packages/attogram/htfaker)
[![Latest Unstable Version](https://poser.pugx.org/attogram/htfaker/v/unstable)](https://packagist.org/packages/attogram/htfaker)
[![Total Downloads](https://poser.pugx.org/attogram/htfaker/downloads)](https://packagist.org/packages/attogram/htfaker)
[![License](https://poser.pugx.org/attogram/htfaker/license)](https://github.com/attogram/htfaker/blob/master/LICENSE.md)
[![Code Climate](https://codeclimate.com/github/attogram/htfaker/badges/gpa.svg)](https://codeclimate.com/github/attogram/htfaker)
[![Codacy Badge](https://api.codacy.com/project/badge/Grade/798587683ca54661a8fb5df5ed850745)](https://www.codacy.com/app/attogram-project/htfaker?utm_source=github.com&amp;utm_medium=referral&amp;utm_content=attogram/htfaker&amp;utm_campaign=Badge_Grade)
[`[CHANGELOG]`](https://github.com/attogram/htfaker/blob/master/CHANGELOG.md)

[htfaker](https://github.com/attogram/htfaker) is a router script that emulates
[Apache .htaccess](https://httpd.apache.org/docs/current/howto/htaccess.html)
functionality for the
[PHP built-in web server](http://php.net/manual/en/features.commandline.webserver.php).

## Install

Example install:
```
composer require attogram/htfaker
```

## Usage

Example usage:

```
cd vendor/attogram/htfaker
php -S localhost:8080 router.php
```

then open [http://localhost:8080/](http://localhost:8080/) in your web browser.

## Status

htfaker is in the planning stage. There is currently very little functionality.

If you're interested in making a working library, please fork and contribute!

htfaker framework                    | *status*<a id="htfaker">
------------------------------------ | ------------------------
get document root directory          | **Testing**
get current directory                | *in dev*
check if request is for a file       | *in dev*
check if request is for a directory  | *in dev*
get .htaccess files, current to root | **Testing**
parse all found .htaccess files      | **Testing**
get all directives to apply          | *in dev*
apply directives                     | *in dev*
shutdown                             | -

*standards* | *status*
----------- | --------
[PSR-1 Basic Coding Standard](http://www.php-fig.org/psr/psr-1/) | **Testing**
[PSR-2 Coding Style Guide](http://www.php-fig.org/psr/psr-2/) | **Testing**
[PSR-3 Logger Interface](http://www.php-fig.org/psr/psr-3/) | **Testing**
[PSR-4 Autoloading](http://www.php-fig.org/psr/psr-4/) | **Testing**
[PSR-5 PHPDoc](https://github.com/phpDocumentor/fig-standards/blob/master/proposed/phpdoc.md) | *in dev*
[PSR-7 HTTP message interfaces](http://www.php-fig.org/psr/psr-7/) | -

[core](http://httpd.apache.org/docs/trunk/mod/core.html#allowoverride) directives | *status*<a id="core"></a>
-------------------- | --------------------
[ErrorDocument](http://httpd.apache.org/docs/trunk/mod/core.html#errordocument) | [*in dev*](https://github.com/attogram/htfaker/blob/master/src/ErrorDocument.php)
ErrorDocument 400 (Bad Request) | -
ErrorDocument 401 (Unauthorized) | -
ErrorDocument 402 (Payment Required) | -
ErrorDocument 403 (Forbidden) | -
ErrorDocument 404 (Not Found) | -
ErrorDocument 500 (Internal Server Error) | -
[ForceType](http://httpd.apache.org/docs/trunk/mod/core.html#forcetype) | -
[Options](http://httpd.apache.org/docs/trunk/mod/core.html#options) | [*in dev*](https://github.com/attogram/htfaker/blob/master/src/Options.php)
Options -Indexes | -
Options +Indexes | -

[mod_access_compat](http://httpd.apache.org/docs/trunk/mod/mod_access_compat.html) directives | *status*
-------------------- | --------------------
[Allow](http://httpd.apache.org/docs/trunk/mod/mod_access_compat.html#allow) | -
Allow from all | -
Allow from *host* | -
Allow from *host [host] ...* | -
Allow from *ip* | -
Allow from *ip [ip] ...* | -
Allow from *network/netmask* | -
Allow from *network/nnn-CIDR* | -
Allow from *env=* | -
[Deny](http://httpd.apache.org/docs/trunk/mod/mod_access_compat.html#deny) | -
Deny from all | -
Deny from *host* | -
Deny from *host [host] ...* | -
Deny from *ip* | -
Deny from *ip [ip] ...* | -
Deny from *network/netmask* | -
Deny from *network/CIDR* | -
Deny from *env=* | -
[Order](http://httpd.apache.org/docs/trunk/mod/mod_access_compat.html#order) | -
Order Allow,Deny | -
Order Deny,Allow | -
[Satisfy](http://httpd.apache.org/docs/trunk/mod/mod_access_compat.html#satisfy) | -
Satisfy All | -
Satisfy Any | -

[mod_alias](http://httpd.apache.org/docs/trunk/mod/mod_alias.html) directives | *status*
-------------------- | --------------------
[Redirect](http://httpd.apache.org/docs/trunk/mod/mod_alias.html#redirect) | -
[RedirectPermanent](http://httpd.apache.org/docs/trunk/mod/mod_alias.html#redirectpermanent) | -
[RedirectTemp](http://httpd.apache.org/docs/trunk/mod/mod_alias.html#redirecttemp) | -
[RedirectMatch](http://httpd.apache.org/docs/trunk/mod/mod_alias.html#redirectmatch) | -

[mod_dir](http://httpd.apache.org/docs/trunk/mod/mod_dir.html) directives | *status*
-------------------- | --------------------
[DirectoryCheckHandler](https://httpd.apache.org/docs/trunk/mod/mod_dir.html#directorycheckhandler) | -
[DirectoryIndex](https://httpd.apache.org/docs/trunk/mod/mod_dir.html#directoryindex) | [*in dev*](https://github.com/attogram/htfaker/blob/master/src/DirectoryIndex.php)
DirectoryIndex _local-url_ | -
DirectoryIndex _local-url [local-url]..._ | -
DirectoryIndex disabled | -
[DirectoryIndexRedirect](https://httpd.apache.org/docs/trunk/mod/mod_dir.html#directoryindexredirect) | -
[DirectorySlash](https://httpd.apache.org/docs/trunk/mod/mod_dir.html#directoryslash) | -
[FallbackResource](https://httpd.apache.org/docs/trunk/mod/mod_dir.html#fallbackresource) | [*in dev*](https://github.com/attogram/htfaker/blob/master/src/FallbackResource.php)
FallbackResource _local-url_ | -
FallbackResource disabled | -

[mod_rewrite](http://httpd.apache.org/docs/trunk/mod/mod_rewrite.html) directives | *status*
-------------------- | --------------------
[RewriteEngine](http://httpd.apache.org/docs/trunk/mod/mod_rewrite.html#rewriteengine) | -
[RewriteOptions](http://httpd.apache.org/docs/trunk/mod/mod_rewrite.html#rewriteoptions) | -
[RewriteBase](http://httpd.apache.org/docs/trunk/mod/mod_rewrite.html#rewritebase) | -
[RewriteCond](http://httpd.apache.org/docs/trunk/mod/mod_rewrite.html#rewritecond) | -
[RewriteRule](http://httpd.apache.org/docs/trunk/mod/mod_rewrite.html#rewriterule) | -

[mod_authn_core](http://httpd.apache.org/docs/trunk/mod/mod_authn_core.html) directives | *status*
-------------------- | --------------------
[Require](http://httpd.apache.org/docs/trunk/mod/mod_authz_core.html#require) | -
[AuthType](http://httpd.apache.org/docs/trunk/mod/mod_authn_core.html#authtype) | -
[AuthName](http://httpd.apache.org/docs/trunk/mod/mod_authn_core.html#authname) | -

[mod_authn_file](http://httpd.apache.org/docs/trunk/mod/mod_authn_file.html) directives | *status*
-------------------- | --------------------
[AuthUserFile](http://httpd.apache.org/docs/trunk/mod/mod_authn_file.html#authuserfile) | -

[mod_authz_groupfile](http://httpd.apache.org/docs/trunk/mod/mod_authz_groupfile.html) directives | *status*
-------------------- | --------------------
[AuthGroupFile](http://httpd.apache.org/docs/trunk/mod/mod_authz_groupfile.html#authgroupfile) | -

## License

htfaker is dual licensed under
[The MIT License](http://opensource.org/licenses/MIT) or the
[GNU General Public License](http://opensource.org/licenses/GPL-3.0), at your choosing.

Read the
[LICENSE.md](https://github.com/attogram/htfaker/blob/master/LICENSE.md)
file for more info.

## TODO

* use <https://github.com/tivie/php-htaccess-parser>? - Apache License
* use <https://github.com/jaytaph/HTRouter>?
* use <http://pecl.php.net/package/htscanner>?
