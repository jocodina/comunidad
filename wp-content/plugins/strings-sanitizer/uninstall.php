<?php

/**
* Prospek_Strings_Sanitizer WP plugin uninstall routine
*
* @author Frédéric Trudeau <ftrudeau@prospek.ca>
* @copyright 2012 Prospek <wordpress@prospek.ca>
* @license GNU General Public License, version 2
* @link http://prospek.ca/
* @since 1.0b1
*
* This program is free software; you can redistribute it and/or modify
* it under the terms of the GNU General Public License, version 2, as
* published by the Free Software Foundation.
*
* This program is distributed in the hope that it will be useful,
* but WITHOUT ANY WARRANTY; without even the implied warranty of
* MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE. See the
* GNU General Public License for more details.
*
* You should have received a copy of the GNU General Public License
* along with this program; if not, write to the Free Software
* Foundation, Inc., 59 Temple Place, Suite 330, Boston, MA  02111-1307  USA
*/

// really ?
if (!defined('ABSPATH') AND !defined('WP_UNINSTALL_PLUGIN'))
    exit(); // no, not really.

// load plugin core class
if (!class_exists('Prospek_Strings_Sanitizer')) {
    require 'core.php';
}

// leave no trace.
delete_option(Prospek_Strings_Sanitizer::$wp_option_name);
return;