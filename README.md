# htfaker

[![Latest Stable Version](https://poser.pugx.org/attogram/htfaker/v/stable)](https://packagist.org/packages/attogram/htfaker)
[![Latest Unstable Version](https://poser.pugx.org/attogram/htfaker/v/unstable)](https://packagist.org/packages/attogram/htfaker)
[![Total Downloads](https://poser.pugx.org/attogram/htfaker/downloads)](https://packagist.org/packages/attogram/htfaker)
[![License](https://poser.pugx.org/attogram/htfaker/license)](https://github.com/attogram/htfaker/blob/master/LICENSE.md)
[![Code Climate](https://codeclimate.com/github/attogram/htfaker/badges/gpa.svg)](https://codeclimate.com/github/attogram/htfaker)
[![Issue Count](https://codeclimate.com/github/attogram/htfaker/badges/issue_count.svg)](https://codeclimate.com/github/attogram/htfaker)
[![Codacy Badge](https://api.codacy.com/project/badge/Grade/798587683ca54661a8fb5df5ed850745)](https://www.codacy.com/app/attogram-project/htfaker?utm_source=github.com&amp;utm_medium=referral&amp;utm_content=attogram/htfaker&amp;utm_campaign=Badge_Grade)
[`[CHANGELOG]`](https://github.com/attogram/htfaker/blob/master/CHANGELOG.md)
[`[TODO]`](https://github.com/attogram/htfaker/blob/master/TODO.md)


[htfaker](https://github.com/attogram/htfaker)
is a PHP library that emulates
[Apache .htaccess](https://httpd.apache.org/docs/current/howto/htaccess.html)
functionality.

It is intended to be run as a router script for the
[PHP built-in web server](http://php.net/manual/en/features.commandline.webserver.php).

## Usage

Example usage:

``php -S localhost:8080 router.php``

then open [http://localhost:8080/](http://localhost:8080/) in your web browser.

## Status

htfaker is in the planning stage. There is currently very little functionality.

| Directive         | Status |
| ----------------  | ------ |
| FallbackResource  | 0%     |
| ErrorDocument 404 | 0%     |
| DirectoryIndex    | 0%     |
| Options -Indexes  | 0%     |
| Options +Indexes  | 0%     |

If you're interested in making a working library,
please fork and contribute!

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
