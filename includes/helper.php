<?php
    function create_random_list( $post_id, $limit = null ) {
        if( empty( $post_id ) ) return '';
        if( empty( $limit ) ) {
            $wrl_options = get_option('wrl-options');
            $limit = $wrl_options['posts_limit'];
        }
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
            $post_types = get_option( 'wrl-options' )['post_types'];
            $post_types = implode('", "', $post_types);
            $posts = $wpdb->get_results('SELECT ID FROM ' . $wpdb->prefix . 'posts p LEFT JOIN ' . $wpdb->prefix . 'term_relationships tr ON (p.ID = tr.object_id) WHERE (tr.term_taxonomy_id IN ('.$term_ids.')) AND p.post_status = "publish" AND p.ID != '.$post_id.' AND p.post_type IN ("' . $post_types . '") GROUP BY p.ID ORDER BY rand() LIMIT ' . $limit, ARRAY_A);
            if(count($posts)){
                $posts = implode(',', array_column($posts, 'ID'));
                $wpdb->query('INSERT INTO wrl_list (wl_post_id, wl_assigned_post_id) VALUES ('.$post_id.', "'.$posts.'")');
                return $posts;
            }
        }
        return '';
    }