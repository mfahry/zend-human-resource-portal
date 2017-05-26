<?php
class MGajiDibayarkan{
	private $registry;

  	function __construct( $registry ) {
		$this->registry = $registry;
    }

	function insert_gajiDbyrkn($user_id , $periode, $gajibulanan, $SPJLokal1, $SPJLokal2, $lemburDayOff, $lemburMlm, $THR, $potonganPajak, $potonganKonsumsi, $total){
		$query = "INSERT INTO gaji_dibayarkan (`user_id` , `periode`, `gajibulanan`, `SPJLokal1`, `SPJLokal2`, `lemburDayOff`, `lemburMlm`, `THR`, `potonganPajak`, `potonganKonsumsi`, `total`)
					VALUES ( '".$user_id."' , '".$periode."', ".$gajibulanan.", ".$SPJLokal1.", ".$SPJLokal2.", ".$lemburDayOff.", ".$lemburMlm.", ".$THR.", ".$potonganPajak.", ".$potonganKonsumsi.", ".$total.")";
		$rs = $this->registry->db->Execute($query);
		//echo "<br>".$query;
		return $rs;
	}

	function select_GJdbyrkn($userid = NULL, $periode = NULL, $gdid = NULL){
		$query = "SELECT * FROM gaji_dibayarkan a JOIN user b ON a.user_id=b.user_id WHERE";
		if( ($gdid != NULL)&&($userid == NULL)&&($periode == NULL) ){
			$query = $query." a.gd_id=".$gdid;
		}elseif($userid != NULL){
			$query = $query." a.user_id='".$userid."'";
		}elseif($periode != NULL){
			$query = $query." a.periode = '".$periode."'";
		}
		//echo $query;
		$rs = $this->registry->db->Execute($query);
		if($rs){
          if($rs->RecordCount() > 0){
            while($row = $rs->FetchNextObject()){
              $data[] = $row;

            }
          }else{
            $data = 'Data gaji_dibayarkan kosong';
          }
        }else{
          $data = 'Gagal mengambil data gaji_dibayarkan';
        }
		return $data;
	}

	function update_GJdbyrkn($id, $SPJLokal1, $SPJLokal2, $lemburDayOff, $lemburMlm, $THR, $potonganPajak, $potonganKonsumsi, $tTotal){
		$query = "UPDATE gaji_dibayarkan SET SPJLokal1=".$SPJLokal1.", SPJLokal2=".$SPJLokal2.", lemburDayOff=".$lemburDayOff.", lemburMlm=".$lemburMlm.", THR=".$THR.", potonganPajak=".$potonganPajak.", potonganKonsumsi=".$potonganKonsumsi.", total=".$tTotal.", status = 1 WHERE gd_id =".$id;

		//echo $query;
		$rs = $this->registry->db->Execute($query);
		return $rs;
	}

}
?>