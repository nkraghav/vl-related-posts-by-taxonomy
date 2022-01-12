<?php
/**
 * This will add a general option tab to setting for 
 * adding global header and footers
 */
namespace WRL\Includes;
class Autoincludes
{
	public $autoinclude_path;
	function __construct( $path )
	{
		# settings autload path
		$this->set_autoinclude_path( $path );
		# autoinclude options, metaboxes and shortcodes
		$this->autoinclude( );
	}

	function autoinclude( ) {
		foreach ($this->autoinclude_path as $autoinclude_path) {
			$class_path = WRL_PATH . "/" . $autoinclude_path;
			foreach (scandir($class_path) as $file){
				if(preg_match("/.php$/", WRL_PATH . "/" . $autoinclude_path . "/" .$file) !== 1 || ! is_file(WRL_PATH . "/" . $autoinclude_path . "/" .$file))
					continue;
				include_once $class_path . "/" . $file;
			}
		}
	}

	function set_autoinclude_path( $path ) {
		$this->autoinclude_path = $path;
	}
}