<?php
class CReporting extends Controllers{
	
	public function index() {
		try{ 
			$year = $this->registry->mCalendar->getYear();
			$this->registry->view->year = $year;
			$month = $this->registry->mCalendar->getMonth(); 
			
			if($_SESSION['position_id'] == 1)
				$this->registry->view->tasklist = $this->registry->mTask->get_taskByCalendar('', $month, $year);				
			else
				$this->registry->view->tasklist = $this->registry->mTask->get_taskByCalendar($_SESSION['userid'], $month, $year,'');
			
			$this->registry->view->tasklistperiod = $this->registry->mTask->get_taskByPeriod('', $month, $year);
			
			if($_SESSION['level_id'] != 3)				
				$this->registry->view->getUser = $this->registry->mUser->selectDB_user();
			$this->registry->view->datauserRec 	= $this->registry->mAbsenTemp->selectDB_absenTemp($_SESSION['userid'],'user_id', NULL, '', '','' ,'calendar_id');
			
			#report monthly:
	
			$mm = $month - 1;
			$pastmonth = date('m', strtotime('last month'));
							 
			$this->registry->view->bln_1=$this->registry->mCalendar->monthname($month);
			$this->registry->view->bln_2=$this->registry->mCalendar->monthname($mm);
			//*
			$pastyear = $year;
			if ($pastmonth == 12) {
				$pastyear = $year - 1;
			
			}
			//echo "pastyear : ".$pastyear.", pastmonth : ".$pastmonth;
			$this->registry->view->getCalidMonthly1 = $this->registry->mCalendar->selectCalId("", 26, 31, $pastmonth, $pastyear);
			
			$this->registry->view->getCalidMonthly2 = $this->registry->mCalendar->selectCalId("", 1, 25, $month, $year);
			//*/	
			//$this->registry->view->monthlyreport = $this->registry->mTask->selectDB_task(($_SESSION['level_id'] != 3)||($_SESSION['position_id'] == 1)?'':$_SESSION['userid']);
		
			#report out office:
			//$this->registry->view->outOfficelist = $this->registry->mTask->selectDB_task(($_SESSION['level_id'] != 3)||($_SESSION['position_id'] == 1)?'':$_SESSION['userid']);
		
			#report user recommendation:
			$this->registry->view->userReclist = $this->registry->mAbsenTemp->get_userRecByCalendar(isset($_POST['cmbUser'])?$_POST['cmbUser']:'', $month, $year);
			
			$date = explode("-", $this->registry->mAbsensiHarian->firstDayOfweek());
			$calID = $this->registry->mCalendar->select_calendarID($date[2], $date[1], $date[0]);
			$this->registry->view->calID = $calID; 
			
			if($month==1){
				$mm = 12; 
			}else{
				$mm = $month - 1; 
			}
				 
			$this->registry->view->bln_1=$this->registry->mCalendar->monthname($month);
			$this->registry->view->bln_2=$this->registry->mCalendar->monthname($mm);
			 	
			
			$this->registry->view->submit = 0; 
			$this->registry->view->multiple = 0; 
			
			 
				$this->registry->view->user = ($_SESSION['level_id'] == 3)?$_SESSION['userid']:''; 
				$this->registry->view->content = 'tab_laporan'; 
			
		}catch(Exception $e){
			$this->registry->error  = $e->getMessage();
			$this->registry->view->content	= 'errorMsg'; 
		}
		$this->registry->view->show ('template');
	}
	
	public function taskDetail($userid, $taskid){
		try{
			$year = $this->registry->mCalendar->getYear();
			$this->registry->view->year = $year;
			$month = $this->registry->mCalendar->getMonth(); 
			
			if($_SESSION['position_id'] == 1)
				$this->registry->view->tasklist = $this->registry->mTask->get_taskByCalendar('', $month, $year);
			else
				$this->registry->view->tasklist = $this->registry->mTask->get_taskByCalendar($_SESSION['userid'], $month, $year);

			$this->registry->view->datauser	= $this->registry->mTask->selectDB_task($userid, '', '', '', $taskid);
			$this->registry->view->monthlyreport = $this->registry->mTask->selectDB_task(($_SESSION['level_id'] != 3)||($_SESSION['position_id'] == 1)?'':$_SESSION['userid']);
			
			$year = $this->registry->mCalendar->getYear();
			$this->registry->view->year = $year;
			$month = $this->registry->mCalendar->getMonth(); 
			
			if($month==1){
				$mm = 12; 
			}else{
				$mm = $month - 1; 
			}
				 
			$this->registry->view->user = ($_SESSION['level_id'] == 3)?$_SESSION['userid']:''; 
			$this->registry->view->bln_1=$this->registry->mCalendar->monthname($month);
			$this->registry->view->bln_2=$this->registry->mCalendar->monthname($mm);
			$date = explode("-", $this->registry->mAbsensiHarian->firstDayOfweek());
			$calID = $this->registry->mCalendar->select_calendarID($date[2], $date[1], $date[0]);
			$this->registry->view->calID = $calID;
			$this->registry->view->submit = 0; 
			$this->registry->view->multiple = 0;
			$this->registry->view->setActive = '5';
			$this->registry->view->content = 'tab_laporan';
		}catch(Exception $e){
			$this->registry->error  = $e->getMessage();
			$this->registry->view->content	= 'errorMsg'; 
		}
		$this->registry->view->show ('template');
	}
	
	public function task() {
		try{
			$this->registry->view->tasklist = $this->registry->mTask->get_taskByCalendar(isset($_POST['cmbUser'])?$_POST['cmbUser']:'', isset($_POST['cmbMonth'])?$_POST['cmbMonth']:'', isset($_POST['cmbYear'])?$_POST['cmbYear']:'',isset($_POST['cmbProject'])?$_POST['cmbProject']:'',isset($_POST['cmbDate'])?$_POST['cmbDate']:'');
			
			$this->registry->view->submit = 0; 
			$this->registry->view->multiple = 0;
			$this->registry->view->setActive = '5';
			$this->registry->view->getUser = $this->registry->mUser->selectDB_user();
			$this->registry->view->user = ($_SESSION['level_id'] == 3)?$_SESSION['userid']:''; 
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
			if(isset($_POST['cmbProject'])) $this->registry->view->user=$_POST['cmbProject'];
			
			$this->registry->view->content = 'tab_laporan';
		}catch(Exception $e){
			$this->registry->error  = $e->getMessage();
			$this->registry->view->content	= 'errorMsg';
		}
		$this->registry->view->show ('template');
	}
	public function taskperiod() {
		try{
			/*$this->registry->view->tasklist = $this->registry->mTask->get_taskByPeriod(isset($_POST['cmbUser'])?$_POST['cmbUser']:'', isset($_POST['cmbMonth'])?$_POST['cmbMonth']:'', isset($_POST['cmbYear'])?$_POST['cmbYear']:'',isset($_POST['cmbProject'])?$_POST['cmbProject']:'',isset($_POST['cmbDate'])?$_POST['cmbDate']:'');
			*/
			$this->registry->view->submit = 0; 
			$this->registry->view->multiple = 0;
			$this->registry->view->setActive = '7';
			$this->registry->view->getUser = $this->registry->mUser->selectDB_user();
			$this->registry->view->user = ($_SESSION['level_id'] == 3)?$_SESSION['userid']:''; 
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
			if(isset($_POST['cmbProject'])) $this->registry->view->user=$_POST['cmbProject'];
			
			$this->registry->view->content = 'tab_laporan';
			echo "sini!";
		}catch(Exception $e){
			$this->registry->error  = $e->getMessage();
			$this->registry->view->content	= 'errorMsg';
		}
		$this->registry->view->show ('template');
	}
	#20111124:filter function for user recommendation
	public function userRecommend() {
		try{
			$this->registry->view->userReclist = $this->registry->mAbsenTemp->get_userRecByCalendar(isset($_POST['cmbUser'])?$_POST['cmbUser']:'', $_POST['cmbMonth'], $_POST['cmbYear']);
			
			$this->registry->view->submit = 0; 
			$this->registry->view->multiple = 0;
			$this->registry->view->setActive = '6';
			/*$this->registry->view->getUser = $this->registry->mUser->selectDB_userRecommend();
			$this->registry->view->user = ($_SESSION['level_id'] == 3)?$_SESSION['userid']:''; */
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
			
			$this->registry->view->content = 'tab_laporan';
		}catch(Exception $e){
			$this->registry->error  = $e->getMessage();
			$this->registry->view->content	= 'errorMsg';
		}
		$this->registry->view->show ('template');
	}
	
	
	public function weekly(){
		try{ 
			$this->registry->view->weeklylist = $this->registry->mTask->selectDB_task(($_SESSION['level_id'] != 3)||($_SESSION['position_id'] == 1)?'':$_SESSION['userid']);

			$this->registry->view->getUser = $this->registry->mUser->selectDB_user();

			$year = $this->registry->mCalendar->getYear();
			$this->registry->view->year = $year;
			$month = $this->registry->mCalendar->getMonth(); 
			
			if($month==1){
				$mm = 12; 
			}else{
				$mm = $month - 1; 
			}
				 
			$this->registry->view->bln_1=$this->registry->mCalendar->monthname($month);
			$this->registry->view->bln_2=$this->registry->mCalendar->monthname($mm);
			 	
			
			$this->registry->view->submit = 0; 
			$this->registry->view->multiple = 0; 
			
			$date = explode("-", $this->registry->mAbsensiHarian->firstDayOfweek());
			$calID = $this->registry->mCalendar->select_calendarID($date[2], $date[1], $date[0]);
			$this->registry->view->calID = $calID;
			 
			$this->registry->view->user = $_POST['cmbUser']; 
			$this->registry->view->content = 'tab_laporan'; 
		}catch(Exception $e){
			$this->registry->error  = $e->getMessage();
			$this->registry->view->content	= 'errorMsg'; 
		}
		$this->registry->view->show ('template');
	}
	
	public function monthly() { 
		try{
			$this->registry->view->monthlyreport = $this->registry->mTask->selectDB_task(($_SESSION['level_id'] != 3)||($_SESSION['position_id'] == 1)?'':$_SESSION['userid']);
			$this->registry->view->submit = 0; 
			$this->registry->view->multiple = 0;
			if($_SESSION['level_id'] != 3)				
				$this->registry->view->getUser = $this->registry->mUser->selectDB_user();
		
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
				 
			$pastyear = $year;
			if ($pastmonth == 12) {
				$pastyear = $year - 1;
			
			}			
			


			$this->registry->view->bln_1=$this->registry->mCalendar->monthname($month);
			$this->registry->view->bln_2=$this->registry->mCalendar->monthname($mm);
			
			$this->registry->view->getCalidMonthly1 = $this->registry->mCalendar->selectCalId("", 26, 31, $pastmonth, $pastyear);
			$this->registry->view->getCalidMonthly2 = $this->registry->mCalendar->selectCalId("", 1, 25, $month, $year);	
			
			$date = explode("-", $this->registry->mAbsensiHarian->firstDayOfweek());
			$calID = $this->registry->mCalendar->select_calendarID($date[2], $date[1], $date[0]);
			$this->registry->view->calID = $calID;
			
			$this->registry->view->user = ($_SESSION['level_id'] == 3)?$_SESSION['userid']:$_POST['cmbUser'];

			$this->registry->view->setActive = '2';
			$this->registry->view->content = 'tab_laporan'; 
		}catch(Exception $e){
			$this->registry->error  = $e->getMessage();
			$this->registry->view->content	= 'errorMsg'; 
		}
		$this->registry->view->show ('template');
	}
	
	public function OutOfOffice() { 
		 try{
			$this->registry->view->outOfficelist = $this->registry->mTask->selectDB_task(($_SESSION['level_id'] != 3)||($_SESSION['position_id'] == 1)?'':$_SESSION['userid']);
			//--status--
			
			//--status--
			$this->registry->view->submit = 0; 
			$this->registry->view->multiple = 0;
			if($_SESSION['level_id'] != 3)				
				$this->registry->view->getUser = $this->registry->mUser->selectDB_user(); 
			
			$this->registry->view->datauser 	= $this->registry->mUser->selectDB_user();  
			$this->registry->view->user = ($_SESSION['level_id'] == 3)?$_SESSION['userid']:$_POST['cmbUser'];
 			$this->registry->view->year= $_POST['cmbYear'];
			$this->registry->view->month = $_POST['cmbMonth'];
			$year= $_POST['cmbYear'];
			$month = $_POST['cmbMonth'];
			 		
			if($month==1){
				$mm = 12;
				$pastmonth = 12;
			}else{
				$mm = $month - 1;
				$pastmonth = $month - 1;
			}
			$this->registry->view->bln_1=$this->registry->mCalendar->monthname($month);
			$this->registry->view->bln_2=$this->registry->mCalendar->monthname($mm);
			 			
			$this->registry->view->getCalidMonthly1 = $this->registry->mCalendar->selectCalId("", 26, 31, $pastmonth, $year);
			$this->registry->view->getCalidMonthly2 = $this->registry->mCalendar->selectCalId("", 1, 25, $month, $year);
			
			$date = explode("-", $this->registry->mAbsensiHarian->firstDayOfweek());
			$calID = $this->registry->mCalendar->select_calendarID($date[2], $date[1], $date[0]);
			$this->registry->view->calID = $calID;
			
			$this->registry->view->setActive = '3';
			$this->registry->view->content = 'tab_laporan'; 
		 }catch(Exception $e){
			$this->registry->error  = $e->getMessage();
			$this->registry->view->content	= 'errorMsg'; 
		 }
		$this->registry->view->show ('template');
	}
	
	public function statistic(){
		$this->registry->view->tasklist = $this->registry->mTask->selectDB_task(($_SESSION['level_id'] != 3)||($_SESSION['position_id'] == 1)?'':$_SESSION['userid']);
		
		$this->registry->view->submit = 0; 
		$this->registry->view->multiple = 0;
		$this->registry->view->getUser = $this->registry->mUser->selectDB_user();
		
		$date = explode("-", $this->registry->mAbsensiHarian->firstDayOfweek());
		$calID = $this->registry->mCalendar->select_calendarID($date[2], $date[1], $date[0]);
		$this->registry->view->calID = $calID;
		
		$this->registry->view->user = ($_SESSION['level_id'] == 3)?$_SESSION['userid']:'';
		 
		$year = $_POST['cmbYear'];
		$month = $_POST['cmbMonth']; 
 	
		$this->registry->view->year = $year;
		$this->registry->view->month = $month; 
		if($month==1){
			$mm = 12;
        		$pastmonth = 12;
		}else{
			$mm = $month - 1;
				$pastmonth = $month - 1;
		}
		
			$this->registry->view->getCalidMonthly1 = $this->registry->mCalendar->get_calendarID(26, $pastmonth, $year);
			$this->registry->view->getCalidMonthly2 = $this->registry->mCalendar->get_calendarID(25, $month, $year);
		$this->registry->view->datauser 	= $this->registry->mUser->selectDB_user();  
		
		$this->registry->view->bln_1=$this->registry->mCalendar->monthname($month);
		$this->registry->view->bln_2=$this->registry->mCalendar->monthname($mm);
		 	
	
	
		$this->registry->view->setActive = '4';
 		$this->registry->view->content = 'tab_laporan'; 
		$this->registry->view->show ('template');
	}
	
	public function monthlyToExcel($userid,$month,$year){
		$this->registry->view->userid = $userid;
		$this->registry->view->month = $month;
		$this->registry->view->year = $year;
		$this->registry->view->show("excel_monthly");
	}
	
	public function actSaveToExcelKeluar($userid,$month,$year,$tipe){
		$this->registry->view->userid = $userid;
		$this->registry->view->month = $month;
		$this->registry->view->year = $year;
		$this->registry->view->tipeAbsen = $tipe;
		$this->registry->view->show("SaveToExcelKeluar");
	}
	
	/*public function actSaveToExcelDetail($month,$year){
		$this->registry->view->month = $month;
		$this->registry->view->year = $year;
		try{
			$this->registry->view->show("excel_detail");
		}catch(Exception $e){
			$this->registry->error  = $e->getMessage();
			$this->registry->view->content	= 'errorMsg';
			$this->registry->view->show('template');
		}
	}*/
	
	public function showBulananAgain(){
		$this->registry->view->tasklist = $this->registry->mTask->selectDB_task(($_SESSION['level_id'] != 3)||($_SESSION['position_id'] == 1)?'':$_SESSION['userid']);
		
		$this->registry->view->submit = 0; 
		$this->registry->view->multiple = 0;
		$this->registry->view->getUser = $this->registry->mUser->selectDB_user();
		
		$date = explode("-", $this->registry->mAbsensiHarian->firstDayOfweek());
		$calID = $this->registry->mCalendar->select_calendarID($date[2], $date[1], $date[0]);
		$this->registry->view->calID = $calID;
		
		if (($_SESSION['level_id'] == 3)) $this->registry->view->user = $_SESSION['userid'];
		else{
			if(isset($_POST['sbmtUser'])) $this->registry->view->user = $_POST['cmbUser'];
		}

		if(isset($_POST['cmbUser'])) $this->registry->view->user=$_POST['cmbUser'];
		
		//coba-coba
		
		if(isset($_POST['submitCalendar'])){
			$this->registry->view->year= $_POST['cmbYear'];
			$this->registry->view->month = $_POST['cmbMonth'];
			if($_SESSION['level_id'] != 3)	$this->registry->view->userid	= $_POST['cmbUser'];
			else							$this->registry->view->userid = $_SESSION['userid'];
		}else{
			$this->registry->view->year = $this->registry->mCalendar->getYear();
			$this->registry->view->month = $this->registry->mCalendar->getMonth();
			$this->registry->view->userid = $_SESSION['userid'];
		}
	
	
	
		$this->registry->view->setActive = '2';
		$this->registry->view->detail='2';
		$this->registry->view->content="tab_laporan";
		$url = explode('/',$_GET['mod']);
		$this->registry->view->url = $url[1];
		$this->registry->view->show("template");
		
	}
	
	/*public function detailReport($userID,$calid){
		//dari mingguan
		$this->registry->view->tasklist = $this->registry->mTask->selectDB_task();
		
		$this->registry->view->submit = 0; 
		$this->registry->view->multiple = 0;
		$this->registry->view->getUser = $this->registry->mUser->selectDB_user();
		 
		$this->registry->view->calID = $calid;
		
		$calendar = explode('-',$this->registry->mCalendar->select_calendarID('','','',$calid,1));
		
		if (($_SESSION['level_id'] == 3)) $this->registry->view->user = $_SESSION['userid'];
		else{
			 $this->registry->view->user = $_POST['cmbUser'];
		}
 
		if($calendar[1]==1){
			$mm = 12;
			$pastmonth = 12;
		}else{
			$mm = $calendar[1] - 1;
			$pastmonth = $calendar[1] - 1;
		}
			 
		$this->registry->view->bln_1=$this->registry->mCalendar->monthname($calendar[1]);
		$this->registry->view->bln_2=$this->registry->mCalendar->monthname($mm);
 
		if(isset($_POST['submitCalendar'])){
			$year= $_POST['cmbYear'];
			$month = $_POST['cmbMonth'];
			if($_SESSION['level_id'] != 3)	$userid	= $_POST['cmbUser'];
			else							$userid = $_SESSION['userid'];
		} 
	  
		$this->registry->view->setActive = '2';
		$this->registry->view->detail='2';
		$this->registry->view->content="tab_laporan";
		$url = explode('/',$_GET['mod']);
		$this->registry->view->url = $url[1];
		$this->registry->view->show("template");
		
	}*/
	
	//-----Status rekomendasi
	
	
	
}

?>