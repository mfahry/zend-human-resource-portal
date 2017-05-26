<?php
class MAbsenOut{
	private $registry;

  	function __construct( $registry ) {
		$this->registry = $registry;
	}
	
	public function selectDB_attendanceLeave($userid){
		$data = array();
		$query = "SELECT ao.* FROM absensiout ao JOIN absensiharian ah ON ao.absensiharian_id = ah.absensiharian_id
					JOIN calendar c ON ah.calendar_id = c.calendar_id
					WHERE ah.user_id = '".$userid."'";	
		
    	$rs = $this->registry->db->Execute($stmt,$arrBinding);
    	if($rs){
          if($rs->RecordCount() > 0){
            while($row = $rs->FetchNextObject()){
              $data[] = $row;
            }
          }
        }else throw new Exception("Gagal memeriksa cekCalendarOut");
		
        return $data;
	}
	
	function cekCalendarOut($type, $tgl, $bulan, $tahun, $userid = NULL) {
    	//echo "<br>*tgl: ".$tgl." ## ".$bulan." ## ".$tahun." ## ".$userid." ...";
		$data = array();
    	$query = "SELECT * FROM absensiout a JOIN absensiharian b ON a.absensiharian_id = b.absensiharian_id JOIN calendar c ON c.calendar_id = b.calendar_id
    				WHERE c.date =? AND c.month =? AND c.year =? AND c.status =1";
    	if(!empty($userid)){
    	    $query = $query." AND b.user_id=?";
    	}
    	if($type==0){
    	    $query = $query." AND (a.out_timeend IS NULL OR a.out_timeend ='00:00:00')";
    	}else{
    	    $query = $query." AND (a.out_timeend IS NOT NULL OR a.out_timeend <> '00:00:00')";
		}
    	$stmt = $this->registry->db->Prepare($query);
    	$arrBinding[0] = $tgl;
    	$arrBinding[1] = $bulan;
    	$arrBinding[2] = $tahun;

    	if(!empty($userid)){
    		$arrBinding[3] = $userid;
    	}
    	$rs = $this->registry->db->Execute($stmt,$arrBinding);
    	if($rs){
          if($rs->RecordCount() > 0){
            while($row = $rs->FetchNextObject()){
              $data[] = $row;
            }
          }
        }else throw new Exception("Gagal memeriksa cekCalendarOut");
		
        return $data;
	}

	function insert_absenOut($idHarian, $tipe, $timeIN, $note, $ip)
	{
			$idHarian = mysql_real_escape_string($idHarian);
			$tipe = mysql_real_escape_string($tipe);
			$timeIN = mysql_real_escape_string($timeIN);
			$note = mysql_real_escape_string($note);
			$ip = mysql_real_escape_string($ip);

			//echo "<br>*idHarian: ".$idHarian." tipe: ".$tipe." timeIN: ".$timeIN." note: ".$note." ip: ".$ip;

			$query = "INSERT INTO absensiout (absensiharian_id, out_type, out_timestart, out_descstart, input_from)
					VALUES (?, ?, ?, ?, ?)";

			$stmt = $this->registry->db->Prepare($query);
			$arrBinding[0] = $idHarian;
			$arrBinding[1] = $tipe;
			$arrBinding[2] = $timeIN;
			$arrBinding[3] = $note;
			$arrBinding[4] = $ip;
			//echo "<br>*insert_absenOut : ".$query."<br>";
			$rs = $this->registry->db->Execute($stmt,$arrBinding);
			
			if(!$rs) throw new Exception("Gagal menyimpan absen keluar kantor");
			else return true;
	}

    # buat insert jam pulang OUT
	function update_Absenout($out_timeend, $out_descend, $ip_End, $worksummary, $harianID) {
    	// echo "<br>jam keluar: ".$out_timeend." note keluar: ".$out_descend." ip keluar: ".$ip_End." ws : ".$worksummary." harian id: ".$harianID."<br>";
    	$out_timeend = mysql_real_escape_string($out_timeend);
    	$out_descend = mysql_real_escape_string($out_descend);
    	$ip_End = mysql_real_escape_string($ip_End);
    	$worksummary = mysql_real_escape_string($worksummary);
    	$harianID = mysql_real_escape_string($harianID);

    	$query = "UPDATE absensiout
    				SET out_timeend='".$out_timeend."', out_descend='".$out_descend."', input_endfrom='".$ip_End."', worksummary='".$worksummary."'
    				WHERE absensiharian_id=".$harianID;

    	/* $stmt = $this->registry->db->Prepare($query);
    	$arrBinding[0] = $out_timeend;
    	$arrBinding[1] = $out_descend;
    	$arrBinding[2] = $ip_End;
    	$arrBinding[3] = $worksummary;
    	$arrBinding[4] = $harianID; */
    	// echo "<br>*update_Absenout : ".$query."<br>";
    	$rs = $this->registry->db->Execute($query);
		if(!$rs) throw new Exception("Gagal mengupedate absen keluar kantor");

	}
	
	public function select_UserAbsenKeluar($idharian){
		$data  = array();
    	$query = "SELECT absensiharian_id
					FROM absensiout where absensiharian_id = '$idharian' and worksummary=''";
    	$rs = $this->registry->db->Execute($query);
		  if($rs->RecordCount() > 0){
            while($row = $rs->FetchNextObject()){
              $data[] = $row;
            }
          }
        return $data;
    }
	
	function selectDB_outOffice($userid, $absen = NULL, $calid_1 = NULL, $calid_2 = NULL, $cntr = NULL){
		//echo $userid."#".$calid_1."#".$calid_2;
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
		if($absen != NULL){
			$query .= " AND o.out_type = ".$absen;
		}
		//echo $query.' # ';
		if($cntr != NULL){ 
			$jml=0;
			$rs = $this->registry->db->Execute($query);
			$cnt = $rs->RecordCount();
			return $cnt; 
		}else{
			$rs = $this->registry->db->Execute($query);
			return $rs;
		}

	}

	public function selectDB_attendance_leaveDetail($id){
		$data = array();
		$query = "SELECT ao.absenout_id AS id, ah.user_id AS userid, u.name,  'title' AS title, ao.out_descstart AS content, 
				  	DATE_FORMAT(CONCAT(c.year,'-', c.month,'-', c.date,' ', ao.out_timestart), '%Y-%m-%d %H:%m:%s') AS tanggal, 
					'attendance_leave' AS identity, u.photo 
				  	FROM absensiout ao JOIN absensiharian ah ON ao.absensiharian_id = ah.absensiharian_id 
				  	JOIN calendar c ON ah.calendar_id = c.calendar_id	
				  	JOIN user u ON ah.user_id = u.user_id
					WHERE ao.absenout_id = '".$id."'";
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
	
	public function selectDB_attendance_backDetail($id){
		$data = array();
		$query = "SELECT ao.absenout_id AS id, ah.user_id AS userid, u.name,  'title' AS title, ao.out_descend AS content, 
				  	DATE_FORMAT(CONCAT(c.year,'-', c.month,'-', c.date,' ', ao.out_timeend), '%Y-%m-%d %H:%m:%s') AS tanggal, 
					'attendance_back' AS identity, u.photo 
				  	FROM absensiout ao JOIN absensiharian ah ON ao.absensiharian_id = ah.absensiharian_id 
				  	JOIN calendar c ON ah.calendar_id = c.calendar_id
				  	JOIN user u ON ah.user_id = u.user_id
					WHERE ao.absenout_id = '".$id."'";
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