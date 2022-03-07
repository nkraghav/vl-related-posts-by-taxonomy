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
        # return empty if related posts is not enabled on current post type
        if( empty($post_types) || ! is_array($post_types) || ! in_array( get_post_type(), $post_types ) ) return;
        # set description length if not defined
        if( empty( $description_length ) ) $description_length = 20;
        $related_content_data = [];
        foreach (explode(',', $this->get_related_posts_ta()) as $post) :
            if( empty( $post ) ) continue;
            $temp_data = $this->get_title_description( $post, $description_length );
            $temp_data['post_url'] = get_permalink( $post );
            $related_content_data[] = $temp_data;
        endforeach;
        # start form
        ob_start();
        wp_enqueue_style( 'wp-related-posts', WRL_URL . "assets/css/style.min.css", null, false );
        # if no custom template found, get the default template
        if( empty( $rp_template ) )
            $rp_template = file_get_contents( WRL_PATH . "/templates/frontend/" . __FUNCTION__ . "_default.php" );
        include WRL_PATH . "/templates/frontend/" . __FUNCTION__ . ".php";
        $content = ob_get_clean();
		return $content;
    }

    function get_related_posts_ta() {
        $post_id = get_the_ID();
        # get the mapping of the post ids to the pages
        $posts = $this->wpdb->get_row('SELECT wl_assigned_post_id FROM wrl_list WHERE wl_post_id = '.$post_id, ARRAY_A);
        # if it is empty then create a new list
        if( ! empty($posts) && is_array($posts) && count( $posts ) < 1 ) {
            return create_random_list( $post_id  );
        }
        return $posts->wl_assigned_post_id;
    }

    function get_title_description( $post_id = null, $length = 20 ) {
        if( empty( $post_id ) ) return '';
        $title = get_the_title( $post_id );
        $description = get_the_content(null, false, $post_id);
        if( ! empty( $description ) ) {
            $description = preg_replace('/<h[1-6]>(.*?)<\/h[1-6]>/', '', $description );
            $description = preg_replace('/\[table(.*?)\]/', '', $description );
            $description = wp_trim_words(strip_tags( do_shortcode( $description )), $length);
        }
        return [
            'title' => $title,
            'description' => apply_filters( 'wrl_post_description', $description, $post_id )
        ];
    }
}