<?php
/**
 * This will add a general option tab to setting for 
 * adding global header and footers
 */
namespace VRP\Includes;
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
			$class_path = VRP_PATH . "/" . $autoinclude_path;
			foreach (scandir($class_path) as $file){
				if(preg_match("/.php$/", VRP_PATH . "/" . $autoinclude_path . "/" .$file) !== 1 || ! is_file(VRP_PATH . "/" . $autoinclude_path . "/" .$file))
					continue;
				$filename = $class_path . '/' . $file;
				if( validate_file($filename) === 0 ) include_once $filename;
			}
		}
	}

	function set_autoinclude_path( $path ) {
		$this->autoinclude_path = $path;
	}
}