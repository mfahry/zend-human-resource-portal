<?php
class MUser{
	private $registry;
	private $loggedOn = false;
	private $pattern_numeric ="/^([0-9]+)$/";
	private $pattern_string ="/^[a-z][A-Z]$/";

  	function __construct( $registry ) {
		$this->registry = $registry;
	}
	
	function __destruct() {
		$this->registry = null;
	}
	
	public function isLoggedOn()
	{
		if (isset($_SESSION['userid'])){ 		
			$this->loggedOn = true;
			
		}else{
			$this->loggedOn = false;
		}
		return $this->loggedOn;	
	}
	
 	public  function onLogin($user, $passwd) {
		$err_msg 	= "Success";
		$err_code 	= 0;
		//$this->registry->db->debug=true;
		$sql = "SELECT a.user_id, a.password, a.name, a.level_id, a.status_login, a.position_id
				FROM user a JOIN u_level b ON a.level_id = b.level_id
				WHERE a.user_id = ? AND hrdstatus = 1";
		
		$stmt 	= $this->registry->db->Prepare($sql);
		$this->registry->db->Parameter($stmt, $user, 'param');
		$rs = $this->registry->db->Execute($sql,array($user));
			
		if ($rs) {
			if ($rs->RecordCount() > 0 ) {
				$row_data = $rs->FetchNextObject();
				
				if ($row_data->STATUS_LOGIN == 2){	
					//throw new Exception("Maaf, user kami locked");
					$err_msg = "Maaf, user kami locked";
					$err_code = 4;
					
				}else{	
					if ( $passwd == $row_data->PASSWORD) {
						
						if ($row_data->STATUS_LOGIN == 1){	
							$err_code	= 3;
							$err_msg	= "Username sedang dipakai";
							$logout     = $this->cekAutomaticallyLogout($user);								
							$expLogOut = explode("#",$logout);
							
							if ($logout!= NULL){ //tidak ada data di session log								
								if ($expLogOut[0]=='1'){ //ip sama dipersilahkan dapat masuk
									$err_code = 0;
									$this->delete_sessionLog($user, 0, $_SERVER['REMOTE_ADDR']);
									$this->gen_session($row_data);	
									
								}else{ //ip berbeda
									if ($expLogOut[1] != ""){
										$this->updateStatusLogin(0,$user);
										$this->delete_sessionLog($user, 0, $_SERVER['REMOTE_ADDR']);
										$this->delete_sessionLog($user, 1, $expLogOut[1]);
										$this->doLogout();	
										
									}else{
										$this->delete_sessionLog($user, 0, $_SERVER['REMOTE_ADDR']);
									}	
								}							
							}else{
								$err_code = 0;
								$this->delete_sessionLog($user, 0, $_SERVER['REMOTE_ADDR']);
								$this->gen_session($row_data);	
							}
							//throw new Exception("Username sedang dipakai");	
							
						}else if ($row_data->STATUS_LOGIN == 2){
							$err_msg = "Maaf, user kami locked";
							$err_code = 4;
							//throw new Exception("Maaf, user kami locked");
							
						}else{
							$err_code = 0;
							$this->delete_sessionLog($user, 0, $_SERVER['REMOTE_ADDR']);
							$this->gen_session($row_data);
						}
					}else { // tidak sama passwordnya
						$err_code = 2;
						$err_msg  = " Pasword Salah ";
						$this->insert_sessionLog('0',$user,0);				
						$rsData   = $this->select_sessionLog($user, 0, $_SERVER['REMOTE_ADDR']);
						
						if (count($rsData) == 3){
							$this->updateStatusLogin(2,$user);
							$this->delete_sessionLog($user, 0, $_SERVER['REMOTE_ADDR']);
							//throw new Exception("Maaf, user kami locked");
							$err_msg = "Maaf, user kami locked";
							$err_code = 4;
						}//else							
							//throw new Exception(" Pasword Salah ");							
					}
				}
			}else {
				//throw new Exception("Maaf, anda tidak terdaftar");
				$err_code = 1;
				$err_msg  = " User Tidak Terdaftar "; 
			}
		}else throw new Exception("Gagal memeriksa login user, hubungi administrator");
		
		if ($err_code == 0 ) {
			return 0;
		} 	else {
			throw new Exception($err_msg);
		}
	}
		
	function cekAutomaticallyLogout($userid){
		$batasSession = 60; //60 menit
		$logout = NULL;
		
		$query 			= "SELECT TIMEDIFF(NOW(), MAX(session_dtm)), ip_address 
							FROM session_log WHERE user_id = ? AND ip_address = ? 
							AND session_stat = 1 GROUP BY user_id";
		$arrBinding[0]  = $userid;
		$arrBinding[1]  = $_SERVER['REMOTE_ADDR'];
		// echo $query.' ' .$userid.' '.$_SERVER['REMOTE_ADDR'];
		$rs 			= $this->registry->db->Execute($query, $arrBinding);
		if($rs){
			if ($rs->RecordCount()>0){ //ada di session log yg ip addressnya sama & userid-nya sama :D
				$row 		= $rs->FetchRow();
				$selisih	= explode(":",$row[0]);
	
				if (intval($selisih[0])>0){ // harus logout
					$logout = "1#".$row[1];	
					
				}else{
					if (intval($selisih[1]) >= $batasSession){ // harus logout
						$logout = "1#".$row[1];
						
					}else $logout = "1#";
				}
			}else{ //yg ip addressnya sama ga ada
				$query_2 	= "SELECT TIMEDIFF(NOW(), MAX(session_dtm)), ip_address 
								FROM session_log WHERE user_id = ? AND session_stat = 1 
								GROUP BY user_id";
				$arrBinding_2[0]  = $userid;
		
				$rs_2 		= $this->registry->db->Execute($query_2, $arrBinding_2);
				if($rs_2){
					if ($rs_2->RecordCount()>0){					
						$row_2 		= $rs_2->FetchRow();
						$selisih	= explode(":",$row_2[0]);
						
						if (intval($selisih[0])>0){ // harus logout
							$logout = "0#".$row_2[1];	
							
						}else{
							if (intval($selisih[1]) >= $batasSession){ // harus logout
								$logout = "0#".$row_2[1];
								
							}else $logout = "0#";	
						}
					}//else throw new Exception("User sedang dipakai");
				}else throw new Exception("Gagal memeriksa cek 'Automatically Logout' ip");
			}
		}else throw new Exception("Gagal memeriksa cek 'Automatically Logout' user");
		
		return $logout;
	}
	
	function insert_sessionLog($sess_id, $user_id, $sess_stat){
		$link = isset($_SERVER["HTTP_REFERER"])?$_SERVER["HTTP_REFERER"]:"index.php";
		 

		$query = "INSERT INTO session_log(session_id, user_id, ip_address, session_stat, link, session_dtm)
					VALUES ('".$sess_id."','".$user_id."', '".$_SERVER['REMOTE_ADDR']."', '".$sess_stat."', '".$link."', now())";
		//echo $query;
		$rs = $this->registry->db->Execute($query);
        if(!$rs) throw new Exception("Gagal memasukkan data session log");
		return $rs;
	}
		
	function select_sessionLog($userid, $status, $ipaddress = NULL){
		$query = "SELECT * FROM session_log WHERE user_id = ? AND session_stat = ? ";
		$arrBinding[0] = $userid;
		$arrBinding[1] = $status;
		
		if ($ipaddress != NULL){
			$query .= " AND ip_address = ? ";
			$arrBinding[2] = $ipaddress;
		}
		
		$query .= " ORDER BY session_dtm ASC";	
	
		$rs = $this->registry->db->Execute($query, $arrBinding);
		if($rs){
          if($rs->RecordCount() > 0){
            while($row = $rs->FetchNextObject()){
              $data[] = $row;
            }
          }else throw new Exception("data session log kosong");
        }else throw new Exception("Gagal memeriksa session log");
		
        return $data;		
	}
	
	function delete_sessionLog($userid, $status, $ipaddress = NULL){
		$query = "DELETE FROM session_log WHERE user_id = ? AND session_stat = ? ";
		
		$arrBinding[0] = $userid;
		$arrBinding[1] = $status;
		
		if ($ipaddress != NULL){
			$query .= " AND ip_address = ? ";
			$arrBinding[2] = $ipaddress;		
		}	
		
		$rs = $this->registry->db->Execute($query, $arrBinding);
		if(!$rs) throw new Exception("Gagal menghapus session log");
		return $rs;
	}
	
	protected function gen_session($row_data){		
		if (!isset($_SESSION['initiated'])){
			session_regenerate_id();
			$_SESSION['initiated'] = TRUE;
		}
		
		$_SESSION['userid']	    		= $row_data->USER_ID;
		$_SESSION['username']	    	= $row_data->NAME;
		$_SESSION['level_id'] 	        = $row_data->LEVEL_ID;
		$_SESSION['position_id'] 	    = $row_data->POSITION_ID;
		$_SESSION['ipAddress']			= $_SERVER['REMOTE_ADDR'];
		$_SESSION['logged_time']		= time();
		
		$this->updateStatusLogin(1,$_SESSION['userid']);
		$this->loggedOn = true;
		$log_href_next="index.php";
		session_regenerate_id();
	}
	
	public function updateStatusLogin($statusLogin, $user_id){
		$query 	= "UPDATE user SET status_login = ".$statusLogin." ";
		
		if ($statusLogin == 0) $query .= ", last_login = now() ";

		$query .= "WHERE user_id = ? ";
		$arrBinding[0] = $user_id;		

		$rs = $this->registry->db->Execute($query, $arrBinding);	
		if(!$rs) throw new Exception("Gagal mengupdate status login");	
	}
	
	public function doLogout(){

		if(isset($_SESSION['userid'])){
			$this->updateStatusLogin(0,$_SESSION['userid']);	
			$this->delete_sessionLog($_SESSION['userid'], 1, $_SERVER['REMOTE_ADDR']);
			
			unset($_SESSION['userid']);
			unset($_SESSION['level_id']);
			unset($_SESSION['ipAddress']);
			unset($_SESSION['logged_time']);			
			
			$this->loggedOn = false;
			
			session_destroy();
			session_regenerate_id();
		
		}else{
			$this->loggedOn = false;
			session_regenerate_id();
			session_destroy();
		
		}
		
		echo '<script>location.href = "index.php?mod=index/login";</script>';
	}

	#20111118:for new selection
	public function selectDB_project($projectid = NULL){
		$data = array();
		$query = "SELECT distinct (lower(substr(task,locate('[',task)+1,(locate(']',task)-2)))) as tsk
					FROM (user_task a join task b on a.task_id=b.task_id) join task_status ts on b.task_id = ts.task_id ";
		
		if($_SESSION['level_id']==3){
			$query .= "WHERE a.user_id='".$_SESSION['userid']."' AND ts.is_show = 1 ORDER BY b.priority_id ASC, ts.status DESC, b.task ASC";
		}elseif($_SESSION['level_id']!=3){
			$query .= "WHERE ts.is_show = 1 ORDER BY b.priority_id ASC, ts.status DESC, b.task ASC";
		}
		
		$rs = $this->registry->db->Execute($query);
		
		if($rs){
          if($rs->RecordCount() > 0){
            while($row = $rs->FetchNextObject()){
              $data[] = $row;

            }
          }
        }else throw new Exception('Gagal mengambil data project');
		
		
		return $data;
	}
    public function selectDB_user($userid = NULL){
		$data = array();
		$query = "SELECT * FROM `user` WHERE HRDstatus = '1' AND level_id = '3'";

		if($userid != NULL) $query .= " AND user_id='".$userid."'";
		
		$query .=" ORDER BY `name`";
		
		$rs = $this->registry->db->Execute($query);
		if($rs){
          if($rs->RecordCount() > 0){
            while($row = $rs->FetchNextObject()){
              $data[] = $row;

            }
          }
        }else throw new Exception("Gagal mengambil data user -> selectDB_user. $query");
		
		//echo $query;
		return $data;
	}

	function select_empl(){
    	$query = "SELECT u.user_id, u.name as uname, u.email, u.hire_date,
                    u.alamat, u.phone, u.level_id, l.name, u.photo
    				FROM `user` u JOIN u_level l ON u.level_id = l.level_id
                    ORDER BY u.name DESC";
		//echo $query;
    	$rs = $this->registry->db->Execute($query);
        if($rs){
          if($rs->RecordCount() > 0){
            while($row = $rs->FetchNextObject()){
              $data[] = $row;

            }
          }else throw new Exception('Data pegawai kosong');
        }else throw new Exception('Gagal mengambil data pegawai');

    	return $data;
	}

	function getIPGuest(){
		return $_SERVER['REMOTE_ADDR'];
	}
	
	function selectDB_userLevel($userid = NULL, $getColumn = NULL, $isAktif = 'yes'){
		
		if($getColumn == NULL) 	$query = "SELECT u.user_id,u.name,u.email, l.name AS lev_name, u.status_login, u.level_id, u.HRDStatus ";
		else					$query = "SELECT  ".$getColumn." AS namakolom ";
				
		$query .= "FROM user u,u_level l WHERE  u.level_id=l.level_id ";
		
		if($userid != NULL)
			$query .= " AND user_id='".$userid."'";
		if($isAktif == 'yes')
			$query .= " AND HRDStatus= 1";
		
		$query .= " ORDER BY HRDStatus DESC";
		$rs = $this->registry->db->Execute($query);
		//echo $query;
		
		if($getColumn != NULL){
			while($data = $rs->FetchNextObject()){
				$kolom = $data->NAMAKOLOM;
			}		
			
			return $kolom;
		}else{		
			$data = array();
			if($rs){
			  if($rs->RecordCount() > 0){
				while($row = $rs->FetchNextObject()){
				  $data[] = $row; 
				}
			  } 
			}else throw new Exception('Gagal mengambil data pegawai');

			return $data;
		}
	}
	
	public function select_user($userid){
		$query = "SELECT * FROM `user` WHERE user_id ='$userid'";
		$rs = $this->registry->db->Execute($query);
		if($rs){
          if($rs->RecordCount() > 0){
            while($row = $rs->FetchNextObject()){
              $data[] = $row;
            }
          }else throw new Exception('Data user kosong');
        }else throw new Exception('Gagal mengambil data user -> select_user');

		return $data;
	}
	
	
	//last edited by de_haynain
	
	function replaceSymbol($myString, $findMe, $changeWith){
		$pos = strpos($myString, $findMe); 
		if ($pos === false) { 
		   $newMyString=$myString;
		} else { 
			$newMyString=str_replace($findMe,$changeWith,$myString);
		} 
		
		return $newMyString;
	}
	
	function selectDB_level(){
		$data = array();
		
		$query = "SELECT * FROM u_level";
		$rs = $this->registry->db->Execute($query);
		if($rs){
			if($rs->RecordCount() > 0){
				while($row=$rs->FetchNextObject()){
					$data[] = $row;
				}
			}
		}else throw new Exception('Gagal mengambil data user -> selectDB_level');
		
		
		return $data;
	}

	function selectDB_userID($userid = NULL){
		//echo $userid;
		$data = array();
		$query = "SELECT  * FROM user ";
		
		if($userid != NULL)		$query .= "WHERE user_id='".$userid."'";
		
		$rs = $this->registry->db->Execute($query);
		if($rs){
			if($rs->RecordCount() > 0){
				while($row=$rs->FetchNextObject()){
					$data[] = $row;
				}
			}
		}else throw new Exception('Gagal mengambil data user -> selectDB_userID');
		return $data;
	}		
	
	function edit_userDetail($user_id1, $user_id2,$name, $email, $hire, $address,$phone, $level, $HRDstat, $ket){
		 $data = array();
		 if($ket == 'edit'){
			 $query = "UPDATE user SET user_id = '".$user_id2."', name = '".$name."', 
						hire_date = '".$hire."', alamat = '".$address."', email = '".$email."', phone = '".$phone."', level_id = ".$level.", HRDstatus = ".$HRDstat."
						WHERE user_id = '".$user_id1."'";
			
		}else{ 
			$password = md5('neuron#123');
			 $query = "INSERT INTO user (`user_id`,`password`,`name`, `hire_date`,`alamat`, `email`,`phone`, level_id, hrdstatus) VALUES
			 		('".$user_id2."','".$password."','".$name."','".$hire."','".$address."','".$email."','".$phone."','".$level."', 1)";
		} 
		
		$rs = $this->registry->db->Execute($query); 
		if(!$rs)throw new Exception('Gagal menyimpan data user');
		return $data;
		
	}
	
	function delete_userDetail($userid){
		$data = array();
		$query = "DELETE FROM user WHERE user_id = '".$userid."'";
		
		$rs = $this->registry->db->Execute($query);
		if(!$rs){
		 throw new Exception('GAgal mengambil data');
		}
		return $data;
	}
	
	function updateUser_unlock($userid, $passwd){
		$data = array();
		$query = "UPDATE user SET status_login = 0, password = '".$passwd."' WHERE user_id = '".$userid."'";
		
		$rs = $this->registry->db->Execute($query);
		if(!$rs)throw new Exception('Gagal meng-unlock user');
	}
	
	function updateUser_lock($userid){
		$query = "UPDATE user SET status_login = 2 WHERE user_id = '".$userid."'";
		
		$rs = $this->registry->db->Execute($query);
		if(!$rs) throw new Exception('Gagal me-lock user');
		 
	}
	
	public function updateDB_userProfile($nama, $alamat, $email, $password, $photo, $phone, $userid){
		$query 	= "UPDATE user SET name = '".$nama."', alamat  = '".$alamat."', email = '".$email."', 
					photo = '".$photo."',  phone = '".$phone."'";
		if($password != NULL) $query .= ", password = '".md5($password)."'";
		$query .= " where user_id='".$userid."' ";
		$rs = $this->registry->db->Execute($query);	
		if(!$rs) throw new Exception("Gagal mengupdate Profile");
	}
	#2011-11-01:query select all from form cv
	public function selectDB_Cv($userid=NULL, $schid){
		$query="SELECT a.name as nama,a.email,b.address as address,b.cv_id, b.phone_1, b.phone_2, b.city, b.zipcode,
				c.school_id as schoolid,c.school_name as sname, c.school_year AS syear, c.education, c.description, c.city as educity				
				FROM user a JOIN curriculum_vitae b ON b.user_id = a.user_id JOIN school c ON c.user_id = a.user_id				
				WHERE a.user_id ='".$userid."' AND c.school_id ='1' ";//nantinya pake session id				
		//echo $query;
		$rs = $this->registry->db->Execute($query);	
		if(!$rs) throw new Exception("Gagal mengambil data Cv");
	}
	
	public function insertDB_Cv($userid){
		$query 	= "INSERT INTO curriculum_vitae(user_id) VALUES('".$userid."') ";		
		//echo $query;
		$rs = $this->registry->db->Execute($query);	
		if(!$rs) throw new Exception("Gagal menyimpan Cv");
	}
	public function updateDB_userCv($userid, $nama, $alamat, $email, $phone, $kota, $zipcode){
		$query 	= "UPDATE user SET name = '".$nama."', alamat  = '".$alamat."', email = '".$email."', phone = '".$phone."', city = '".$kota."', zipcode = '".$zipcode."' ";	
		$query .= " where user_id='".$userid."' ";
		//echo $query."<br>";
		$rs = $this->registry->db->Execute($query);	
		if(!$rs) throw new Exception("Gagal mengupdate user Cv");
	}
	public function updateDB_educationCv($userid, $sname, $city, $syear, $education, $desc, $schid){
		//echo $countschid;
		
			$query 	= "UPDATE school SET school_name = '".$sname."', city  = '".$city."', school_year = '".$syear."',  education = '".$education."', description = '".$desc."' ";
			$query .= " where user_id='".$userid."' and school_id = '". $schid."' ";
			//echo $query."<br>";
			//echo $countschid;
			$rs = $this->registry->db->Execute($query);				
			if(!$rs) throw new Exception("Gagal mengupdate education Cv");		
	}
	public function updateDB_companyCv($userid, $cname, $city, $cyear, $working_position, $project, $compid){
		$query 	= "UPDATE company SET company_name = '".$cname."', city  = '".$city."', company_year = '".$cyear."',  working_position = '".$working_position."', project = '".$project."' ";
		$query .= " where user_id='".$userid."' AND company_id = '".$compid."' ";
		//echo $query."<br>";
		$rs = $this->registry->db->Execute($query);	
		if(!$rs) throw new Exception("Gagal mengupdate company Cv");
	}
	public function updateDB_additionalCv($userid = NULL, $otherjob = NULL, $otherjobid){
		$query 	= "UPDATE additional_profesional_activities SET other_job = '".$otherjob."' ";
		$query .= " where user_id='".$userid."' and add_activities_id = '".$otherjobid."' ";
		//echo $query."<br>";
		$rs = $this->registry->db->Execute($query);	
		if(!$rs) throw new Exception("Gagal mengupdate  additional Cv");
	}
	public function updateDB_skillCv($userid = NULL, $skill = NULL, $skillid){
		$query 	= "UPDATE skill SET skill_desc = '".$skill."' where user_id='".$userid."' and skill_id = '".$skillid."' ";
		//echo $query;
		$rs = $this->registry->db->Execute($query);	
		if(!$rs) throw new Exception("Gagal mengupdate skill Cv");
	}
	public function get_fullname($userid){
		$query = "SELECT  name FROM user WHERE user_id='".$userid."'";
		$data = '';
		$rs = $this->registry->db->Execute($query);
		if($rs){
			if($rs->RecordCount() > 0){
				while($row=$rs->FetchNextObject()){
					$data = $row->NAME;
				}
			}
		}else throw new Exception('Gagal mengambil nama lengkap user');
		return $data;
	}
	
	public function get_userPhoto($userid){
		$query = "SELECT  photo FROM user WHERE user_id='".$userid."'";
		
		$rs = $this->registry->db->Execute($query);
		if($rs){
			if($rs->RecordCount() > 0){
				while($row=$rs->FetchNextObject()){
					$data = $row->PHOTO;
				}
			}
		}else throw new Exception('Gagal mengambil photo user');
		return $data;
	}
	
	public function display_marques(){
			$query = "SELECT d.dashboard_id, d.description FROM dashboard d WHERE d.dashboard_id ='1'";	
			
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
			
	public function get_sessionlogLastAccess($userid){
		$data = NULL;
		$query = "SELECT MAX(session_dtm) as session_dtm FROM `session_log` WHERE user_id = '".$userid."' LIMIT 0,1";	
		$rs = $this->registry->db->Execute($query);
		if($rs){
			if($rs->RecordCount() > 0){
				while($row=$rs->FetchNextObject()){
					$data = $row->SESSION_DTM;
				}
			}
		}else throw new Exception('Gagal mengambil get_sessionlogLastAccess');
		return $data;
	}
}

?>
