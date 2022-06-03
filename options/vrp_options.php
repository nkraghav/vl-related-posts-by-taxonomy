<?php
/**
 * This will add a general option tab to setting for 
 * adding global header and footers
 */
class VrpOptions
{
	public $defaults = [];
	function __construct( )
	{
		$this->set_defaults();
		/* for adding option to settings */
		add_action('admin_menu', [ $this, 'vrp_options_admin_menu' ]);
	}

	function vrp_options_admin_menu( ) {
		if ( !current_user_can( 'manage_options' ) )
			return;
		add_submenu_page('vrp_related_posts', 'Options', 'Options', 'manage_options', 'vrp_options', [ $this, 'vrp_options' ], 2);
	}

	function vrp_options() {
		$vrp_options = get_option( 'vrp-options', $this->get_defaults( ) );
		if( isset( $_POST['vrp_options'] ) ) {
			// $post_data = $_POST;
			// array_walk_recursive($post_data, 'sanitize_text_field');
			$post_types = $_POST['post_types'];
			array_walk($post_types, function(&$value, &$key) {
				$value = sanitize_text_field($value);
			});
			$vrp_options = [
				'posts_limit' => sanitize_text_field($_POST['posts_limit']),
				'heading' => sanitize_text_field( $_POST['heading'] ),
				'post_types' => $post_types,
				'description_length' => sanitize_text_field($_POST['description_length']),
				'sort_by' => sanitize_text_field( $_POST['sort_by'] ),
				'rp_template' => wp_kses( $_POST['rp_template'], array_merge( wp_kses_allowed_html(), ['vrp-repeater-main' => [], 'vrp-repeater-no-result' => '', 'div' => ['class' => true], 'p' => [], 'h4' => [], 'h5' => [] ]) ),
			];
			update_option('vrp-options', $vrp_options );
			$vrp_options = get_option( 'vrp-options' );
		}
		extract( $vrp_options );
		ob_start();
		wp_enqueue_style('vrp_option_style', VRP_URL . '/assets/css/vrp-related-posts-options.min.css', array(), microtime());
		wp_enqueue_script( 'vrp_script', VRP_URL . '/assets/js/script.js', array(), microtime() );
		$vrp_info = [
			'ajax_url' => site_url('/wp-json/vrp/v1/'),
			'theme_url' => get_theme_file_uri(),
			'vrp_url' => VRP_URL,
		];
		wp_localize_script('vrp_script', 'vrp_info', $vrp_info);
		include_once VRP_PATH . "/templates/options/" . __FUNCTION__ . ".php";
		$content = ob_get_clean();
		echo html_entity_decode($content);
	}

	function set_defaults( ) {
        $this->defaults = [
			'posts_limit' => 5,
			'heading' => 'Related Posts',
			'post_types' => ['post', 'page'],
			'description_length' => 20,
			'sort_by' => 'random',
			'rp_template' => file_get_contents( VRP_PATH . "/templates/frontend/add_vrp_related_posts_default.php" ),
		];
	}

	function get_defaults( ) {
		return $this->defaults;
	}
}