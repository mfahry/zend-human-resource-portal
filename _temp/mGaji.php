<?php
class MGaji{
	private $registry;

  	function __construct( $registry ) {
		$this->registry = $registry;
    }

	function insert_gaji($user, $gpokok, $kshtn, $trans, $jbtn, $komunikasi){
		$query = "INSERT INTO gaji (`user_id` , `g_pokok` , `g_tunjKesehatan` , `g_transportasi`,  `g_tunjJabatan`, `g_tunjKomunikasi`, `start_dtm`)
					VALUES ( '".$user."', ".$gpokok.", ".$kshtn.", ".$trans.", ".$jbtn.", ".$komunikasi.", now() )";
		$rs = $this->registry->db->Execute($query);
		//echo "<br>".$query;
		return $rs;
	}

	function selectALL_gaji($gid = NULL){
		$query = "SELECT * FROM gaji a JOIN user b ON a.user_id=b.user_id WHERE a.end_dtm IS NULL";
		if($gid != NULL){
			$query = $query." WHERE gaji_id=".$gid;
		}
		$query = $query." ORDER BY b.name ASC";
		$rs = $this->registry->db->Execute($query);
		if($rs){
          if($rs->RecordCount() > 0){
            while($row = $rs->FetchNextObject()){
              $data[] = $row;

            }
          }else{
            $data = 'Data news_category kosong';
          }
        }else{
          $data = 'Gagal mengambil data news_category';
        }
		return $data;
	}

	function updateDtm($gid){
		$query = "UPDATE gaji SET `end_dtm`=now() WHERE `gaji_id` =".$gid;
		$rs = $this->registry->db->Execute($query);
		return $rs;
	}

}
?>