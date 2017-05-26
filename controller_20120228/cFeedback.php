<?php
class CFeedback extends Controllers {

	public function index($type = NULL, $userid = NULL, $nama = NULL) { 
		try{
			#ambil task  list utk side bar
			$this->registry->view->tasklisttop5 = $this->registry->mTask->selectDB_taskTop5(isset($_SESSION['userid'])?$_SESSION['userid']:'',100);
			$this->registry->view->feedback = $this->registry->mFeedback->get_feedback($fbid);
			$this->registry->view->knowledge = $this->registry->mKnowledge->get_newKnowledge();
			$this->registry->view->content = "form_feedback";
			$this->registry->view->show("template");
		}catch(Exception $e){
			$this->registry->error  = $e->getMessage();
			$this->registry->view->content	= 'errorMsg';
			$this->registry->view->show('template');
		}
	}

	public function detail($fbid){
		try{
			//$this->registry->view->tasklist  = $this->registry->mTask->selectDB_task(isset($_SESSION['userid'])?$_SESSION['userid']:'', 100);
			$this->registry->view->tasklisttop5 = $this->registry->mTask->selectDB_taskTop5(isset($_SESSION['userid'])?$_SESSION['userid']:'',100);
			//$this->registry->view->feedback = $this->registry->mFeedback->get_feedback($fbid);	
			$this->registry->view->feedback = $this->registry->mFeedback->get_feedback($fbid);
			$this->registry->view->content = "form_feedback";
 		}catch(Exception $e){
			$this->registry->error  = $e->getMessage();
			$this->registry->view->content	= 'errorMsg';
		}
		$this->registry->view->show("template");
	}
	
	
}
?>	