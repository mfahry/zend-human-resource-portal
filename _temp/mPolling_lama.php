<?php
class MPolling{
	private $registry;

  	function __construct( $registry ) {
		$this->registry = $registry;
    }

	function selectDB_polling($table, $field1=NULL, $field2 = NULL, $value1=NULL, $value2 = NULL){
		$value1 = mysql_escape_string($value1);
		$value2 = mysql_escape_string($value2);

		$query = "SELECT * FROM ".$table." ";
		if($field1 != NULL){
			if($value1 == 'IS NOT NULL')	$query .= " WHERE ".$field1." ".$value1."";
			else							$query .= " WHERE ".$field1." = '".$value1."'";
		}
		if($field2 != NULL){
			if($value2 == 'IS NULL')	$query .= " AND ".$field2." ".$value2;
			else $query .= " AND ".$field2." = '".$value2."'";
		}
		$rs = $this->registry->db->Execute($query);
		//echo $query;
		if($rs){
          if($rs->RecordCount() > 0){
            while($row = $rs->FetchNextObject()){
              $data[] = $row;

            }
          }else{
            $data = 'Data  kosong';
          }
        }else{
          $data = 'Gagal mengambil data';
        }
		return $data;
	}

	function selectMax_polling(){
		$query = "SELECT MAX(polling_id)AS pollid FROM polling";
		$rs = $this->registry->db->Execute($query);
		while($data = $rs->FetchNextObject()){
			return $data->POLLID;
		}
	}

	function getPollingId(){
		$query = "select polling_id from polling where end_dtm <> NULL";
		$rs = $this->registry->db->Execute($query);
		while($data = $rs->FetchNextObject()){
			return $data->POLLING_ID;
		}
	}

	function updateDB_publishPolling($polid, $field){
		$query = "UPDATE polling SET ".$field." = now() WHERE polling_id=".$polid;
		$rs = $this->registry->db->Execute($query);
	}

	function insertDB_pollingQuestion($tquest){
		$query = "INSERT INTO polling(polling, inserted_by, start_dtm)
					VALUES('".$tquest."', '".$_SESSION['user_id']."', now())";
		$rs = $this->registry->db->Execute($query);

		if($rs) return true;
		else	return false;
	}

}
?>