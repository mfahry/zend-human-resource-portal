<?php
	
class MCategoryList{
	private $registry;

  	function __construct( $registry ) {
		$this->registry = $registry;
	}
	/*
	public function selectCategoryList(){
		$data = array();
		$queryselect = "SELECT *
				FROM news_category order by nc_id";
		$rsselect = $this->registry->db->Execute($queryselect);
		if($rsselect){
		  if($rsselect->RecordCount() > 0){
			while($row = $rsselect->FetchNextObject()){
			  $data[] = $row;
			}
		  }
		}else throw new Exception("Gagal mengambil data knowledge");
		return $data;
	}
	*/
	
	public function selectCategoryList($nama = NULL, $cat_id = NULL){
		$data = array();
		$queryselect = "SELECT * FROM news_category";
		if(!empty($nama)){
			$queryselect = $queryselect." where cat_name='$nama' ";
		}
		if(!empty($cat_id)){
			$queryselect = $queryselect." where nc_id='$cat_id' ";
		}
		$rsselect = $this->registry->db->Execute($queryselect);
		if($rsselect){
		  if($rsselect->RecordCount() > 0){
			while($row = $rsselect->FetchNextObject()){
			  $data[] = $row;
			}
		  }
		}else throw new Exception("Gagal mengambil data knowledge");
		return $data;
	}
	
	public function addCategory($category){
		$dat = $this->selectCategoryList($category,NULL);
		if($dat=="tidak_ada"){
			$query = "INSERT INTO news_category(cat_name,publishType) VALUES ('$category',1)";
			$rs = $this->registry->db->Execute($query);
			if(!$rs){
				throw new Exception('Gagal menyimpan kategori Artikel');
			}
		}
	}
	
}
?>