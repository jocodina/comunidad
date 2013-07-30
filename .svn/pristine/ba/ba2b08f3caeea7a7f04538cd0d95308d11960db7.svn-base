<?php

/**
* Plugin Name: Prospek | Strings Sanitizer
* Version: 1.0
* Author: Prospek
* Author URI: http://prospek.ca/
* Description: Aggressively sanitizes titles for clean, SEO friendly post slugs, and media filenames during upload. Works by converting common accentuated UTF-8 characters, as well as a few special cyrillic, hebrew, spanish and german characters.
*
* Copyright 2012 Prospek <wordpress@prospek.ca>
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

// define some usefull constants
if (!defined('DS')) define('DS', DIRECTORY_SEPARATOR);
if (!defined('PROSPEK_MAIN_MENU_POSITION')) define('PROSPEK_MAIN_MENU_POSITION', 1000);

// requires PHP >= 5.1.0
if (version_compare(PHP_VERSION, '5.1.0') >= 0) {

    // load plugin core
    require 'core.php';

    // get instance
    if (!$Prospek_Strings_Sanitizer = Prospek_Strings_Sanitizer::instance(
        realpath(dirname(__FILE__)),
        'prospek-strings-sanitizer'
    )) {
        exit();
    }

    // add an admin pointer advertising our newly installed plugin
    if (version_compare($wp_version, '3.3') >= 0) {
        require_once 'classes/admin_pointers.php';
        $pointer_html  = '<h3>'.$Prospek_Strings_Sanitizer->__('Prospek\'s Strings Sanitizer').'</h3>';
        $pointer_html .= '<p>'.$Prospek_Strings_Sanitizer->__('Oh goody, post titles and media  filenames are now automatically sanitized. Ain\'t that sweet?').'</p>';
        $pointer_html .= '<p>'.$Prospek_Strings_Sanitizer->__('If for any reason you wish to change this default behavior, you can do so at any time in the configuration area of the plugin.').'</p>';
        WP_Admin_Pointers::instance($Prospek_Strings_Sanitizer->urls['assets'] . '/css/prospek-pointer.css')
            ->add(
                $pointer_html,
                'li.toplevel_page_prospek',
                array(
                    'position' => array('edge'=>'bottom', 'offset' => '5 -8'),
                ),
                false,
                array('manage_options')
        );
    }

    // register basic hooks
    register_activation_hook(__FILE__, array('Prospek_Strings_Sanitizer', 'activate'));
    register_deactivation_hook(__FILE__, array('Prospek_Strings_Sanitizer', 'deactivate'));

} else {

    require_once 'classes/admin_notices.php';
    new WP_Admin_Notices('<strong>Prospek | Strings Sanitizer</strong> requires PHP 5.1.0 or later to be initialized. Please upgrade, or <a href="plugins.php?plugin_status=active">deactivate the plugin</a> to get ride of this message.', 'error');

}