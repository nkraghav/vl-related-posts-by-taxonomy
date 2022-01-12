<?php
    class Activate
    {
        # global db object
        private $wpdb;

		function __construct() {
			// parent::__construct();
			$this->activate();
		}

        private function activate()
        {
            global $wpdb;
            $this->wpdb = $wpdb;
            if( ! get_option( 'wrl-options' ) )
            {
                $defaults = [
                    'posts_limit' => 5,
                    'heading' => 'Related Posts',
                    'description_length' => 75,
                    'post_types' => [
                        'post',
                        'page',
                    ],
                    'sort_by' => 'random',
                ];
                add_option( 'wrl-options', $defaults );
            }
            # generate table
            $this->create_table();
        
            // flush rewrite rules
            flush_rewrite_rules();
        }

        private function create_table()
        {
            $sql = "CREATE TABLE IF NOT EXISTS `wrl_list` (
                `wl_id` int(11) NOT NULL AUTO_INCREMENT,
                `wl_post_id` int(11) NOT NULL,
                `wl_assigned_post_id` varchar(200) NOT NULL,
                `wl_created_time` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
                PRIMARY KEY (`wl_id`)
              ) ENGINE=InnoDB DEFAULT CHARSET=utf8";
            return $this->wpdb->query($sql);
        }
    }