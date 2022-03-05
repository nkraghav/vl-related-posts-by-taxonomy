<?php
/**
 * This will add a general option tab to setting for 
 * adding global header and footers
 */
class Options
{
	public $defaults = [];
	function __construct( )
	{
		$this->set_defaults();
		/* for adding option to settings */
		add_action('admin_menu', [ $this, 'wrl_options_admin_menu' ]);
	}

	function wrl_options_admin_menu( ) {
		if ( !current_user_can( 'manage_options' ) )
			return;
		add_submenu_page('wp_related_posts', 'Options', 'Options', 'manage_options', 'wrl_options', [ $this, 'wrl_options' ], 2);
	}

	function wrl_options() {
		$wrl_options = get_option( 'wrl-options', $this->get_defaults( ) );
		if( isset( $_POST['wrl_options'] ) ) {
			$wrl_options = [
				'posts_limit' => $_POST['posts_limit'],
				'heading' => stripslashes( $_POST['heading'] ),
				'post_types' => $_POST['post_types'],
				'description_length' => $_POST['description_length'],
				'sort_by' => stripslashes( $_POST['sort_by'] ),
				'rp_template' => stripslashes( $_POST['rp_template'] ),
			];
			update_option('wrl-options', $wrl_options );
			$wrl_options = get_option( 'wrl-options' );
		}
		extract( $wrl_options );
		ob_start();
		wp_enqueue_style('wrl_option_style', WRL_URL . '/assets/css/wp-related-posts-options.min.css', array(), microtime());
		wp_enqueue_script( 'wrl_script', WRL_URL . '/assets/js/script.js', array(), microtime() );
		$wrl_info = [
			'ajax_url' => site_url('/wp-json/wrl/v1/'),
			'theme_url' => get_theme_file_uri(),
			'wrl_url' => WRL_URL,
		];
		wp_localize_script('wrl_script', 'wrl_info', $wrl_info);
		include_once WRL_PATH . "/templates/options/" . __FUNCTION__ . ".php";
		$content = ob_get_clean();
		echo $content;
	}

	function set_defaults( ) {
        $this->defaults = [
			'posts_limit' => 5,
			'heading' => 'Related Posts',
			'post_types' => [],
			'description_length' => 20,
			'sort_by' => 'random',
			'rp_template' => file_get_contents( WRL_PATH . "/templates/frontend/add_wrl_related_posts_default.php" ),
		];
	}

	function get_defaults( ) {
		return $this->defaults;
	}
}