<?php

/**
* WP_Admin_Notices class
* Helper class to generate persistent, dismissible notices for admin
*
* Usage:
*
*   new WP_Admin_Notices('This is a very important persistent, dismissible notice', 'error');
*   new WP_Admin_Notices('This is a just a simple, non-dismissible notice', 'updated', false);
*
* @author Frédéric Trudeau <ftrudeau@prospek.ca>
* @copyright 2012 Prospek <wordpress@prospek.ca>
* @license GNU General Public License, version 2
* @link http://prospek.ca/
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

if (!class_exists('WP_Admin_Notices'))
{
    class WP_Admin_Notices
    {

        function WP_Admin_Notices($message, $class = 'updated', $persistent = true)
        {
            $this->id = '_wp_notice_'.substr(md5($message.$class), -12, 10);
            $this->message = $message;
            $this->class = $class;
            $this->persistent = $persistent;
            $this->has_user_meta = function_exists('get_user_meta');
            add_action('admin_notices', array($this, 'admin_notices'));

            // Can only dismiss notices if user meta are supported
            if ($this->has_user_meta)
                add_action('admin_init', array($this, 'admin_init'));

        }

        function admin_notices()
        {
            global $current_user;
            if ($this->is_admin()) {

                if ($this->has_user_meta)
                    if (get_user_meta($current_user->ID, $this->id)) return;

                $this->html  = '<div class="'.$this->class.'"><p>';
                $this->html .= $this->message;
                parse_str($_SERVER['QUERY_STRING'], $params);
                if ($this->persistent AND $this->has_user_meta)
                    $this->html .= '<a href="?'.http_build_query(array_merge($params, array($this->id => 'hide'))).'" style="float: right">x</a>';
                $this->html .= '</p></div>';
                echo $this->html;

            }
        }

        function admin_init()
        {
            global $current_user;
            if ($this->is_admin() AND $this->persistent) {
                if (isset($_GET[$this->id]) AND $_GET[$this->id] == 'hide') {
                    add_user_meta($current_user->ID, $this->id, 'true', true);
                }
            }
        }

        function is_admin()
        {
            return (current_user_can('install_plugins') AND current_user_can('manage_options'));
        }

    }

}