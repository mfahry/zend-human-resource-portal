<?php

class MAttendanceComment{
	private $registry;

  	function __construct( $registry ) {
		$this->registry = $registry;
	}
	
	public function selectDB_attendanceComment($id, $identifier){
		$data = array();
		$query = "SELECT ac.*, u.name, u.photo FROM attendance_comment ac JOIN user u ON ac.user_id = u.user_id 
					WHERE absensiharian_id = ".$id." AND identifier = '".$identifier."' 
					ORDER BY input_dtm ASC";	
		$rs = $this->registry->db->Execute($query);
		if($rs){
          if($rs->RecordCount() > 0){
            while($row = $rs->FetchNextObject()){
              $data[] = $row;
            }
          }
        }else  throw new Exception('Gagal mengambil data selectDB_attendanceComment');
        
        return $data;
	}
	
	public function insertDB_attendanceComment($id, $comment, $identifier){
		$query = "INSERT INTO attendance_comment(absensiharian_id,comment,input_dtm,user_id, identifier) VALUES (".$id.", '".$comment."', now(),'".$_SESSION['userid']."', '". $identifier."')";
		$rs = $this->registry->db->Execute($query);
		if(!$rs) 
			throw new Exception($query.' Gagal menyimpan insertDB_attendanceComment');
	}
	
	public function deleteDB_attendanceComment($id){
		$query = "DELETE FROM attendance_comment WHERE comment_id=".$id;
		$rs = $this->registry->db->Execute($query);
		if(!$rs) throw new Exception('Gagal mengahapus deleteDB_attendanceComment');
	}

	public function updateDB_statusReadAttendanceComment($id){
		$query = "UPDATE attendance_comment SET status_read = 'yes' WHERE comment_id = ".$id;
		$rs = $this->registry->db->Execute($query);
		if(!$rs) throw new Exception('Gagal updateDB_statusReadAttendanceComment');
	}
	
	
}
?>
	