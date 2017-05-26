<?php
class MAbsenType{
	private $registry;

  	function __construct( $registry ) {
		$this->registry = $registry;
	}

    function selectDB_typeAbsen($typeid = NULL){
		$data = array();
		$typename = NULL;
		
		$query = "SELECT * FROM absen_type";		
		if($typeid != NULL){
			$query .= " WHERE type_id = ".$typeid;

			$rs = $this->registry->db->Execute($query);
			while($data = $rs->FetchNextObject()){
				$typename = $data->TYPE_NAME;
			}
			return $typename;
		}else{
			$query .= " WHERE publish_type = 1";
			$rs = $this->registry->db->Execute($query);
			if($rs){
			  if($rs->RecordCount() > 0){
				while($row = $rs->FetchNextObject()){
				  $data[] = $row;

				}
			  }
			}else{
			  throw new Exception('tidak dapat mengambil data');
			}
			return $data;
		}
	}
	
}
?>