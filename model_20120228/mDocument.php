<?php
class MDocument{

    private $registry;
    public function __construct($registry){
      $this->registry = $registry;
    }
	public function time_since($original) {
	
		$original = strtotime($original);
		
		$phitdate = array(
			array(60 * 60 * 24 * 365 , 'year'),
			array(60 * 60 * 24 * 30 , 'month'),
			array(60 * 60 * 24 * 7, 'week'),
			array(60 * 60 * 24 , 'day'),
			array(60 * 60 , 'hour'),
			array(60 , 'minute'),
		);
		
		$today = time();
		$since = $today - $original;
		
		if($since < 5){
			$print='a few seconds';
		}else{
			for ($i = 0, $j = count($phitdate); $i < $j; $i++) {
			
				$seconds = $phitdate[$i][0];
				$name = $phitdate[$i][1];
				
				// cek
				if (($count = floor($since / $seconds)) != 0) {
					break;
				}
			}
			
			if($count == 0) $print='a few seconds';
			elseif($count == 1) $print = '1 '.$name.'s';
			else $print =  "$count {$name}s";
			
			if ($i + 1 < $j) {
			// detik
				$seconds2 = $phitdate[$i + 1][0];
				$name2 = $phitdate[$i + 1][1];
				
				// jika detik lebih dari 0
				if (($count2 = floor(($since - ($seconds * $count)) / $seconds2)) != 0) {
					$print .= ($count2 == 1) ? ', 1 '.$name2 : " and $count2 {$name2}s";
				}
			}
		}
		return $print.' ago';
		// create by PHITIAS
	}

	function get_documentByCalendar($userid = NULL, $month = NULL, $year = NULL){
		$data = array();
		$query = "SELECT u.user_id, u.name, a.file_name, a.original_file_name, a.file_type, a.uploaded_by, a.uploaded_dtm, b.folder_id, b.folder_name, b.folder_parent
			FROM user u JOIN file_kerja a ON a.uploaded_by = u.user_id LEFT JOIN folder_kerja b ON b.folder_id = a.folder_id "; 
		
		if($userid != NULL && $userid != '-1' && $month != NULL && $year != NULL){
			$query .= " WHERE u.user_id = '".$userid."'  
						AND MONTH(a.uploaded_dtm) = '".$month."' 
						AND YEAR(a.uploaded_dtm) = '".$year."'";
		}elseif($month != NULL && $year != NULL){
			$query .= " WHERE MONTH(a.uploaded_dtm) = '".$month."' 
						AND YEAR(a.uploaded_dtm) = '".$year."'";
		}elseif($userid == NULL && $_SESSION['position_id'] != 1 && $month != NULL && $year != NULL){
			$query .= " WHERE u.user_id = '".$_SESSION['userid']."'  
						AND MONTH(a.uploaded_dtm) = '".$month."' 
						AND YEAR(a.uploaded_dtm) = '".$year."'";
		}elseif($userid == NULL && $_SESSION['position_id'] == 1 && $month != NULL && $year != NULL){
			$query .= " WHERE MONTH(a.uploaded_dtm) = '".$month."' 
						AND YEAR(a.uploaded_dtm) = '".$year."'";
		}
		//echo $query;
		$query .= " ORDER BY a.uploaded_dtm DESC "; 
		$rs = $this->registry->db->Execute($query);
		if($rs){
          if($rs->RecordCount() > 0){
            while($row = $rs->FetchNextObject()){
              $data[] = $row;
            }
          }
        }else  throw new Exception('Gagal mengambil data document');
        
        return $data;
	
	}

	
}
?>
