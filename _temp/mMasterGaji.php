<?php
class MMasterGaji{
	private $registry;

  	function __construct( $registry ) {
		$this->registry = $registry;
    }
 	function insert_mGaji($desc, $value){
		$query = "INSERT INTO m_gaji (`mg_desc` , `mg_value`, `start_dtm`)
					VALUES ( '".$desc."', ".$value.", now() )";
		$rs = $this->registry->db->Execute($query);
		//echo "<br>".$query;
		return $rs;
	}

	function selectALL_mGaji($mgid = NULL){
		$query = "SELECT * FROM m_gaji WHERE end_dtm IS NULL" ;
		if($mgid != NULL){
			$query = $query." WHERE mgaji_id = ".$mgid;
		}
		$query = $query." ORDER BY mg_desc ASC";
		$rs = $this->registry->db->Execute($query);
		if($rs){
          if($rs->RecordCount() > 0){
            while($row = $rs->FetchNextObject()){
              $data[] = $row;

            }
          }else{
            $data = 'Data m_gaji kosong';
          }
        }else{
          $data = 'Gagal mengambil data m_gaji';
        }
		return $data;
	}

	function updateDtm_mGaji($id){
		$query = "UPDATE m_gaji SET `end_dtm`=now() WHERE `mgaji_id` =".$id;
		$rs = $this->registry->db->Execute($query);
		return $rs;
	}


}
?>