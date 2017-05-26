<?php
class MComment{

	private $registry;

  	function __construct( $registry ) {
		$this->registry = $registry;
	}
	
	
	public function selectDB_comment($id, $identifier){
		$data = array();
		$query = "SELECT ac.*, u.name, u.photo 
					FROM comment ac JOIN user u ON ac.user_id = u.user_id 
					WHERE parent_id = ".$id." AND identifier = '".$identifier."' 
					ORDER BY input_dtm ASC";	
		$rs = $this->registry->db->Execute($query);
		if($rs){
          if($rs->RecordCount() > 0){
            while($row = $rs->FetchNextObject()){
              $data[] = $row;
            }
          }
        }else  throw new Exception('Gagal mengambil data selectDB_comment');
        
        return $data;
	}
	
	public function get_notification(){
		$data = array();					
		$query = "(SELECT comment_id, parent_id, c.user_id, u.name, identifier, input_dtm
					FROM knowledge k JOIN comment c ON k.knowledge_id = c.parent_id 
					JOIN user u ON c.user_id = u.user_id    
					WHERE c.parent_id IN 
					(SELECT c2.parent_id FROM knowledge k2 JOIN comment c2 ON k2.knowledge_id = c2.parent_id 
					WHERE userid_uploader = '".$_SESSION['userid']."' OR c2.user_id = '".$_SESSION['userid']."') 
					AND c.status_read = 'no' 
					AND  c.user_id <> userid_uploader
					ORDER BY input_dtm DESC)";
		$query .= "UNION
				  (SELECT comment_id, parent_id, c.user_id, u.name, identifier, input_dtm
					FROM wall w JOIN comment c ON w.wall_id = c.parent_id 
					JOIN user u ON c.user_id = u.user_id    
					WHERE c.parent_id IN 
					(SELECT c2.parent_id FROM wall w2 JOIN comment c2 ON w2.wall_id = c2.parent_id 
					WHERE w2.user = '".$_SESSION['userid']."' OR c2.user_id = '".$_SESSION['userid']."')
					AND c.status_read = 'no' 
					AND  c.user_id <> '".$_SESSION['userid']."'";
		$query .= " ORDER BY input_dtm DESC)
				  	UNION
				  (SELECT comment_id, parent_id, c.user_id, u.name, identifier, c.input_dtm
					FROM task t JOIN comment c ON t.task_id = c.parent_id 
					JOIN user u ON c.user_id = u.user_id    
					WHERE c.parent_id IN 
					(SELECT c2.parent_id FROM task t2 JOIN comment c2 ON t2.task_id = c2.parent_id 
					WHERE t2.user_id = '".$_SESSION['userid']."' OR c2.user_id = '".$_SESSION['userid']."') 
					AND c.status_read = 'no' 
					AND  c.user_id <> '".$_SESSION['userid']."'";
		$query .= " ORDER BY c.input_dtm DESC)
				  	UNION
				  (SELECT comment_id, parent_id, c.user_id, u.name, identifier, input_dtm
					FROM absensiharian ah JOIN comment c ON ah.absensiharian_id = c.parent_id 
					JOIN user u ON c.user_id = u.user_id  
					WHERE c.parent_id IN 
					(SELECT c2.parent_id FROM absensiharian ah2 JOIN comment c2 ON ah2.absensiharian_id = c2.parent_id 
					WHERE ah2.user_id = '".$_SESSION['userid']."' OR c2.user_id = '".$_SESSION['userid']."')  
					AND c.status_read = 'no' 
					AND  c.user_id <> '".$_SESSION['userid']."'
					ORDER BY input_dtm DESC)"; 
        //echo $query;
		$rs = $this->registry->db->Execute($query);
		if($rs){
          if($rs->RecordCount() > 0){
            while($row = $rs->FetchNextObject()){
              $data[] = $row;
            }
          }
        }else  throw new Exception('Gagal mengambil data get_notification');
        return $data;
	}
	
	public function insertDB_comment($parent_id, $identifier, $content){
		$query = "INSERT INTO comment(parent_id, identifier, user_id, content, input_dtm) 
					VALUES (".$parent_id.", '".$identifier."', '".$_SESSION['userid']."', '". $content."',now())";
		$rs = $this->registry->db->Execute($query);
		if(!$rs) 
			throw new Exception($query.' Gagal menyimpan insertDB_comment');
	}
	
	public function updateDB_statusReadComment($id){
		$query = "UPDATE comment SET status_read = 'yes' WHERE comment_id = ".$id;
		$rs = $this->registry->db->Execute($query);
		if(!$rs) throw new Exception('Gagal updateDB_statusReadComment');
	}
	
	public function deleteDB_comment($id){
		$query = "DELETE FROM comment WHERE comment_id=".$id;
		
		$rs = $this->registry->db->Execute($query);
		if(!$rs) throw new Exception('Gagal mengahapus wall comment');
	}

}
?>