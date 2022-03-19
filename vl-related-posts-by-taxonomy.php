<?php
/**
 * Plugin Name: VL Related Posts by Taxonomy
 * Description: This plugin is used to show related posts on the pages.
 * Version: 0.1
 * Requires PHP: 7.0
 * Requires at least: 5.2
 * Author: Nitin Kumar Raghav <mails@nitinraghav.com>
 * Author URI: https://nitinraghav.com/
 * License: GPLv2 or later
 * Text Domain: vl-related-posts-by-taxonomy
 * Tags: vl-related-posts-by-taxonomy, contextual-related-posts, related, related-articles, related-posts, similar-posts
 */
	# file path
	defined("VRP_PATH") OR define("VRP_PATH", plugin_dir_path( __FILE__ ) );
	# file path
	defined("VRP_PLUGIN") OR define("VRP_PLUGIN", plugin_basename( __FILE__ ));
	# ad block url
	defined("VRP_URL") OR define("VRP_URL", plugin_dir_url( __FILE__ ));
	
	include_once 'includes/autoloads.php';
	include_once 'includes/autoincludes.php';
	include_once 'includes/helper.php';

	/**
	 * Code that runs while activating the plugin
	 */
	function activate_vrp_plugin() {
		include_once 'settings/vrp_activate.php';
		new VrpActivate();
	}
	register_activation_hook( __FILE__, 'activate_vrp_plugin' );
	
	/**
	 * Code that runs while deactivating the plugin
	 */
	function deactivate_vrp_plugin() {
		include_once 'settings/vrp_deactivate.php';
		new VrpDeactivate();
	}
	register_deactivation_hook( __FILE__, 'deactivate_vrp_plugin' );
	
	/**
	 * Code that runs while deactivating the plugin
	 */
	function uninstall_vrp_plugin() {
		include_once 'settings/vrp_uninstall.php';
		new VrpUninstall();
	}
	register_uninstall_hook( __FILE__, 'uninstall_vrp_plugin' );

	# start including classes
	use VRP\Includes\Autoincludes;
	new AutoIncludes(['classes']);

	/*
	 * Description: Add Related Posts module links in admin menu
	 */
	
	function wrl_admin_menu() {
		add_menu_page('Related Posts', 'Related Posts', 'manage_options', 'vrp_related_posts', ['VrpMappingList', 'listing'], 'dashicons-embed-post', 6);
		add_submenu_page('vrp_related_posts', 'Mapping List', 'Mapping List', 'manage_options', 'vrp_related_posts');
	}
	add_action('admin_menu', 'wrl_admin_menu');

	# start adding autoload classes
	use VRP\Includes\Autoloads;
	new Autoloads(['options', 'taxonomies', 'shortcodes']);