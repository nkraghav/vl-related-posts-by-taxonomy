<?php
/**
 * Adds a shortcode for
 * creating three company widgte
 */
class WrlRelatedPosts
{
    private $wpdb;
	function __construct() {
        global $wpdb;
        $this->wpdb = $wpdb;
		# create company widget block
        add_shortcode( 'wrl_related_posts', [ $this, 'add_wrl_related_posts' ] );
	}

    function add_wrl_related_posts( $attr ) {
        # extract attributs
        extract( shortcode_atts( get_option( 'wrl-options' ), $attr ) );
        if( empty( $description_length ) ) $description_length = 20;
        $related_content_data = [];
        foreach (explode(',', $this->get_related_posts_ta()) as $post) :
            if( empty( $post ) ) continue;
            $temp_data = $this->get_title_description( $post, $description_length );
            $temp_data['cta_url'] = get_permalink( $post );
            $temp_data['cta_label'] = 'Read More';
            $related_content_data[] = $temp_data;
        endforeach;
        # start form
        ob_start();
        wp_enqueue_style( 'wp-related-posts', WRL_URL . "/assets/css/wp-related-posts.min.css", null, false );
        include WRL_PATH . "/templates/frontend/" . __FUNCTION__ . ".php";
        $content = ob_get_clean();
		return $content;
    }

    function get_related_posts_ta() {
        $post_id = get_the_ID();
        # get the mapping of the post ids to the pages
        $posts = $this->wpdb->get_row('SELECT wl_assigned_post_id FROM wrl_list WHERE wl_post_id = '.$post_id);
        # if it is empty then create a new list
        if( count( $posts ) < 1 ) {
            return create_random_list( $post_id  );
        }
        return $posts->wl_assigned_post_id;
    }

    function get_title_description( $post_id = null, $length = 20 ) {
        if( empty( $post_id ) ) return '';
        $title = get_the_title( $post_id );
        $description = get_the_content(null, false, $post_id);
        if( ! empty( $description ) ) $description = wp_trim_words(strip_tags(preg_replace('/<h[1-6]>(.*?)<\/h[1-6]>/', '', do_shortcode( $description ))), $length);
        return [
            'title' => $title,
            'description' => apply_filters( 'wrl_post_description', $description, $post_id )
        ];
    }
}