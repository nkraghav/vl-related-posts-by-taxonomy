<?php
    class VrpMappingList {
        private static $wpdb;
        private static $list;

        public static function listing() {
            # connect db
            self::connect_db();
            # get data
            self::get_list();
            ob_start();
            wp_enqueue_style('vrp_style', VRP_URL . '/assets/css/admin-block.min.css', array(), microtime());
            wp_enqueue_script( 'vrp_script', VRP_URL . '/assets/js/script.js', array(), microtime() );
            $vrp_info = [
                'ajax_url' => site_url('/wp-json/vrp/v1/'),
                'theme_url' => get_theme_file_uri(),
                'vrp_url' => VRP_URL,
            ];
            wp_localize_script('vrp_script', 'vrp_info', $vrp_info);
            include_once VRP_PATH . "/templates/classes/" . __FUNCTION__ . ".php";
            $content = ob_get_clean();
            echo wp_kses_post($content);
        }

        private static function connect_db() {
            global $wpdb;
            self::$wpdb = $wpdb;
        }

        private static function get_list() {
            $sql = 'SELECT * FROM vrp_list';
            self::$list = self::$wpdb->get_results($sql);
        }
    }
?>