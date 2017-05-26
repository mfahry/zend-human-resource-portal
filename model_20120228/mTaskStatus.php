<?php
class MTaskStatus{
	private $registry;
	
	public function __construct($registry){
		$this->registry = $registry;
	}
	
	public function insertDB_taskStatus($status, $taskid){
		$query = "INSERT INTO task_status(status, update_by, update_dtm, ip_address, task_id, is_show)
                VALUES('".$status."', '".$_SESSION['userid']."',now(), '".$_SERVER['REMOTE_ADDR']."',".$taskid.", 1)";
		
		if(!$this->registry->db->execute($query)) throw new Exception('Gagal menyimpan data task status');
	}

	public function updateDB_showTaskStatus($taskid){
		$query = "UPDATE task_status SET is_show = 0 WHERE task_id = ".$taskid;
		
		if(!$this->registry->db->execute($query)) throw new Exception('Gagal menyimpan data task status');
	}
		
	public function updateDB_task($taskid, $task, $priority,$target){
		$query = "UPDATE task SET task = '".$task."', priority_id = '".$priority."', target='".$target."' 
					WHERE task_id = ".$taskid;
		
		if(!$this->registry->db->execute($query)) throw new Exception('Gagal menyimpan data task status');
	}
		
	public function deleteDB_userTaskStatus($taskid){
		$query = "DELETE FROM task_status WHERE task_id=".$taskid;
		if(!$this->registry->db->execute($query)) throw new Exception('Gagal menghapus data task status');
	}	
}
?>