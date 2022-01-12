<?php
/**
 * This will add a settings link
 * adding global header and footers
 */
class Settings
{
	function __construct( )
	{
		/* for adding option to settings */
        $plugin = plugin_basename(__FILE__);
        add_filter('plugin_action_links_' . WRL_PLUGIN, [$this, 'wrl_settings_link'] );
	}

    function wrl_settings_link($links) {
        $settings_link = '<a href="admin.php?page=wrl_options">Options</a>';
        array_unshift($links, $settings_link);
        return $links;
    }
}