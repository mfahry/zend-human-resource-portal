<?php

class CAttendance extends Controllers {
	
	public function index($activateTabAbsen = NULL) {
		try{
			
			# ambil task  list
			$tasklist = $this->registry->mTask->selectDB_task(isset($_SESSION['userid'])?$_SESSION['userid']:'');
			$this->registry->view->tasklist = $tasklist;			
			$this->registry->view->datauser		= $this->registry->mUser->selectDB_userLevel($_SESSION['userid']);
			$this->registry->view->datauserRec 	= $this->registry->mAbsenTemp->selectDB_absenTemp($_SESSION['userid'],'user_id', NULL, '', '','' ,'calendar_id');
			$this->registry->view->getUser = $this->registry->mUser->selectDB_user();
			$this->registry->view->submit = 0;
			$this->registry->view->multiple = 1;
			
			$tasklisttop5 = $this->registry->mTask->selectDB_taskTop5(isset($_SESSION['userid'])?$_SESSION['userid']:'',100);
			$this->registry->view->tasklisttop5 = $tasklisttop5;			
			$this->registry->view->datauser		= $this->registry->mUser->selectDB_userLevel($_SESSION['userid']);
			$this->registry->view->datauserRec 	= $this->registry->mAbsenTemp->selectDB_absenTemp($_SESSION['userid'],'user_id', NULL, '', '','' ,'calendar_id');
			$this->registry->view->getUser = $this->registry->mUser->selectDB_user();
			$this->registry->view->submit = 0;
			$this->registry->view->multiple = 1;
			
			#------------------ mulai utk validasi absen
			$nowTime = $this->registry->mCalendar->getTime();
			$getDate = $this->registry->mCalendar->getDate();
			$getMonth = $this->registry->mCalendar->getMonth();
			$getYear = $this->registry->mCalendar->getYear();
			
			$this->registry->view->time = $nowTime;
			$this->registry->view->date = $getDate;
			$this->registry->view->month = $getMonth;
			$this->registry->view->year = $getYear;
			
			$getDateYesterday = $this->registry->mCalendar->getDateYesterday();
			$isWorkDay = 0;
			$this->registry->view->calendar_id = $this->registry->mCalendar->select_calendarID($getDate, $getMonth, $getYear);
			
			# apakah hari ini adalah hari kerja?
			$getStatusDay= $this->registry->mCalendar->selectCalId("", $getDate, "", $getMonth, $getYear);
			foreach($getStatusDay as $data){
				$isWorkDay = $data->STATUS;
			}
			
			
			if ($isWorkDay == 1){
				$calIDYesterday = 0;
				
				# ambil cal id hari kemarin	
				$getCalIDYesterday	=	$this->registry->mCalendar->selectDateStatus($getDate,$getMonth,$getYear);
				foreach($getCalIDYesterday as $dataTgl){
					$calIDYesterday  = $dataTgl->CALENDAR_ID;
				}
				
				if(isset($_SESSION['level_id']) && $_SESSION['level_id']== 3){ 
					# -------------------------------------VALIDASI ABSEN HARIAN
					
					# variable utk aktivasi tab absen
					$this->registry->view->activateTabAbsen = $activateTabAbsen;
					
					# confirm, apakah kemarin masuk atau tdk
					$getAbsentYesterday	=	$this->registry->mAbsensiHarian->selectAbsenY($getDate,	$getMonth,$getYear, $_SESSION['userid']);					
 					$dataReject1 = NULL;
					  
					# cek, apakah ada rekomendasi absen?
					if(count($getAbsentYesterday)>0){
						foreach($getAbsentYesterday as $data){
																																						//di ganti absen masuk
							$dataReject1 	= $this->registry->mAbsenTemp->selectDB_absenTemp($_SESSION['userid'],'user_id',3, $data->CALENDAR_ID, '',  1, 'user_recommendation');
						  	$absenType_id = $data->ABSENTYPE_ID;  
					
						}
					}elseif(count($getAbsentYesterday) == 0){ 
						$this->registry->mAbsensiHarian->insert_AbsenALL($_SESSION['userid'], $calIDYesterday, 0);
					}
					
					# jika data rekomendasi >= 2, jgn ditampilin. 
					if(count($dataReject1) < 2){
						$this->registry->view->getAbsentYesterday = $getAbsentYesterday;
						$this->registry->view->absenType_id = $absenType_id;
					}elseif(count($dataReject1) >= 2){
						$this->registry->view->getAbsentYesterday = 3;
						$this->registry->view->absenType_id = 3;
					}
					
					# ambil absen pulang hari kemarin
					$getAbsentHomeYesterday	=	$this->registry->mAbsensiHarian->cekMaxCalendarHarian($getDate, $getMonth,$getYear, $_SESSION['userid']);
					$dataReject2 = NULL;
					
					# cek, apakah ada rekomendasi absen?
					if(count($getAbsentHomeYesterday)>0){
						foreach($getAbsentHomeYesterday as $reject){
							$dataReject2 	= $this->registry->mAbsenTemp->selectDB_absenTemp($_SESSION['userid'],'user_id',3, $reject->CALENDAR_ID, '',  $reject->ABSENTYPE_ID, 'user_recommendation');
						}
					}
					
					# jika data rekomendasi >= 2, jgn ditampilin.
					if(count($dataReject2) < 2)
						$this->registry->view->dataAbsentHomeYesterday = $getAbsentHomeYesterday;
					elseif(count($dataReject2) >= 2)
						$this->registry->view->dataAbsentHomeYesterday = NULL;
								
					# ambil data absen masuk hari ini
					$getAbsentToday	= $this->registry->mAbsensiHarian->cekCalendarHarian(1,$getDate,$getMonth,$getYear,$_SESSION['userid']);
					$this->registry->view->getAbsentToday = $getAbsentToday;
					if(count($getAbsentToday)== 0){
					
						if($nowTime <= "16:00:00") $this->registry->view->tab2 = 'form_attendancePresent';								
						else{
							# tidak absen masuk kantor untuk hari ini
							if (count($getAbsentToday) == 0) $this->registry->view->tab2 = "confirm_cannotAbsent";										
							else $this->registry->view->tab2 = 'form_attendanceReturnHome';																	
						}
					}else{
						if(($nowTime >= "16:00:00")){
							$this->registry->view->tab2 = 'form_attendanceReturnHome';
						}
					} 
									
					# -------------------------------------VALIDASI ABSEN KELUAR
					$getAbsentBackYesterday = array();
					
					# ambil data absen kembali ke kantor untuk hari kemarin
					$getAbsentBackYesterday	=	$this->registry->mCalendar->cekMaxCalendarOut($getDate,$getMonth,$getYear, $_SESSION['userid']);					
					$this->registry->view->dataAbsentBackYesterday = $getAbsentBackYesterday;
					if(count($getAbsentBackYesterday) > 0){ 
						 
						$this->registry->view->dataAbsentBackYesterday = $getAbsentBackYesterday;
						$this->registry->view->tab3 = 'form_attendanceReturnYday';
					}else{
						#ambil data absen keluar
						$getAbsentOut	= $this->registry->mAbsenOut->cekCalendarOut(1,$getDate, $getMonth,$getYear, $_SESSION['userid']);
						$this->registry->view->getAbsentOut = $getAbsentOut;
						$this->registry->view->ip = $this->registry->mUser->getIPGuest();
						
						if(count($getAbsentOut) > 0){
							# apakah sudah absen kembali?
							$getAbsentBack	= $this->registry->mAbsenOut->cekCalendarOut(0,$getDate, $getMonth,$getYear, $_SESSION['userid']);
							$this->registry->view->getAbsentBack = $getAbsentBack;
							if(count($getAbsentBack) > 0)
								$this->registry->view->tab3 = 'form_attendanceReturn';	
							else
								$this->registry->view->tab3 = 'form_attendanceLeave';	
						}else{
							$this->registry->view->tab3 = 'form_attendanceLeave';
						}
						#update absen lembur
						#$this->registry->mAbsenTemp->updateDB_lembur($_POST['userid'],  $_POST['calid'], $_POST['tWs'], $_POST['tNote'], $_POST['time1']);
				
					}
										
					#untuk window task
					if(isset($_POST['submitTask'])){
						$this->registry->view->submit = 1;
						$this->registry->view->ind1=$_POST['inputTask'];
						$this->registry->view->ind2 = $_POST['prosentaseTask'];
						$this->registry->view->ind3 = $_POST['priorityTask'];
					}
					
					$this->registry->view->content = 'tab_absentTask';
					
				}else{ 
					echo '<script>location.href = "index.php"</script>';
				}
			}
	


		
		
	


			/******** Alert Rekomendasi ********/
			$getData=$this->registry->mAbsenTemp->selectDB_absenTemp($_SESSION['userid'],"user_recommendation", 0);
			 
			$status =1;
			if(count($getData)>0){
				foreach($getData as $data){
					$status = $data->STATUS;
				}
			}
			
			$this->registry->view->identifier='0';
			if($status == 0){
				$this->registry->view->identifier='1';
			}
			
			
		}catch(Exception $e){
			$this->registry->error  = $e->getMessage();
			$this->registry->view->content	= 'errorMsg';
		}
		$this->registry->view->show ('template');
	}
	
	public function leave(){
		try{
			$ip = $this->registry->mUser->getIPGuest();
			$time=$this->registry->mCalendar->getTime();
			//if($_POST['tAbsen']==1){ //absenKeluar kantor
				$this->registry->mAbsenOut->insert_absenOut($_POST['harianID'], $_POST['rbAbsen'], $time, $_POST['tNote'], $ip);
 				//echo "<script>location.href=\"index.php?mod=attendance\"<\/script>";
				$this->index();
			/*}elseif($_POST['tAbsen']==01){
				$this->registry->mAbsenOut->update_Absenout($_POST['tTime'], $_POST['tNote'], $_POST['ipAddress'], $_POST['tWs'], $_POST['harianID']);
				//setelah absen kembali di submit,tampilkan absen pulang
			}else{
				$this->registry->mAbsenOut->update_Absenout($_POST['tTime'], $_POST['tNote'], $_POST['ipAddress'], $_POST['tWs'], $_POST['harianID']);
			}*/
      	}catch(Exception $e){
			$this->registry->error  = $e->getMessage();
			$this->registry->view->content	= 'errorMsg';
			$this->registry->view->show('template');
		}
	}
	
	public function returnOfficeYday(){
		try{
			$ip = $this->registry->mUser->getIPGuest();
			for ($i = 1; $i < $_POST['ctrOut']; $i++) {
				$abh = "abhID".$i; 
				$jamOut = "tTime".$i; 
				$noteOut = "tNote".$i; 
				$wsOut = "tWs".$i; 
				$this->registry->mAbsensiHarian->update_Absenout($_POST[$jamOut], $_POST[$noteOut], $ip, $_POST[$wsOut], $_POST[$abh]);
			}
			//tambahan 130710
		//echo "<script>location.href=\"index.php?mod=attendance\"<\/script>";
			$this->index();
		}catch(Exception $e){
			$this->registry->error  = $e->getMessage();
			$this->registry->view->content	= 'errorMsg';
			$this->registry->view->show('template');
		}
	}
	
	public function returnOffice(){
		try{
			$ip = $this->registry->mUser->getIPGuest();
			$time = $this->registry->mCalendar->getTime();
			//update_Absenout($out_timeend, $out_descend, $ip_End, $worksummary, $harianID)
			$this->registry->mAbsenOut->update_AbsenOut($time, $_POST['tNote'], $ip, $_POST['tWs'], $_POST['harianID']);
			//echo "<script>location.href=\"index.php?mod=attendance\";<\/script>";
			$this->index();
      	}catch(Exception $e){
			$this->registry->error  = $e->getMessage();
			$this->registry->view->content	= 'errorMsg';
			$this->registry->view->show('template');
		}
	}
	
	public function present(){
		try{ 
			$ip = $this->registry->mUser->getIPGuest();
			$time = $this->registry->mCalendar->getTime();
			$this->registry->mAbsensiHarian->insert_Absen($_SESSION['userid'], $_POST['CalendarID'], $time, $_POST['tNote'], $ip, 1);
 
			echo "<script>location.href=\"index.php\"</script>";
      	}catch(Exception $e){
			$this->registry->error  = $e->getMessage();
			$this->registry->view->content	= 'errorMsg';
			$this->registry->view->show('template');
		}
	}
	
	public function returnHome(){
		try{
		$calid = $this->registry->mCalendar->select_calendarID($cal1[0], $cal1[1], $cal1[2]);
		$calids = $this->registry->mCalendar->currentDate('d-m-Y');
		$cal21 =  explode("-",$calids);		
		$calstat = $this->registry->mCalendar->select_calStatus($cal21[0], $cal21[1], $cal21[2]);
			foreach($calstat as $dataCek){
			$status	= $dataCek->STATUS;
		}
		//echo $status;
		if($calstat == 1){
			if($_POST['tTime'] > '19:00:00'){
				$getLembur = $this->registry->mAbsenTemp->selectDB_absenTemp($_SESSION['userid'], 'user_id', NULL, $_POST['CalendarID'], 'yes', 8);
				
				if(count($getLembur) > 0){
					$_POST['tNote'] = '[Lembur Hari Kerja] Pkl 19:00 s.d '.$_POST['tTime'].'<br>'.$_POST['tNote'];
					
					$this->registry->mAbsenTemp->updateDB_lembur($_SESSION['userid'], $_POST['CalendarID'], $_POST['tTime'], $_POST['tNote'], $_POST['tWs']);
				}

			}
		}elseif($calstat == 0){	
		if($_POST['tTime'] > '08:00:00'){
				$getLembur = $this->registry->mAbsenTemp->selectDB_absenTemp($_SESSION['userid'], 'user_id', NULL, $_POST['CalendarID'], 'yes', 8);
				
				if(count($getLembur) > 0){
					$_POST['tNote'] = '[Lembur Hari Non Kerja] Pkl 08:00 s.d '.$_POST['tTime'].'<br>'.$_POST['tNote'];
					
					$this->registry->mAbsenTemp->updateDB_lembur($_SESSION['userid'], $_POST['CalendarID'], $_POST['tTime'], $_POST['tNote'], $_POST['tWs']);
				}

			}
		}
			$this->registry->mAbsensiHarian->update_Absen($_POST['tTime'], $_POST['tNote'], $_POST['ipAddress'], $_POST['tWs'], $_SESSION['userid'], $_POST['CalendarID']);
			echo '<script>location.href="index.php?mod=index/attendance";</script>';
      	}catch(Exception $e){
			$this->registry->error  = $e->getMessage();
			$this->registry->view->content	= 'errorMsg';
			$this->registry->view->show('template');
		}
	}
	
	/*public function submitAbsentGoHome(){
		try{	
			if(isset($_POST['ctrHarian'])){
				for ($i = 1; $i <= $_POST['ctrHarian']; $i++) {
					$CalHarian = "CalendarID".$i; 
					$jamHarian = "tTime".$i; 
					$noteHarian = "tNote".$i; 
					$wsHarian = "tWs".$i; 
					$this->registry->mAbsensiHarian->update_Absen($_POST[$jamHarian], $_POST[$noteHarian], $_POST['ipAddress'], $_POST[$wsHarian], $_SESSION['userid'], $_POST[$CalHarian]);			
				}
			}else{
				throw new Exception("Gagal mengupdate absen pulang + ctrl");
			}
			//tambahan
			echo "<script>location.href=\"index.php?mod=attendance\"</script>";
			// echo '<script>location.href="index.php?mod=index/Task";<\/script>';
      	}catch(Exception $e){
			$this->registry->error  = $e->getMessage();
			$this->registry->view->content	= 'errorMsg';
			$this->registry->view->show('template');
		}
	}*/
	
	public function submitRecommendation(){
		try{
			if($_POST['rbAbsen']==1 || $_POST['rbAbsen']==8||$_POST['rbAbsen']==14){ # masuk / pulang /puasa
				$dataAbsen = $this->registry->mAbsensiHarian->select_reportHarian($_POST['userid'], $_POST['calid'],3);
				if(count($dataAbsen)> 0){
 					//$this->registry->mAbsensiHarian->updateDB_attendanceIn($_POST['userid'], $_POST['time1'], '[Rekomendasi] '.$_POST['desc'],$_POST['calid']);

					$this->registry->mAbsenTemp->activate_recommendation($_POST['userid'], $_POST['calid'], $_POST['rbAbsen']);
				}else{
				
 					 $this->registry->mAbsensiHarian->insert_Absen($_POST['userid'], $_POST['calid'], $_POST['time1'], '[Rekomendasi '.($_POST['rbAbsen']==8)?'lembur':''.'] '.$_POST['desc'], $this->registry->mUser->getIPGuest(), 1);
					 $this->registry->mAbsensiHarian->update_Absen(($_POST['rbAbsen']==8)?'00:00:00':'17:00:00', '[Rekomendasi] '.$_POST['desc'], $this->registry->mUser->getIPGuest(), '', $_POST['userid'],$_POST['calid']);
					//$this->registry->mAbsenTemp->activate_recommendation($_POST['userid'], $_POST['calid'], $_POST['rbAbsen']);
				}
				
			}elseif($_POST['rbAbsen']!=8){
				$absensiharianID = $this->registry->mAbsensiHarian->get_absensiHarianID($_POST['userid'],$_POST['calid']);
				if($absensiharianID == NULL){
 					 $this->registry->mAbsensiHarian->insert_Absen($_POST['userid'], $_POST['calid'], $_POST['time1'], '[Rekomendasi] '.$_POST['desc'], $this->registry->mUser->getIPGuest(), 1);
					 $this->registry->mAbsensiHarian->update_Absen('17:00:00', '[Rekomendasi] '.$_POST['desc'], $this->registry->mUser->getIPGuest(), '', $_POST['userid'],$_POST['calid']);
					$absensiharianID = $this->registry->mAbsensiHarian->get_absensiHarianID($_POST['userid'],$_POST['calid']);
				}
				
				if($absensiharianID!=NULL){
					if($_POST['rbAbsen']==10){ 
						$this->registry->mAbsensiHarian->update_Absen($_POST['time1'], '[Rekomendasi] '.$_POST['desc'], $this->registry->mUser->getIPGuest(),'[Rekomendasi] '.$_POST['desc'], $_POST['userid'], $_POST['calid']);
						$this->registry->mAbsenTemp->activate_recommendation($_POST['userid'], $_POST['calid'], $_POST['rbAbsen']);
						/*if($_POST['rbAbsen']==8){		
							#update absen lembur
							$this->registry->mAbsenTemp->updateDB_lembur($_POST['userid'],  $_POST['calid'], $_POST['tWs'], $_POST['tNote'], $_POST['time1']);
								}*/
					}else{ 
						$this->registry->mAbsenOut->insert_absenOut($absensiharianID, $_POST['rbAbsen'], $_POST['time1'], '[Rekomendasi] '.$_POST['desc'], $this->registry->mUser->getIPGuest());

						if($_POST['rbAbsen']==7){ 
							$this->registry->mAbsenOut->update_Absenout('17:00:00', '[Rekomendasi] '.$_POST['desc'], $this->registry->mUser->getIPGuest(), '[Rekomendasi] '.$_POST['desc'], $absensiharianID);
						}
						$this->registry->mAbsenTemp->activate_recommendation($_POST['userid'], $_POST['calid'], $_POST['rbAbsen']);

					}
				}
			} 
		}catch(Exception $e){
			$this->registry->error  = $e->getMessage();
			$this->registry->view->content	= 'errorMsg';
		}
	}
	
	/*public function actAbsenTabRekomendasi($ket = NULL,$userid = NULL){
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
		$this->registry->view->content = 'tab_recommedation';
		$this->registry->view->show('template') ;
	}*/

	
	public function submitfullRecommendation(){
		try{
			if(isset($_POST['calid'])){
				# untuk notifikasi yg di reject
			   foreach($_REQUEST['cmbUser'] as $userRec){
					$this->registry->mAbsenTemp->insertDB_absenTemp($_SESSION['userid'], $_POST['calid'], $_POST['tKet'], $userRec, $_POST['rbAbsen'], $_POST['time1']);
					echo '1';
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
							
					#06282011: for overtime recommendation	
					if($_POST['rbAbsen']==8){						
						$this->registry->mAbsenTemp->insertDB_lembur($_POST['userid'], $calid, $_POST['time1'], $_POST['tKet'], $outInputend);			   
						$success = true;
					}	
					if(($_POST['rbAbsen']==6)||($_POST['rbAbsen']==7)){# spj luar kota dan cuti
						if($this->registry->mAbsenTemp->insertDB_absenTemp($_POST['userid'], $calid2, $_POST['tKet'], $userRec, $_POST['rbAbsen'], $_POST['time1']))
							$success = true;
					}

			   	}	

				if($success)
					//$this->registry->view->message = '<font color="#009900">Rekomendasi anda sudah terkirim</font>';
					$this->registry->view->message = "<script>alert('Rekomendasi anda sudah terkirim');location.href='index.php'</script>";
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
				$this->registry->view->calid = $this->registry->mCalendar->select_calendarID($this->registry->mCalendar->getDate(), $this->registry->mCalendar->getMonth(), 
				$this->registry->mCalendar->getYear());
				$this->registry->view->tabActive=1;	
				$this->registry->view->type = NULL;
				$this->registry->mCalendar->getTime();
					 
				$this->registry->view->content = 'tab_absentTask';
				$this->registry->view->show('template') ;
 			}
		}catch(Exception $e){
			$this->registry->error  = $e->getMessage();
			$this->registry->view->content	= 'errorMsg';
			$this->registry->view->show('template');
		}
					 
	}
}
?>