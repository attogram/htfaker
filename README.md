# htfaker

[![Latest Stable Version](https://poser.pugx.org/attogram/htfaker/v/stable)](https://packagist.org/packages/attogram/htfaker)
[![Latest Unstable Version](https://poser.pugx.org/attogram/htfaker/v/unstable)](https://packagist.org/packages/attogram/htfaker)
[![Total Downloads](https://poser.pugx.org/attogram/htfaker/downloads)](https://packagist.org/packages/attogram/htfaker)
[![License](https://poser.pugx.org/attogram/htfaker/license)](https://github.com/attogram/htfaker/blob/master/LICENSE.md)
[![Code Climate](https://codeclimate.com/github/attogram/htfaker/badges/gpa.svg)](https://codeclimate.com/github/attogram/htfaker)
[![Issue Count](https://codeclimate.com/github/attogram/htfaker/badges/issue_count.svg)](https://codeclimate.com/github/attogram/htfaker)
[![Codacy Badge](https://api.codacy.com/project/badge/Grade/798587683ca54661a8fb5df5ed850745)](https://www.codacy.com/app/attogram-project/htfaker?utm_source=github.com&amp;utm_medium=referral&amp;utm_content=attogram/htfaker&amp;utm_campaign=Badge_Grade)
[`[CHANGELOG]`](https://github.com/attogram/htfaker/blob/master/CHANGELOG.md)

[htfaker](https://github.com/attogram/htfaker) is a router script that emulates
[Apache .htaccess](https://httpd.apache.org/docs/current/howto/htaccess.html)
functionality for the
[PHP built-in web server](http://php.net/manual/en/features.commandline.webserver.php).

## Install

``composer require attogram/htfaker``

## Usage

Example usage:

``php -S localhost:8080 router.php``

then open [http://localhost:8080/](http://localhost:8080/) in your web browser.

## Status

htfaker is in the planning stage. There is currently very little functionality.

If you're interested in making a working library,
please fork and contribute!

[core](http://httpd.apache.org/docs/trunk/mod/core.html#allowoverride) | *status*<a id="core"></a>
-------------------- | --------------------
[ErrorDocument](http://httpd.apache.org/docs/trunk/mod/core.html#errordocument) | 0%
ErrorDocument 400 (Bad Request) | 0%
ErrorDocument 401 (Unauthorized) | 0%
ErrorDocument 402 (Payment Required) | 0%
ErrorDocument 403 (Forbidden) | 0%
ErrorDocument 404 (Not Found) | 0%
ErrorDocument 500 (Internal Server Error) | 0%
[ForceType](http://httpd.apache.org/docs/trunk/mod/core.html#forcetype) | 0%
[Options](http://httpd.apache.org/docs/trunk/mod/core.html#options) | 0%
Options -Indexes | 0%
Options +Indexes | 0%

[mod_access_compat](http://httpd.apache.org/docs/trunk/mod/mod_access_compat.html) | *status*
-------------------- | --------------------
[Allow](http://httpd.apache.org/docs/trunk/mod/mod_access_compat.html#allow) | 0%
[Deny](http://httpd.apache.org/docs/trunk/mod/mod_access_compat.html#deny) | 0%
[Order](http://httpd.apache.org/docs/trunk/mod/mod_access_compat.html#order) | 0%
[Satisfy](http://httpd.apache.org/docs/trunk/mod/mod_access_compat.html#satisfy) | 0%

[mod_alias](http://httpd.apache.org/docs/trunk/mod/mod_alias.html) | *status*
-------------------- | --------------------
[Redirect](http://httpd.apache.org/docs/trunk/mod/mod_alias.html#redirect) | 0%
[RedirectPermanent](http://httpd.apache.org/docs/trunk/mod/mod_alias.html#redirectpermanent) | 0%
[RedirectTemp](http://httpd.apache.org/docs/trunk/mod/mod_alias.html#redirecttemp) | 0%
[RedirectMatch](http://httpd.apache.org/docs/trunk/mod/mod_alias.html#redirectmatch) | 0%

[mod_dir](http://httpd.apache.org/docs/trunk/mod/mod_dir.html) | *status*
-------------------- | --------------------
[DirectoryIndex](https://httpd.apache.org/docs/trunk/mod/mod_dir.html#directoryindex) | 0%
[FallbackResource](https://httpd.apache.org/docs/trunk/mod/mod_dir.html#fallbackresource) | 0%

[mod_rewrite](http://httpd.apache.org/docs/trunk/mod/mod_rewrite.html) | *status*
-------------------- | --------------------
[RewriteEngine](http://httpd.apache.org/docs/trunk/mod/mod_rewrite.html#rewriteengine) | 0%
[RewriteOptions](http://httpd.apache.org/docs/trunk/mod/mod_rewrite.html#rewriteoptions) | 0%
[RewriteBase](http://httpd.apache.org/docs/trunk/mod/mod_rewrite.html#rewritebase) | 0%
[RewriteCond](http://httpd.apache.org/docs/trunk/mod/mod_rewrite.html#rewritecond) | 0%
[RewriteRule](http://httpd.apache.org/docs/trunk/mod/mod_rewrite.html#rewriterule) | 0%

[mod_authn_core](http://httpd.apache.org/docs/trunk/mod/mod_authn_core.html) | *status*
-------------------- | --------------------
[Require](http://httpd.apache.org/docs/trunk/mod/mod_authz_core.html#require) | 0%
[AuthType](http://httpd.apache.org/docs/trunk/mod/mod_authn_core.html#authtype) | 0%
[AuthName](http://httpd.apache.org/docs/trunk/mod/mod_authn_core.html#authname) | 0%

[mod_authn_file](http://httpd.apache.org/docs/trunk/mod/mod_authn_file.html) | *status*
-------------------- | --------------------
[AuthUserFile](http://httpd.apache.org/docs/trunk/mod/mod_authn_file.html#authuserfile) | 0%

[mod_authz_groupfile](http://httpd.apache.org/docs/trunk/mod/mod_authz_groupfile.html) | *status*
-------------------- | --------------------
[AuthGroupFile](http://httpd.apache.org/docs/trunk/mod/mod_authz_groupfile.html#authgroupfile) | 0%

*standards* | *status*
----------- | --------
[PSR-1 Basic Coding Standard](http://www.php-fig.org/psr/psr-1/) | ?
[PSR-2 Coding Style Guide](http://www.php-fig.org/psr/psr-2/) | ?
[PSR-3 Logger Interface](http://www.php-fig.org/psr/psr-3/) | 0%
[PSR-4 Autoloading](http://www.php-fig.org/psr/psr-4/) | ?
[PSR-5 PHPDoc](https://github.com/phpDocumentor/fig-standards/blob/master/proposed/phpdoc.md) | ?
[PSR-7 HTTP message interfaces](http://www.php-fig.org/psr/psr-7/) | 0%
[Stack HttpKernelInterface](http://stackphp.com/) | 0%

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
