<?php

class router {

	private $registry;
 	private $path;	
	private $file;
	private $param1;
 	private $param2;
 	private $param3;
 	private $param4;
 	private $param5;
	
	public $controller;
	public $action; 
 
	public function __construct($registry) {
		$this->registry = $registry;
	}

	# @set controller directory path
	# @param string $path
	# @return void
	public function setPath($path) {

		# check if path i sa directory
		if (is_dir($path) == false){
			throw new Exception ('Controller path tidak valid : `' . $path . '`');
		}
		# set the path
	 	$this->path = $path;
	}


	# @load the controller
	# @access public
	# @return void
	public function loader(){
		# check the route
		$this->getController();
		
		# if the file is not exist
		if (is_readable($this->file) == false){
			$this->file = $this->path.'/cError'.EXT;
            $this->controller = 'error';
			$this->action = 'error_404';
		}

		# include the controller
		include $this->file;

		# a new controller class instance
		$class = 'C'.$this->controller;
		$controller = new $class($this->registry);

		# check if the action is callable
		if (is_callable(array($controller, $this->action)) == false){
			$action = 'index';
		}else{
			$action = $this->action;
		}
		
		# run the action
		if(isset($this->param1)){
			if(isset($this->param2)){
				if(isset($this->param3)){
					if(isset($this->param4)){
						if(isset($this->param5)){
							$controller->$action($this->param1, $this->param2, $this->param3, $this->param4, $this->param5);
						}else
							$controller->$action($this->param1, $this->param2, $this->param3, $this->param4);
					}else
						$controller->$action($this->param1, $this->param2, $this->param3);
				}else
					$controller->$action($this->param1, $this->param2);		
			}else
				$controller->$action($this->param1);
		}else
			$controller->$action();
		
	}

	# @get the controller
	# @access private
	# @return void
	private function getController() {

		# get the route from the url
		$route = (empty($_GET['mod'])) ? '' : $_GET['mod'];

		if (empty($route)){
			$route = 'index';
		}else{
			# get the parts of the route
			$parts = explode('/', $route);
			
			# controller / class
			$this->controller = $parts[0];
			
			# function
			if(isset( $parts[1])){
				$this->action = $parts[1];
				$this->url[1] = $parts[1];
			}
			
			# param 1
			if(isset( $parts[2])){
				$this->param1 = $parts[2];
				$this->url[2] = $parts[2];
			}
			
			#param 2
			if(isset( $parts[3])){
				$this->param2 = $parts[3];
				$this->url[3] = $parts[3];
			}
			
			#param 3
			if(isset( $parts[4])){
				$this->param3 = $parts[4];
				$this->url[4] = $parts[4];
			}
			
			#param 4
			if(isset( $parts[5])){
				$this->param4 = $parts[5];
				$this->url[5] = $parts[5];
			}
			#param 5
			if(isset( $parts[6])){
				$this->param5 = $parts[6];
				$this->url[6] = $parts[6];
			}
		}
		
		if (empty($this->controller)){
			$this->controller = 'index';
		}

		# Get action
		if (empty($this->action)){
			$this->action = 'index';
		}

		# set the file path
		$this->file = $this->path .'/c'. ucfirst($this->controller) . EXT;
	}


}

?>
