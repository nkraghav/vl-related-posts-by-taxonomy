<?php
    /*
    Plugin Name: WP Related Posts by Taxonomy
    Plugin URI: https://nitinraghav.com/
    Description: This plugin is used to show related posts on the pages.
    Author: Nitin Kumar Raghav
    Author URI: https://nitinraghav.com/
    Version: 0.1
	License: GPLv2 or later
 	Text Domain: related-posts
    */
	# file path
	defined("WRL_PATH") OR define("WRL_PATH", plugin_dir_path( __FILE__ ) );
	# file path
	defined("WRL_PLUGIN") OR define("WRL_PLUGIN", plugin_basename( __FILE__ ));
	# ad block url
	defined("WRL_URL") OR define("WRL_URL", plugin_dir_url( __FILE__ ));
	
	include_once 'includes/autoloads.php';
	include_once 'includes/autoincludes.php';
	include_once 'includes/helper.php';

	/**
	 * Code that runs while activating the plugin
	 */
	function activate_wrl_plugin() {
		include_once 'settings/activate.php';
		new Activate();
	}
	register_activation_hook( __FILE__, 'activate_wrl_plugin' );
	
	/**
	 * Code that runs while deactivating the plugin
	 */
	function deactivate_wrl_plugin() {
		include_once 'settings/deactivate.php';
		new Deactivate();
	}
	register_deactivation_hook( __FILE__, 'deactivate_wrl_plugin' );
	
	/**
	 * Code that runs while deactivating the plugin
	 */
	function uninstall_wrl_plugin() {
		include_once 'settings/uninstall.php';
		new Uninstall();
	}
	register_uninstall_hook( __FILE__, 'uninstall_wrl_plugin' );

	# start including classes
	use WRL\Includes\Autoincludes;
	new AutoIncludes(['classes']);

	/*
	 * Description: Add Related Posts module links in admin menu
	 */
	
	function wrl_admin_menu() {
		add_menu_page('Related Posts', 'Related Posts', 'manage_options', 'wp_related_posts', ['MappingList', 'listing'], 'dashicons-embed-post', 6);
		add_submenu_page('wp_related_posts', 'Mapping List', 'Mapping List', 'manage_options', 'wp_related_posts');
	}
	add_action('admin_menu', 'wrl_admin_menu');

	# start adding autoload classes
	use WRL\Includes\Autoloads;
	new Autoloads(['options', 'taxonomies', 'shortcodes']);