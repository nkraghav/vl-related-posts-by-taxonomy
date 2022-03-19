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
            $wrl_options = get_option( 'vrp-options' );
            $labels = array(
                'name'              => _x( 'TA Tags', 'taxonomy general name' ),
                'singular_name'     => _x( 'TA Tag', 'taxonomy singular name' ),
                'search_items'      => __( 'Search TA Tags' ),
                'all_items'         => __( 'All TA Tags' ),
                'parent_item'       => __( 'Parent TA Tag' ),
                'parent_item_colon' => __( 'Parent TA Tag:' ),
                'edit_item'         => __( 'Edit TA Tag' ),
                'update_item'       => __( 'Update TA Tag' ),
                'add_new_item'      => __( 'Add New TA Tag' ),
                'new_item_name'     => __( 'New TA Tag Name' ),
                'menu_name'         => __( 'TA Tag' ),
            );
            $args   = array(
                'hierarchical'      => true, // make it hierarchical (like categories)
                'labels'            => $labels,
                'show_ui'           => true,
                'show_admin_column' => true,
                'query_var'         => true,
                'rewrite'           => [ 'slug' => 'ta-tag' ],
            );
            if( ! empty($wrl_options['post_types']) ) register_taxonomy( 'ta-tag', $wrl_options['post_types'], $args );
        }
}