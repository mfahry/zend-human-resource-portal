<?php
class CStatus extends Controllers {

	public function index() {
		$this->registry->view->datawall = $this->registry->mStatus->SelectMyWall($_SESSION['userid']);
		$this->registry->view->content = "Form_WallStatus";
		$this->registry->view->show("template");
	}
/*	
	public function status(){
		try{
			$this->registry->mStatus->Status();
		}catch(Exception $e){
			$this->registry->error  = $e->getMessage();
			$this->registry->view->content	= 'errorMsg';
		}
		$this->registry->view->show('template');
	
	}
*/
	public function UpdateComment(){
		try{
			$comment=$_POST['comment_value'];
			$commentexp = explode('||^|',$comment);
			$comment = $commentexp[0];
			$msg_id=$commentexp[1];
			$this->registry->mStatus->UpdateComment($comment,$msg_id);
		}catch(Exception $e){
			$this->registry->error  = $e->getMessage();
			$this->registry->view->content	= 'errorMsg';
			$this->registry->view->show('template');
		}
	}
	
	public function DeleteComment(){
		try{
			$this->registry->mStatus->DeleteComment($comment_id);
		}catch(Exception $e){
			$this->registry->error  = $e->getMessage();
			$this->registry->view->content	= 'errorMsg';
			$this->registry->view->show('template');
		}
	}
	
	public function UpdateStatus(){
		try{
			$this->registry->mStatus->UpdateStatus($_POST['content']);
		}catch(Exception $e){
			$this->registry->error  = $e->getMessage();
			$this->registry->view->content	= 'errorMsg';
			$this->registry->view->show('template');
		}
	}
	
	public function DeleteStatus(){
		try{
			if($_POST['msg_id'])
			{
			$this->registry->mStatus->DeleteStatus($_POST['msg_id']);
			}
		}catch(Exception $e){
			$this->registry->error  = $e->getMessage();
			$this->registry->view->content	= 'errorMsg';
			$this->registry->view->show('template');
		}
	}

}
?>