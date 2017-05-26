<?php
class CTask extends Controllers {

	public function index(){
		$this->registry->view->tasklist = $this->registry->mTask->selectDB_task();
		$this->registry->view->task = $this->registry->mTask->selectDB_task();
		$this->registry->view->content = "form_task";
		$this->registry->view->show("template");
	}
	/* public function updateTask($taskid, $task, $status){
		try{
			$this->registry-mTask->updateDB_userTask($taskid, $task, $status);
		}catch(Exception $e){
			$this->registry->error  = $e->getMessage();
			$this->registry->view->content	= 'errorMsg';
			$this->registry->view->show ('template');
		}
	} */
}
?>