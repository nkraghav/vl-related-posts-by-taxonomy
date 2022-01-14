<?php
/**
 * This will add a general option tab to setting for 
 * adding global header and footers
 */
class RestApis
{
	public $defaults = [];
	function __construct( )
	{
        add_action( 'rest_api_init', function(){
            register_rest_route( 'wrl/v1', 'refresh-list', ['methods' => 'POST', 'callback' => [$this, 'refresh_list_ajax'], 'show_in_index' => false] );
        } );
	}

    function refresh_list_ajax(\WP_REST_Request $request) {
        $post_id = $request['post_id'];
        $index = $request['index'];
        if ((!$post_id && $post_id != 0 ) || !$index)
            return new \WP_Error('no_id', 'Missing ID or Index', ['status' => 400]);
        global $wpdb;
        if( $post_id == 0 ) {
            $wpdb->query('TRUNCATE TABLE wrl_list');
            return ['status' => 'ok', 'content' => 'reload' ];
        }
        else {
            $wpdb->query('DELETE FROM wrl_list WHERE wl_post_id = ' . $post_id);
            $updated_list = create_random_list( $post_id );
            if ( ! empty( $updated_list ) ) {
                ob_start();
                include WRL_PATH . "/templates/options/" . __FUNCTION__ . ".php";
                $content = ob_get_clean();
                return ['status' => 'ok', 'content' => $content ];
            } else {
                return ['status' => 'fail', 'content' => ''];
            }
        }
    }
}