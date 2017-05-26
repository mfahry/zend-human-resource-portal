<?php
class MQuote{
	private $registry;

  	function __construct( $registry ) {
		$this->registry = $registry;
    }

	function display_quote($type,$par = NULL){
		$query = "SELECT * FROM quote WHERE quote_type=".$type;

		if(!empty($par)){
			$query = $query." AND status=1 LIMIT 1";
		}else{
			$query = $query." ORDER BY quote_id DESC";
		}
		//echo "<br>##".$query;
		$rs = $this->registry->db->Execute($query);
		if($rs){
          if($rs->RecordCount() > 0){
            while($row = $rs->FetchNextObject()){
              $data[] = $row;

            }
          }else{
            $data = 'Data quote kosong';
          }
        }else{
          $data = 'Gagal mengambil data quote';
        }
		return $data;
	}

	function insert_quote($tipe, $quote, $from, $user){
		$query = "INSERT INTO quote (`quote_type` , `quote` , `quote_from` , `inserted_by`,  `insert_dtm`)
					VALUES ( ".$tipe.", '".$quote."', '".$from."', '".$user."', curdate() )";
		$rs = $this->registry->db->Execute($query);
	}

	function status_notPublishALL($tipe){
		$query = "UPDATE quote SET `status`=0 WHERE `quote_type` =".$tipe;
		$rs = $this->registry->db->Execute($query);
	}

	function status_publishThis($quote_id){
		$query = "UPDATE quote SET `status`=1 WHERE `quote_id` =".$quote_id;
		$rs = $this->registry->db->Execute($query);
	}

	function dispSingle_quote($qtid){
		$query = "SELECT * FROM quote WHERE quote_id=".$qtid;
		$rs = $this->registry->db->Execute($query);
		if($rs){
          if($rs->RecordCount() > 0){
            while($row = $rs->FetchNextObject()){
              $data[] = $row;

            }
          }else{
            $data = 'Data quote kosong';
          }
        }else{
          $data = 'Gagal mengambil data quote';
        }
		return $data;
	}

	function updateQuote($quote_id, $quote, $from){
		$query = "UPDATE quote SET quote = '".$quote."', quote_from = '".$from."' WHERE `quote_id` =".$quote_id;
		$rs = $this->registry->db->Execute($query);
	}

	function delQuote($quote_id){
		$query = "DELETE FROM quote WHERE `quote_id` =".$quote_id;
		$rs = $this->registry->db->Execute($query);
	}
}
?>