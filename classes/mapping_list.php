<?php
    class MappingList {
        private static $wpdb;
        private static $list;

        public static function listing() {
            # connect db
            self::connect_db();
            # get data
            self::get_list();
            ob_start();
            wp_enqueue_style('wrl_style', WRL_URL . '/assets/css/admin-block.min.css', array(), microtime());
            wp_enqueue_script( 'wrl_script', WRL_URL . '/assets/js/script.js', array(), microtime() );
            $wrl_info = [
                'ajax_url' => site_url('/wp-json/wrl/v1/'),
                'theme_url' => get_theme_file_uri(),
                'wrl_url' => WRL_URL,
            ];
            wp_localize_script('wrl_script', 'wrl_info', $wrl_info);
            include_once WRL_PATH . "/templates/classes/" . __FUNCTION__ . ".php";
            $content = ob_get_clean();
            echo $content;
        }

        private static function connect_db() {
            global $wpdb;
            self::$wpdb = $wpdb;
        }

        private static function get_list() {
            $sql = 'SELECT * FROM wrl_list';
            self::$list = self::$wpdb->get_results($sql);
        }
    }
?>