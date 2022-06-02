<?php
    function vrp_create_random_list( $post_id ) {
        if( empty( $post_id ) ) return '';
        # get the terms attached to the page
        $ta_terms = get_the_terms($post_id, 'ta-tag');
        $term_ids = [];
        foreach ($ta_terms as $key => $value) {
            $term_ids[] = $value->term_id;
        }
        # if terms exists then get the related posts
        if( $term_ids !== false ) {
            global $wpdb;
            $term_ids = implode(', ', $term_ids);
            # get vrp options
            $vrp_options = get_option( 'vrp-options' );
            # get posts limit to fetch for a page
            $limit = $vrp_options['posts_limit'];
            # get sort by order
            $sort_by = $vrp_options['sort_by'];
            # get posts types where the tags are enabled
            $post_types = $vrp_options['post_types'];
            $post_types = implode('", "', $post_types);
            $posts = $wpdb->get_results('SELECT ID FROM ' . $wpdb->prefix . 'posts p LEFT JOIN ' . $wpdb->prefix . 'term_relationships tr ON (p.ID = tr.object_id) WHERE (tr.term_taxonomy_id IN ('.$term_ids.')) AND p.post_status = "publish" AND p.ID != '.$post_id.' AND p.post_type IN ("' . $post_types . '") GROUP BY p.ID ORDER BY rand() LIMIT ' . $limit, ARRAY_A);
            if(count($posts)){
                $posts = implode(',', array_column($posts, 'ID'));
                $wpdb->query('INSERT INTO vrp_list (wl_post_id, wl_assigned_post_id) VALUES ('.$post_id.', "'.$posts.'")');
                return $posts;
            }
        }
        return '';
    }