<?php
	/**
	 * Adds a txonomy for
	 * TA Pages
	 */
	class VrpTaTags
	{
		function __construct() {
			add_action( 'init', [$this, 'vrp_register_taxonomy'] );
		}
		
		function vrp_register_taxonomy() {
			$vrp_options = get_option( 'vrp-options' );
			$labels = array(
				'name'              => _x( 'VRP Tags', 'taxonomy general name' ),
				'singular_name'     => _x( 'VRP Tag', 'taxonomy singular name' ),
				'search_items'      => __( 'Search VRP Tags' ),
				'all_items'         => __( 'All VRP Tags' ),
				'parent_item'       => __( 'Parent VRP Tag' ),
				'parent_item_colon' => __( 'Parent VRP Tag:' ),
				'edit_item'         => __( 'Edit VRP Tag' ),
				'update_item'       => __( 'Update VRP Tag' ),
				'add_new_item'      => __( 'Add New VRP Tag' ),
				'new_item_name'     => __( 'New VRP Tag Name' ),
				'menu_name'         => __( 'VRP Tag' ),
			);
			$args   = array(
				'hierarchical'      => true, // make it hierarchical (like categories)
				'labels'            => $labels,
				'show_ui'           => true,
				'show_admin_column' => true,
				'query_var'         => true,
				'rewrite'           => [ 'slug' => 'vrp-tag' ],
			);
			if( ! empty($vrp_options['post_types']) ) register_taxonomy( 'vrp-tag', $vrp_options['post_types'], $args );
		}
	}