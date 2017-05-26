<?php

class CStaffing extends Controllers {
	
	public function index(){ 
		try{
			$this->registry->view->datauser 	= $this->registry->mUser->selectDB_userLevel('','','no');
			$this->registry->view->setWindowActive = NULL;     		
			$this->registry->view->content='grid_managementUser';
		}catch(Exception $e){
			$this->registry->error  = $e->getMessage();
			$this->registry->view->content	= 'errorMsg';
		}
		$this->registry->view->show('template');
	}
	
	/*public function detail($userid){
		try{
			$this->registry->view->datauser 	= $this->registry->mUser->selectDB_userLevel();  
			$this->registry->view->setWindowActive = 'detail'; 
			$this->registry->view->datauserid = $this->registry->mUser->selectDB_userID($userid);
 		
			$this->registry->view->content='grid_managementUser';
		}catch(Exception $e){
			$this->registry->error  = $e->getMessage();
			$this->registry->view->content	= 'errorMsg';
		}
		$this->registry->view->show('template');
	}
	
	public function edit($userid){
		try{
			$this->registry->view->datauser 	= $this->registry->mUser->selectDB_userLevel();  
			$this->registry->view->setWindowActive = 'edit'; 
			$this->registry->view->datauserid = $this->registry->mUser->selectDB_userID($userid);
 		
			$this->registry->view->content='grid_managementUser';
		}catch(Exception $e){
			$this->registry->error  = $e->getMessage();
			$this->registry->view->content	= 'errorMsg';
		}
		$this->registry->view->show('template');
	}*/
	
	public function unlock(){
		try{
			$this->registry->mUser->updateUser_unlock($_POST['userid'], md5($_POST['tPass']));	
			echo "<script>location.href=\"index.php?mod=staffing\";</script>";
		}catch(Exception $e){
			$this->registry->error  = $e->getMessage();
			$this->registry->view->content	= 'errorMsg';
		}
		$this->registry->view->show('template');
	}
	
	public function lock($userid){
		try{
			$this->registry->mUser->updateUser_lock($userid);	
			echo "<script>location.href=\"index.php?mod=staffing\";</script>";
		}catch(Exception $e){
			$this->registry->error  = $e->getMessage();
			$this->registry->view->content	= 'errorMsg';
		}
		$this->registry->view->show('template');
	}
	
	public function saveUser(){
		try{
			$this->registry->mUser->edit_userDetail($_POST['hUser_id'],$_POST['tUser_id'],$_POST['tName'], 
				$_POST['tEmail'], $_POST['tHire'],$_POST['addr'],$_POST['tPhone'], $_POST['leveluser_id'], 
				$_POST['HRDstat'], $_POST['setWindowActive']);	
			//$this->registry->view->content='grid_managementUser';
		}catch(Exception $e){
			$this->registry->error  = $e->getMessage();
			$this->registry->view->content	= 'errorMsg';
		}
			//$this->registry->view->show('template');
	}
	
	public function delete($userid){
		try{
			$this->registry->mUser->delete_userDetail($userid);	
			echo "<script>location.href=\"index.php?mod=staffing\";</script>";
		}catch(Exception $e){
			$this->registry->error  = $e->getMessage();
			$this->registry->view->content	= 'errorMsg';
			$this->registry->view->show('template');
		}
	}
		
	/*public function saveUserLock(){ 
		try{
			if($_POST['setWindowActive'] == 'lock')
				$this->registry->mUser->updateUser_lock($_POST['userid']);	
			else
				$this->registry->mUser->updateUser_unlock($_POST['userid'], md5($_POST['tPass']));	
			echo "<script>location.href=\"index.php?mod=staffing\";</script>";
		}catch(Exception $e){
			$this->registry->error  = $e->getMessage();
			$this->registry->view->content	= 'errorMsg';
			$this->registry->view->show('template');
		}
	}*/
	
}
?>