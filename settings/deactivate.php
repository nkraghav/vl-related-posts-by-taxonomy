<?php
    class Deactivate
    {
		private $wpdb;

		function __construct() {
			// parent::__construct();
			// $this->deactivate();
		}

		public function deactivate()
		{
            global $wpdb;
            $this->wpdb = $wpdb;
            if( get_option( 'wrl-options' ) )
                delete_option( 'wrl-options' );
            # generate table
            $this->tbl_drop();
        
            // flush rewrite rules
            flush_rewrite_rules();
		}
		public function tbl_drop()
		{
			$sql = "DROP TABLE IF EXISTS `wrl_list`";
			$this->wpdb->query($sql);
		}
    }