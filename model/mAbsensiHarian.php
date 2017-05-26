<?php
class MAbsensiHarian{
	private $registry;

  	function __construct( $registry ) {
		$this->registry = $registry;
	}

	function select_reportKaryawan($userid) {
    	$userid = mysql_real_escape_string($userid);
    	$query="SELECT * FROM absensiharian a 
				JOIN calendar b ON a.calendar_id=b.calendar_id
    			WHERE a.user_id= ? ";

    	$stmt = $this->registry->db->Prepare($query);
    	$arrBinding[0] = $userid;

    	$rs = $this->registry->db->Execute($stmt,$arrBinding);
		
    	if($rs){
		
          if($rs->RecordCount() > 0){
            while($row = $rs->FetchNextObject()){
              $data[] = $row;
            }
			
          }else $data = 'Data kosong';
          
        }else $data = 'Gagal mengambil data';
        
        return $data;
	}


	function select_reportHarian($userid,$calID,$level) {
        $data = array();
		$query = "SELECT * FROM absensiharian WHERE calendar_id= ? ";
		
		# HRD dan admin
      	if ($level != 3){ 
      		$stmt = $this->registry->db->Prepare($query);
      		$arrBinding[0] = $calID;

      	}else{ # team
      		$query = $query."AND user_id = ?";
      		$stmt = $this->registry->db->Prepare($query);
      		$arrBinding[0] = $calID;
      		$arrBinding[1] = $userid;
      	}
      	
		//echo $query.' # '.$userid.', '.$calID.', '.$level;
      	$rs = $this->registry->db->Execute($stmt,$arrBinding);
		
      	if($rs){
			if($rs->RecordCount() > 0){
				while($row = $rs->FetchNextObject()){
				  $data[] = $row;
				}
			}
        }else throw new Exception('Gagal mengambil data select_reportHarian');
        return $data;
	}


	function select_reportBulanan($calid, $userid){
	    $data = array();
		$query = "SELECT * FROM absensiharian
						WHERE calendar_id=".$calid;
		if($userid != -1){
			$query .= " AND user_id=".$userid;
		}
		
		$query .= " ORDER BY calendar_id ASC";
		//echo $query.'</br>';
		//echo "<br>".$query."</br>";
    	$rs = $this->registry->db->Execute($query);
		//echo $calid;
		//echo $userid;
    	if($rs){
			if($rs->RecordCount() > 0){
            while($row = $rs->FetchNextObject()){
              $data[] = $row;
            }
		  }
		}else throw new Exception('Gagal mengambil data select_reportBulanan');
		
        return $data;
	}


	function select_reportBulananOut($calid, $userid, $tipeAbsen = NULL, $spjLokal = 0) {
		$data = array();
	    $query = "SELECT * FROM absensiharian a
				JOIN absensiout b ON a.absensiharian_id = b.absensiharian_id
				JOIN absen_type c ON b.out_type=c.type_id
				WHERE a.calendar_id = ".$calid;
		if($userid != NULL && $userid != '-1')	
			$query .= "	AND a.user_id= '".$userid."'";
		
    	if($tipeAbsen != NULL && $tipeAbsen != -1 ){
    	    $query .= " AND b.out_type = ".$tipeAbsen;
    	}/*elseif($tipeAbsen === 0){ 
    	    $query .= " AND a.absenType_id = ".$tipeAbsen;
			
		}*/
		

    	/*if($tipeAbsen == 5){
    	    $query .= " AND b. out_timestart  <= '12:00'";
    	}elseif($tipeAbsen == 6){
    	    $query .= " AND b. out_timestart  >= '12:00'";
    	}*/
		$query .= " ORDER BY a.calendar_id asc;";
    	//echo "<br>*calid: ".$calid." userid ".$userid." type ".$tipeAbsen;
    	//echo "<br>".$query."<br>";
		//echo $query."</br>";
    	$rs = $this->registry->db->Execute($query);
    	//echo $rs."</br>";
		if($rs){
          if($rs->RecordCount() > 0){
            while($row = $rs->FetchNextObject()){
              $data[] = $row;
            }
		  }
		}else throw new Exception($query.' Gagal mengambil data select_reportBulanan');

        return $data;
	}

	function select_reportMingguan($cal_id, $userid = NULL){
        //			echo "<br>*calendarID: ".$cal_id." userid ".$userid;
		$data = array();
        $query = "SELECT * , TIMEDIFF( ah.start_time, '08:10:00') AS late
                  FROM absensiharian ah
                  JOIN calendar c ON ah.calendar_id = c.calendar_id
                  JOIN `day` d ON c.day_id = d.day_id
                  WHERE c.calendar_id =".$cal_id;
        if($userid != NULL && $userid != -1){
            $query = $query." AND ah.user_id = '".$userid."'";
        }
        $query = $query." AND c.status=1 ORDER BY ah.user_id, ah.calendar_id";


        //echo "<br>".$query."<br>";
        $rs = $this->registry->db->Execute($query);
        if($rs){
          if($rs->RecordCount() > 0){
            while($row = $rs->FetchNextObject()){
              $data[] = $row;
            }
          }
        }else throw new Exception('Gagal mengambil data select_reportMingguan');

        return $data;
	}

	function select_AllReportDetail($cal_id, $userid){
    	$data = array();
    	//echo "<br>*calendarID: ".$cal_id." userid ".$userid;
    	$query = "SELECT a.absensiharian_id, a.user_id, a.calendar_id, a.start_time, a.start_desc, a.out_time, a.out_desc, a.worksummary AS ws_harian, a.absenType_id, b.absenout_id, b.out_type, b.out_timestart, b.out_descstart, b.out_timeend, b.out_descend, b.worksummary AS ws_out
    				FROM absensiharian a LEFT OUTER JOIN absensiout b ON a.absensiharian_id = b.absensiharian_id
    				JOIN calendar c ON a.calendar_id = c.calendar_id
    				WHERE a.calendar_id =".$cal_id."
    				AND a.user_id = '".$userid."'
    				AND c.status =1";

    			// echo "<br>*select_AllReportDetail:".$query."<br>";
    	$rs = $this->registry->db->Execute($query);
    	if($rs){
          if($rs->RecordCount() > 0){
            while($row = $rs->FetchNextObject()){
              $data[] = $row;
            }
          }
        }else{
          throw new Exception('Gagal mengambil data');
        }
	//	echo $query;
        return $data;
	}

	function selectAbsenY($tgl, $bulan, $tahun, $userid){
    	$data = array();
    	$query = " SELECT * FROM absensiharian WHERE calendar_id = ( SELECT max( calendar_id ) FROM calendar
    				WHERE calendar_id < ( SELECT calendar_id FROM calendar WHERE ( date =? AND MONTH =? AND year =?) )
    				AND STATUS =1 ) AND user_id = ?";

    	$stmt = $this->registry->db->Prepare($query);
    	$arrBinding[0] = $tgl;
    	$arrBinding[1] = $bulan;
    	$arrBinding[2] = $tahun;
    	$arrBinding[3] = $userid;

    	//echo "<br>*selectAbsenY:".$query."<br>".$tgl.'#'.$bulan.'#'.$tahun.'#'.$userid;
    	$rs = $this->registry->db->Execute($stmt,$arrBinding);
    	if($rs){
          if($rs->RecordCount() > 0){
            while($row = $rs->FetchNextObject()){
              $data[] = $row;
            }
          }
        }else throw new Exception('Gagal mengambil data absensiharian');

        return $data;
	}

    # buat insert jam masuk
	function insert_Absen($userid, $day, $start_time, $start_desc, $ip_From, $absenstatus){
    	//echo "<br>#insert: ".$userid."#".$day."#".$start_time."# ".$start_desc."#".$ip_From."# ".$absenstatus." <br>";
    	$userid 		= mysql_real_escape_string($userid);
    	$day 			= mysql_real_escape_string($day);
    	$start_time 	= mysql_real_escape_string($start_time);
    	$start_desc 	= mysql_real_escape_string($start_desc);
    	$ip_From 		= mysql_real_escape_string($ip_From);
    	$absenstatus 	= mysql_real_escape_string($absenstatus);

    	$query = "INSERT INTO absensiharian (user_id, calendar_id, start_time,
                start_desc, start_inputFrom, absenType_id, input1_dtm)
    			VALUES (?, ?, ?, ?, ?, ?, now())";
		//echo $query;
    	$stmt = $this->registry->db->Prepare($query);
    	$arrBinding[0] = $userid;
    	$arrBinding[1] = $day;
    	$arrBinding[2] = $start_time;
    	$arrBinding[3] = $start_desc;
    	$arrBinding[4] = $ip_From;
    	$arrBinding[5] = $absenstatus;

    	//echo "<br>#insert: ".$query."<br>";
		$rs = $this->registry->db->Execute($stmt,$arrBinding);
		if(!$rs) throw new Exception('Gagal menyimpan absen masuk');
	}

	function cekCalendarHarian($type, $tgl, $bulan, $tahun, $userid = NULL){
			$data = array();
			$query = "SELECT a.absensiharian_id, a.user_id, a.calendar_id, a.absenType_id, a.start_time, a.out_time, b.date, b.month, b.year, b.status
						FROM absensiharian a JOIN calendar b ON a.calendar_id=b.calendar_id
						WHERE b.date=? AND b.month=? AND b.year=? AND b.status=1";
			if(!empty($userid)){
			$query = $query." AND a.user_id=?";
			}		
			
			if($type==0)
				$query = $query." AND (a.out_time IS NULL OR a.out_time = '00:00:00')";
			
			$stmt = $this->registry->db->Prepare($query);
			$arrBinding[0] = $tgl; 
			$arrBinding[1] = $bulan; 
			$arrBinding[2] = $tahun; 
			
			if(!empty($userid)){
				$arrBinding[3] = $userid; 
			}	
			$rs = $this->registry->db->Execute($stmt,$arrBinding);	
				//echo $query.' '.$type. '-'. $tgl. '-'. $bulan. '-'. $tahun. '-'. $userid;
			if($rs){
			  if($rs->RecordCount() > 0){
				while($row = $rs->FetchNextObject()){
				  $data[] = $row;
				}
			  }
			}else throw new Exception("Gagal memeriksa cekCalendarHarian");
			//echo  $query."<br>*: ".$type." ## ".$tgl." ## ".$bulan." ## ".$tahun." ...";
			
			return $data;
	}

    # buat insert jam masuk jika kemaren lom absen masuk
	function insert_AbsenALL($userid, $day, $tipeAbsen) {
	
    	$userid 		= mysql_real_escape_string($userid);
    	$day 			= mysql_real_escape_string($day);
    	$tipeAbsen 		= mysql_real_escape_string($tipeAbsen);

    	$query = "INSERT INTO absensiharian (user_id, calendar_id, absenType_id,
                start_time, out_time, start_desc, out_desc, input1_dtm, input2_dtm)
    			VALUES (?, ?, ?, ?, ?, ?,?, now(), now())";

    	$stmt = $this->registry->db->Prepare($query);
    	$arrBinding[0] = $userid;
    	$arrBinding[1] = $day;
    	$arrBinding[2] = $tipeAbsen;
    	$arrBinding[3] = '24:00';
    	$arrBinding[4] = '24:00';
    	$arrBinding[5] = 'Bolos/Lupa absen';
    	$arrBinding[6] = 'Bolos/Lupa absen';

    	$rs = $this->registry->db->Execute($stmt,$arrBinding);
		if(!$rs) throw new Exception("Gagal menyimpan absen bolos");
	}

     # buat insert jam pulang
	function update_Absen($out_time, $out_desc, $ip_End, $worksummary, $userid, $day) {
		$userid = mysql_real_escape_string($userid);	
		$day = mysql_real_escape_string($day);		
		$out_desc = mysql_real_escape_string($out_desc);	
		$ip_End = mysql_real_escape_string($ip_End);	

    	$query = "UPDATE absensiharian
    				SET out_time=?, out_desc=?, out_inputEnd=?, worksummary=?, input2_dtm = now()
    				WHERE user_id=? and calendar_id=?";

    	$stmt = $this->registry->db->Prepare($query);
    	$arrBinding[0] = $out_time;
    	$arrBinding[1] = $out_desc;
    	$arrBinding[2] = $ip_End;
    	$arrBinding[3] = $worksummary;
    	$arrBinding[4] = $userid;
    	$arrBinding[5] = $day;
		//echo $query.'    #'.$out_time.'#'.$out_desc.'#'.$ip_End.'#'.$worksummary.'#'.$userid.'#'.$day;
    	$rs = $this->registry->db->Execute($stmt,$arrBinding);
		if(!$rs) throw new Exception("Gagal mengupdate absen pulang");
	}

	function updateDB_attendanceIn($userid, $start_time, $start_desc, $calid){ 

		$query = "UPDATE absensiharian SET start_time ='".$start_time."', start_desc = '". $start_desc."', 
					start_inputFrom = '".$this->registry->mUser->getIPGuest()."', 
					out_time = '00:00:00', out_desc = NULL, absenType_id = 1, input1_dtm = now(),input2_dtm = '0000-00-00 00:00:00'
					WHERE user_id = '".$userid."' AND calendar_id = ".$calid;
 		//echo $query;
		$rs = $this->registry->db->Execute($query);
	}

	function edit_statusAbsen($userid,$note, $absentype){
		$day = jddayofweek ( cal_to_jd(CAL_GREGORIAN, date("m"),date("d"), date("Y")) , 1 );

		$userid		= mysql_real_escape_string($userid);
		$note		= mysql_real_escape_string($note);
		$absentype	= mysql_real_escape_string($absentype);
		$day 		= mysql_real_escape_string($day);

		$getUser = $this->selectDB_absensiHarian($userid);
		if($getUser->RecordCount() > 0){
			$query  = "UPDATE absensiharian SET absentype_id = ".$absentype.", note = '".$note."'
						WHERE user_id = '".$userid."'";
		}else{
			$query = "INSERT INTO absensiharian(user_id, day, start_dtm, login_ip, note, absenType_id)
						VALUES('".$userid."', '".$day."', now(), '".getenv(HTTP_X_FORWARDED_FOR)."', '".$note."', ".$absentype.")";
		}

		$rs = $this->registry->db->Execute($query);
	}

	

    public function selectDB_absensiHarianTimeline(){
    	$query = "SELECT u.user_id, u.name as uname, u.photo
    				FROM `user` u JOIN absensiharian ah ON u.user_id = ah.user_id
                    ORDER BY ah.start_time DESC";
		//echo $query;
    	$rs = $this->registry->db->Execute($query);
        if($rs){
          if($rs->RecordCount() > 0){
            while($row = $rs->FetchNextObject()){
              $data[] = $row;
            }
          }else{
            $data = 'Data kosong';
          }
        }else{
          $data = 'Gagal mengambil data';
        }
        return $data;
    }
	

	public function select_UserUdahAbsen($user,$calendar){
    	$query = "SELECT user_id
					FROM absensiharian where user_id = '$user' and calendar_id = '$calendar' ";
    	$rs = $this->registry->db->Execute($query);
        if($rs->RecordCount() > 0){
            while($row = $rs->FetchNextObject()){
              $data[] = $row;
            }
          }else{
            $data = 'Data kosong';
          }
        return $data;
    }


	function selectDB_absensiHarian($userid = NULL){
		$userid	= mysql_real_escape_string($userid);

		$query = "SELECT * FROM absensiharian ";
		if($userid != NULL)
			$query .= "WHERE user_id = '".$userid."'";
		$query .= " ORDER BY start_time DESC LIMIT 0,10";
		$rs = $this->registry->db->Execute($query);
        if($rs){
          if($rs->RecordCount() > 0){
            while($row = $rs->FetchNextObject()){
              $data[] = $row;
            }
          }else{
            $data = 'Data kosong';
          }
        }else{
          $data = 'Gagal mengambil data';
        }
        return $data;
	}
	
	function selectDB_absensi_type($userid = NULL, $calid = NULL){
		$userid	= mysql_real_escape_string($userid);

		$query = "SELECT * FROM absensiharian ah
					JOIN absen_type at ON ah.absentype_id = at.type_id";

		if($userid != NULL){
			$query .= " WHERE ah.user_id = '".$userid."'";

			if($calid != NULL)
				$query .= " AND ah.calendar_id = '".$calid."'";

			$rs = $this->registry->db->Execute($query);
			$typeid = NULL;
			if($rs){
				if($rs->RecordCount() > 0){
			
					while($data = $rs->FetchNextObject()){
						$typeid = $data->TYPE_ID;
					}
				}
			}else throw new Exception('Gagal mengambil data selectDB_absensi_type');
			
			return $typeid;

		}else{
			if($rs){
			  if($rs->RecordCount() > 0){
				while($row = $rs->FetchNextObject()){
				  $data[] = $row;
				}
			  }else{
				$data = 'Data kosong';
			  }
			}else{
			  $data = 'Gagal mengambil data';
			}
			return $data;
		}

	}

	function selectDB_outOffice($userid,  $absen = NULL,$calid_1 = NULL, $cntr = 0,$calid_2 =NULL){
		//echo $userid."#".$calid_1."#".$calid_2;
		$data = array();
		$query = "SELECT * FROM absensiharian a
				JOIN absensiout o ON a.absensiharian_id = o.absensiharian_id
				JOIN absen_type t ON o.out_type = t.type_id
				WHERE a.user_id = '".$userid."'";
		if($calid_1 != NULL){
			if($calid_2 != NULL){
				$query .= " AND a.calendar_id BETWEEN ".$calid_1." AND ".$calid_2;
			}else{
				$query .= " AND a.calendar_id= ".$calid_1."";
			}
		}
		if($absen != NULL)
			$query .= " AND o.out_type = ".$absen;

		if($cntr != 0){
			//echo "<br>".$query;
			$jml=0;
			$rs = $this->registry->db->Execute($query);
			$cnt = $rs->RecordCount();
			return $cnt;
			/*if ($cnt!=0){ //ada hasilnya
				$jml = $jml+1;
			}
			return $jml;	*/
		}else{
			$rs = $this->registry->db->Execute($query);
			if($rs){
			  if($rs->RecordCount() > 0){
				while($row = $rs->FetchNextObject()){
				  $data[] = $row;
				}
			  }
			}else throw new Exception("Gagal mengambil data");
			return $data;
		}
		
		

	}

      function selectDB_jamMasukKantor($userid = NULL, $jam = NULL, $operator = NULL){
		   $query = "SELECT * FROM absensiharian ah
					JOIN calendar c ON ah.calendar_id = c.calendar_id
					WHERE c.day_id between 1 and 4 ";
		   if($userid != NULL)
				$query .= "AND  ah.user_id = '".$userid."'";

		   if($jam != NULL)
				$query .= "AND ah.START_TIME ".$operator." '".$jam ."' AND ah.START_TIME <> '24:00'";

		   //echo $query;
		   $rs = $this->registry->db->Execute($query);
	       $cnt = $rs->RecordCount();
               return $cnt;
        }
		
	function update_Absenout($out_timeend, $out_descend, $ip_End, $worksummary, $harianID)   //buat insert jam pulang OUT
	{
			//echo "<br>jam keluar: ".$out_timeend." note keluar: ".$out_descend." ip keluar: ".$ip_End." ws : ".$worksummary." harian id: ".$harianID."<br>";
			$out_timeend = mysql_real_escape_string($out_timeend);	
			$out_descend = mysql_real_escape_string($out_descend);	
			$ip_End = mysql_real_escape_string($ip_End);	
			$worksummary = mysql_real_escape_string($worksummary);	
			$harianID = mysql_real_escape_string($harianID);	
			//$tipe = mysql_real_escape_string($tipe);	
			
			$query = "UPDATE absensiout
						SET out_timeend=?, out_descend=?, input_endfrom=?, worksummary=?
						WHERE absensiharian_id=?";
					
			//$stmt = $this->conn->Prepare($query);
			$stmt = $this->registry->db->Prepare($query);
			$arrBinding[0] = $out_timeend; 
			$arrBinding[1] = $out_descend;
			$arrBinding[2] = $ip_End; 
			$arrBinding[3] = $worksummary;
			$arrBinding[4] = $harianID;
			//echo "<br>*update_Absenout : ".$query."<br>";
			//$rs = $this->conn->Execute($stmt,$arrBinding);
			$rs = $this->registry->db->Execute($stmt,$arrBinding);
			
	}
	
	
		function cekMaxCalendarOut($tgl, $bulan, $tahun, $userid = NULL)
		{
			$data = array();
			//echo "<br>*********tgl: ".$tgl." ## ".$bulan." ## ".$tahun." ## ".$userid." ...";
			$query = "  SELECT max( b.calendar_id ) AS calendar_id, a.date, a.month, a.year, c.*, b.absensiharian_id
						FROM calendar a JOIN absensiharian b ON a.calendar_id = b.calendar_id
						JOIN absensiout c ON b.absensiharian_id = c.absensiharian_id
						WHERE a.calendar_id < ( SELECT calendar_id FROM calendar WHERE ( date ='$tgl' AND MONTH ='$bulan' AND year ='$tahun' ) )
						AND a.status =1 AND ( c.out_timeend IS NULL OR c.out_timeend = '00:00:00' )";
			if(!empty($userid)){
			$query = $query." AND b.user_id='$userid'";
			}		
			
			$query = $query." GROUP BY b.calendar_id";
			//echo $query;
			/*$stmt = $this->registry->db->Prepare($query);
			$arrBinding[0] = $tgl; 
			$arrBinding[1] = $bulan; 
			$arrBinding[2] = $tahun; 
			
			if(!empty($userid)){
				$arrBinding[3] = $userid; 
			}	*/
			$rs = $this->registry->db->Execute($query);	
			if ($rs) {
				if ($rs->RecordCount() > 0 ) {
					while($row = $rs->FetchNextObject()){
						$data[] = $row;
					}	
				}
			}
			//echo "<br>*********cekMaxCalendarOut:".$query."<br>";
			return $data;
	}
	
	function selectDB_user($userid = NULL){
		$query = "SELECT * FROM `user` WHERE HRDstatus = '1' AND level_id = '3'";
		if($userid != NULL)		$query .= " AND user_id='".$userid."'";
		$query .=" ORDER BY `name`";
		//$rs = $this->conn->Execute($query);
		$rs = $this->registry->db->Execute($query);
		return $rs;		
	}		
	
	function cekMaxCalendarHarian($tgl, $bulan, $tahun, $userid = NULL)
	{
		$data = array();
			//echo "<br>*tgl: ".$tgl." ## ".$bulan." ## ".$tahun." ## ".$userid." ...";
			
			$prevTahun = $tahun;
			
			/*if ($bulan == '01'){
				
				$prevBulan = '12';	
				$prevTahun = $tahun - 1;
			}else{
				$prevBulan=substr($bulan, 1, 1);
				
				$prevBulan = $prevBulan - 1;
				
				if (strlen($prevBulan) != 2){
					$prevBulan = '0'.$prevBulan;						
				}				
			}*/
			$prevBulan = date('m', strtotime('-1 month'));
			
			
			//echo "<br>*tgl: ".$tgl." ## ".$prevBulan." ## ".$prevTahun." ## ".$userid." ...";
			
			$query = " SELECT max( b.calendar_id ) AS calendar_id, b.absensiharian_id, b.user_id, b.absenType_id, b.start_time, b.out_time, a.date, a.month, a.year, a.status
						FROM calendar a	JOIN absensiharian b ON a.calendar_id = b.calendar_id
						WHERE a.calendar_id < (SELECT calendar_id	FROM calendar WHERE (date =".$tgl." AND MONTH =".$bulan." AND year =".$tahun.") )
						AND a.calendar_id > (SELECT calendar_id	FROM calendar WHERE (date = 25 AND MONTH =".$prevBulan." AND year =".$prevTahun.") )
						AND a.status =1
						AND (b.out_time IS NULL OR b.out_time = '00:00:00') ";
			if(!empty($userid)){
			$query = $query." AND b.user_id='".$userid."'";
			}		
			
			$query = $query." GROUP BY b.calendar_id";
					
			$rs = $this->registry->db->Execute($query);	
			if ($rs) {
				if ($rs->RecordCount() > 0 ) {
					while($row = $rs->FetchNextObject()){
						$data[] = $row;
					}	
				}
			}
			//echo "<br>*cekMaxCalendarHarian:".$query."<br>";
			return $data;
	}	

		
	function firstDayOfweek(){
		$query = "SELECT date_sub( curdate( ) , INTERVAL WEEKDAY( curdate( ) ) -0 DAY ) 
				AS firstDayOfweek";
		$rs = $this->registry->db->Execute($query);
		while($data = $rs->FetchNextObject()){
			$fdw = $data->FIRSTDAYOFWEEK;
		}
		return $fdw;
	}
	
	public function get_absensiHarianID($userid, $calid){
		$query = "SELECT absensiharian_id FROM absensiharian WHERE user_id = '".$userid."' AND calendar_id = ".$calid;
		$data = NULL;
		$rs = $this->registry->db->Execute($query);
		if ($rs) {
			if ($rs->RecordCount() > 0 ) {
				while($row = $rs->FetchNextObject()){
					$data = $row->ABSENSIHARIAN_ID;
				}	
			}
		}else throw new Exception("Gagal mengambil data get_absensiHarianID");
		echo "<br>".$query."<br>";
		return $data;
	}
	
	public function selectDB_attendance_inDetail($id){
		$data = array();
		$query = "SELECT ah.absensiharian_id AS id, ah.user_id AS userid, u.name,  'title' AS title, ah.start_desc AS content, 
				  	ah.input1_dtm AS tanggal, 'attendance_in' AS identity, u.photo
				  	FROM absensiharian ah join calendar c ON ah.calendar_id = c.calendar_id
				  	JOIN user u ON ah.user_id = u.user_id
					WHERE ah.absensiharian_id = '".$id."'";
		$rs = $this->registry->db->Execute($query);
		if($rs){
		    if($rs->RecordCount() > 0){
			while($row = $rs->FetchNextObject()){
			  $data[] = $row;
			}
		  }
		}else throw new Exception('Gagal ambil selectDB_wallDetail');
		return $data;
	}
	
	public function selectDB_attendance_outDetail($id){
		$data = array();
		$query = "SELECT absensiharian_id AS id, ah.user_id AS userid, u.name,  'title' AS title, out_desc AS content, 
				  	ah.input2_dtm AS tanggal, 'attendance_out' AS identity, u.photo 
				  	FROM absensiharian ah join calendar c ON ah.calendar_id = c.calendar_id
				  	JOIN user u ON ah.user_id = u.user_id
					WHERE ah.absensiharian_id = '".$id."'";
		$rs = $this->registry->db->Execute($query);
		if($rs){
		    if($rs->RecordCount() > 0){
			while($row = $rs->FetchNextObject()){
			  $data[] = $row;
			}
		  }
		}else throw new Exception('Gagal ambil selectDB_wallDetail');
		return $data;
	}
	public function selectDB_attendance_summaryDetail($id){
		$data = array();
		$query = "SELECT absensiharian_id AS id, ah.user_id AS userid, u.name,  'title' AS title, worksummary AS content, 
				  	ah.input2_dtm AS tanggal, 'attendance_summary' AS identity, u.photo 
				  	FROM absensiharian ah join calendar c ON ah.calendar_id = c.calendar_id
				  	JOIN user u ON ah.user_id = u.user_id
					WHERE ah.absensiharian_id = '".$id."'";
		$rs = $this->registry->db->Execute($query);
		if($rs){
		    if($rs->RecordCount() > 0){
			while($row = $rs->FetchNextObject()){
			  $data[] = $row;
			}
		  }
		}else throw new Exception('Gagal ambil selectDB_wallDetail');
		return $data;
	}
	
}
		
?>
