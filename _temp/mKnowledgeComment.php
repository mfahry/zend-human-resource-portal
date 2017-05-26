<?php

class MKnowledgeComment{
	private $registry;

  	function __construct( $registry ) {
		$this->registry = $registry;
	}
	
	public function selectDB_knowledgeComment($id){
		$data = array();
		$query = "SELECT kc.*, u.name, u.photo FROM knowledge_comment kc JOIN user u ON kc.user_id = u.user_id 
					 WHERE knowledge_id = ".$id." ORDER BY input_dtm ASC";	
		$rs = $this->registry->db->Execute($query);
		if($rs){
          if($rs->RecordCount() > 0){
            while($row = $rs->FetchNextObject()){
              $data[] = $row;
            }
          }
        }else  throw new Exception('Gagal mengambil data selectDB_knowledgeComment');
        
        return $data;
	}
	
	public function insertDB_knowledgeComment($task_id, $comment){
		$query = "INSERT INTO knowledge_comment(knowledge_id,comment,input_dtm,user_id) VALUES (".$task_id.", '".$comment."', now(),'".$_SESSION['userid']."')";
		$rs = $this->registry->db->Execute($query);
		if(!$rs) 
			throw new Exception($query.' Gagal menyimpan insertDB_knowledgeComment');
	}
	
	public function deleteDB_knowledgeComment($id = NULL, $knowledgeid = NULL){
		$query = "DELETE FROM knowledge_comment WHERE";
		
		if($knowledgeid != NULL) $query .= " knowledge_id = ".$knowledgeid;
		else $query .= " comment_id=".$id;
		$rs = $this->registry->db->Execute($query);
		if(!$rs) throw new Exception('Gagal mengahapus deleteDB_knowledgeComment');
	}

	
	public function updateDB_statusReadKnowledgeComment($id){
		$query = "UPDATE knowledge_comment SET status_read = 'yes' WHERE comment_id = ".$id;
		$rs = $this->registry->db->Execute($query);
		if(!$rs) throw new Exception('Gagal updateDB_statusReadKnowledgeComment');
	}

}
?>
	