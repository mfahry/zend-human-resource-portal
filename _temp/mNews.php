<?php
class MNews{
	private $registry;

  	function __construct( $registry ) {
		$this->registry = $registry;
	}
    
 	function insertNews($nc_id, $title, $content, $userid){
		$query = "INSERT INTO news (`news_id` , `nc_id` , `news_title` , `news_content` , `datetime`, `inserted_by` )
					VALUES ( NULL , ?, ?, ?, curdate(), ? )";

		$stmt 			= $this->registry->db->Prepare($query);
		$arrBinding[0] 	= mysql_real_escape_string($nc_id);
		$arrBinding[1] 	= mysql_real_escape_string($title);
		$arrBinding[2] 	= mysql_real_escape_string($content);
		$arrBinding[3] 	= mysql_real_escape_string($userid);
		$rs = $this->registry->db->Execute($stmt,$arrBinding);
		//echo "<br>*insertNews:".$query."<br>";
	}

	function countCategories($category){
		$query = "SELECT COUNT(*) as jumlah FROM news WHERE `nc_id` = ".$category;
			$rs = $this->registry->db->Execute($query);
			while($data = $rs->FetchNextObject()){
				$jumlah = $data->JUMLAH;
			}
			return $jumlah;
	}

	function disp_news($category){
		$query = "SELECT * FROM news a JOIN newscategory b
					ON a.nc_id= b.nc_id
					WHERE a.news_id=(SELECT max( news_id ) AS news_id FROM news WHERE nc_id =".$category.")";
		//echo "<br>*disp_news:".$query."<br>";
		$rs = $this->registry->db->Execute($query);
		if($rs){
          if($rs->RecordCount() > 0){
            while($row = $rs->FetchNextObject()){
              $data[] = $row;

            }
          }else{
            $data = 'Data news kosong';
          }
        }else{
          $data = 'Gagal mengambil data news';
        }
		return $data;
	}

	function disp_LatestNews($publish = NULL){
		$data = array();
		$query = "SELECT * FROM news a JOIN news_category b
					ON a.nc_id= b.nc_id";

		if($publish == NULL){
			$query .= " WHERE b.publishType = 1";
		}

		$query .= " ORDER BY a.news_id DESC LIMIT 5";
		
		$rs = $this->registry->db->Execute($query);
		if($rs){
          if($rs->RecordCount() > 0){
            while($row = $rs->FetchNextObject()){
              $data[] = $row;
            }
          }
        }else throw new Exception('Gagal mengambil data news @disp_LatestNews');
        
		return $data;
	}

	function disp_OneNews($newsID){
		$query = "SELECT * FROM news a JOIN newscategory b
					ON a.nc_id= b.nc_id
					WHERE news_id=".$newsID;
		//echo "<br>*disp_LatestNews:".$query."<br>";
		$rs = $this->registry->db->Execute($query);
		if($rs){
          if($rs->RecordCount() > 0){
            while($row = $rs->FetchNextObject()){
              $data[] = $row;

            }
          }else{
            $data = 'Data news kosong';
          }
        }else{
          $data = 'Gagal mengambil data news';
        }
		return $data;
	}

	function disp_newsCat($category){
		$query = "SELECT * FROM news a JOIN newscategory b ON a.nc_id= b.nc_id WHERE a.nc_id = ".$category." ORDER BY news_id DESC";
		$rs = $this->registry->db->Execute($query);
		if($rs){
          if($rs->RecordCount() > 0){
            while($row = $rs->FetchNextObject()){
              $data[] = $row;

            }
          }else{
            $data = 'Data news kosong';
          }
        }else{
          $data = 'Gagal mengambil data news';
        }
		return $data;
	}

	function truncate($string, $length = '', $replacement = '<br><a href="index.php?abs=40" class="ReadMoreNews">Read more...</a>', $start = 60) {
		if (strlen($string) <= $start) return $string;
		if ($length) {
			return substr_replace($string, $replacement, $start, $length);
		} else {
			return substr_replace($string, $replacement, $start);
		}
	}

}
?>