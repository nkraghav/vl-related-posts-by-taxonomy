<?php
/**
 * This will add a general option tab to setting for 
 * adding global header and footers
 */
namespace VRP\Includes;
class Autoloads
{
	public $autoload_path;
	function __construct( $path )
	{
		# settings autload path
		$this->set_autoload_path( $path );
		# autoload options, metaboxes and shortcodes
		$this->autoload( );
	}

	function autoload( ) {
		foreach ($this->autoload_path as $autoload_path) {
			$class_path = VRP_PATH . "/" . $autoload_path;
			foreach (scandir($class_path) as $file){
				if(preg_match("/.php$/", VRP_PATH . "/" . $autoload_path . "/" .$file) !== 1 || ! is_file(VRP_PATH . "/" . $autoload_path . "/" .$file))
					continue;
				$filename = $class_path . '/' . $file;
				if( validate_file($filename) === 0 ) include_once $filename;
				$class = explode('_', preg_replace("/.php$/", "", $file));
				# if class starts from '_' then we will not instantiate that
				if( $class[0] !== "" ) {
					array_walk($class, function(&$value){ $value = ucwords($value); });
					$class = implode("", $class);
					if( class_exists($class) )
						new $class;
				}
			}
		}
	}

	function set_autoload_path( $path ) {
		$this->autoload_path = $path;
	}
}