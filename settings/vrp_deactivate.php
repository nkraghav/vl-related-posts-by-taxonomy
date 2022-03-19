<?php
    class VrpDeactivate
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
            if( get_option( 'vrp-options' ) )
                delete_option( 'vrp-options' );
            # generate table
            $this->tbl_drop();
        
            // flush rewrite rules
            flush_rewrite_rules();
		}
		public function tbl_drop()
		{
			$sql = "DROP TABLE IF EXISTS `vrp_list`";
			$this->wpdb->query($sql);
		}
    }