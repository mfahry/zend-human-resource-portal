<?php

class CIndex extends Controllers {
	
	public function index() {
		try{
 			$this->registry->view->tasklisttop5 = $this->registry->mTask->selectDB_taskTop5(isset($_SESSION['userid'])?$_SESSION['userid']:'',100);
			$this->registry->view->knowledge = $this->registry->mKnowledge->get_newKnowledge();
			if(isset($_SESSION['userid']) && ($_SESSION['userid'] != NULL)){ 
				if($_SESSION['level_id'] == 3){ 
					$this->registry->view->dataUnion = $this->registry->mStatus->selectDB_homeUnion();
 					$this->registry->view->content	= 'form_home';
					
				}else $this->registry->view->content = 'confirm_welcome';				
			}else $this->registry->view->content = "form_artikel";
 		}catch(Exception $e){
			$this->registry->error  = $e->getMessage();
			$this->registry->view->content	= 'errorMsg';
		}
		
		$this->registry->view->show('template');
	}
	
	public function previousWall(){
		try{
			$data = $this->registry->mStatus->selectDB_homeUnion('',$_POST['limitfrom'],5);				
            $this->registry->mStatus->format_wall($data, 'previous');
			
		}catch(Exception $e){
			echo $e->getMessage();	
		}
	}
	
	public function notifComment($identity, $id, $commentid){
		try{  
			$this->registry->view->tasklist = $this->registry->mTask->selectDB_task(isset($_SESSION['userid'])?$_SESSION['userid']:'');
			
			if($identity == 'knowledge'){
				$this->registry->view->dataUnion = $this->registry->mKnowledge->selectDB_knowledgeDetail($id); 
			}elseif($identity == 'wall'){
				$this->registry->view->dataUnion = $this->registry->mStatus->selectDB_wallDetail($id); 
			}elseif($identity == 'task'){ 
				$this->registry->view->dataUnion = $this->registry->mTask->selectDB_taskDetail($id); 
			}elseif($identity == 'attendance_in'){
				$this->registry->view->dataUnion = $this->registry->mAbsensiHarian->selectDB_attendance_inDetail($id);
			}elseif($identity == 'attendance_out'){
				$this->registry->view->dataUnion = $this->registry->mAbsensiHarian->selectDB_attendance_outDetail($id);
			}elseif($identity == 'attendance_summary'){
				$this->registry->view->dataUnion = $this->registry->mAbsensiHarian->selectDB_attendance_summaryDetail($id);
			}elseif($identity == 'attendance_leave'){
				$this->registry->view->dataUnion = $this->registry->mAbsenOut->selectDB_attendance_leaveDetail($id);
			}elseif($identity == 'attendance_back'){
				$this->registry->view->dataUnion = $this->registry->mAbsenOut->selectDB_attendance_backDetail($id);
			}
			
			$this->registry->mComment->updateDB_statusReadComment($commentid);
			$this->registry->view->content = "form_home";
			
		}catch(Exception $e){
			$this->registry->error  = $e->getMessage();
			$this->registry->view->content	= 'errorMsg';
		}
		$this->registry->view->show('template');
	}
	
	public function notification($userid){
		try{ 
			$this->registry->view->notification = $this->registry->mWallComment->get_notification($userid);
		}catch(Exception $e){
			echo $e->getMessage();	
		}
	}
	
	public function login(){
		if($this->registry->mUser->isLoggedOn()==TRUE){
			echo '<script>location.href="index.php";</script>';
		}
		$this->registry->view->content 	= 'form_login';
		$this->registry->view->show('template');
	}
	
	public function loginValidation(){
	  try{
        $this->registry->mUser->onLogin($_POST['tUsername'], md5($_POST['tPassword']));
		echo "<script>location.href = 'index.php?mod=attendance';</script>";
      }catch(Exception $e){
			$this->registry->view->message 	= '<blockquote class="error">'.$e->getMessage().'</blockquote>';
			$this->registry->view->content	= 'form_login';
			$this->registry->view->show('template');
      }
	}
	public function logout(){
        $this->registry->mUser->doLogout(); 
		$this->index();
	}
	
	

    public function saveStatus(){
        if(ini_get('magic_quotes_gpc'))
          $_POST['tstatus']=stripslashes($_POST['tstatus']);

        try{
          	$data =  $this->registry->mStatus->insertDB_status($_POST['tstatus']); 
            echo $this->registry->mStatus->format_wall($data); 
        }catch(Exception $e){
          echo $e->getMessage();
        } 
    }
  
  	public function deleteStatus(){
		try{
			$data = explode("-",$_POST['data']);
			
			# utk data[0] lihat di mStatus->selectDB_homeUnion - identity
			if($data[0] == 'knowledge'){
				$this->registry->mKnowledge->deleteDB_knowledge($data[1]);
				$this->registry->mKnowledgeComment->deleteDB_knowledgeComment("", $data[1]);
			}elseif($data[0] == 'wall'){
				$this->registry->mStatus->deleteDB_status($data[1]);
				$this->registry->MWallComment->deleteDB_wallComment("", $data[1]);	
			}elseif($data[0] == 'task'){ 
				$this->registry->mTask->deleteDB_userTask($data[1]);
				$this->registry->mTaskComment->deleteDB_taskComment("", $data[1]);	
			}elseif(($data[0] == 'attendance_in')||($data[0] == 'attendance_out')||($data[0] == 'attendance_summary')||
				($data[0] == 'attendance_leave')||($data[0] == 'attendance_back')){
					
					// attendance bisa di hapus oleh user ga ya?
					
				//$this->registry->mTask->deleteDB_userTask($data[1]);
				//$this->registry->MWallComment->deleteDB_wallComment($data[1]);	
			}
		}catch(Exception $e){
		  echo $e->getMessage();	
		}
	}
	
	public function commentStatus(){
		
		try{
			$data = explode("-",$_POST['com_msgid']);
			$photo = $this->registry->mUser->get_userPhoto($_SESSION['userid']);
			
			$this->registry->mComment->insertDB_comment($data[1], $data[0], $_POST['textcontent']);
			echo $this->registry->mStatus->format_comment($data[0], $data[1], $_POST['textcontent'], $photo);
		}catch(Exception $e){
		  echo $e->getMessage();
		}
	}
	
	public function deleteComment(){
		try{
			$data = explode("-",$_POST['com_id']);
			$this->registry->mComment->deleteDB_comment($data[1]);
			
		}catch(Exception $e){
		  echo $e->getMessage();	
		}
	}

	public function about(){
		$this->registry->view->content = 'form_about';
		$this->registry->view->show ('template');
	}
	
	public function contact(){
		$this->registry->view->content = 'form_contact';
		$this->registry->view->show ('template');
    }

}
?>