<?php
class MDay{
	private $registry;

  	function __construct( $registry ) {
		$this->registry = $registry;
	}

	function selectdb_day(){
		$query = "SELECT * FROM day";
		$rs = $this->registry->db->Execute($query);
        //echo $query;
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

}
?>
