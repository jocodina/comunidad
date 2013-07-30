<?php

/**
* Prospek_Strings_Sanitizer class for WP Plugin
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

if (!class_exists('Prospek_Strings_Sanitizer'))
{

    class Prospek_Strings_Sanitizer
    {

        /**
        * Holds the singleton instance of Prospek_Strings_Sanitizer
        *
        * @since 1.0b5
        *
        * @var object Prospek_Strings_Sanitizer
        */
        private static $_instance = null;

        /**
        * Required WP version
        *
        * @since 1.0b5
        *
        * @var string
        */
        private $wp_version_required = '2.7';

        /**
        * Internal paths
        *
        * @since 1.0b1
        *
        * @var array
        */
        protected $paths = array('assets','l10n','views');

        /**
        * Internal URLs
        *
        * @since 1.0b1
        *
        * @var array
        */
        public $urls = array('assets');

        /**
        * Option name to use for wp_options DB operations
        *
        * @since 1.0b1
        *
        * @var string
        */
        public static $wp_option_name = 'prospek_strings_sanitizer';

        /**
        * Default wp_options
        *
        * @since 1.0b1
        *
        * @var array
        */
        private static $wp_default_options = array(
            'title' => true,
            'title_case' => 0,
            'media' => true,
            'media_case' => 0
        );

        /**
        * Loaded wp_options
        *
        * @since 1.0b1
        *
        * @var array
        */
        private $wp_options = null;

        /**
        * Direct object creation via constructor is prevented
        * Use Prospek_Strings_Sanitizer::instance() instead
        *
        * @since 1.0b1
        *
        * @var string $basepath Plugin base path
        * @var string $textdomain Gettext's domain
        * @return object Prospek_Strings_Sanitizer instance
        */
        public function __construct($basepath, $textdomain)
        {

            // Define paths
            $paths = array();
            foreach ($this->paths AS $directory) {
                $path = $basepath . DS . $directory;
                if (is_dir($path) AND is_readable($path)) {
                    $paths[$directory] = $path . DS;
                }
            }
            $this->paths = array_merge(array('base'=>$basepath), $paths);

            // Define urls
            $urls = array();
            foreach ($this->urls AS $directory) {
                // Path must exists.
                if (array_key_exists($directory, $this->paths)) {
                    $urls[$directory] = plugins_url() . '/' . basename($basepath) . '/' . $directory;
                }
            }
            $this->urls = array_merge(array('base'=>plugins_url() . '/' . basename($basepath)), $urls);

            // Set textdomain and load translations
            $this->textdomain = $textdomain;
            if (isset($this->paths['l10n'])) {
                load_plugin_textdomain($this->textdomain, false, dirname(plugin_basename( __FILE__ )) . '/l10n/');
            }

            // Check for required WP version
            global $wp_version;
            if (version_compare($wp_version, $this->wp_version_required) < 0) {
                require_once 'classes/admin_notices.php';
                new WP_Admin_Notices(sprintf($this->__('<strong>Prospek | Strings Sanitizer</strong> requires Wordpress version %s or higher to be initialized. <a href="update-core.php">Upgrade Wordpress</a> to the latest stable version, or <a href="plugins.php?plugin_status=active">deactivate the plugin</a> to get ride of this message.'), $this->wp_version_required, $wp_version), 'error');
                return false;
            }

            // Initialize plugin
            $this->init();

            // Process update request
            if ($_SERVER['REQUEST_METHOD'] === 'POST' AND !empty($_POST) AND isset($_POST['action']) AND $_POST['action'] == 'prospek-strings-sanitizer-update') {
                $this->action_update();
            }

            // Return self
            return $this;

        }

        /**
        * Returns new or existing singleton instance of WP_Admin_Pointers
        *
        * @since 1.0b5
        *
        * @return object Prospek_Strings_Sanitizer instance
        */
        public static function instance($basepath, $textdomain)
        {
            if (self::$_instance === null) {
                self::$_instance = new Prospek_Strings_Sanitizer($basepath, $textdomain);
            }
            return self::$_instance;
        }

        /**
         * Display dashboard for plugin
         *
         * @since 1.0b1
         *
         * @return void
         */
        public function action_index()
        {
            require $this->paths['views'] . 'index.php';
        }

        /**
         * Update
         *
         * @since 1.0b1
         *
         * @return void
         */
        private function action_update()
        {

            // Require pluggable
            require_once ABSPATH . WPINC . '/pluggable.php';

            // Validate that request was made from an admin page, and carries a valid nonce
            if (check_admin_referer('update', '_wpnonce'))
            {
                // Load options
                $wp_options = $this->load_options();

                // Set new options
                $wp_options['title'] = (isset($_POST['title'])) ? true : false;
                $wp_options['media'] = (isset($_POST['media'])) ? true : false;
                $this->wp_options = $wp_options;

                // Update options
                update_option(self::$wp_option_name, serialize($wp_options));

            }

        }

        /**
         * Plugin initialization
         *
         * @since 1.0b1
         *
         * @return void
         */
        private function init()
        {

            // Load options
            $wp_options = $this->load_options();

            if (is_admin()) {

                // Add stylesheets
                wp_enqueue_style($this->textdomain,  $this->urls['assets'] . '/css/main.css');
                wp_enqueue_style('bootstrap-buttons', $this->urls['assets'] . '/css/bootstrap-buttons.css');
                wp_enqueue_style('fontawesome-webfonts', $this->urls['assets'] . '/css/fontawesome-webfonts.css');

                // Add our menu
                add_action('admin_menu', array($this, 'admin_menu'));

                // Sanitize title, if option allows
            	if (intval($wp_options['title']) == 1)
					add_filter('sanitize_title', array($this, 'sanitize_title'), 0);

            	// Sanitize media, if option allows
            	if (intval($wp_options['media']) == 1)
            		add_filter('sanitize_file_name', array($this, 'sanitize_file_name'), 0);
            	
            }

        }

        /**
         * Add plugin menu
         *
         * @since 1.0b1
         *
         * @return void
        */
        public function admin_menu()
        {

            global $menu, $submenu;

            // Add ou main menu, only if needed.
            if (!isset($menu[PROSPEK_MAIN_MENU_POSITION]))
                add_menu_page(
                    __('Prospek'),
                    __('Prospek'),
                    'manage_options',
                    'prospek',
                    array($this, 'action_index'),
                    $this->urls['assets'] . '/images/wp-icon-x16.png',
                    PROSPEK_MAIN_MENU_POSITION
                );

            // Add submenu page
            add_submenu_page(
                'prospek',
                __('Strings Sanitizer | Prospek'),
                __('Strings Sanitizer'),
                'manage_options',
                'prospek-strings-sanitizer',
                array($this, 'action_index')
            );

            // we do not want the main Prospek menu page to have it's own submenu entry. hacky, hack, hack, hack.
            if ($submenu['prospek'][0][2] === 'prospek') {
                unset($submenu['prospek'][0]);
            }

        }

        /**
        * Sanitizes title
        *
        * @since 1.0b1
        *
        * @see http://codex.wordpress.org/Function_Reference/sanitize_title
        * @return string Sanitized title
        */
        public function sanitize_title($title)
        {
            $wp_options = $this->load_options();
            return $this->clean($title, 'title', $wp_options['title_case']);
        }

        /**
        * Sanitizes media filename
        *
        * @since 1.0b1
        *
        * @see http://codex.wordpress.org/Function_Reference/sanitize_file_name
        * @return string Sanitized media filename
        */
        public function sanitize_file_name($name)
        {
            $wp_options = $this->load_options();
            return $this->clean($name, 'media', $wp_options['media_case']);
        }

        /**
         * Transliterate a string to ASCII, and donverts it to a URL & system safe string.
         *
         * @since 1.0b1
         *
         * @param string $string String to convert
         * @param string $type Type of string to convert (title|media)
         * @param integer $case Cases to convert -1 lowercase, +1 uppercase, 0 both
         * @return string
        */
        private function clean($string, $type, $case)
        {

            if ($type === 'media') {
                list($dirname, $basename, $file_extension, $string) = array_values(pathinfo($string));
            }

            // Transliterate non-ASCII characters
            $string = $this->to_ascii($string, $case);

            // Remove all characters that are not the separator, a-z, 0-9, or whitespace
            $string = preg_replace('![^'.preg_quote('-').'a-z0-_9\s]+!', '', strtolower($string));

            // Replace all separator characters and whitespace by a single separator
            $string = preg_replace('!['.preg_quote('-').'\s]+!u', '-', $string);

            // Trim separators from the beginning and end
            $string = trim($string, '-');

            // Add back file extension, if applicable
            if ($type === 'media') $string = implode('.', array($string, $file_extension));

            // Return filtered string
            return $string;

        }

        /**
        * Load our options, only if not already loaded
        * Revert to default options if nothing is returned from wp_options table
        *
        * @since 1.0b1
        *
        * @return array
        */
        public function load_options()
        {
            if (is_null($this->wp_options)) {
                if (!$wp_options = unserialize(get_option(self::$wp_option_name))) {
                    $wp_options = self::$wp_default_options;
                }
                $this->wp_options = $wp_options;
            }
            return $this->wp_options;
        }

        /**
         * Replaces special/accentuated characters
         *
         * @since 1.0b1
         *
         * @param string $string string to transliterate
         * @param integer $case Cases to convert -1 lowercase, +1 uppercase, 0 both
         * @return string
        */
        private function to_ascii($string, $case = 0)
        {

            if ($case <= 0)
            {
                $characters = array_merge(
                    $this->characters['common']['lower'],
                    $this->characters['cyrillic']['lower'],
                    $this->characters['hebrew']['lower'],
                    $this->characters['spanish']['lower'],
                    $this->characters['german']['lower']
                );
                $string = str_replace(array_keys($characters), array_values($characters), $string);
            }

            if ($case >= 0)
            {
                $characters = array_merge(
                    $this->characters['common']['upper'],
                    $this->characters['cyrillic']['upper'],
                    $this->characters['hebrew']['upper'],
                    $this->characters['spanish']['upper'],
                    $this->characters['german']['upper']
                );
                $string = str_replace(array_keys($characters), array_values($characters), $string);
            }

            return $string;
        }

        /**
         * Retrieves the translation of $string
         *
         * @since 1.0b5
         *
         * @param string $string String to translate
         * @return string Translated string
         */
        public function __($string) {
            return translate($string, $this->textdomain);
        }

        /**
         * Displays the returned translated text
         *
         * @since 1.0b5
         *
         * @param string $text String to translate and echo back
         */
        public function _e($string) {
            echo translate($string, $this->textdomain);
        }

        /**
         * Runs when plugin is activated
         *
         * @since 1.0b1
         *
         * @return void
        */
        public static function activate()
        {
            // Inject default options, if needed
            if (!$options = unserialize(get_option(self::$wp_option_name)))
                add_option(self::$wp_option_name, serialize(self::$wp_default_options));
        }

        /**
         * Runs when plugin is deactivated
         *
         * @since 1.0b1
         *
         * @return void
        */
        public static function deactivate()
        {
        }

        /**
        * Characters map
        *
        * @since 1.0b1
        *
        * @var array
        */
        private $characters = array(
            'common' => array(
                'lower' => array(
                    'à' => 'a',  'ô' => 'o',  'ď' => 'd',  'ḟ' => 'f',  'ë' => 'e',  'š' => 's',  'ơ' => 'o',
                    'ă' => 'a',  'ř' => 'r',  'ț' => 't',  'ň' => 'n',  'ā' => 'a',  'ķ' => 'k',
                    'ŝ' => 's',  'ỳ' => 'y',  'ņ' => 'n',  'ĺ' => 'l',  'ħ' => 'h',  'ṗ' => 'p',  'ó' => 'o',
                    'ú' => 'u',  'ě' => 'e',  'é' => 'e',  'ç' => 'c',  'ẁ' => 'w',  'ċ' => 'c',  'õ' => 'o',
                    'ṡ' => 's',  'ø' => 'o',  'ģ' => 'g',  'ŧ' => 't',  'ș' => 's',  'ė' => 'e',  'ĉ' => 'c',
                    'ś' => 's',  'î' => 'i',  'ű' => 'u',  'ć' => 'c',  'ę' => 'e',  'ŵ' => 'w',  'ṫ' => 't',
                    'ū' => 'u',  'č' => 'c',  'ö' => 'oe', 'è' => 'e',  'ŷ' => 'y',  'ą' => 'a',  'ł' => 'l',
                    'ų' => 'u',  'ů' => 'u',  'ş' => 's',  'ğ' => 'g',  'ļ' => 'l',  'ƒ' => 'f',  'ž' => 'z',
                    'ẃ' => 'w',  'ḃ' => 'b',  'å' => 'a',  'ì' => 'i',  'ï' => 'i',  'ḋ' => 'd',  'ť' => 't',
                    'ŗ' => 'r',  'ä' => 'ae', 'í' => 'i',  'ŕ' => 'r',  'ê' => 'e',  'ü' => 'u',  'ò' => 'o',
                    'ē' => 'e',  'ñ' => 'n',  'ń' => 'n',  'ĥ' => 'h',  'ĝ' => 'g',  'đ' => 'd',  'ĵ' => 'j',
                    'ÿ' => 'y',  'ũ' => 'u',  'ŭ' => 'u',  'ư' => 'u',  'ţ' => 't',  'ý' => 'y',  'ő' => 'o',
                    'â' => 'a',  'ľ' => 'l',  'ẅ' => 'w',  'ż' => 'z',  'ī' => 'i',  'ã' => 'a',  'ġ' => 'g',
                    'ṁ' => 'm',  'ō' => 'o',  'ĩ' => 'i',  'ù' => 'u',  'į' => 'i',  'ź' => 'z',  'á' => 'a',
                    'û' => 'u',  'þ' => 'th', 'ð' => 'dh', 'æ' => 'ae', 'µ' => 'u',  'ĕ' => 'e',  'ı' => 'i',
                ),
                'upper' => array(
                    'À' => 'A',  'Ô' => 'O',  'Ď' => 'D',  'Ḟ' => 'F',  'Ë' => 'E',  'Š' => 'S',  'Ơ' => 'O',
                    'Ă' => 'A',  'Ř' => 'R',  'Ț' => 'T',  'Ň' => 'N',  'Ā' => 'A',  'Ķ' => 'K',  'Ĕ' => 'E',
                    'Ŝ' => 'S',  'Ỳ' => 'Y',  'Ņ' => 'N',  'Ĺ' => 'L',  'Ħ' => 'H',  'Ṗ' => 'P',  'Ó' => 'O',
                    'Ú' => 'U',  'Ě' => 'E',  'É' => 'E',  'Ç' => 'C',  'Ẁ' => 'W',  'Ċ' => 'C',  'Õ' => 'O',
                    'Ṡ' => 'S',  'Ø' => 'O',  'Ģ' => 'G',  'Ŧ' => 'T',  'Ș' => 'S',  'Ė' => 'E',  'Ĉ' => 'C',
                    'Ś' => 'S',  'Î' => 'I',  'Ű' => 'U',  'Ć' => 'C',  'Ę' => 'E',  'Ŵ' => 'W',  'Ṫ' => 'T',
                    'Ū' => 'U',  'Č' => 'C',  'Ö' => 'OE', 'È' => 'E',  'Ŷ' => 'Y',  'Ą' => 'A',  'Ł' => 'L',
                    'Ų' => 'U',  'Ů' => 'U',  'Ş' => 'S',  'Ğ' => 'G',  'Ļ' => 'L',  'Ƒ' => 'F',  'Ž' => 'Z',
                    'Ẃ' => 'W',  'Ḃ' => 'B',  'Å' => 'A',  'Ì' => 'I',  'Ï' => 'I',  'Ḋ' => 'D',  'Ť' => 'T',
                    'Ŗ' => 'R',  'Ä' => 'AE', 'Í' => 'I',  'Ŕ' => 'R',  'Ê' => 'E',  'Ü' => 'UE', 'Ò' => 'O',
                    'Ē' => 'E',  'Ñ' => 'N',  'Ń' => 'N',  'Ĥ' => 'H',  'Ĝ' => 'G',  'Đ' => 'D',  'Ĵ' => 'J',
                    'Ÿ' => 'Y',  'Ũ' => 'U',  'Ŭ' => 'U',  'Ư' => 'U',  'Ţ' => 'T',  'Ý' => 'Y',  'Ő' => 'O',
                    'Â' => 'A',  'Ľ' => 'L',  'Ẅ' => 'W',  'Ż' => 'Z',  'Ī' => 'I',  'Ã' => 'A',  'Ġ' => 'G',
                    'Ṁ' => 'M',  'Ō' => 'O',  'Ĩ' => 'I',  'Ù' => 'U',  'Į' => 'I',  'Ź' => 'Z',  'Á' => 'A',
                    'Û' => 'U',  'Þ' => 'Th', 'Ð' => 'Dh', 'Æ' => 'Ae', 'İ' => 'I'
                )
            ),
            'cyrillic' => array(
                'lower' => array(
                    'а' => 'a', 'б' => 'b', 'в' => 'v', 'г' => 'g','д' => 'd', 'ё' => 'jo',
                    'ж' => 'zh', 'з' => 'z', 'и' => 'i', 'й' => 'ye', 'к' => 'k', 'л' => 'l',
                    'м' => 'm', 'н' => 'n', 'о' => 'o', 'п' => 'p', 'р' => 'r', 'с' => 's', 'т' => 't', 'у' => 'u',
                    'ф' => 'f', 'х' => 'ch', 'ц' => 'z', 'ч' => 'tch', 'ш' => 'sch', 'щ' => 'stch', 'ы' => 'y', 'э' => 'e'
                ),
                'upper' => array(
                    'А' => 'A', 'Б' => 'B', 'В' => 'V', 'Г' => 'G', 'Д' => 'D', 'Е' => 'JE', 'Ё' => 'JO', 'Ж' => 'ZH', 'З' => 'Z',
                    'И' => 'I', 'Й' => 'YE', 'К' => 'K', 'Л' => 'L', 'М' => 'M', 'Н' => 'N', 'О' => 'O', 'П' => 'P', 'Р' => 'R', 'С' => 'S', 'Т' => 'T',
                    'У' => 'U', 'Ф' => 'F', 'Х' => 'CH', 'Ц' => 'Z', 'Ч' => 'TCH', 'Ш' => 'SCH', 'Щ' => 'STCH', 'Э' => 'E', 'Ю' => 'JU', 'Я' => 'JU'
                )
            ),
            'hebrew' => array(
                'lower' => array(
                    '״' => 'u', 'ת' => 't', 'ש' => 'f', 'ר' => 'r', 'ק' => 'q', 'צ' => 'c', 'פ' => 'p', 'ע' => 'e',
                    'ס' => 's', 'נ' => 'n', 'מ' => 'm', 'ל' => 'l', 'כ' => 'k', 'י' => 'i', 'ט' => 'j', 'ח' => 'x',
                    'ז' => 'z', 'ו' => 'w', 'ה' => 'h', 'ד' => 'd', 'ג' => 'g', 'ב' => 'b', 'א' => 'a'
                ),
                'upper' => array()
            ),
            'spanish' => array(
                'lower' => array(
                    'á' => 'a', 'í' => 'i', 'ó' => 'o', 'ú' => 'u', 'ü' => 'u', 'ñ' => 'n', 'º' => 'o', 'ª' => 'a'
                ),
                'upper' => array(
                    'Á' => 'A', 'Í' => 'I', 'Ó' => 'O', 'Ú' => 'U', 'Ü' => 'U', 'Ñ' => 'N'
                )
            ),
            'german' => array(
                'lower' => array(
                    'ä' => 'ae', 'ö' => 'oe', 'ü' => 'ue', 'ß' => 'ss'
                ),
                'upper' => array(
                    'Ä' => 'EA', 'Ö' => 'OE', 'Ü' => 'UE', 'ẞ' => 'SS'
                )
            )

        );

    }

}