<?php
class MKnowledge{
	private $registry;
	
  	function __construct( $registry ) {
		$this->registry = $registry;
	}
	#20111116: 05:00am
	public function get_newKnowledge($catid  = NULL, $search = NULL){
		$data = array();
		
		$query = "SELECT k.knowledge_id, k.cat_id, k.judul, k.deskripsi, k.file, k.date, 
					u.user_id, u.name AS uname, u.photo, c.cat_name 
					FROM knowledge k JOIN news_category c ON k.cat_id = c.nc_id
					JOIN user u ON k.userid_uploader = u.user_id ";
				
		if($search!=NULL){
			$word=explode(" ",$search);
			
			$query.="WHERE k.judul LIKE '%".$search."%' ";		
			if(count($word)>1){
			$query.=" OR ( k.judul LIKE '% ".$word[0]." %' ";
			
			for($i=1;$i<count($word);$i++){	
				$query.=" AND k.judul LIKE '% ".$word[$i]." %' ";	
			}	
			$query.=" ) ";
			}
			$query.=" UNION
					SELECT k.knowledge_id, k.cat_id, k.judul, k.deskripsi, k.file, k.date, 
					u.user_id, u.name AS uname, u.photo, c.cat_name 
					FROM knowledge k JOIN news_category c ON k.cat_id = c.nc_id
					JOIN user u ON k.userid_uploader = u.user_id 
					WHERE k.deskripsi LIKE '%".$search."%' ";
					
					/*if(count($word)>1){
						$query.=" OR ( k.deskripsi LIKE '%".$word[0]."%' ";
						
						for($i=1;$i<count($word);$i++){							
							$query.=" AND k.deskripsi LIKE '%".$word[$i]."%' ";							
						}
					
					$query.=" ) ";
						
					}
					$query.=" UNION
						SELECT k.knowledge_id, k.cat_id, k.judul, k.deskripsi, k.file, k.date, 
						u.user_id, u.name AS uname, u.photo, c.cat_name 
						FROM knowledge k JOIN news_category c ON k.cat_id = c.nc_id
						JOIN user u ON k.userid_uploader = u.user_id ";
						
						if(count($word)>1){
							$query.=" WHERE  k.judul LIKE '% ".$word[0]." %' ";
							
							for($i=1;$i<count($word);$i++){							
								$query.=" AND k.judul LIKE '% ".$word[$i]." %' ";							
							}	
						}*/
					if(count($word)>1){	
						$query.=" UNION
							SELECT k.knowledge_id, k.cat_id, k.judul, k.deskripsi, k.file, k.date, 
							u.user_id, u.name AS uname, u.photo, c.cat_name 
							FROM knowledge k JOIN news_category c ON k.cat_id = c.nc_id
							JOIN user u ON k.userid_uploader = u.user_id ";
							
							if(count($word)>1){
								$query.=" WHERE  k.deskripsi LIKE '% ".$word[0]." %' ";
								
								for($i=1;$i<count($word);$i++){							
									$query.=" AND k.deskripsi LIKE '% ".$word[$i]." %' ";							
								}	
							}
					}
	
		}
		
		if($catid != NULL)
			$query .= "WHERE k.cat_id = ".$catid;
			
		if(($catid == NULL)&&($search==NULL)){	
		$query .= "	ORDER BY k.date DESC LIMIT 0,5";
		}
		//echo $query;			
		$rs = $this->registry->db->Execute($query);
	
		if($rs){
		  if($rs->RecordCount() > 0){
			while($row = $rs->FetchNextObject()){
			  $data[] = $row;
			}
		  }
		}else throw new Exception("Gagal mengambil knowledge terbaru");
		return $data;
	}
	public function searchknowledge($search = NULL){
		$query = "SELECT * FROM knowledge a ";
			
		$rs = $this->registry->db->Execute($query);
		
		if(!$rs) throw new Exception('Gagal mencari knowledge');
	}
	/*public function get_newKnowledge($catid  = NULL, $search = NULL){
		$data = array();
		$query = "SELECT k.knowledge_id, k.cat_id, k.judul, k.deskripsi, k.file, k.date, 
					u.user_id, u.name AS uname, u.photo, c.cat_name 
					FROM knowledge k JOIN news_category c ON k.cat_id = c.nc_id
					JOIN user u ON k.userid_uploader = u.user_id ";
		if($search!=NULL){
			$query.="WHERE k.deskripsi LIKE '%".$search."%' OR k.judul LIKE '%".$search."%' ";
		}
		if($catid != NULL)
			$query .= "WHERE k.cat_id = ".$catid;
		$query .= "	ORDER BY k.date DESC LIMIT 0,5";
					
		$rs = $this->registry->db->Execute($query);
		
		if($rs){
		  if($rs->RecordCount() > 0){
			while($row = $rs->FetchNextObject()){
			  $data[] = $row;
			}
		  }
		}else throw new Exception("Gagal mengambil knowledge terbaru");
		return $data;
	}*/
	
	public function deleteDB_knowledge($id){
		$query = "DELETE FROM knowledge WHERE knowledge_id=".$id;
		$rs = $this->registry->db->Execute($query);
		if(!$rs) throw new Exception('Gagal mengahapus knowledge');
		echo "<script>alert('Knowledge Telah Dihapus!')</script>";
		echo "<script>location.href=\"index.php?mod=knowledge\"</script>";		
		
	}
	
	public function updateknowledge($id,$judul,$deskripsi,$kategori,$namafile,$file_sementara,$adafile){
		if($kategori==""){
			echo "<script>alert('Kategori tidak Valid')</script>";
			echo "<script>location.href=\"index.php?mod=knowledge/ShowUpdateKnowledge/".$id."\"</script>";		
		}else{
				$this->registry->mCategoryList->addCategory($kategori);
				$dat = $this->registry->mCategoryList->selectCategoryList($kategori,NULL);
				foreach($dat as $kat){
					$kategori_id = $kat->NC_ID;
				}
			if((!empty($namafile)) && (copy($file_sementara, SITE_PATH ."/includes/File/$namafile"))){
					$query = "UPDATE knowledge SET judul='$judul', deskripsi='$deskripsi', cat_id='$kategori_id', file='$namafile' where knowledge_id='$id' ";
					$rs = $this->registry->db->Execute($query);
					if(!$rs){
					throw new Exception('Gagal mengupdate Artikel 0');
					}
					unlink($file_sementara);
					echo "<script>alert('Artikel dan Filenya telah diupdate, terimakasih!!')</script>";
					echo "<script>location.href=\"index.php?mod=knowledge\"</script>";
			}else{
					$query = "UPDATE knowledge SET judul='$judul', deskripsi='$deskripsi', cat_id='$kategori_id' where knowledge_id='$id' ";
					$rs = $this->registry->db->Execute($query);
					if(!$rs){
						throw new Exception('Gagal mengupdate Artikel 1');
					}else{
						echo "<script>alert('Artikel telah diupdate, terimakasih!!')</script>";
						echo "<script>location.href=\"index.php?mod=knowledge\"</script>";
					}
			}
		}
	}

	function UploadArtikel($namauser,$judul,$deskripsi,$kategori,$namafile,$file_sementara,$adafile){
		$time = date("Y-m-d h:i:s");	
		if($kategori==""){
			echo "<script>alert('Kategori tidak Valid')</script>";
			echo "<script>location.href=\"index.php?mod=knowledge/addKnowledge\"</script>";		
		}else{
				$this->registry->mCategoryList->addCategory($kategori);
				$dat = $this->registry->mCategoryList->selectCategoryList($kategori,NULL);
				foreach($dat as $kat){
					$kategori_id = $kat->NC_ID;
				}
			if((!empty($namafile)) && (copy($file_sementara, SITE_PATH ."/includes/File/$namafile"))){
					$query = "INSERT INTO knowledge(userid_uploader,judul,deskripsi,file,date,cat_id) VALUES ('$namauser','$judul','$deskripsi','$namafile','$time','$kategori_id')";
					$rs = $this->registry->db->Execute($query);
					if(!$rs){
					throw new Exception('Gagal menyimpan Artikel 0');
					}
					unlink($file_sementara);
					echo "<script>alert('Artikel dan Filenya telah diupload, terimakasih!!')</script>";
					echo "<script>location.href=\"index.php?mod=knowledge\"</script>";
			}else{
					$query = "INSERT INTO knowledge(userid_uploader,judul,deskripsi,date,cat_id) VALUES ('$namauser','$judul','$deskripsi','$time','$kategori_id')";
					$rs = $this->registry->db->Execute($query);
					if(!$rs){
					throw new Exception('Gagal menyimpan Artikel 1');
					}
					echo "<script>alert('Artikel telah diupload tanpa file, terimakasih!!')</script>";
					echo "<script>location.href=\"index.php?mod=knowledge\"</script>";
			}
		}
	}
	
	public function get_byID($id, $column = 'k.knowledge_id'){
		$data = array();
		$query = "SELECT k.knowledge_id, k.cat_id, k.judul, k.deskripsi, k.file, k.date, 
					u.user_id, u.name AS uname, u.photo, c.cat_name 
					FROM knowledge k JOIN news_category c ON k.cat_id = c.nc_id
					JOIN user u ON k.userid_uploader = u.user_id
		 			WHERE ".$column." = '".$id."'"; 
		$rs = $this->registry->db->Execute($query);
		if($rs){
		  if($rs->RecordCount() > 0){
			while($row = $rs->FetchNextObject()){
			  $data[] = $row;
			}
		  }
		}else throw new Exception("Gagal mengambil data knowledge");
		return $data;
	}

	public function ShowToEdit($id){
		$data = array();
		$queryselect = "SELECT * FROM knowledge where knowledge_id = '$id'";
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
	
	public function pilihCategoryArtikel($kategory){
		$data = array();
		$queryselect = "SELECT * FROM knowledge where kategori = '$kategory' order by knowledge_id";
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
	
	public function jumlahCategory($cat_id){
		$data = array();
		$queryselect = "SELECT * FROM knowledge where cat_id = '$cat_id'";
		$rsselect = $this->registry->db->Execute($queryselect);
		if($rsselect){
		  if($rsselect->RecordCount() > 0){
			while($row = $rsselect->FetchNextObject()){
			  $data[] = $row;
			}
		  }
		}else throw new Exception("Gagal mengambil data knowledge");
		return $rsselect->RecordCount();
	}
	
	function shortAlinea($string, $length = '', $replacement = '><br><a href="index.php?mod=knowledge">Selengkapnya...</a>', $start = 150) { 
		if (strlen($string) <= $start) return $string; 
		if ($length) { 
			return substr_replace($string, $replacement, $start, $length); 
		} else { 
			return substr_replace($string, $replacement, $start); 
		} 
	} 	
	public function selectDB_knowledgeDetail($id){
		$data = array();
		$query = "SELECT k.knowledge_id AS id, k.userid_uploader AS userid, u.name, judul AS title, 
					k.deskripsi AS content, k.date AS tanggal, 'knowledge' AS identity, u.photo
					FROM knowledge k JOIN user u ON k.userid_uploader = u.user_id
					WHERE k.knowledge_id = '".$id."'";
		$rs = $this->registry->db->Execute($query);
		if($rs){
		    if($rs->RecordCount() > 0){
			while($row = $rs->FetchNextObject()){
			  $data[] = $row;
			}
		  }
		}else throw new Exception('Gagal ambil selectDB_wallDetail');
		return $data;
	}
	
}
?>
