<?php
class MPollingChoice{
	private $registry;

  	function __construct( $registry ) {
		$this->registry = $registry;
    }

	function insertDB_pollingChoice($pollid, $i,$choice){
		$query = "INSERT INTO pollingchoice(polling_id, sequence_choice, choice, choosed)
					VALUES(".$pollid.", $i, '".$choice."',0)";
		$rs = $this->registry->db->Execute($query);
	}

	function updateDB_pollingChoosed($polid, $polcid){
		$query1 = "SELECT choosed FROM polling_choice WHERE polling_id = ".$polid." AND pollc_id=".$polcid;
		$rs1 = $this->registry->db->Execute($query1);
		while($data1 = $rs1->FetchNextObject()){
			$choosed = $data1->CHOOSED;
		}
		if(($choosed == NULL)||($choosed == 0)) $choosed = 1;
		elseif($choosed > 0) $choosed = $choosed+1;

		$query2 = "UPDATE polling_choice SET choosed = ".$choosed."
					WHERE polling_id = ".$polid." AND pollc_id=".$polcid;
		$rs2 = $this->registry->db->Execute($query2);
		if($rs2){
          if($rs2->RecordCount() > 0){
            while($row = $rs2->FetchNextObject()){
              $data[] = $row;

            }
          }else{
            $data = 'Data polling_choice kosong';
          }
        }else{
          $data = 'Gagal mengambil data polling_choice';
        }
		
		return $data;
	}
}
?>