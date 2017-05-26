<?php
class CDocument extends Controllers {

	public function index($type = NULL, $userid = NULL, $nama = NULL) { 
		try{
			$year = $this->registry->mCalendar->getYear();
			$this->registry->view->year = $year;
			$month = $this->registry->mCalendar->getMonth(); 
			
			//$this->registry->view->datauser 	= $this->registry->mUser->selectDB_userLevel('','','no');
			$this->registry->view->document = $this->registry->mDocument->get_documentByCalendar('',$month, $year);
			/*if($this->registry->view->document){
			echo "masuk";
			}else{
			echo "gagal ke fungsi index via var document";
			}*/
			$this->registry->view->submit = 0; 
			$this->registry->view->multiple = 0;
			
			    		
			$this->registry->view->content='tab_document';
		}catch(Exception $e){
			$this->registry->error  = $e->getMessage();
			$this->registry->view->content	= 'errorMsg';
		}
		$this->registry->view->show('template');
	}
	public function test(){
		try{
			
			$this->registry->view->document = $this->registry->mDocument->get_documentByCalendar(isset($_POST['cmbUser'])?$_POST['cmbUser']:'', $_POST['cmbMonth'], $_POST['cmbYear']);
			$this->registry->view->submit = 0; 
			$this->registry->view->multiple = 0;
			$this->registry->view->setActive = '1';
			//$this->registry->view->getUser = $this->registry->mUser->selectDB_userRecommend();
			//$this->registry->view->user = ($_SESSION['level_id'] == 3)?$_SESSION['userid']:''; 
			$year = $_POST['cmbYear'];
			$this->registry->view->year = $year;
			$month = $_POST['cmbMonth']; 
		
			if($_POST['cmbMonth']==1){
				$mm = 12;
				$pastmonth = 12;
			}else{
				$mm = $_POST['cmbMonth'] - 1;
				$pastmonth = $_POST['cmbMonth'] - 1;
			}
				 
			$this->registry->view->bln_1=$this->registry->mCalendar->monthname($month);
			$this->registry->view->bln_2=$this->registry->mCalendar->monthname($mm);
			$date = explode("-", $this->registry->mAbsensiHarian->firstDayOfweek());
			$calID = $this->registry->mCalendar->select_calendarID($date[2], $date[1], $date[0]);
			$this->registry->view->calID = $calID;
			if(isset($_POST['cmbUser'])) $this->registry->view->user=$_POST['cmbUser'];
			
			$this->registry->view->content = 'tab_document';
		}catch(Exception $e){
			$this->registry->error  = $e->getMessage();
			$this->registry->view->content	= 'errorMsg';
		}
		$this->registry->view->show ('template');
	}
	
}
?>	