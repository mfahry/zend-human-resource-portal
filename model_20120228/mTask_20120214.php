<?php
class MTask{

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
	
    /*function relativeTime($dt,$precision=2){
    	$times=array(	365*24*60*60	=> "year",
    					30*24*60*60		=> "month",
    					7*24*60*60		=> "week",
    					24*60*60		=> "day",
    					60*60			=> "hour",
    					60				=> "minute",
    					1				=> "second");

    	$passed=time()-$dt;

    	if($passed<5){
    		$output='less than 5 seconds ago';
    	}else{
    		$output=array();
    		$exit=0;

    		foreach($times as $period=>$name)
    		{
    			if($exit>=$precision || ($exit>0 && $period<60)) break;

    			$result = floor($passed/$period);
    			if($result>0)
    			{
    				$output[]=$result.' '.$name.($result==1?'':'s');
    				$passed-=$result*$period;
    				$exit++;
    			}
    			else if($exit>0) $exit++;
    		}

    		$output=implode(' and ',$output).' ago';
    	}

    	return $output;
    }*/

    function formatTweet($data) {
		foreach($data as $wall){
			if(is_string($wall->DATE)) $dt=strtotime($wall->DATE);
	
			$content=htmlspecialchars(stripslashes($wall->CONTENT));
		
			$content .= '
				<li>
				<a href="#"><img class="avatar" src="includes/img/photo/'.(isset($photo)?$photo:'image.gif').'" width="48" height="48" alt="avatar" /></a>
				<div class="tweetTxt">
				<strong><a href="#">'.$wall->USERID.'</a></strong> '. preg_replace('/((?:http|https|ftp):\/\/(?:[A-Z0-9][A-Z0-9_-]*(?:\.[A-Z0-9][A-Z0-9_-]*)+):?(\d+)?\/?[^\s\"\']+)/i','<a href="$1" rel="nofollow" target="blank">$1</a>',$content).'
				<div class="date">'.$this->relativeTime($dt).'</div>
				</div>
				<div class="clear"></div>
				</li>';
		}
		
    	return $content;

    }
    
    public function selectDB_allTask ($userid = NULL) {
		$data = array();
		$query = "SELECT * FROM task";
		if($userid != NULL) $query .= " WHERE user_id = '".$userid."'";
          $rs = $this->registry->db->Execute($query);
        if($rs){
          if($rs->RecordCount() > 0){
            while($row = $rs->FetchNextObject()){
              $data[] = $row;

            }
          }
        }else  throw new Exception('Gagal mengambil data task');
        
        return $data;
	}
	//revision 20110530
	//new(too young to take this chance)
	public function selectDB_orgtask($userid,$orgid){

		$data = array();
        /*$query = "SELECT DISTINCT(t.task) as task, ts.update_dtm, ts.status, t.user_id, t.task_id FROM task t join task_status ts on t.task_id = ts.task_id
					WHERE ts.status < 100 and is_show = 1 and(t.user_id = '".$userid."' 
					or t.user_id IN (select b.childuser_id from organization a join organization_team b on a.organization_id = b.organization_id 
					where b.user_id = '".$userid."' and a.organization_id='".$orgid."'))
					ORDER BY t.user_id";*/
					
		/*$query = "SELECT DISTINCT(t.task) as task, ts.update_dtm, ts.status, t.user_id, t.task_id FROM task t join task_status ts on t.task_id = ts.task_id 
					WHERE ts.status < 100 and is_show = 1 and(t.user_id = '".$userid."' or t.user_id IN
					(select b.childuser_id from organization a join organization_team b on a.organization_id = b.organization_id 
					where b.childuser_id = '".$userid."' and a.organization_id='".$orgid."')or t.user_id IN
					(select b.user_id from organization a join organization_team b on a.organization_id = b.organization_id 
					where b.childuser_id = '".$userid."'))
					ORDER BY t.user_id";*/
					
		$query = "SELECT DISTINCT(t.task) as task, ts.update_dtm, ts.status, t.user_id, t.task_id FROM task t join task_status ts on t.task_id = ts.task_id 
					WHERE ts.status < 100 and is_show = 1 and(t.user_id = '".$userid."' or t.user_id IN
					(select b.childuser_id from organization a right join organization_team b on a.organization_id = b.organization_id 
					where b.organization_id='".$orgid."')or t.user_id IN
					(select b.user_id from organization a right join organization_team b on a.organization_id = b.organization_id 
					where b.childuser_id = '".$userid."' and b.organization_id = '".$orgid."'))
					ORDER BY t.user_id";

        $rs = $this->registry->db->Execute($query);
        if($rs){
          if($rs->RecordCount() > 0){
            while($row = $rs->FetchNextObject()){
              $data[] = $row;
            }
          }
        }else  throw new Exception('Gagal mengambil data task');
        
        return $data;
	
	
	}
	//revision 20110530
	//new(too young to take this chance)
	public function selectDB_orgteam($userid){
		$data = array();
		
        $query = "SELECT o.organization_id, o.name 
					from organization o JOIN organization_team ot ON o.organization_id=ot.organization_id ";

		if($userid == ($_SESSION['position_id'] == 1)) 
			$query .= "WHERE ot.user_id = '".$userid."' or ot.childuser_id='".$userid."' and ot.organization_id = '12' GROUP BY o.organization_id,o.name";
		else 
			$query .= "WHERE ot.user_id = '".$userid."' or ot.childuser_id='".$userid."'  and ot.organization_id <> '12'GROUP BY o.organization_id,o.name";
			
        $rs = $this->registry->db->Execute($query);
        if($rs){
          if($rs->RecordCount() > 0){
            while($row = $rs->FetchNextObject()){
              $data[] = $row;
            }
          }
        }else  throw new Exception('Gagal mengambil data organisasi');
        
        return $data;
	
	
	}
	#20110617: query untuk tambah task user yang akan di delegasikan
	public function selectDB_orglead($userid, $orgid){
		$data = array();		
        $query = "SELECT b.childuser_id, u.name FROM (`organization` a join organization_team b on a.organization_id=b.organization_id) join user u on b.childuser_id = u.user_id
					WHERE b.user_id = '".$userid."' and b.organization_id = '".$orgid."' ";
			
        $rs = $this->registry->db->Execute($query);
        if($rs){
          if($rs->RecordCount() > 0){
            while($row = $rs->FetchNextObject()){
              $data[] = $row;
            }
          }
        }else  throw new Exception('Gagal mengambil data organisasi');
        
     	return $data;
	
	}
	
	#20110616: pilih childuser untuk memberi tugas
	public function selectDB_team($userid){
		$data = array();
		
        $query = "SELECT DISTINCT ot.childuser_id FROM user u JOIN organization_team ot ON ot.user_id = u.user_id 
					WHERE ot.user_id = '".$userid."' ";
	
        $rs = $this->registry->db->Execute($query);
        if($rs){
          if($rs->RecordCount() > 0){
            while($row = $rs->FetchNextObject()){
              $data[] = $row;
            }
          }
        }else  throw new Exception('Gagal mengambil data team');
        
        return $data;	
	}
	
	public function get_taskNotif($userid){
		$data = array();
		
        $query = "SELECT * FROM user_task WHERE user_id = '".$userid."' AND status = 0";
	
        $rs = $this->registry->db->Execute($query);
        if($rs){
          if($rs->RecordCount() > 0){
            while($row = $rs->FetchNextObject()){
              $data[] = $row;
            }
          }
        }else  throw new Exception('Gagal mengambil data notifikasi');
        
        return $data;	
	}
	
	public function get_taskTitle($taskid){
		$data = array();
		
        $query = "SELECT * FROM task WHERE task_id = $taskid";
	
        $rs = $this->registry->db->Execute($query);
        if($rs){
          if($rs->RecordCount() > 0){
            while($row = $rs->FetchNextObject()){
              $data[] = $row;
            }
          }
        }else  throw new Exception('Gagal mengambil data task');
        
        return $data;	
	}
	
	public function update_userTaskStatus($user_id){
		$query = "UPDATE user_task SET status ='1' WHERE user_id ='".$user_id."' AND status='0'";
		
		if(!$this->registry->db->execute($query)) throw new Exception('Gagal mengupdate data task');
		else return $query;
	}
	
    function get_userNick($user_id){
		$query = "select nick_name from user WHERE user_id ='".$user_id."'";
		
		$rs = $this->registry->db->Execute($query);
        if($rs){
          if($rs->RecordCount() > 0){
            $row = $rs->FetchNextObject();
              $data = $row->NICK_NAME;
          }
        }else  throw new Exception("Gagal mengambil nick name $user_id");
        
        return $data;
	}
	#for task in attendance
    public function selectDB_task($userid = NULL, $procent = NULL, $month = NULL, $year = NULL, $task_id = NULL){
		$data = array();
        /*$query = "SELECT DISTINCT(t.task), u.user_id, u.photo, ts.update_dtm, ts.status, t.task_id, u.name, t.priority_id
                    FROM task t JOIN user u ON t.user_id=u.user_id
					JOIN task_status ts ON ts.task_id = t.task_id ";*/
		
		$query = "SELECT a.*,b.*,ts.* 
					FROM (user_task a join task b on a.task_id=b.task_id) 
					join task_status ts on b.task_id = ts.task_id";
		
        if($userid != NULL && $userid != 0) 
			$query .= " WHERE a.user_id='".$userid."' ";
			
		if($task_id != NULL){ 
			$query .= " AND b.task_id = '".$task_id."' ORDER BY b.priority_id ASC, ts.status DESC, ts.update_dtm DESC";	
		}else{
			$query .= "  AND ts.is_show = 1 group by b.task_id having max(ts.status) <> 100 ORDER BY b.priority_id ASC, ts.status DESC, ts.update_dtm DESC";	
		}
		
		//$query .= " AND ts.is_show = 1";
	
		//$query .= " group by b.task_id having max(ts.status) <> 100";
		//$query .= " ORDER BY b.priority_id ASC, ts.status DESC, ts.update_dtm DESC";

		//echo $query.'<br>';
		
        $rs = $this->registry->db->Execute($query);
        if($rs){
          if($rs->RecordCount() > 0){
            while($row = $rs->FetchNextObject()){
              $data[] = $row;
            }
          }
        }else  throw new Exception('Gagal mengambil data task');
        
        return $data;
    }
	 #2011-06-15: display top 5
	public function selectDB_taskTop5($userid = NULL, $procent = NULL, $month = NULL, $year = NULL, $task_id = NULL){
		$data = array();
		$query = "SELECT a.*,b.*,ts.* 
					FROM (user_task a join task b on a.task_id=b.task_id) 
					join task_status ts on b.task_id = ts.task_id";
		
        if($userid != NULL && $userid != 0) 
			$query .= " WHERE a.user_id='".$userid."'";
			
		$query .= " AND ts.is_show = 1";
	
		$query .= " group by b.task_id having max(ts.status) <> 100";
		$query .= " ORDER BY b.priority_id ASC, ts.status DESC, ts.update_dtm DESC";

		//echo $query.'<br>';
		
        $rs = $this->registry->db->Execute($query);
        if($rs){
          if($rs->RecordCount() > 0){
            while($row = $rs->FetchNextObject()){
              $data[] = $row;
            }
          }
        }else  throw new Exception('Gagal mengambil data task');
        
        return $data;
        /*$query = "SELECT t.task, u.user_id, u.photo, ts.update_dtm, ts.status, t.task_id, u.name, t.priority_id
                    FROM task t JOIN user u ON t.user_id=u.user_id
					JOIN task_status ts ON ts.task_id = t.task_id ";
        if($userid != NULL && $userid != 0) 
			$query .= " WHERE t.user_id = '".$userid."'";
        if($procent != NULL) 
			$query .= " AND ts.status < '".$procent."'";
        if($month != NULL && $userid != 0) 
			$query .= " AND MONTH(ts.update_dtm) = '".$month."'";
		elseif($month != NULL && $userid == 0) 
			$query .= " WHERE MONTH(ts.update_dtm) = '".$month."'";
        if($year != NULL) 
			$query .= " AND YEAR(ts.update_dtm) = '".$year."'";
		
        if($task_id != NULL) 
			$query .= " AND t.task_id = '".$task_id."' ORDER BY t.priority_id ASC LIMIT 5";
        else 
			$query .= " AND ts.is_show = 1 ORDER BY t.priority_id ASC LIMIT 5";

		 //echo $query.'<br>';
        $rs = $this->registry->db->Execute($query);
        if($rs){
          if($rs->RecordCount() > 0){
            while($row = $rs->FetchNextObject()){
              $data[] = $row;
            }
          }
        }else  throw new Exception('Gagal mengambil data task');
        
        return $data;*/
    }
	#20111118: add new condition for new selection in task report
	#20120131: add new condition for new selection in task report
	function get_taskByCalendar($userid = NULL, $month = NULL, $year = NULL, $project = NULL, $date = NULL){
		$data = array();
        $query = "SELECT t.task, u.user_id, u.photo, ts.update_dtm, ts.status, t.task_id, t.priority_id, u.name, t.target, t.calendar_id
                    FROM task t JOIN user u ON t.user_id=u.user_id
					JOIN task_status ts ON ts.task_id = t.task_id";
		#all options fully			
        if($userid != NULL && $userid != 0 && $month != NULL && $year != NULL && $project!=NULL && $date!=NULL){
			$query .= " WHERE t.user_id = '".$userid."'  
						AND MONTH(ts.update_dtm) = '".$month."' 
						AND YEAR(ts.update_dtm) = '".$year."'
						AND t.task LIKE '%[".$project."]%'
						AND DAY(ts.update_dtm) = '".$date."'";
		#all options fully	except $date
		}elseif($userid != NULL && $userid != 0 && $month != NULL && $year != NULL && $project!=NULL && $date==NULL){
			$query .= " WHERE t.user_id = '".$userid."'  
						AND MONTH(ts.update_dtm) = '".$month."' 
						AND YEAR(ts.update_dtm) = '".$year."'
						AND t.task LIKE '%[".$project."]%'";
		#all options fully	except $project				
		}elseif($userid != NULL && $userid != 0 && $month != NULL && $year != NULL && $project==NULL && $date!=NULL){
			$query .= " WHERE t.user_id = '".$userid."'  
						AND MONTH(ts.update_dtm) = '".$month."' 
						AND YEAR(ts.update_dtm) = '".$year."'
						AND DAY(ts.update_dtm) = '".$date."'";
		#except $project and $date
		}elseif($userid != NULL && $userid != 0 && $month != NULL && $year != NULL && $project==NULL && $date==NULL){
			$query .= " WHERE t.user_id = '".$userid."'  
						AND MONTH(ts.update_dtm) = '".$month."' 
						AND YEAR(ts.update_dtm) = '".$year."'";		
		#all options fully	except $month		
		}elseif($userid != NULL && $userid != 0 && $month == NULL && $year != NULL && $project!=NULL && $date!=NULL){
			$query .= " WHERE t.user_id = '".$userid."'   
						AND YEAR(ts.update_dtm) = '".$year."'
						AND t.task LIKE '%[".$project."]%'
						AND DAY(ts.update_dtm) = '".$date."'";
		#except $month and $date		
		}elseif($userid != NULL && $userid != 0 && $month == NULL && $year != NULL && $project!=NULL && $date==NULL){
			$query .= " WHERE t.user_id = '".$userid."'   
						AND YEAR(ts.update_dtm) = '".$year."'
						AND t.task LIKE '%[".$project."]%'";
		#except $month and $project
		}elseif($userid != NULL && $userid != 0 && $month == NULL && $year != NULL && $project==NULL && $date!=NULL){
			$query .= " WHERE t.user_id = '".$userid."'  
						AND YEAR(ts.update_dtm) = '".$year."'
						AND DAY(ts.update_dtm) = '".$date."'";
		#except $month and $project and $date
		}elseif($userid != NULL && $userid != 0 && $month == NULL && $year != NULL && $project==NULL && $date==NULL){
			$query .= " WHERE t.user_id = '".$userid."'  
						AND YEAR(ts.update_dtm) = '".$year."'";
		#all options fully except $year
		}elseif($userid != NULL && $userid != 0 && $month != NULL && $year == NULL && $project!=NULL && $date!=NULL){
			$query .= " WHERE t.user_id = '".$userid."'   
						AND MONTH(ts.update_dtm) = '".$month."'
						AND t.task LIKE '%[".$project."]%'
						AND DAY(ts.update_dtm) = '".$date."'";
		#except $year and $date
		}elseif($userid != NULL && $userid != 0 && $month != NULL && $year == NULL && $project!=NULL && $date==NULL){
			$query .= " WHERE t.user_id = '".$userid."'   
						AND MONTH(ts.update_dtm) = '".$month."'
						AND t.task LIKE '%[".$project."]%'";
		#except $year and $project
		}elseif($userid != NULL && $userid != 0 && $month != NULL && $year == NULL && $project==NULL && $date!=NULL){
			$query .= " WHERE t.user_id = '".$userid."'  
						AND MONTH(ts.update_dtm) = '".$month."'
						AND DAY(ts.update_dtm) = '".$date."'";	
		#except $year and $project and $date
		}elseif($userid != NULL && $userid != 0 && $month != NULL && $year == NULL && $project==NULL && $date==NULL){
			$query .= " WHERE t.user_id = '".$userid."'  
						AND MONTH(ts.update_dtm) = '".$month."'";
		#except $userid							
		}elseif($userid != NULL && $userid == 0 && $month != NULL && $year != NULL && $project!=NULL && $date!=NULL){
			$query .= " AND MONTH(ts.update_dtm) = '".$month."' 
						AND YEAR(ts.update_dtm) = '".$year."'
						AND t.task LIKE '%[".$project."]%'
						AND DAY(ts.update_dtm) = '".$date."'";
		#except $userid and $date					
		}elseif($userid != NULL && $userid == 0 && $month != NULL && $year != NULL && $project!=NULL && $date==NULL){
			$query .= " AND MONTH(ts.update_dtm) = '".$month."' 
						AND YEAR(ts.update_dtm) = '".$year."'
						AND t.task LIKE '%[".$project."]%'";
		#except $userid and $project				
		}elseif($userid != NULL && $userid == 0 && $month != NULL && $year != NULL && $project==NULL && $date!=NULL){
			$query .= " AND MONTH(ts.update_dtm) = '".$month."' 
						AND YEAR(ts.update_dtm) = '".$year."'
						AND DAY(ts.update_dtm) = '".$date."'";
		#except $userid and $project and $date				
		}elseif($userid != NULL && $userid == 0 && $month != NULL && $year != NULL && $project==NULL && $date==NULL){
			$query .= " AND MONTH(ts.update_dtm) = '".$month."' 
						AND YEAR(ts.update_dtm) = '".$year."'";
		
		#except $userid and $month				
		}elseif($userid != NULL && $userid == 0 && $month == NULL && $year != NULL && $project!=NULL && $date!=NULL){
			$query .= " WHERE YEAR(ts.update_dtm) = '".$year."'
						AND t.task LIKE '%[".$project."]%'
						AND DAY(ts.update_dtm) = '".$date."'";
		#except $userid and $month and $date
		}elseif($userid != NULL && $userid == 0 && $month == NULL && $year != NULL && $project!=NULL && $date==NULL){
			$query .= " WHERE YEAR(ts.update_dtm) = '".$year."'
						AND t.task LIKE '%[".$project."]%'";
		#except $userid and month and project
		}elseif($userid != NULL && $userid == 0 && $month == NULL && $year != NULL && $project==NULL && $date!=NULL){
			$query .= " WHERE YEAR(ts.update_dtm) = '".$year."'
						AND DAY(ts.update_dtm) = '".$date."'";
		#except $userid and $month and $project and $date
		}elseif($userid != NULL && $userid == 0 && $month == NULL && $year != NULL && $project==NULL && $date==NULL){
			$query .= " WHERE YEAR(ts.update_dtm) = '".$year."'";
		#except $userid and $year					
		}elseif($userid != NULL && $userid == 0 && $month != NULL && $year == NULL && $project!=NULL && $date!=NULL){
			$query .= " WHERE MONTH(ts.update_dtm) = '".$month."'
						AND t.task LIKE '%[".$project."]%'
						AND DAY(ts.update_dtm) = '".$date."'";
		#except $userid and $year and $date				
		}elseif($userid != NULL && $userid == 0 && $month != NULL && $year == NULL && $project!=NULL && $date==NULL){
			$query .= " WHERE MONTH(ts.update_dtm) = '".$month."'
						AND t.task LIKE '%[".$project."]%'";
		#except $userid and $year and $project
		}elseif($userid != NULL && $userid == 0 && $month != NULL && $year == NULL && $project==NULL && $date!=NULL){
			$query .= " WHERE MONTH(ts.update_dtm) = '".$month."'
						AND DAY(ts.update_dtm) = '".$date."'";
		#except $userid and $year and $project and $date
		}elseif($userid != NULL && $userid == 0 && $month != NULL && $year == NULL && $project==NULL && $date==NULL){
			$query .= " WHERE MONTH(ts.update_dtm) = '".$month."'";
			
		#by your self all options fully				
		}elseif($userid == NULL && $_SESSION['position_id'] != 1 && $_SESSION['level_id'] != 2 && $month != NULL && $year != NULL && $project!=NULL){
			$query .= " WHERE t.user_id = '".$_SESSION['userid']."'  
						AND MONTH(ts.update_dtm) = '".$month."' 
						AND YEAR(ts.update_dtm) = '".$year."'
						AND t.task LIKE '%[".$project."]%'";
		#by your self all options fully except $project				
		}elseif($userid == NULL && $_SESSION['position_id'] != 1 && $_SESSION['level_id'] != 2 && $month != NULL && $year != NULL && $project==NULL){
			$query .= " WHERE t.user_id = '".$_SESSION['userid']."' 
						AND MONTH(ts.update_dtm) = '".$month."' 
						AND YEAR(ts.update_dtm) = '".$year."'";
		#by your self except $month and $year 
		}elseif($userid == NULL && $_SESSION['position_id'] != 1 && $_SESSION['level_id'] != 2 && $month == NULL && $year == NULL && $project!=NULL){
			$query .= " WHERE t.user_id = '".$_SESSION['userid']."'
						AND t.task LIKE '%[".$project."]%'";
		#by your self except $month and $year and $project
		}elseif($userid == NULL && $_SESSION['position_id'] != 1 && $_SESSION['level_id'] != 2 && $month == NULL && $year == NULL && $project==NULL){
			$query .= " WHERE t.user_id = '".$_SESSION['userid']."'";
		#by your self except $year
		}elseif($userid == NULL && $_SESSION['position_id'] != 1 && $_SESSION['level_id'] != 2 && $month != NULL && $year == NULL && $project!=NULL){
			$query .= " WHERE t.user_id = '".$_SESSION['userid']."'
						AND MONTH(ts.update_dtm) = '".$month."'
						AND t.task LIKE '%[".$project."]%'";
		#by your self except $year and $project
		}elseif($userid == NULL && $_SESSION['position_id'] != 1 && $_SESSION['level_id'] != 2 && $month != NULL && $year == NULL && $project==NULL){
			$query .= " WHERE t.user_id = '".$_SESSION['userid']."'
						AND MONTH(ts.update_dtm) = '".$month."'";
		#by your self except $month
		}elseif($userid == NULL && $_SESSION['position_id'] != 1 && $_SESSION['level_id'] != 2 && $month == NULL && $year != NULL && $project!=NULL){
			$query .= " WHERE t.user_id = '".$_SESSION['userid']."'
						AND YEAR(ts.update_dtm) = '".$year."'
						AND t.task LIKE '%[".$project."]%'";
		#by your self except $month and $project
		}elseif($userid == NULL && $_SESSION['position_id'] != 1 && $_SESSION['level_id'] != 2 && $month == NULL && $year != NULL && $project==NULL){
			$query .= " WHERE t.user_id = '".$_SESSION['userid']."'
						AND YEAR(ts.update_dtm) = '".$year."'";				
		#by your self except $project
		}elseif($userid == NULL && $_SESSION['position_id'] == 1 && $_SESSION['level_id'] != 2 && $month != NULL && $year != NULL && $project==NULL){
			$query .= " WHERE MONTH(ts.update_dtm) = '".$month."' 
						AND YEAR(ts.update_dtm) = '".$year."'";
						
		}
       
		//$query .= " GROUP BY ts.task_id ORDER BY ts.task_id,ts.update_dtm DESC ";
		$query .= " AND ts.is_show = 1 GROUP BY ts.task_id
					ORDER BY ts.task_id,ts.update_dtm DESC ";
 		//echo $query.'<br>';
        $rs = $this->registry->db->Execute($query);
        if($rs){
          if($rs->RecordCount() > 0){
            while($row = $rs->FetchNextObject()){
              $data[] = $row;
            }
          }
        }else  throw new Exception('Gagal mengambil data task');
        
        return $data;
	}
	function get_taskByPeriod($userid = NULL, $month = NULL, $year = NULL, $project = NULL, $date = NULL){
		$data = array();
        $query = "SELECT t.task, u.user_id, u.photo, ts.update_dtm, ts.status, t.task_id, t.priority_id, u.name, 
					t.target, t.calendar_id, d.name_day
                    FROM task t JOIN user u ON t.user_id=u.user_id
					JOIN task_status ts ON ts.task_id = t.task_id
					JOIN calendar cal ON cal.calendar_id = t.calendar_id
					JOIn day d ON d.day_id = cal.day_id";
		#all options fully			
        if($userid != NULL && $userid != 0 && $month != NULL && $year != NULL && $project!=NULL && $date!=NULL){
			$query .= " WHERE t.user_id = '".$userid."'  
						AND MONTH(ts.update_dtm) = '".$month."' 
						AND YEAR(ts.update_dtm) = '".$year."'
						AND t.task LIKE '%[".$project."]%'
						AND DAY(ts.update_dtm) = '".$date."'";
		#all options fully	except $date
		}elseif($userid != NULL && $userid != 0 && $month != NULL && $year != NULL && $project!=NULL && $date==NULL){
			$query .= " WHERE t.user_id = '".$userid."'  
						AND MONTH(ts.update_dtm) = '".$month."' 
						AND YEAR(ts.update_dtm) = '".$year."'
						AND t.task LIKE '%[".$project."]%'";
		#all options fully	except $project				
		}elseif($userid != NULL && $userid != 0 && $month != NULL && $year != NULL && $project==NULL && $date!=NULL){
			$query .= " WHERE t.user_id = '".$userid."'  
						AND MONTH(ts.update_dtm) = '".$month."' 
						AND YEAR(ts.update_dtm) = '".$year."'
						AND DAY(ts.update_dtm) = '".$date."'";
		#except $project and $date
		}elseif($userid != NULL && $userid != 0 && $month != NULL && $year != NULL && $project==NULL && $date==NULL){
			$query .= " WHERE t.user_id = '".$userid."'  
						AND MONTH(ts.update_dtm) = '".$month."' 
						AND YEAR(ts.update_dtm) = '".$year."'";		
		#all options fully	except $month		
		}elseif($userid != NULL && $userid != 0 && $month == NULL && $year != NULL && $project!=NULL && $date!=NULL){
			$query .= " WHERE t.user_id = '".$userid."'   
						AND YEAR(ts.update_dtm) = '".$year."'
						AND t.task LIKE '%[".$project."]%'
						AND DAY(ts.update_dtm) = '".$date."'";
		#except $month and $date		
		}elseif($userid != NULL && $userid != 0 && $month == NULL && $year != NULL && $project!=NULL && $date==NULL){
			$query .= " WHERE t.user_id = '".$userid."'   
						AND YEAR(ts.update_dtm) = '".$year."'
						AND t.task LIKE '%[".$project."]%'";
		#except $month and $project
		}elseif($userid != NULL && $userid != 0 && $month == NULL && $year != NULL && $project==NULL && $date!=NULL){
			$query .= " WHERE t.user_id = '".$userid."'  
						AND YEAR(ts.update_dtm) = '".$year."'
						AND DAY(ts.update_dtm) = '".$date."'";
		#except $month and $project and $date
		}elseif($userid != NULL && $userid != 0 && $month == NULL && $year != NULL && $project==NULL && $date==NULL){
			$query .= " WHERE t.user_id = '".$userid."'  
						AND YEAR(ts.update_dtm) = '".$year."'";
		#all options fully except $year
		}elseif($userid != NULL && $userid != 0 && $month != NULL && $year == NULL && $project!=NULL && $date!=NULL){
			$query .= " WHERE t.user_id = '".$userid."'   
						AND MONTH(ts.update_dtm) = '".$month."'
						AND t.task LIKE '%[".$project."]%'
						AND DAY(ts.update_dtm) = '".$date."'";
		#except $year and $date
		}elseif($userid != NULL && $userid != 0 && $month != NULL && $year == NULL && $project!=NULL && $date==NULL){
			$query .= " WHERE t.user_id = '".$userid."'   
						AND MONTH(ts.update_dtm) = '".$month."'
						AND t.task LIKE '%[".$project."]%'";
		#except $year and $project
		}elseif($userid != NULL && $userid != 0 && $month != NULL && $year == NULL && $project==NULL && $date!=NULL){
			$query .= " WHERE t.user_id = '".$userid."'  
						AND MONTH(ts.update_dtm) = '".$month."'
						AND DAY(ts.update_dtm) = '".$date."'";	
		#except $year and $project and $date
		}elseif($userid != NULL && $userid != 0 && $month != NULL && $year == NULL && $project==NULL && $date==NULL){
			$query .= " WHERE t.user_id = '".$userid."'  
						AND MONTH(ts.update_dtm) = '".$month."'";
		#except $userid							
		}elseif($userid != NULL && $userid == 0 && $month != NULL && $year != NULL && $project!=NULL && $date!=NULL){
			$query .= " AND MONTH(ts.update_dtm) = '".$month."' 
						AND YEAR(ts.update_dtm) = '".$year."'
						AND t.task LIKE '%[".$project."]%'
						AND DAY(ts.update_dtm) = '".$date."'";
		#except $userid and $date					
		}elseif($userid != NULL && $userid == 0 && $month != NULL && $year != NULL && $project!=NULL && $date==NULL){
			$query .= " AND MONTH(ts.update_dtm) = '".$month."' 
						AND YEAR(ts.update_dtm) = '".$year."'
						AND t.task LIKE '%[".$project."]%'";
		#except $userid and $project				
		}elseif($userid != NULL && $userid == 0 && $month != NULL && $year != NULL && $project==NULL && $date!=NULL){
			$query .= " AND MONTH(ts.update_dtm) = '".$month."' 
						AND YEAR(ts.update_dtm) = '".$year."'
						AND DAY(ts.update_dtm) = '".$date."'";
		#except $userid and $project and $date				
		}elseif($userid != NULL && $userid == 0 && $month != NULL && $year != NULL && $project==NULL && $date==NULL){
			$query .= " AND MONTH(ts.update_dtm) = '".$month."' 
						AND YEAR(ts.update_dtm) = '".$year."'";
		
		#except $userid and $month				
		}elseif($userid != NULL && $userid == 0 && $month == NULL && $year != NULL && $project!=NULL && $date!=NULL){
			$query .= " WHERE YEAR(ts.update_dtm) = '".$year."'
						AND t.task LIKE '%[".$project."]%'
						AND DAY(ts.update_dtm) = '".$date."'";
		#except $userid and $month and $date
		}elseif($userid != NULL && $userid == 0 && $month == NULL && $year != NULL && $project!=NULL && $date==NULL){
			$query .= " WHERE YEAR(ts.update_dtm) = '".$year."'
						AND t.task LIKE '%[".$project."]%'";
		#except $userid and month and project
		}elseif($userid != NULL && $userid == 0 && $month == NULL && $year != NULL && $project==NULL && $date!=NULL){
			$query .= " WHERE YEAR(ts.update_dtm) = '".$year."'
						AND DAY(ts.update_dtm) = '".$date."'";
		#except $userid and $month and $project and $date
		}elseif($userid != NULL && $userid == 0 && $month == NULL && $year != NULL && $project==NULL && $date==NULL){
			$query .= " WHERE YEAR(ts.update_dtm) = '".$year."'";
		#except $userid and $year					
		}elseif($userid != NULL && $userid == 0 && $month != NULL && $year == NULL && $project!=NULL && $date!=NULL){
			$query .= " WHERE MONTH(ts.update_dtm) = '".$month."'
						AND t.task LIKE '%[".$project."]%'
						AND DAY(ts.update_dtm) = '".$date."'";
		#except $userid and $year and $date				
		}elseif($userid != NULL && $userid == 0 && $month != NULL && $year == NULL && $project!=NULL && $date==NULL){
			$query .= " WHERE MONTH(ts.update_dtm) = '".$month."'
						AND t.task LIKE '%[".$project."]%'";
		#except $userid and $year and $project
		}elseif($userid != NULL && $userid == 0 && $month != NULL && $year == NULL && $project==NULL && $date!=NULL){
			$query .= " WHERE MONTH(ts.update_dtm) = '".$month."'
						AND DAY(ts.update_dtm) = '".$date."'";
		#except $userid and $year and $project and $date
		}elseif($userid != NULL && $userid == 0 && $month != NULL && $year == NULL && $project==NULL && $date==NULL){
			$query .= " WHERE MONTH(ts.update_dtm) = '".$month."'";
		}
       
		//$query .= " GROUP BY ts.task_id ORDER BY ts.task_id,ts.update_dtm DESC ";
		$query .= " AND ts.is_show = 1 GROUP BY ts.task_id
					ORDER BY ts.task_id,ts.update_dtm DESC ";
 		//echo $query.'<br>';
        $rs = $this->registry->db->Execute($query);
        if($rs){
          if($rs->RecordCount() > 0){
            while($row = $rs->FetchNextObject()){
              $data[] = $row;
            }
          }
        }else  throw new Exception('Gagal mengambil data task per period');
        
        return $data;
	}		
	public function get_initialTaskDate($taskid, $userid){
		$data = NULL;
        $query = "SELECT MIN(ts.update_dtm) AS initial_dtm
                    FROM task t JOIN user u ON t.user_id=u.user_id
					JOIN task_status ts ON ts.task_id = t.task_id
        			WHERE t.user_id = '".$userid."'
			 		AND t.task_id = '".$taskid."'";
		//if($procent != NULL) $query .= " LIMIT 0, 10";
		 //echo $query.'<br>';
        $rs = $this->registry->db->Execute($query);
        if($rs){
          if($rs->RecordCount() > 0){
            while($row = $rs->FetchNextObject()){
              $data = $row->INITIAL_DTM;
            }
          }
        }else  throw new Exception('Gagal mengambil initial date task');
        
        return $data;
	}
	
	public function get_maxID(){
		$data = NULL;
		//$query = "SELECT MAX(task_id) AS task_id FROM task LIMIT 1";
		$query = "SHOW TABLE STATUS LIKE 'task'";
        $rs = $this->registry->db->Execute($query);
        if($rs){
          if($rs->RecordCount() > 0){
            while($row = $rs->FetchNextObject()){
              $data = $row->AUTO_INCREMENT;
            }
          }
        }else  throw new Exception('Gagal max data task');
        
        return $data;	
	}
	
    public function insertDB_task($task_id,$userid, $task, $priority,$target, $calid){
			$query = "INSERT INTO task(task_id,user_id, task, priority_id,target, calendar_id) 
						VALUES ('".$task_id."','".$userid."', '".$task."', '1','".$target."','".$calid."')";			

		if(!$this->registry->db->execute($query)) throw new Exception('Gagal menyimpan data task');
    }
	
	public function insertDB_userTask($task,$userid,$status){
		$query = "INSERT INTO user_task (task_id,user_id,status) VALUES ('".$task."', '".$userid."','$status')";			

		if(!$this->registry->db->execute($query)) throw new Exception('Gagal menyimpan data task');
    }
	
	//pilih childuser untuk memberikan tugas
	 public function insertDB_delegationtask($userid, $task, $priority){
			$query = "INSERT INTO task(user_id, task, priority_id) VALUES('".$userid."', '".$task."', '1')";			
	
		if(!$this->registry->db->execute($query)) throw new Exception('Gagal menyimpan data task');
    }
	
	
	public function updateDB_userTask($taskid, $task, $status){
		$query = "UPDATE task SET task ='".$task."', task_status_id ='".$status."' WHERE task_id ='".$taskid."'";
				
		if(!$this->registry->db->execute($query)) throw new Exception('Gagal mengupdate data task');
		
	}
	
	public function updateDB_userTaskTemp($taskid, $status){
		$query = "UPDATE task SET status_task_temp ='".$status."' WHERE task_id ='".$taskid."'";
				
		if(!$this->registry->db->execute($query)) throw new Exception('Gagal mengupdate data task');
	}
	
	public function deleteDB_task($taskid){
		$query = "DELETE FROM task WHERE task_id=".$taskid;
		if(!$this->registry->db->execute($query)) throw new Exception('Gagal menghapus data task');
	}
	
	public function deleteDB_userTask($taskid){
		$query = "DELETE FROM user_task WHERE task_id=".$taskid;
		if(!$this->registry->db->execute($query)) throw new Exception('Gagal menghapus data task');
	}
	
	public function selectDB_taskDetail($id){
		$data = array();
		$query = "SELECT t.task_id AS id, t.user_id AS userid, u.name, 'title' AS title,
				  	CONCAT(t.task, ' : ', ts.status, ' %') AS content, ts.update_dtm AS tanggal, 'task' AS identity, u.photo 
				  	FROM task t JOIN task_status ts ON ts.task_id = t.task_id
				   	JOIN user u ON t.user_id = u.user_id WHERE ts.is_show = 1
					AND t.task_id = '".$id."'";
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
	#06092011: new dashboard fiture
	public function display_marques(){
			$query = "SELECT d.dashboard_id, d.description FROM dashboard d WHERE d.dashboard_id ='1'";	
			
	$rs = $this->registry->db->Execute($query);
        if($rs){
          if($rs->RecordCount() > 0){
            while($row = $rs->FetchNextObject()){
              $data[] = $row;
            }
          }
        }else  throw new Exception('Gagal menampilkan marquee');
        
        return $data;
	
	}
	public function pencarian($word){
			$query = "SELECT distinct SUBSTRING(task, (locate('@',task)+1), (locate(' ', task)-1)) 
						from task where task like '%@%' and lower(SUBSTRING(task, (locate('@',task)+1), (locate(' ', task)-1))) 
						like '".$word."%' group by task";	
			
	$rs = $this->registry->db->Execute($query);
        if($rs){
          if($rs->RecordCount() > 0){
            while($row = $rs->FetchNextObject()){
              $data[] = $row;
            }
          }
        }else  throw new Exception('Gagal mengambil data');
        
        return $data;
	
	}
	
}
?>