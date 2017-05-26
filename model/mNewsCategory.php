<?php
class MNewsCategory{
	private $registry;

  	function __construct( $registry ) {
		$this->registry = $registry;
    }

	function selectDB_newsCategory($tipeCategory = NULL){
		$query = "SELECT * FROM news_category ";
				if(($tipeCategory != NULL) || ($tipeCategory=='0')){
					$query .= "WHERE publishType=".$tipeCategory;
				}
		//echo "<br>*selectDB_newsCategory:".$query."<br>";
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
	
	function selectNewsCategory($tipeCategory = NULL){
		$data = array();
		$query = "SELECT * FROM news_category ";
		if(($tipeCategory != NULL) || ($tipeCategory=='0')){
			$query .= "WHERE publishType=".$tipeCategory;
		}
		
		//echo "<br>".$query."<br>";
		$rs = $this->registry->db->Execute($query);
		if($rs){
          if($rs->RecordCount() > 0){
            while($row = $rs->FetchNextObject()){
              $data[] = $row;

            }
          }
        }else throw new Exception("Gagal mengambil data");
        
        
		return $data;
	}
	
	function selectNNews($catId){
		//$data = array();
		$query = "SELECT * FROM `news` WHERE nc_id='".$catId."'";
		
		$rs = $this->registry->db->Execute($query);
		$cnt = $rs->RecordCount();
		
		//echo $query;
		return $cnt;
	}
	
	function selectNamePublish($catID){
		$data = array();
		$query = "SELECT cat_name,publishType FROM `news_category` WHERE nc_id='".$catID."'";
	
		$rs = $this->registry->db->Execute($query);
		if($rs){
			if($rs->RecordCount() > 0){
				while($row = $rs->FetchNextObject()){
					$data[] = $row;
				}
			}
		}else throw new Exception("Gagal mengambil data");
		
		return $data;
	}
	
	function insertDBNewsCategory($catName,$pubType){
 			$query = "INSERT INTO `news_category`(`cat_name` ,`publishType`) VALUES ('".$catName."', '".$pubType."')";
 		echo $query;
		$rs = $this->registry->db->Execute($query);
        if(!$rs) throw new Exception('Gagal Insert data kategori');
 	}
	
	public function updateDB_category($catID,$catName,$pubType){
 			$query = "update `news_category` SET cat_name = '".$catName."',publishType='".$pubType."' WHERE nc_id='".$catID."'";
 		
		//echo $query;
		$rs = $this->registry->db->Execute($query);
        if($rs) throw new Exception('Gagal Update data kategori');
 	}
	
	function deleteNewsCategory($catID){
		$data = array();
		$query = "DELETE from news_category where nc_id='".$catID."'";
		$rs = $this->registry->db->Execute($query);
		if(!$rs) throw new Exception ('gagal menghapus data');
		
	}
		
}
?>