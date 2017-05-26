<?php
class MAbsenTemp{
	private $registry;

  	function __construct( $registry ) {
		$this->registry = $registry;
	}

	function insertDB_absenTemp($userid, $date, $desc, $userRec, $typeAbsen, $time){
		//echo $date;

		$query = "INSERT INTO absen_temp (user_id, calendar_id, start_time, start_desc, start_inputfrom, user_recommendation, status, absentype_id, time1)
					VALUES(?, ?, ?, ?, ?, ?, ?, ?, ?)";
		$stmt 			= $this->registry->db->Prepare($query);
		$arrBinding[0] 	= mysql_real_escape_string($userid);
		$arrBinding[1] 	= mysql_real_escape_string($date);
		$arrBinding[2] 	= mysql_real_escape_string($this->registry->mCalendar->currentDate('Y-m-d h:i:s'));
		$arrBinding[3] 	= mysql_real_escape_string($desc);
		$arrBinding[4] 	= mysql_real_escape_string($this->registry->mUser->getIPGuest());
		$arrBinding[5] 	= mysql_real_escape_string($userRec);
		$arrBinding[6] 	= mysql_real_escape_string("0");
		$arrBinding[7] 	= mysql_real_escape_string($typeAbsen);
		$arrBinding[8] 	= mysql_real_escape_string($time);

		$rs 			= $this->registry->db->Execute($stmt,$arrBinding);
		if(!$rs) throw new Exception("Gagal menginput absen temp");
		else return true;
	}
	#20120104:cancel recommendation
	function cancelDB_absenTemp($userid, $date, $userReject){
		$query	= "DELETE FROM absen_temp WHERE user_id='".$userid."' and calendar_id='".$date."' and user_recommendation='".$userReject."' and status='2'";
		$rs = $this->registry->db->Execute($query);
		echo $rs;
		if(!$rs) throw new Exception('gagal menghapus absen temp');
	}	
	#06272011: absen lembur
	function insertDB_lembur($userid, $date, $startTime, $desc, $outInputend){
			//echo $date;
			/*$query = "INSERT INTO lembur (user_id, calendar_id, start_time, start_desc, start_inputfrom, input1_dtm)
						VALUES('".$userid."', '".$date."', '".$startTime."', '".$desc."', '".($this->registry->mUser->getIPGuest())."', '".($this->registry->mCalendar->currentDate('Y-m-d h:i:s'))."')";*/
			$query = "INSERT INTO lembur (user_id, calendar_id, start_time, start_desc, start_inputfrom, input1_dtm)
						VALUES('".$userid."', '".$date."', '".$startTime."', '".$desc."', '".($this->registry->mUser->getIPGuest())."', '".($this->registry->mCalendar->currentDate('Y-m-d h:i:s'))."')";
	//echo $query;
			$rs 			= $this->registry->db->Execute($query);
			if(!$rs) throw new Exception("Gagal menginput lembur");
			else return true;
	}
	# $outTime,$outDesc,$outinputend,$workSummary,$input1,$input2
	function updateDB_lembur($userid, $date, $outTime, $outDesc, $workSummary){
		/*$query = "UPDATE lembur SET out_time = '".$outTime."', out_desc = '".$outDesc."', worksummary = '".$workSummary."', out_inputend = '".($this->registry->mUser->getIPGuest())."', input2_dtm = now()
					WHERE user_id='".$userid."' and calendar_id='".$date."'";*/
		$query = "UPDATE lembur SET out_time = '".$outTime."', out_desc = '".$outDesc."', worksummary = '".$workSummary."', out_inputend = '".($this->registry->mUser->getIPGuest())."', input2_dtm = '".($this->registry->mCalendar->currentDate('Y-m-d h:i:s'))."'
					WHERE user_id='".$userid."' and calendar_id='".$date."'";
	//echo $query;			
	$rs = $this->registry->db->Execute($query);
		if(!$rs) throw new Exception("Gagal mengupdate absen lembur");
	}
	
	function selectDB_absenTemp($userid = NULL, $column = NULL, $status = NULL, $calid = NULL, $activated = NULL, $absentype_id = NULL, $groupby = NULL){
		$data = array();
		$query = "SELECT * FROM absen_temp ";
		
		if(($userid != NULL) && ($column != NULL))
			$query .= "WHERE ".$column." = '".$userid."' ";
		if($status !== NULL)
			$query .= " AND status = ".$status;


		if($calid != NULL)
			$query .= " AND calendar_id = ".$calid;

       	if($activated != NULL)
			$query .= " AND activated  = '".$activated."'";
			
       	if($absentype_id != NULL)
			$query .= " AND absenType_id  = '".$absentype_id."'";
			
       	if($groupby != NULL)
			$query .= " GROUP BY ".$groupby;
		/*if(($column == 'user_id')&&($status == 1)){
                echo "<br>$userid # $column # $status # $calid # $activated  <br>";
                }*/
				//if ($status ==2)
              // echo $query;
		
		$rs = $this->registry->db->Execute($query);
		if($rs){
          if($rs->RecordCount() > 0){
            while($row = $rs->FetchNextObject()){
              $data[] = $row;
            }
          }
        }else throw new Exception('gagal mengambil data selectDB_absenTemp '.$query);
        return $data;
	}
	
	function updateDB_absenTemp($absenID, $activated = NULL, $status = NULL){
		$query = "UPDATE absen_temp";
                if($activated != NULL)
                    $query .= " SET activated = '".$activated."'";
                else
                    $query .= " SET status = ".$status.", dtm_approved = now()";

                $query .= " WHERE temp_id = ".$absenID;

               // echo $query;
		$rs = $this->registry->db->Execute($query);
		if(!$rs) throw new Exception('gagal mengupdate absen temp');
	}
	#20111124:select user recommendation
	function get_userRecByCalendar($userid = NULL, $month = NULL, $year = NULL){
		$data = array();
        $query = "SELECT * FROM absen_temp ";
					
        if($userid != NULL && $userid != '-1' && $month != NULL && $year != NULL){
			$query .= " WHERE user_id = '".$userid."'  
						AND MONTH(start_time) = '".$month."' 
						AND YEAR(start_time) = '".$year."'";
		}elseif($userid != NULL && $userid == '-1' && $month != NULL && $year != NULL){
			$query .= "	WHERE MONTH(start_time) = '".$month."' 
						AND YEAR(start_time) = '".$year."'";
		}elseif($userid == NULL && $_SESSION['position_id'] != 1 && $month != NULL && $year != NULL){
			$query .= " WHERE user_id = '".$_SESSION['userid']."'  
						AND MONTH(start_time) = '".$month."' 
						AND YEAR(start_time) = '".$year."'";
		}elseif($userid == NULL && $_SESSION['position_id'] == 1 && $month != NULL && $year != NULL){
			$query .= " WHERE MONTH(start_time) = '".$month."' 
						AND YEAR(start_time) = '".$year."'";
		}
        //echo $query;
		$query .= " GROUP BY calendar_id ORDER BY start_time ASC ";
 		//echo $query.'<br>';
        $rs = $this->registry->db->Execute($query);
        if($rs){
          if($rs->RecordCount() > 0){
            while($row = $rs->FetchNextObject()){
              $data[] = $row;
            }
          }
        }else  throw new Exception('Gagal mengambil data user');
        
        return $data;
	}
	
	public function activate_recommendation($userid, $calid,$absentype){
		$query = "UPDATE absen_temp  SET activated = 'yes' 
					WHERE user_id = '".$userid."' AND status = 1 
					AND activated = 'no'
					AND calendar_id = ".$calid."
					AND absenType_id = ".$absentype;

              //  echo $query;
		$rs = $this->registry->db->Execute($query);
		if(!$rs) throw new Exception('gagal mengaktivasi absen temp');
	}

	function deleteDB_absenTemp($absenID = NULL, $userid = NULL, $userRec = NULL, $status = NULL){
		$query = "DELETE FROM absen_temp WHERE";
		if($absenID !=NULL)
			$query .= " temp_id = ".$absenID;
			
		elseif($userid != NULL && $userRec != NULL && $status!=NULL)
			$query .= " user_id = '".$userid."' AND user_recommendation = '".$userRec."' AND status = ".$status;
                //echo $query;
		$rs = $this->registry->db->Execute($query);
		if(!$rs) throw new Exception('gagal menghapus absen temp');
	}
	
	function insertDB_absenTempSPJnCuti($userid, $date1, $desc, $userRec, $typeAbsen,$date2){
		$i= $date2-$date1;
		echo $i;
		for($i=$date1;$i<=$date2;$i++){
			$query = "INSERT INTO absen_temp (user_id, calendar_id, start_time, start_desc, start_inputfrom, user_recommendation, status, absentype_id)
						VALUES(?, ?, ?, ?, ?, ?, ?, ?)";
			$stmt 			= $this->registry->db->Prepare($query);
			$arrBinding[0] 	= mysql_real_escape_string($userid);
			$arrBinding[1] 	= mysql_real_escape_string($i);
			$arrBinding[2] 	= mysql_real_escape_string($this->registry->mCalendar->getTime());
			$arrBinding[3] 	= mysql_real_escape_string($desc);
			$arrBinding[4] 	= mysql_real_escape_string($this->registry->mUser->getIPGuest());
			$arrBinding[5] 	= mysql_real_escape_string($userRec);
			$arrBinding[6] 	= mysql_real_escape_string("0");
			$arrBinding[7] 	= mysql_real_escape_string($typeAbsen);
			$rs 			= $this->registry->db->Execute($stmt,$arrBinding);
		}
	}
	
	public function count_activeStatus($userid, $calid, $absentype){
		$data = NULL;
		$query = "SELECT COUNT(*) AS count FROM absen_temp WHERE user_id ='".$userid."' 
					AND calendar_id = ".$calid." AND absentype_id = ".$absentype." AND activated = 'yes'";
		$rs = $this->registry->db->Execute($query);
		if($rs){ 
            while($row = $rs->FetchNextObject()){
				if($row->COUNT < 2)
              		$data = '<b style="color:red;">Need Activated</b>'; 
				elseif($row->COUNT >= 2)
              		$data = '<b style="color:green;">Active</b>'; 
          }
        }else throw new Exception('gagal mengambil data count_activeStatus '.$query);
        return $data;
	}

}
?>