<?php

class CAbsen extends Controllers {
	
	public function index($activateTabAbsen = NULL) {
		try{
			#ambil task  list utk side bar
			$this->registry->view->tasklist = $this->registry->mTask->selectDB_task(isset($_SESSION['userid'])?$_SESSION['userid']:'');
			
			# ambil data task yang blm selesai / < 100%
			$currentTask = $this->registry->mTask->selectDB_task(isset($_SESSION['userid'])?$_SESSION['userid']:'', 100);
			$this->registry->view->currentTask = $currentTask;
			
			#------------------ mulai utk validasi absen
			$nowTime = $this->registry->mCalendar->getTime();
			$getDate = $this->registry->mCalendar->getDate();
			$getMonth = $this->registry->mCalendar->getMonth();
			$getYear = $this->registry->mCalendar->getYear();
			$getDateYesterday = $this->registry->mCalendar->getDateYesterday();
			$isWorkDay = 0;
			
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
				
				if($_SESSION['level_id'] == 3){ 
					# -------------------------------------VALIDASI ABSEN HARIAN
					
					$this->registry->view->activateTabAbsen = $activateTabAbsen;
					
					# confirm, apakah kemarin masuk atau tdk
					$getAbsentYesterday	=	$this->registry->mAbsensiHarian->selectAbsenY($getDate,	$getMonth,$getYear, $_SESSION['userid']);					
					$this->registry->view->getAbsentYesterday = $getAbsentYesterday;					
						foreach($getAbsentYesterday as $data){
							$validasi = $data->ABSENTYPE_ID;
							if($validasi == 0){
								$this->registry->view->validasi = $validasi; 
							}else{
								$this->registry->view->validasi = $validasi;
							}
						}
					if(count($getAbsentYesterday) == 0){ 
						# jika kemarin tidak absen, dianggap bolos
						$this->registry->mAbsensiHarian->insert_AbsenALL($_SESSION['userid'], $calIDYesterday, 0);
					}	
					
					# ambil absen pulang hari kemarin
					$getAbsentHomeYesterday	=	$this->registry->mCalendar->cekMaxCalendarHarian($getDate, $getMonth,$getYear, $_SESSION['userid']);
					/*tambahan*/
					$this->registry->view->dataAbsentHomeYesterday = $getAbsentHomeYesterday;
					/*end*/
					
					if(count($getAbsentHomeYesterday) > 0){ 
						$this->registry->view->dataAbsentHomeYesterday = $getAbsentHomeYesterday;
						$this->registry->view->tab2 = 'form_absenpulang_kemarin';
						
					}else{ 				
						# ambil data absen masuk hari ini
						$getAbsentToday	= $this->registry->mAbsensiHarian->cekCalendarHarian(1,$getDate,$getMonth,$getYear,$_SESSION['userid']);
						$this->registry->view->getAbsentToday = $getAbsentToday;
						if(count($getAbsentToday)== 0){
						
							if($nowTime <= "16:00:00") $this->registry->view->tab2 = 'form_absenmasuk';								
							else{
								# tidak absen masuk kantor untuk hari ini
								if (count($getAbsentToday) == 0) $this->registry->view->tab2 = "confirm_cannotAbsent";										
								else $this->registry->view->tab2 = 'form_absenpulang';																	
							}
						}else{
							if(($nowTime >= "16:00:00")){
								$this->registry->view->tab2 = 'form_absenpulang';
							}
						}						
					}
									
					# -------------------------------------VALIDASI ABSEN KELUAR
					$getAbsentBackYesterday = array();
					
					# ambil data absen kembali ke kantor untuk hari kemarin
					$getAbsentBackYesterday	=	$this->registry->mCalendar->cekMaxCalendarOut($getDate,$getMonth,$getYear, $_SESSION['userid']);					
					$this->registry->view->dataAbsentBackYesterday = $getAbsentBackYesterday;
					if(count($getAbsentBackYesterday) > 0){ 
						//echo count($getAbsentBackYesterday);
						$this->registry->view->dataAbsentBackYesterday = $getAbsentBackYesterday;
						$this->registry->view->tab3 = 'form_absenkembali';
					}else{
						#ambil data absen keluar
						$getAbsentOut	= $this->registry->mAbsenOut->cekCalendarOut(1,$getDate, $getMonth,$getYear, $_SESSION['userid']);
						$this->registry->view->getAbsentOut = $getAbsentOut;
						if(count($getAbsentOut) > 0){
							# apakah sudah absen kembali?
							$getAbsentBack	= $this->registry->mAbsenOut->cekCalendarOut(0,$getDate, $getMonth,$getYear, $_SESSION['userid']);
							$this->registry->view->getAbsentBack = $getAbsentBack;
							if(count($getAbsentBack) > 0)
								$this->registry->view->tab3 = 'form_absenpulangout';	
							else
								$this->registry->view->tab3 = 'form_absenmasukout';	
						}else{
							$this->registry->view->tab3 = 'form_absenmasukout';
						}
					}
					
					//untuk window task
					if(isset($_POST['submitTask'])){
						$this->registry->view->submit = 1;
						$this->registry->view->ind1=$_POST['inputTask'];
						$this->registry->view->ind2 = $_POST['prosentaseTask'];
					}
					$this->registry->view->content = 'tab_absentTask';
					
				}else{ 
					echo '<script>location.href = "index.php"</script>';
				}
			}
		
		
	
			/******** Alert Rekomendasi ********/
			$getData=$this->registry->mAbsenTemp->selectDB_absenTemp($_SESSION['userid'],"user_recommendation", 0);
			echo count($getData);
		
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
	
	/*
	public function backToOffice(){
		try{
			for ($i = 1; $i < $_POST['ctrOut']; $i++) {
				$abh = "abhID".$i; 
				$jamOut = "tTime".$i; 
				$noteOut = "tNote".$i; 
				$wsOut = "tWs".$i; 
				$this->registry->mAbsensiHarian->update_Absenout($_POST[$jamOut], $_POST[$noteOut], $_POST['ipAddress'], $_POST[$wsOut], $_POST[$abh]);
			}
			//tambahan 130710
		echo "<script>location.href=\"index.php?mod=absen\"</script>";
			
		}catch(Exception $e){
			$this->registry->error  = $e->getMessage();
			$this->registry->view->content	= 'errorMsg';
			$this->registry->view->show('template');
		}
	}
	
	
	public function absenReport() {
		$this->registry->view->tasklist = $this->registry->mTask->selectDB_task();
		
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
		
	
		
 		$this->registry->view->content = 'tab_laporan';
		$url = explode('/',$_GET['mod']);
		$this->registry->view->url = $url[1];
		$this->registry->view->show ('template');
	}
	*/
	
	public function nowTime(){
		$this->registry->mCalendar->getTime();
		$this->registry->view->show('template');
	}
	
	public function cekCalendar(){
       $this->registry->mAbsensiHarian->cekCalendarHarian(1,$this->registry->mCalendar->getDate(),$this->registry->mCalendar->getMonth(),$this->registry->mCalendar->getYear(),$_SESSION['userid']);
	   $this->registry->view->show('template');
	}
	
	/* public function actAbsenHarian(){
		$dataUser = $this->registry->mAbsensiHarian->select_UserUdahAbsen($_SESSION['userid'], $_POST['CalendarID']);
		foreach ($dataUser as $user){
			$userid = $user->USER_ID;
		}
					
		if($_SESSION['userid'] != $userid){
			try{
				//$this->registry->mAbsensiHarian->insert_Absen($_SESSION['userid'], $_POST['CalendarID'], $_POST['tTime'],$_POST['tNote'], $_POST['ipAddress'], $_POST['radio']);
				$this->registry->mAbsensiHarian->insert_Absen($_SESSION['userid'], $_POST['CalendarID'], $this->registry->mCalendar->getTime(), $_POST['tNote'], $this->registry->mUser->getIPGuest(), $_POST['radio']);
				header('Location:index.php?mod=index/Task');
			}catch(Exception $e){
				$this->registry->error  = $e->getMessage();
				$this->registry->view->content	= 'errorMsg';
				$this->registry->view->show('template');
      		}
		}
		else {
			echo "<script>location.href=\"index.php\"</script>";
		}
	} */
	
	/*
	public function submitAbsentForWork(){
		try{
			if($_POST['radio'] == 1){
				$this->registry->mAbsensiHarian->insert_Absen($_SESSION['userid'], $_POST['CalendarID'], $_POST['tTime'], $_POST['tNote'], $_POST['ipAddress'], 1);
			}else{
				$this->registry->mAbsensiHarian->update_Absen($_POST['tTime'], $_POST['tNote'], $_POST['ipAddress'], $_POST['tWs'], $_SESSION['user_id'], $_POST['CalendarID']);			
			}
			echo "<script>location.href=\"index.php?mod=absen\"</script>";
      	}catch(Exception $e){
			$this->registry->error  = $e->getMessage();
			$this->registry->view->content	= 'errorMsg';
			$this->registry->view->show('template');
		}
	}
	
	
	public function actAbsenPulang(){
		try{
			$this->registry->mAbsensiHarian->update_Absen($_POST['tTime'], $_POST['tNote'], $_POST['ipAddress'], $_POST['tWs'], $_SESSION['userid'], $_POST['CalendarID']);
			echo '<script>location.href="index.php?mod=index/absen";</script>';
      	}catch(Exception $e){
			$this->registry->error  = $e->getMessage();
			$this->registry->view->content	= 'errorMsg';
			$this->registry->view->show('template');
		}
	}
	
	
	public function submitAbsentGoHome(){
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
			echo "<script>location.href=\"index.php?mod=absen\"</script>";
			// echo '<script>location.href="index.php?mod=index/Task";</script>';
      	}catch(Exception $e){
			$this->registry->error  = $e->getMessage();
			$this->registry->view->content	= 'errorMsg';
			$this->registry->view->show('template');
		}
	}
	*/
	
	public function absenKeluar(){
		$calendar_id = $this->registry->mCalendar->select_calendarID($this->registry->mCalendar->getDate(), $this->registry->mCalendar->getMonth(), $this->registry->mCalendar->getYear());
		$dataUser = $this->registry->mAbsensiHarian->select_UserUdahAbsen($_SESSION['userid'], $calendar_id);
		
		$cekHarian=$this->registry->mAbsensiHarian->cekCalendarHarian(1,$this->registry->mCalendar->getDate(),$this->registry->mCalendar->getMonth(),$this->registry->mCalendar->getYear(),$_SESSION['userid']);
		$dataabsenkeluar = $this->registry->mAbsenOut->select_UserAbsenKeluar($cekHarian);
		if ($dataUser == 'Data kosong'){
			$this->registry->view->content	= 'confim_blmabsenmasuk';
        }
		elseif($dataabsenkeluar != 'Data kosong'){
			$this->registry->view->content	= 'confirm_blmabsenkembali';
		}
		else{
			$this->registry->view->content	= 'form_absenmasukout';		
		}
		$this->registry->view->show('template'); 
	}
	
	public function actAbsenKeluar(){
		$absenkeluar = NULL;
		
		$dataabsenkeluar = $this->registry->mAbsenOut->select_UserAbsenKeluar($_POST['harianID']);
		if(count($dataabsenkeluar) > 0){
			foreach ($dataabsenkeluar as $keluar){
					$absenkeluar = $keluar->ABSENSIHARIAN_ID;
			}
		}
		if($_POST['harianID'] != $absenkeluar){
			try{
				//insert_absenOut($idHarian, $tipe, $timeIN, $note, $ip)
				$this->registry->mAbsenOut->insert_absenOut($_POST['harianID'], $_POST['rbAbsen'], $this->registry->mCalendar->getTime(), $_POST['tNote'], $this->registry->mUser->getIPGuest());
				//header('Location:index.php?mod=index/Task');
			}catch(Exception $e){
				$this->registry->error  = $e->getMessage();
				$this->registry->view->content	= 'errorMsg';
				$this->registry->view->show('template');
			}
		}
		else{
			$this->registry->view->content	= 'form_absenpulangout';
			$this->registry->view->show('template');
		}
	}
	
	/*
	public function submitAbsentOutOffice(){
		try{
			if($_POST['tAbsen']==1){ //absenKeluar kantor
				$this->registry->mAbsenOut->insert_absenOut($_POST['harianID'], $_POST['rbAbsen'], $_POST['tTime'], $_POST['tNote'], $_POST['ipAddress']);
				// $ins_CInterfaceAbsensi->askOut(2);
				echo "<script>location.href=\"index.php?mod=absen\"</script>";
			}elseif($_POST['tAbsen']==01){
				$this->registry->mAbsenOut->update_Absenout($_POST['tTime'], $_POST['tNote'], $_POST['ipAddress'], $_POST['tWs'], $_POST['harianID']);
				//setelah absen kembali di submit,tampilkan absen pulang
			}else{
				$this->registry->mAbsenOut->update_Absenout($_POST['tTime'], $_POST['tNote'], $_POST['ipAddress'], $_POST['tWs'], $_POST['harianID']);
			}
      	}catch(Exception $e){
			$this->registry->error  = $e->getMessage();
			$this->registry->view->content	= 'errorMsg';
			$this->registry->view->show('template');
		}
	}
	*/
	
	public function absenPulangOut(){
		$cekHarian=$this->registry->mAbsensiHarian->cekCalendarHarian(1,$this->registry->mCalendar->getDate(),$this->registry->mCalendar->getMonth(),$this->registry->mCalendar->getYear(),$_SESSION['userid']);
		$dataabsenkeluar = $this->registry->mAbsenOut->select_UserAbsenKeluar($cekHarian);
		if(($dataabsenkeluar == 'Data kosong'))
		{
		$this->registry->view->content	= 'confirm_absenpulangudah';
		$this->registry->view->show('template');
		}else{
		$this->registry->view->content	= 'form_absenpulangout';
		$this->registry->view->show('template');
		}
	}
	
	/*
	public function actAbsenPulangOut(){
		try{
			//update_Absenout($out_timeend, $out_descend, $ip_End, $worksummary, $harianID)
			$this->registry->mAbsenOut->update_AbsenOut($_POST['tTime'], $_POST['tNote'], $_POST['ipAddress'], $_POST['tWs'], $_POST['harianID']);
			echo "<script>location.href=\"index.php?mod=absen\";</script>";
      	}catch(Exception $e){
			$this->registry->error  = $e->getMessage();
			$this->registry->view->content	= 'errorMsg';
			$this->registry->view->show('template');
		}
	}
	*/
	
		
	public function absenHarian(){

		$calendar_id = $this->registry->mCalendar->select_calendarID($this->registry->mCalendar->getDate(), $this->registry->mCalendar->getMonth(), $this->registry->mCalendar->getYear());
		$dataUser = $this->registry->mAbsensiHarian->select_UserUdahAbsen($_SESSION['userid'], $calendar_id);
		if ($dataUser == 'Data kosong'){
			# date, month, year adalah variable yg dapat dipanggil dari fungsi ini saja
			$date = $this->registry->mCalendar->getDate();
			$month = $this->registry->mCalendar->getMonth();
			$year = $this->registry->mCalendar->getYear();
		
			# calendar_id adalah variable yg dapt dipanggil dari form yg bersangkutan (form_absenmasuk)
			$this->registry->view->tasklist = $this->registry->mTask->selectDB_task();
			$this->registry->view->ip = $this->registry->mUser->getIPGuest();
			$this->registry->view->nowTime = $this->registry->mCalendar->getTime();
			$this->registry->view->calendar_id = $this->registry->mCalendar->select_calendarID($date,$month,$year);
			$this->registry->view->content	= 'form_absenmasuk';
			$this->registry->view->show('template'); 
		}
		else{
			$this->registry->view->content	= 'form_absenpulang';
			$this->registry->view->show('template'); 
		}
	}
	
	//Perubahan
	//=============================================================
	
	//dipindah ke cReporting-->jadi index
	/*
	public function detailReport($userID,$calid){
		//dari mingguan
		$this->registry->view->tasklist = $this->registry->mTask->selectDB_task();
		
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
		
		//dari bulanan
		$this->registry->view->tasklist = $this->registry->mTask->selectDB_task();
		
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
			$year= $_POST['cmbYear'];
			$month = $_POST['cmbMonth'];
			if($_SESSION['level_id'] != 3)	$userid	= $_POST['cmbUser'];
			else							$userid = $_SESSION['userid'];
		}else{
			$year = $this->registry->mCalendar->getYear();
			$month = $this->registry->mCalendar->getMonth();
			$userid = $_SESSION['userid'];
		}
	
		if($month==1){
			$mm = 12;
		}else{
			$mm = $month - 1;
		}
			$bln_1=$this->registry->mCalendar->monthname($month);
			$bln_2=$this->registry->mCalendar->monthname($mm);
		
		
		if($month == 1){
        		$pastmonth = 12;
        }else{
				$pastmonth = $month - 1;
		}
		
		
		$this->registry->view->calid = $calid;
		$this->registry->view->userid = $userID;
		$this->registry->view->setActive = '2';
		$this->registry->view->detail='2';
		$this->registry->view->content="tab_laporan";
		$url = explode('/',$_GET['mod']);
		$this->registry->view->url = $url[1];
		$this->registry->view->show("template");
		
	}
	*/
	
	//dipindah ke cReporting
	/*
	public function absenReportBulanan() {
		$this->registry->view->tasklist = $this->registry->mTask->selectDB_task();
		
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
	
		/*
		if($month==1){
			$mm = 12;
		}else{
			$mm = $month - 1;
		}
			$bln_1=$this->registry->mCalendar->monthname($month);
			$bln_2=$this->registry->mCalendar->monthname($mm);
		
		
		if($month == 1){
        		$pastmonth = 12;
        }else{
				$pastmonth = $month - 1;
		}
		*/
		
	/*	
		$this->registry->view->setActive = '2';
 		$this->registry->view->content = 'tab_laporan';
		$url = explode('/',$_GET['mod']);
		$this->registry->view->url = $url[1];
		$this->registry->view->show ('template');
	}
	*/
	
	//dipindah ke cReporting
	/*
	public function absenReportKeluar() {
		$this->registry->view->tasklist = $this->registry->mTask->selectDB_task();
		
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
		

		
		if(isset($_POST['submitCalendar'])){
			$year= $_POST['cmbYear'];
			$month = $_POST['cmbMonth'];
			if($_SESSION['level_id'] != 3)	$userid	= $_POST['cmbUser'];
			else							$userid = $_SESSION['userid'];
		}else{
			$year = $this->registry->mCalendar->getYear();
			$month = $this->registry->mCalendar->getMonth();
			$userid = $_SESSION['userid'];
		}
	
		if($month==1){
			$mm = 12;
		}else{
			$mm = $month - 1;
		}
			$bln_1=$this->registry->mCalendar->monthname($month);
			$bln_2=$this->registry->mCalendar->monthname($mm);
		
		
		if($month == 1){
        		$pastmonth = 12;
        }else{
				$pastmonth = $month - 1;
		}
		
		
		
		$this->registry->view->setActive = '3';
 		$this->registry->view->content = 'tab_laporan';
		$url = explode('/',$_GET['mod']);
		$this->registry->view->url = $url[1];
		$this->registry->view->show ('template');
	}
	*/
	
	
	//dipindah ke cReporting
	/*
	public function actSaveToExcelBulanan($userid,$month,$year){
		$this->registry->view->userid = $userid;
		$this->registry->view->month = $month;
		$this->registry->view->year = $year;
		$this->registry->view->show("saveToExcelBulanan");
	}
	
	//dipindah ke cReporting
	public function actSaveToExcelKeluar($userid,$month,$year,$tipe){
		$this->registry->view->userid = $userid;
		$this->registry->view->month = $month;
		$this->registry->view->year = $year;
		$this->registry->view->tipeAbsen = $tipe;
		$this->registry->view->show("saveToExcelKeluar");
	}
	
	//dipindah ke cReporting
	public function actSaveToExcelDetail($month,$year){
		$this->registry->view->month = $month;
		$this->registry->view->year = $year;
		try{
			$this->registry->view->show("saveToExcelDetail");
		}catch(Exception $e){
			$this->registry->error  = $e->getMessage();
			$this->registry->view->content	= 'errorMsg';
			$this->registry->view->show('template');
		}
	}
	
	
	//dipindah ke cReporting
	public function absenReportDetail(){
		$this->registry->view->tasklist = $this->registry->mTask->selectDB_task();
		
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
			$year= $_POST['cmbYear'];
			$month = $_POST['cmbMonth'];
			if($_SESSION['level_id'] != 3)	$userid	= $_POST['cmbUser'];
			else							$userid = $_SESSION['userid'];
		}else{
			$year = $this->registry->mCalendar->getYear();
			$month = $this->registry->mCalendar->getMonth();
			$userid = $_SESSION['userid'];
		}
	
		if($month==1){
			$mm = 12;
		}else{
			$mm = $month - 1;
		}
			$bln_1=$this->registry->mCalendar->monthname($month);
			$bln_2=$this->registry->mCalendar->monthname($mm);
		
		
		if($month == 1){
        		$pastmonth = 12;
        }else{
				$pastmonth = $month - 1;
		}
	
	
	
	
		$this->registry->view->setActive = '4';
 		$this->registry->view->content = 'tab_laporan';
		$url = explode('/',$_GET['mod']);
		$this->registry->view->url = $url[1];
		$this->registry->view->show ('template');
	}
	
	

	public function showBulananAgain(){
		$this->registry->view->tasklist = $this->registry->mTask->selectDB_task();
		
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
	*/
	
	public function actWindowTask(){
		$this->registry->view->tasklist = $this->registry->mTask->selectDB_task(isset($_SESSION['userid'])?$_SESSION['userid']:'');
		$nowTime = $this->registry->mCalendar->getTime();
		$getDate = $this->registry->mCalendar->getDate();
		$getMonth = $this->registry->mCalendar->getMonth();
		$getYear = $this->registry->mCalendar->getYear();
		$getDateYesterday = $this->registry->mCalendar->getDateYesterday();
		$getAbsentHomeYesterday	=	$this->registry->mCalendar->cekMaxCalendarHarian($getDate, $getMonth,$getYear, $_SESSION['userid']);
					/*tambahan*/
		$this->registry->view->dataAbsentHomeYesterday = $getAbsentHomeYesterday;
		$getAbsentToday	= $this->registry->mAbsensiHarian->cekCalendarHarian(1,$getDate,$getMonth,$getYear,$_SESSION['userid']);						$this->registry->view->getAbsentToday = $getAbsentToday;
		$this->registry->view->submit = 1;
		$getAbsentYesterday	=	$this->registry->mAbsensiHarian->selectAbsenY($getDate,	$getMonth,$getYear, $_SESSION['userid']);								$this->registry->view->getAbsentYesterday = $getAbsentYesterday;
		$this->registry->view->validasi = 0;
		//$this->registry->view->ind1 = $inputTask;
		//$this->registry->view->ind1 = $prosentaseTask;
		$this->registry->view->content = 'tab_absentTask';
		$this->registry->view->show('template');
	}
	
	//tidak dipake
	public function statusAbsenRecomend(){
		$this->registry->view->content='gridUserRecomend';
			$url = explode('/',$_GET['mod']);
		$this->registry->view->url = $url[1];
		$this->registry->view->show('template');
	}	
}
?>
