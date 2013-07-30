<?php

/**
* WP_Admin_Pointers class
*
* Helper class to generate feature pointers in the admin
* Inspired by Wordpress own WP_Internal_Pointers class
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

if (!class_exists('WP_Admin_Pointers'))
{

    class WP_Admin_Pointers
    {

        /**
         * Holds the singleton instance of WP_Admin_Pointers
         * @var object WP_Admin_Pointers
         * @access private
         */
        private static $_instance = null;

        /**
         * Holds the list of pointers enqueued for display
         * @var array
         * @access private
         */
        private $enqueued = array();

        /**
         * Holds the list of already dismissed pointers
         * @var array
         * @access private
         */
        private $dismissed;

        /**
         * Key to use to save user's dismissed pointers
         * @var string
         */
        private $user_meta_key = '_wp_admin_pointers_dismissed';

        /**
         * Custom stylesheet url
         * @var string
         */
        private $css_custom_url;

        /**
         * Stylesheet handle
         * @var string
         */
        private $css_handle = 'wp-pointer';

        /**
        * Direct object creation via constructor is prevented
        * Use WP_Admin_Pointers::instance() instead
        *
        * @var mixed $css URL of custom CSS to load, or false stick with the default
        * @return object WP_Admin_Pointers instance
        * @access private
        */
        private function __construct($css)
        {

            // We'll need WP's pluggables
            require_once ABSPATH . WPINC . '/pluggable.php';

            // Set custom CSS handle
            if ($css !== FALSE)
                $this->css_custom_url = $css;

            // Get dismissed pointers
            $this->dismissed = explode(',', (string) get_user_meta(get_current_user_id(), $this->user_meta_key, true));

            // Add our own AJAX action, called when user dismisses a pointer
            add_action('wp_ajax_dismiss_pointer', array($this, 'action_dismiss'));

            // Hook into WP's admin_enqueue_scripts
            add_action('admin_enqueue_scripts', array($this, 'enqueue_scripts'));

            // Hook into WP's admin_print_footer_scripts
            add_action('admin_print_footer_scripts', array($this, 'admin_print_footer_scripts'));

            // Return self
            return $this;
        }

        /**
        * Returns new or existing singleton instance of WP_Admin_Pointers
        *
        * @var mixed $css URL of custom CSS to load, or false stick with the default
        * @return object WP_Admin_Pointers instance
        * @access public
        */
        public static function instance($css = false)
        {
            if (self::$_instance === null) {
                self::$_instance = new WP_Admin_Pointers($css);
            }
            return self::$_instance;
        }

        /**
        * Chainable method to add a pointer
        *
        * @param string $content Pointer's HTML content
        * @param string $selector The HTML element(s) on which the pointer JavaScript should be attached
        * @param array $options Options to setup the pointer (see /wp-includes/js/wp-pointer.dev.js)
        * @param mixed $hooks A single admin page, an array of admin pages, or false if pointer should display on any admin page
        * @param mixed $capabilities A single capability, an array of capabilities, or false if none needed
        * @return object WP_Admin_Pointers
        * @access public
        */
        public function add($content, $selector, $options = array('position'=>array('edge'=>'top','align'=>'center')), $hooks = false, $capabilities = false)
        {

            // Figure out a (somewhat) unique id for this pointer
            $pointer_id = substr(md5($content.$selector.$options.$hooks.$capabilities), -12, 10);

            // Avoid enqueuing already dismissed pointers
            if (!in_array($pointer_id, $this->dismissed)) {
                $this->enqueued[$pointer_id] = array(
                    'hooks' => $hooks,
                    'content' => $content,
                    'selector' => $selector,
                    'options' => $options,
                    'capabilites' => $capabilities
                );
            }

            // Return self
            return $this;
        }

        /**
        * Checks if enqueued pointers are hooked to specific admin pages, or if required capabilities are met
        *
        * @param string $hook Current admin page
        * @return void
        * @access public
        */
        public function enqueue_scripts($hook)
        {

            // Register custom CSS ?
            if ($this->css_custom_url !== NULL) {
                $this->css_handle = 'wp-pointer-custom';
                wp_register_style($this->css_handle, $this->css_custom_url);
            }

            foreach ($this->enqueued AS $pointer_id => $pointer) {

                // Check for hooks ?
                if ($pointer['hooks'] !== false) {

                    // Transform string into an array
                    if (is_string($pointer['hook']))
                        $pointer['hooks'] = (array) $pointer['hooks'];

                    // Is current page in any pages pointer is hooked to ?
                    if (!in_array($hook, $pointer['hooks']))
                        // Nop. Remove from queue
                        unset($this->enqueued[$pointer_id]);

                }

                // Check for capabilities ?
                if ($pointer['capabilites'] !== false) {

                    // Transform string into an array
                    if (is_string($pointer['capabilites']))
                        $pointer['capabilites'] = (array) $pointer['capabilites'];

                    // Check each required capability
                    foreach ($pointer['capabilites'] AS $capability) {

                        // User does not have required capability. Remove from queue.
                        if (!current_user_can($capability)) {
                            unset($this->enqueued[$pointer_id]);
                            break;
                        }

                    }

                }
            }

            // Load required assets only if we still got enqueued pointers
            if (count($this->enqueued) > 0) {
                wp_enqueue_style($this->css_handle);
                wp_enqueue_script('wp-pointer');
            }

        }

        /**
        * Print the JavaScript for each pointer
        *
        * @return void
        * @access public
        */
        public function admin_print_footer_scripts()
        {
            if (count($this->enqueued) > 0) {
                foreach ($this->enqueued AS $pointer_id => $pointer) {
                    self::print_js($pointer_id, $pointer['selector'], array_merge(array('content'=>$pointer['content']), $pointer['options']));
                }
            }
        }

        /**
        * Saves user's decision to dismiss a specific pointer
        * Called when wp_ajax_dismiss_pointer is triggered
        *
        * @return void
        * @access public
        */
        public function action_dismiss()
        {
            $pointer = $_POST['pointer'];
            if ($pointer != sanitize_key($pointer))
                wp_die(0);
            if (in_array($pointer, $this->dismissed))
                wp_die(0);
            array_push($this->dismissed, $pointer);
            $this->dismissed = implode(',', $this->dismissed);
            update_user_meta(get_current_user_id(), $this->user_meta_key, $this->dismissed);
            wp_die(1);
        }

        /**
         * Prints the pointer javascript data
         *
         * @param string $pointer_id The pointer ID.
         * @param string $selector The HTML elements, on which the pointer should be attached
         * @param array  $options Options to be passed to the pointer JavaScript
         * @return void
         * @access private
         */
         private static function print_js($pointer_id, $selector, $options) {
             if (empty($pointer_id) || empty($selector) || empty($options) || empty($options['content']))
                return;
             ?>
            <script type="text/javascript">
            //<![CDATA[
                jQuery(document).ready( function($) {
                    var options = <?php echo json_encode($options); ?>;
                    if (!options) return;
                    options = $.extend(options, {
                        close: function() {
                            $.post( ajaxurl, {
                                pointer: '<?php echo $pointer_id; ?>',
                                action: 'dismiss_pointer'
                            });
                        },
                        buttons: function( event, t ) {
                            var close = ( wpPointerL10n ) ? wpPointerL10n.dismiss : 'Dismiss',
                            button = $('<a class="btn btn-inverse btn-small" href="#"><i class="icon-signout">&nbsp;</i>' + close + '</a>');
                            return button.bind( 'click.pointer', function(e) {
                                e.preventDefault();
                                t.element.pointer('close');
                            });
                        }
                    });
                    $('<?php echo $selector; ?>').pointer( options ).pointer('open');
                });
            //]]>
            </script>
            <?php
         }

    }

}