<?php

class CRecommendation extends Controllers {
	
	public function index($type = NULL, $userid = NULL, $nama = NULL) { 
		try{
			if(isset($_SESSION['level_id']) && $_SESSION['level_id']==2){
				$this->registry->view->datauser1 	= $this->registry->mUser->selectDB_userLevel();
				$this->registry->view->datauserRec 	= $this->registry->mAbsenTemp->selectDB_absenTemp('','',NULL,'','','','calendar_id');
			}else if(isset($_SESSION['level_id']) && $_SESSION['level_id'] == 3){
				$this->registry->view->datauserRec 	= $this->registry->mAbsenTemp->selectDB_absenTemp($_SESSION['userid'],'user_id', NULL, '', '','' ,'calendar_id');
				$this->registry->view->datauser		= $this->registry->mUser->selectDB_userLevel($_SESSION['userid']);
				$this->registry->view->getUser = $this->registry->mUser->selectDB_user();
				$this->registry->view->submit = 0;
				$this->registry->view->multiple = 1;
			}
			$this->registry->view->calid 		= $this->registry->mCalendar->select_calendarID($this->registry->mCalendar->getDate(), $this->registry->mCalendar->getMonth(), 
			$this->registry->mCalendar->getYear());
			$this->registry->view->tabActive=1;	
			$this->registry->view->type = NULL;
				
			$url = explode('/',$_GET['mod']);
			$this->registry->view->url = $url;
			if($type != NULL){
				$this->registry->view->type = $type;
				$this->registry->view->userid = $userid;
				$this->registry->view->nama = $nama;
			}
#############################################################################	
			//untuk window task delegation									#
			if(isset($_POST['newTask'])){							 		#	
				$this->registry->view->submit = 1;							#
				$this->registry->view->ind1=$_POST['inputTask'];			#
				$this->registry->view->ind2=$_POST['delegasiUser'];			#
				$this->registry->view->ind3 = $_POST['prosentaseTask'];		#
			}																#
#############################################################################
			if($_SESSION['level_id']==3)
				$this->registry->view->content = 'tab_organization';
			else
				$this->registry->view->content = 'tab_recommendation';				

		}catch(Exception $e){
			$this->registry->error  = $e->getMessage();
			$this->registry->view->content	= 'errorMsg'; 
		}
		$this->registry->view->show ('template');
	}
	
	/*public function detail($calid, $userid, $absentype){
		try{
			if(isset($_SESSION['level_id']) && $_SESSION['level_id']==2){
				$this->registry->view->datauser 	= $this->registry->mUser->selectDB_userLevel();
				$this->registry->view->datauserRec 	= $this->registry->mAbsenTemp->selectDB_absenTemp();
			}else if(isset($_SESSION['level_id']) && $_SESSION['level_id'] == 3){
				$this->registry->view->datauserRec 	= $this->registry->mAbsenTemp->selectDB_absenTemp($_SESSION['userid'],'user_id', NULL, '', '','' ,'calendar_id');
				$this->registry->view->datauser		= $this->registry->mUser->selectDB_userLevel($_SESSION['userid']);
				$this->registry->view->getUser = $this->registry->mUser->selectDB_user();
				$this->registry->view->submit = 0;
				$this->registry->view->multiple = 1;
			}  
			$this->registry->view->calid 		= $this->registry->mCalendar->select_calendarID($this->registry->mCalendar->getDate(), $this->registry->mCalendar->getMonth(), 
			$this->registry->mCalendar->getYear());
			$this->registry->view->detailRec = $this->registry->mAbsenTemp->selectDB_absenTemp($userid,"user_id", NULL, $calid,'', $absentype, 'calendar_id');
			$this->registry->view->tabActive=2;
			$this->registry->view->content = 'tab_recommedation';
		}catch(Exception $e){
			$this->registry->error  = $e->getMessage();
			$this->registry->view->content	= 'errorMsg'; 
		}
		$this->registry->view->show ('template');
	}*/
	
	public function submitAlertRecommendation(){
		try{
			//if(isset($_POST['rConfirm']) && $_POST['rConfirm']==1){
				$this->registry->mAbsenTemp->updateDB_absenTemp($_POST['atID'], '', $_POST['rConfirm']); 
			//}

			/*if(isset($_POST['rConfirm']) && $_POST['rConfirm']==0){
				$this->registry->mAbsenTemp->deleteDB_absenTemp($_POST['atID']); 
			} */
		}catch(Exception $e){
			$this->registry->error  = $e->getMessage();
			$this->registry->view->content	= 'errorMsg';
			$this->registry->view->show('template');
		}
	} 
	
	
	public function actAbsensiRekomendasi(){
		/* $type = NULL, $userid = NULL, $nama = NULL,$ket = NULL
		if($_SESSION['level_id']==2){
			$this->registry->view->datauser 	= $this->registry->mUser->selectDB_userLevel();
		}else if($_SESSION['level_id'] == 3){
			$this->registry->view->datauser		= $this->registry->mUser->selectDB_userLevel($_SESSION['userid']);
		}
			$this->registry->view->calid 		= $this->registry->mCalendar->select_calendarID($this->registry->mCalendar->getDate(), $this->registry->mCalendar->getMonth(), 
			$this->registry->mCalendar->getYear());
			$this->registry->view->datauserRec 	= $this->registry->mAbsenTemp->selectDB_absenTemp();
		//	$this->registry->view->type = NULL;
		$this->registry->view->tabActive=1;	
		//if($type != NULL){
		
			$this->registry->view->type = $type;
			$this->registry->view->userid = $userid;
			$this->registry->view->nama = $nama;
			$this->registry->view->ket = $ket;
		//}
		$this->registry->view->setWindowActive = '1';
		$url = explode('/',$_GET['mod']);
		$this->registry->view->url = $url[1];
		$this->registry->view->content = 'tab_recommedation';
		$this->registry->view->show ('template');*/
		try{ 
			$cal = explode('-',$_POST['tDate']); 
			$calid = $this->registry->mCalendar->get_calendarID($cal[2], $cal[1], $cal[0]);
			echo $calid;
			if($calid != NULL){
				$this->registry->mAbsensiHarian->insert_Absen($_POST['userid'], $calid, 'now()', $_POST['tDesc'], $this->registry->mUser->getIPGuest(), $_POST['ket']);
			} 
			//echo "<script>location.href=\"index.php?mod=index/daftarAbsensi\";<\/script>";
		}catch(Exception $e){
			$this->registry->error  = $e->getMessage();
			$this->registry->view->content	= 'errorMsg';
			$this->registry->view->show('template');
		}
	}
	
	
	public function actAbsenTabRekomendasi($ket = NULL,$userid = NULL){
		if($_SESSION['level_id']==2){
			$this->registry->view->datauser1 	= $this->registry->mUser->selectDB_userLevel();
			$this->registry->view->datauser 	= $this->registry->mUser->selectDB_userLevel($userid);
			$this->registry->view->datauserRec 	= $this->registry->mAbsenTemp->selectDB_absenTemp('','',NULL,'','','','calendar_id');
		}else if($_SESSION['level_id'] == 3){
			$this->registry->view->datauser	= $this->registry->mUser->selectDB_userLevel($_SESSION['userid']);
			$this->registry->view->datauserRec 	= $this->registry->mAbsenTemp->selectDB_absenTemp($_SESSION['userid'],'user_id', NULL, '', '','' ,'calendar_id');
			$this->registry->view->datauser1		= $this->registry->mUser->selectDB_userLevel($_SESSION['userid']);
		}
		
		$this->registry->view->calid 		= $this->registry->mCalendar->select_calendarID($this->registry->mCalendar->getDate(), $this->registry->mCalendar->getMonth(), 
		$this->registry->mCalendar->getYear());
		$this->registry->view->tabActive=1;	
		if($ket!=NULL){
			$this->registry->view->userid	= $userid;
			$this->registry->view->ket = $ket;
			$this->registry->view->getUser = $this->registry->mUser->selectDB_user();
			$this->registry->view->submit = 0;
			$this->registry->view->multiple = 1;
		}
		
		$url = explode('/',$_GET['mod']);
		$this->registry->view->url = $url;
		$this->registry->view->setWindowActive = '2';
		$this->registry->view->content = 'tab_recommendation';
		$this->registry->view->show('template') ;
	}
	
	public function submitfullRecommendation(){
		try{			
			if(isset($_POST['calid'])){
				# untuk notifikasi yg di reject
			   foreach($_REQUEST['cmbUser'] as $userRec){
				$this->registry->mAbsenTemp->insertDB_absenTemp($_SESSION['userid'], $_POST['calid'], $_POST['tKet'], $userRec, $_POST['rbAbsen'], $_POST['time1']);
			   }
			   	$this->registry->mAbsenTemp->updateDB_absenTemp($_POST['tempid'],'',3);
			}else{
				# untuk rekomendasi absen keluar
				$cal1 = explode("/",$_POST['calinput1']);
				$calid = $this->registry->mCalendar->select_calendarID($cal1[0], $cal1[1], $cal1[2]);
				
				if(($_POST['rbAbsen']==6)||($_POST['rbAbsen']==7)){ # spj luar kota dan cuti
					$cal2 = explode("/",$_POST['calinput2']);  
					$calid2 = $this->registry->mCalendar->select_calendarID($cal2[0], $cal2[1], $cal2[2]);
				}
				$success = true;
			   	foreach($_REQUEST['cmbUser'] as $userRec){
					if($this->registry->mAbsenTemp->insertDB_absenTemp($_POST['userid'], $calid, $_POST['tKet'], $userRec, $_POST['rbAbsen'], $_POST['time1']))
						$success = true;
					
					if(($_POST['rbAbsen']==6)||($_POST['rbAbsen']==7)){# spj luar kota dan cuti
						if($this->registry->mAbsenTemp->insertDB_absenTemp($_POST['userid'], $calid2, $_POST['tKet'], $userRec, $_POST['rbAbsen'], $_POST['time1']))
							$success = true;
					}
			   	}
				if($success)
					$this->registry->view->message = '<font color="#009900">Rekomendasi anda sudah terkirim</font>';
				else
					$this->registry->view->message = '<font color="#FF0000">Rekomendasi anda gagal terkirim</font>';
				
				
				if(isset($_SESSION['level_id']) && $_SESSION['level_id']==2){
					$this->registry->view->datauser 	= $this->registry->mUser->selectDB_userLevel();
					$this->registry->view->datauserRec 	= $this->registry->mAbsenTemp->selectDB_absenTemp();
				}else if(isset($_SESSION['level_id']) && $_SESSION['level_id'] == 3){
					$this->registry->view->datauserRec 	= $this->registry->mAbsenTemp->selectDB_absenTemp($_SESSION['userid'],'user_id', NULL, '', '','' ,'calendar_id');
					$this->registry->view->datauser		= $this->registry->mUser->selectDB_userLevel($_SESSION['userid']);
					$this->registry->view->getUser = $this->registry->mUser->selectDB_user();
					$this->registry->view->submit = 0;
					$this->registry->view->multiple = 1;
				}
				$this->registry->view->calid 		= $this->registry->mCalendar->select_calendarID($this->registry->mCalendar->getDate(), $this->registry->mCalendar->getMonth(), 
				$this->registry->mCalendar->getYear());
				$this->registry->view->tabActive=1;	
				$this->registry->view->type = NULL;
					 
				$this->registry->view->content = 'tab_recommendation';
				$this->registry->view->show('template') ;
 			}
		}catch(Exception $e){
			$this->registry->error  = $e->getMessage();
			$this->registry->view->content	= 'errorMsg';
			$this->registry->view->show('template');
		}
		
		
		
	}
	public function submitcancelRecommendation(){
		try{		
			if(isset($_POST['calid'])){
				#20120104	
				# untuk notifikasi yg di reject		
				$userReject=$_POST['userReject'];		
				foreach($_REQUEST['cmbUser'] as $userRec){	
					
					//$this->registry->mAbsenTemp->updateDB_absenTemp($_POST['tempid'],'',3);
				}
				$this->registry->mAbsenTemp->cancelDB_absenTemp($_SESSION['userid'], $_POST['calid'], $userReject);
			}
		}catch(Exception $e){
			$this->registry->error  = $e->getMessage();
			$this->registry->view->content	= 'errorMsg';
			$this->registry->view->show('template');
		}
		
		
		
	}
}
?>