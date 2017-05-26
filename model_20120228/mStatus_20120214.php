<?php

class MStatus{
	private $registry;

  	function __construct( $registry ) {
		$this->registry = $registry;
	}
	
	public function selectDB_homeUnion($userid = NULL, $limitto = NULL, $limitfrom = NULL, $newDate = NULL){
		$data = array();
		$limitto = ($limitto == NULL)?0:$limitto;
		$limitfrom = ($limitfrom == NULL)?15:$limitfrom;
		$query = "(SELECT k.knowledge_id AS id, k.userid_uploader AS userid, u.name, judul AS title, 
					k.deskripsi AS content, k.date AS tanggal, 'knowledge' AS identity, u.photo
					FROM knowledge k JOIN user u ON k.userid_uploader = u.user_id";
					if($newDate != NULL) $query .= " WHERE k.date > '".$newDate."'";
					 if($userid != NULL) $query .= " WHERE userid_uploader = '".$userid."'";
		$query .= " ORDER BY tanggal DESC)
					UNION
				  (SELECT w.wall_id AS id, w.user AS userid, u.name, 'title' AS title, w.wall AS content, 
				  	w.datewall AS tanggal, 'wall' AS identity, u.photo
				  	FROM wall w JOIN user u ON w.user = u.user_id";
					if($newDate != NULL) $query .= " WHERE w.datewall > '".$newDate."'";
					 if($userid != NULL) $query .= " WHERE user = '".$userid."'";
		$query .= " ORDER BY tanggal DESC)
				  	UNION
				  (SELECT t.task_id AS id, t.user_id AS userid, u.name, 'title' AS title, 
				  	CONCAT(t.task, ' : ', ts.status, ' %') AS content, ts.update_dtm AS tanggal, 'task' AS identity, u.photo 
				  	FROM task t JOIN task_status ts ON ts.task_id = t.task_id
				   	JOIN user u ON t.user_id = u.user_id WHERE ts.is_show = 1";
					if($newDate != NULL) $query .= " AND ts.update_dtm > '".$newDate."'";
					 if($userid != NULL) $query .= " AND t.user_id = '".$userid."'";
		$query .= " ORDER BY tanggal DESC)
				  	UNION
				  (SELECT ah.absensiharian_id AS id, ah.user_id AS userid, u.name,  'title' AS title, ah.start_desc AS content, 
				  	ah.input1_dtm AS tanggal, 'attendance_in' AS identity, u.photo
				  	FROM absensiharian ah join calendar c ON ah.calendar_id = c.calendar_id
				  	JOIN user u ON ah.user_id = u.user_id";
					if($newDate != NULL) $query .= " WHERE ah.input1_dtm > '".$newDate."'";
					 if($userid != NULL) $query .= " WHERE ah.user_id = '".$userid."'";
		$query .= "	ORDER BY tanggal DESC)
				  	UNION
				  (SELECT absensiharian_id AS id, ah.user_id AS userid, u.name,  'title' AS title, 
				  	CONCAT(out_desc,' <br>Worksummary : ',worksummary) AS content, 
				  	ah.input2_dtm AS tanggal, 'attendance_out' AS identity, u.photo 
				  	FROM absensiharian ah join calendar c ON ah.calendar_id = c.calendar_id
				  	JOIN user u ON ah.user_id = u.user_id";
					if($newDate != NULL) $query .= " WHERE ah.input2_dtm > '".$newDate."'";
					 if($userid != NULL) $query .= " WHERE ah.user_id = '".$userid."'";
		$query .= "	ORDER BY tanggal DESC)
				  	UNION
				  (SELECT ao.absenout_id AS id, ah.user_id AS userid, u.name,  'title' AS title, ao.out_descstart AS content, 
				  	DATE_FORMAT(CONCAT(c.year,'-', c.month,'-', c.date,' ', ao.out_timestart), '%Y-%m-%d %H:%m:%s') AS tanggal, 
					'attendance_leave' AS identity, u.photo 
				  	FROM absensiout ao JOIN absensiharian ah ON ao.absensiharian_id = ah.absensiharian_id 
				  	JOIN calendar c ON ah.calendar_id = c.calendar_id	
				  	JOIN user u ON ah.user_id = u.user_id";
					if($newDate != NULL) $query .= " WHERE ao.out_timestart > '".$newDate."'";
					 if($userid != NULL) $query .= " WHERE ah.user_id = '".$userid."'";
		$query .= " ORDER BY tanggal)
				  	UNION
				  (SELECT ao.absenout_id AS id, ah.user_id AS userid, u.name,  'title' AS title, ao.out_descend AS content, 
				  	DATE_FORMAT(CONCAT(c.year,'-', c.month,'-', c.date,' ', ao.out_timeend), '%Y-%m-%d %H:%m:%s') AS tanggal, 
					'attendance_back' AS identity, u.photo 
				  	FROM absensiout ao JOIN absensiharian ah ON ao.absensiharian_id = ah.absensiharian_id 
				  	JOIN calendar c ON ah.calendar_id = c.calendar_id
				  	JOIN user u ON ah.user_id = u.user_id";
					if($newDate != NULL) $query .= " WHERE ao.out_timeend > '".$newDate."'";
					 if($userid != NULL) $query .= " WHERE ah.user_id = '".$userid."'";
		$query .= " ORDER BY tanggal DESC) ORDER BY tanggal";
		if($newDate == NULL) $query .= " DESC LIMIT ".$limitto.", ".$limitfrom;	
		//echo $query;
		//echo $limit;
		$rs = $this->registry->db->Execute($query);
		if($rs){
          if($rs->RecordCount() > 0){
            while($row = $rs->FetchNextObject()){
              $data[] = $row;
            }
          }
        }else  throw new Exception($query.'  Gagal mengambil data selectDB_homeUnion');
        
        return $data;
	}
	
	public function get_notification(){
		$data = array(); 
		$query = "(SELECT k.knowledge_id AS id, c.comment_id, c.user_id AS userid, u.name, 
					'knowledge' AS identity, c.input_dtm AS tanggal
					FROM knowledge k JOIN knowledge_comment c ON k.knowledge_id = c.knowledge_id 
					JOIN user u ON c.user_id = u.user_id  
					WHERE userid_uploader = '".$_SESSION['userid']."' AND c.status_read = 'no' 
					AND  c.user_id <> '".$_SESSION['userid']."'";
		$query .= " ORDER BY tanggal DESC)
					UNION
				  (SELECT w.wall_id AS id, c.comment_id, c.user_id AS userid, u.name, 
					'wall' AS identity, c.datecomment AS tanggal
					FROM wall w JOIN wall_comment c ON w.wall_id = c.wall_id 
					JOIN user u ON c.user_id = u.user_id  
					WHERE w.user = '".$_SESSION['userid']."' AND c.status_read = 'no' 
					AND  c.user_id <> '".$_SESSION['userid']."'";
		$query .= " ORDER BY tanggal DESC)
				  	UNION
				  (SELECT t.task_id AS id, c.comment_id, c.user_id AS userid, u.name,  
					'task' AS identity, c.input_dtm AS tanggal
					FROM task t JOIN task_comment c ON t.task_id = c.task_status_id 
					JOIN user u ON c.user_id = u.user_id  
					WHERE t.user_id = '".$_SESSION['userid']."' AND c.status_read = 'no' 
					AND  c.user_id <> '".$_SESSION['userid']."'";
		$query .= " ORDER BY tanggal DESC)
				  	UNION
				  (SELECT c.absensiharian_id AS id, c.comment_id, c.user_id AS userid, u.name,
					identifier, c.input_dtm AS tanggal
					FROM absensiharian ah JOIN attendance_comment c ON ah.absensiharian_id = c.absensiharian_id 
					JOIN user u ON c.user_id = u.user_id  
					WHERE ah.user_id = '".$_SESSION['userid']."'  AND c.status_read = 'no' 
					AND  c.user_id <> '".$_SESSION['userid']."'";
		$query .= "	ORDER BY tanggal DESC)"; 
		//echo $query;
		//echo $limit;
		$rs = $this->registry->db->Execute($query);
		if($rs){
          if($rs->RecordCount() > 0){
            while($row = $rs->FetchNextObject()){
              $data[] = $row;
            }
          }
        }else  throw new Exception($query.'  Gagal mengambil data selectDB_homeUnion');
        
        return $data;
	}
	
	public function format_comment($identity, $id,$comment, $photo){
		$content = '<div class="comment_load" id="comment'.$identity.'-'.$id.'"><img width="50" height="50" src="includes/img/photo/'.$photo.'"/>';
		$content .= '<a href="#">'.$_SESSION['username'].'</a> '.$comment;
		$content .=	'<a href="#" id="'.$identity.'-'.$id.'" class="cdelete_update"  style="float:right;" >x</a><br>';
		$content .= '<h3>a few seconds ago</h3>';//
		$content .= '</div>';
		
		return $content;
	}
	
	public function InsertMyStatus($wall,$userid){
		$time = date("Y-m-d h:i:s");
		$query = "INSERT INTO wall(wall,datewall,user) VALUES ('$wall','$time','$userid')";
		$rs = $this->registry->db->Execute($query);
		if(!$rs){
		throw new Exception('Gagal menyimpan Status');
		}
	}
	
	public function insertDB_status($wall){
		 
		$query = "INSERT INTO wall(wall,datewall,user) VALUES ('$wall',now(),'".$_SESSION['userid']."')";
		$rs = $this->registry->db->Execute($query);
		if(!$rs){
		throw new Exception('Gagal menyimpan Status');
		}
		else{
			$data = array();
			$queryselect = "SELECT wall_id AS id, user AS userid, u.name, 'title' AS title, wall AS content, 
				datewall AS tanggal, 'wall' AS identity, u.photo 
				  FROM wall w JOIN user u ON w.user = u.user_id WHERE user = '".$_SESSION['userid']."' ORDER BY wall_id DESC LIMIT 1";
			$rsselect = $this->registry->db->Execute($queryselect);
			
			if($rsselect){
			  if($rsselect->RecordCount() > 0){
				while($row = $rsselect->FetchNextObject()){
				  $data[] = $row;
				}
			  }
			}
			return $data;
		}
	}

    function format_wall($data, $previous = NULL) {
		if(count($data) > 0){
			foreach($data as $wall){
				if($wall->CONTENT != NULL){
					if(is_string($wall->TANGGAL)) $dt=strtotime($wall->TANGGAL);
			
					$content=htmlspecialchars(stripslashes($wall->CONTENT));
					$content = '<li class="'.$wall->IDENTITY.'-'.$wall->ID.'" style="padding-top:10px;">'; 
					$content .= '	<img width="65" height="65" src="includes/img/photo/'.$wall->PHOTO.'"/>';
					$content .= '	<div style="padding-left: 77px;">';
					$content .= '		<a href="#" onclick="return false;">'.ucfirst($wall->NAME).'</a>';
					if($wall->USERID == $_SESSION['userid']){
        				$content .= '	<a href="#"  style="float:right;" id="'.$wall->IDENTITY.'-'.$wall->ID.'" class="delete_wall">x</a>';
					}
					if($wall->IDENTITY == 'knowledge'){
						$content .= '		<h2>'.$wall->TITLE.'</h2>';
						$content .= '		<p>'.$this->registry->mKnowledge->shortAlinea($wall->CONTENT,'','<br><a href="index.php?mod=knowledge/detail/'.$wall->ID.'"> Selengkapnya...</a>').'</p>'; 
					}else{
						$content .= '		<h2>'.$wall->CONTENT.'</h2>';
					}
					$content .= '		<div class="date">
											<h3 style="float:left;">'.$this->registry->mTask->time_since($wall->TANGGAL).' in <a href="#" title="" onclick="return false;">'.$wall->IDENTITY.'</a></h3>    	
											<h3><a href="#" class="comment" id="'.$wall->IDENTITY.'-'.$wall->ID.'">comments (0)</a></h3>
											<div class=".clear"></div>
										</div>';
					$content .= '		<div class="loadplace'.$wall->IDENTITY.'-'.$wall->ID.'"></div>';
					$content .= '		<div class="flash'.$wall->IDENTITY.'-'.$wall->ID.'"></div>';
				   	$content .= '		<div class="panel" id="slidepanel'.$wall->IDENTITY.'-'.$wall->ID.'">';
					$content .= '			<form method="post" name="'.$wall->IDENTITY.'-'.$wall->ID.'" class="frmComment">
      											<div class="wrapTstatus">
												<textarea id="textboxcontent'.$wall->IDENTITY.'-'.$wall->ID.'" class="comment_txt comment_txtsmall"></textarea>
												<input type="submit" value="Comment" class="comment_submit btn" id="'.$wall->IDENTITY.'-'.$wall->ID.'"/>
												</div>
											</form>
										</div>
									</div>
								</li>';	
					  
					if($previous != NULL){
 						$datawall = $this->registry->mComment->selectDB_comment($wall->ID, $wall->IDENTITY); 
                        $content .= '<div class="loadplace'.$wall->IDENTITY.'-'.$wall->ID.'">';						
						if(count($datawall) > 0){
							foreach($datawall as $comment){
								$content .= '<div class="comment_load" id="comment'.$wall->IDENTITY.'-'.$comment->COMMENT_ID.'">';
								$content .= '<img width="50" height="50" src="includes/img/photo/'.$comment->PHOTO.'"/>';
								$content .= '<a href="#">'.$comment->NAME.'</a> '.$comment->CONTENT;
								if($comment->USER_ID == $_SESSION['userid']){
									$content .= '<a href="#" id="'.$wall->IDENTITY.'-'.$comment->COMMENT_ID.'" class="cdelete_update"  style="float:right;" >x</a><br>';
								} 
								$content .= '<h3>'.$this->registry->mTask->time_since($comment->INPUT_DTM).'</h3>';//$comment->INPUT_DTM
								$content .= '</div>';
							}	
						}

                        $content .= '</div>';
						
						echo $content;
					}
				}
			}
		}
		if($previous == NULL)
    		return $content;

    }
    

	public function UpdateStatus($wall,$userid){
		$time = date("Y-m-d h:i:s");
		$query = "INSERT INTO wall(wall,datewall,user) VALUES ('$wall','$time','$userid')";
		$rs = $this->registry->db->Execute($query);
		if(!$rs){
		throw new Exception('Gagal menyimpan Status');
		}
		else{
			$data = array();
			$queryselect = "SELECT *
					FROM wall order by wall_id desc";
			$rsselect = $this->registry->db->Execute($queryselect);
			
			if($rsselect){
			  if($rsselect->RecordCount() > 0){
				while($row = $rsselect->FetchNextObject()){
				  $data[] = $row;
				}
			  }
			}
			return $data;
		}
	}
	
	public function deleteDB_status($id){
		$query = "DELETE FROM wall where wall_id=".$id;
		$rs = $this->registry->db->Execute($query);
		if(!$rs) throw new Exception('Gagal mengahapus Status');
	}
	
	public function DeleteStatus($wall_id){
			$query = "DELETE FROM wall where wall_id='$wall_id'";
			$rs = $this->registry->db->Execute($query);
			$querycomment = "DELETE FROM wall_comment where wall_id='$wall_id'";
			$rscomment = $this->registry->db->Execute($querycomment);
			if((!$rscomment) && (!$rs)) {
			throw new Exception('Gagal meremove Status');
			}
			return $rscomment;
	}
	
	public function UpdateComment($comment,$msg_id){
		$data = array();
		$userid = $_SESSION['userid'];
		//$t= date("Y-m-d h:i:s");
		$query = "INSERT INTO wall_comment(comment,wall_id,datecomment,user_id) VALUES ('$comment', $msg_id,now(),'".$_SESSION['userid']."')";
		$rs = $this->registry->db->Execute($query);
		if(!$rs) {
			throw new Exception($query.' Gagal menyimpan Status');
		}
		else{
			$data = array();
			$queryselect = "SELECT * FROM wall_comment where wall_id = '$msg_id' order by comment_id desc";
			$rsselect = $this->registry->db->Execute($queryselect);
			if($rsselect){
			  if($rsselect->RecordCount() > 0){
				while($row = $rsselect->FetchNextObject()){
				  $data[] = $row;
				}
			  }
			}
			return $data;
		}
	}
	
	public function DeleteComment($comment_id){
		$data = array();
		$query = "DELETE FROM wall_comment where comment_id='$comment_id'";
		$rs = $this->registry->db->Execute($query);
		if(!$rs) {
		throw new Exception('Gagal meremove comment');
		}
		return $rs;
	}
	
	public function SelectAllWall(){
		$data = array();
		$query = "SELECT * 
			FROM wall order by wall_id desc";
		$rs = $this->registry->db->Execute($query);
		if($rs){
		    if($rs->RecordCount() > 0){
			while($row = $rs->FetchNextObject()){
			  $data[] = $row;
			}
		  }
		}else throw new Exception('Gagal ambil comment in wall');
		return $data;
	}

	public function SelectMyWall($userid){
		$data = array();
		$query = "SELECT * FROM wall where user = '".$userid."' order by wall_id desc";
		$rs = $this->registry->db->Execute($query);
		if($rs){
		    if($rs->RecordCount() > 0){
			while($row = $rs->FetchNextObject()){
			  $data[] = $row;
			}
		  }
		}else throw new Exception(' '.$query.' Gagal ambil comment in wall');
		return $data;
	}
	
	public function SelectComment_In_Wall($wall_id){
		$data = array();
		$query = "SELECT * 
			FROM wall_comment where wall_id = '$wall_id' order by comment_id asc";
		$rs = $this->registry->db->Execute($query);
		if($rs){
		    if($rs->RecordCount() > 0){
			while($row = $rs->FetchNextObject()){
			  $data[] = $row;
			}
		  }
		}else throw new Exception('Gagal ambil comment in wall');
		return $data;
	}
	
	public function selectDB_wallDetail($id){
		$data = array();
		$query = "SELECT w.wall_id AS id, w.user AS userid, u.name, 'title' AS title, w.wall AS content, 
				  	w.datewall AS tanggal, 'wall' AS identity, u.photo
				  	FROM wall w JOIN user u ON w.user = u.user_id 
					WHERE wall_id = '".$id."'";
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
