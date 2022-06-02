<?php
    class VrpActivate
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
            if( ! get_option( 'vrp-options' ) )
            {
                $defaults = [
                    'posts_limit' => 5,
                    'heading' => 'Related Posts',
                    'description_length' => 20,
                    'post_types' => [
                        'post',
                        'page',
                    ],
                    'sort_by' => 'random',
                    'rp_template' => file_get_contents( VRP_PATH . "/templates/frontend/add_vrp_related_posts_default.php" ),
                ];
                add_option( 'vrp-options', $defaults );
            }
            # generate table
            $this->create_table();
        
            // flush rewrite rules
            flush_rewrite_rules();
        }

        private function create_table()
        {
            $sql = "CREATE TABLE IF NOT EXISTS `vrp_list` (
                `wl_id` int(11) NOT NULL AUTO_INCREMENT,
                `wl_post_id` int(11) NOT NULL,
                `wl_assigned_post_id` varchar(200) NOT NULL,
                `wl_created_time` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
                PRIMARY KEY (`wl_id`)
              ) ENGINE=InnoDB DEFAULT CHARSET=utf8";
            return $this->wpdb->query($sql);
        }
    }