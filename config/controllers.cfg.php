<?php

abstract class Controllers {

	protected $registry;
	
	public function __construct($registry) {
		$this->registry = $registry;
	}
	
	#semua class controller harus mempunyai function index
	abstract function index();
}

?>
