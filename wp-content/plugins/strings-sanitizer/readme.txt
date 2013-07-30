=== Strings Sanitizer ===
Contributors: prospek, ftrudeau
Tags: sanitize, clean, transliterate, slug, utf-8, ascii, characters, international, url, filename, french, cyrillic, hebrew, german, plugin, admin, prospek, ftrudeau
Requires at least: 2.7
Tested up to: 3.4-beta3
Stable tag: 1.0

Aggressively sanitizes titles for clean, SEO friendly post slugs, and media filenames during upload.

== Description ==

= In A Nutshell =

Works by converting common accentuated UTF-8 characters, as well as a few special cyrillic, hebrew, spanish and german characters.
Any white space will be replaced by a hyphen, thus generating SEO friendly post slugs, as well as generating Linux-friendly filenames.

= Requirements =

This plugin requires:

* Wordpress 3.0+
* PHP 5.1.0+

= Praises and Criticisms =

Comments, bug reports and feature requests are more then welcome.
Please send you inquiries by email, at wordpress@prospek.ca.

= Shameless Plug =

Explore more plugins by [Prospek](http://wordpress.org/extend/plugins/tags/prospek/ "Prospek"), and while you are at it, [pay us a little visit](http://prospek.ca/en/ "Visit Prospek website").

== Installation ==

Install Strings Sanitizer via the WordPress.org plugin directory, or [download the latest version](http://downloads.wordpress.org/plugin/strings-sanitizer.1.0b5.zip "Download latest version"), unzip, and place the folder and it's entire content to the plugins directory of your Wordpress installation (most likely in /wp-content/plugins/).

After activating, a new top level menu labelled "Prospek" will appear in the admin menu sidebar, containing a submenu labelled "Strings Sanitizer".

Select it. Click it. Explore it.

== Changelog ==

= 1.0 =
* Initial release
* ADD: French translations
* ADD: Added classes/admin_pointers.php helper class
* ADD: Using new feature pointers from WP 3.3+ upon plugin activation
* OPT: Code refactoring, optimizations and documentation
* ADD: Added CSS and webfonts
* CHG: Successful regression testing, up to Wordpress version 2.7
* CHG: Successful testing on Wordpress version 3.4-beta3
* FIX: Only add filters if we are in admin area, otherwise, it might break the frontend! Wikes.

= 1.0b4 =
* Changes in readme.txt

= 1.0b3 =
* FIX: Fixed constructor, effectively removing dependency to PHP >= 5.3
* ADD: Added classes/admin_notices.php helper class
* OPT: Display notice to admins, if PHP >= 5.1 dependency is not met
* CHG: Changed plugin display name (Prospek Strings Sanitizer -> Strings Sanitizer)
* ADD: Added Wordpress Plugin page header image
* UPD: Updated plugin description
* CHG: Successful regression testing, up to Wordpress version 2.8

= 1.0b2 =
* FIX: Fixed contributors and short description
* REM: Removed unneeded logs directory

= 1.0b1 =
* Initial beta release