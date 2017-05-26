<?php

class MTaskComment{
	private $registry;

  	function __construct( $registry ) {
		$this->registry = $registry;
	}
	
	public function selectDB_taskComment($id){
		$data = array();
		$query = "SELECT tc.*, u.name, u.photo FROM task_comment tc JOIN user u ON tc.user_id = u.user_id 
					 WHERE task_status_id = ".$id." ORDER BY input_dtm ASC";	
		$rs = $this->registry->db->Execute($query);
		if($rs){
          if($rs->RecordCount() > 0){
            while($row = $rs->FetchNextObject()){
              $data[] = $row;
            }
          }
        }else  throw new Exception('Gagal mengambil data selectDB_taskComment');
        
        return $data;
	}
	
	public function insertDB_taskComment($task_status_id, $comment){
		$query = "INSERT INTO task_comment(task_status_id,comment,input_dtm,user_id) VALUES (".$task_status_id.", '".$comment."', now(),'".$_SESSION['userid']."')";
		$rs = $this->registry->db->Execute($query);
		if(!$rs) 
			throw new Exception($query.' Gagal menyimpan insertDB_wallComment');
	}
	
	public function deleteDB_taskComment($id = NULL, $taskid = NULL){
		$query = "DELETE FROM task_comment WHERE";
		
		if($taskid != NULL) $query .= " task_status_id = ".$taskid;
		else $query .= " comment_id=".$id;
		echo $query;
		$rs = $this->registry->db->Execute($query);
		if(!$rs) throw new Exception('Gagal mengahapus deleteDB_taskComment');
	}

	public function updateDB_statusReadTaskComment($id){
		$query = "UPDATE task_comment SET status_read = 'yes' WHERE comment_id = ".$id;
		$rs = $this->registry->db->Execute($query);
		if(!$rs) throw new Exception('Gagal updateDB_statusReadTaskComment');
	}
	
}
?>
	