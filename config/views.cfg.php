<?php

class Views {

	private $registry;
	private $vars = array();

	
	# @constructor
	# @access public
	# @return void
	public function __construct($registry) {
		$this->registry = $registry;
	}

	# @set vars
	# @param string $index
	# @param mixed $value
	# @return void
	public function __set($index, $value){
	    $this->vars[$index] = $value;
	 }

	public function show($name) {
		$path = SITE_PATH . '/views' . '/' . $name . EXT;

		if (file_exists($path) == false) {
			throw new Exception('Template tidak ditemukan di "'. $path.'"');
			return false;
		}
		
		# Load variables
		foreach ($this->vars as $key => $value){
			$$key = $value;
		}

		include ($path);               
	}

}

?>
