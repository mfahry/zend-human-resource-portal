<?php
class MWallComment{
	private $registry;
	
  	function __construct( $registry ) {
		$this->registry = $registry;
	}
	
	public function selectDB_wallComment($id){
		$data = array();
		$query = "SELECT wc.*, u.name, u.photo FROM wall_comment wc JOIN user u ON wc.user_id = u.user_id 
					WHERE wall_id = ".$id." ORDER BY datecomment ASC";	
		$rs = $this->registry->db->Execute($query);
		if($rs){
          if($rs->RecordCount() > 0){
            while($row = $rs->FetchNextObject()){
              $data[] = $row;
            }
          }
        }else  throw new Exception('Gagal mengambil data selectDB_wallComment');
        
        return $data;
	}
	
	public function get_notification($userid){
		$data = array();
		$query = "SELECT wc.comment, wc.status_read FROM wall_comment wc JOIN wall w ON wc.wall_id = w.wall_id JOIn user u ON w.user = u.user_id 
					WHERE wc.user_id = '".$userid."' ORDER BY datecomment ASC";	
		$rs = $this->registry->db->Execute($query);
		if($rs){
          if($rs->RecordCount() > 0){
            while($row = $rs->FetchNextObject()){
              $data[] = $row;
            }
          }
        }else  throw new Exception('Gagal mengambil data selectDB_wallComment');
        
        return $data;
	}
	
	public function insertDB_wallComment($msg_id, $comment){
		$query = "INSERT INTO wall_comment(comment,wall_id,datecomment,user_id) VALUES ('".$comment."', ".$msg_id.", now(),'".$_SESSION['userid']."')";
		$rs = $this->registry->db->Execute($query);
		if(!$rs) 
			throw new Exception($query.' Gagal menyimpan Status');
	}
	
	public function deleteDB_wallComment($id = NULL, $wallid = NULL){
		$query = "DELETE FROM wall_comment WHERE";
		
		if($wallid != NULL) $query .= " wall_id = ".$wallid;
		else $query .= " comment_id=".$id;
		
		$rs = $this->registry->db->Execute($query);
		if(!$rs) throw new Exception('Gagal mengahapus wall comment');
	}

	public function updateDB_statusReadWallComment($id){
		$query = "UPDATE wall_comment SET status_read = 'yes' WHERE comment_id = ".$id;
		$rs = $this->registry->db->Execute($query);
		if(!$rs) throw new Exception('Gagal updateDB_statusReadWallComment');
	}

}
?>