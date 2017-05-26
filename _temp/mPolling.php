<?php
class MPolling{
	private $registry;

  	function __construct( $registry ) {
		$this->registry = $registry;
    }
	
	public function PollingBelumAda(){
		$queryselect = "SELECT * FROM polling order by polling_id desc limit 1 ";
		$rsselect = $this->registry->db->Execute($queryselect);
		if($rsselect){
		  if($rsselect->RecordCount() > 0){
			while($row = $rsselect->FetchNextObject()){
			  $data[] = $row;
			}
		  }
		}else throw new Exception("Gagal mengambil data polling");
		return $rsselect->RecordCount();
	}
	
	public function SelectPolling($polling_id=NULL,$all=NULL){
		$data = array();
		$queryselect = "SELECT * FROM polling order by polling_id desc limit 1 ";
		if(!empty($all)){
			$queryselect = "SELECT * FROM polling order by polling_id asc";
		}
		if(!empty($polling_id)){
			$queryselect = "SELECT * FROM polling where polling_id='$polling_id'";
		}
		$rsselect = $this->registry->db->Execute($queryselect);
		if($rsselect){
		  if($rsselect->RecordCount() > 0){
			while($row = $rsselect->FetchNextObject()){
			  $data[] = $row;
			}
		  }
		}else throw new Exception("Gagal mengambil data polling");
		return $data;
	}
	
	public function InsertPolling($question,$start,$end){
		$query = "INSERT INTO polling(question,start_date,end_date) VALUES ('$question','$start','$end')";
		$rs = $this->registry->db->Execute($query);
		if(!$rs){
			throw new Exception('Gagal menyimpan poling');
		}
	}
	
	public function UpdatePolling($polling_id,$question,$start,$end){
		$data = array();
		$queryselect = "UPDATE polling SET question = '$question', start_date = '$start', end_date = '$end' where polling_id = '$polling_id' ";
		$rsselect = $this->registry->db->Execute($queryselect);
		if($rsselect){
		  if($rsselect->RecordCount() > 0){
			while($row = $rsselect->FetchNextObject()){
			  $data[] = $row;
			}
		  }
		}else throw new Exception("Gagal mengambil data pilihan");
		return $data;
	}
	
	public function DeletePolling($polling_id){
		$query = "DELETE FROM polling where polling_id = '$polling_id'";
		$querypilihan = "DELETE FROM polling_pilihan where polling_id = '$polling_id'";
		$queryhasil = "DELETE FROM polling_hasil where polling_id = '$polling_id'";
		$rs = $this->registry->db->Execute($query);
		$rspilihan = $this->registry->db->Execute($querypilihan);
		$rshasil = $this->registry->db->Execute($queryhasil);
		if(((!$rs) || (!$rspilihan)) || (!$rshasil)){
		  throw new Exception("Gagal delete data polling");
		}
		echo "<script>alert('POLING TELAH DI DELETE!!')</script>";
		echo "<script>location.href=\"index.php?mod=index/showAdminCalendar\"</script>";
	}
	
	public function DeletePilihan($polling_id){
		$query = "DELETE FROM polling_pilihan where polling_id = '$polling_id'";
		$rs = $this->registry->db->Execute($query);
		if(!$rs){
		  throw new Exception("Gagal delete data pilihan polling");
		}
	}
	
	
	public function InsertPilihan($pilihan,$idpolling=NULL){
		//polling_id dari data polling yan baru saja di insert
		if(empty($idpolling)){
			$data = $this->SelectPolling();
			foreach($data as $polling){
				$polling_id = $polling->POLLING_ID;
			}
			$query = "INSERT INTO polling_pilihan(polling_id,pilihan) VALUES ('$polling_id','$pilihan')";
			$rs = $this->registry->db->Execute($query);
			if(!$rs){ 
				$this->DeletePolling($polling_id);
				throw new Exception('Gagal menyimpan pilihan');
			}
		}
		//idpolling dari data polling yang baru saja di update.
		if(!empty($idpolling)){
			$queryupdate = "INSERT INTO polling_pilihan(polling_id,pilihan) VALUES ('$idpolling','$pilihan')";
			$rsupdate = $this->registry->db->Execute($queryupdate);
			if(!$rsupdate){ 
				$this->DeletePolling($idpolling);
				throw new Exception('Gagal menyimpan pilihan');
			}
		}
	}
	
	public function SelectPilihan($polling_id,$pilihan_id = NULL,$limit=NULL){
		$data = array();
		if(!empty($limit)){
			$queryselect = "SELECT * FROM polling_pilihan where polling_id = '$polling_id' order by pilihan_id asc limit 1";
		}
		if(empty($pilihan_id)){
			$queryselect = "SELECT * FROM polling_pilihan where polling_id = '$polling_id'";
		}
		if(!empty($pilihan_id)){
			$queryselect = "SELECT * FROM polling_pilihan where polling_id = '$polling_id' AND pilihan_id = '$pilihan_id' ";
		}
		$rsselect = $this->registry->db->Execute($queryselect);
		if($rsselect){
		  if($rsselect->RecordCount() > 0){
			while($row = $rsselect->FetchNextObject()){
			  $data[] = $row;
			}
		  }
		}else throw new Exception("Gagal mengambil data select pilihan");
		return $data;
	}
	
	public function UpdatePilihan($pilihan_id,$jumlah=NULL,$pilihan=NULL){
		$data = array();
		if(!empty($jumlah)){
			$queryselect = "UPDATE polling_pilihan SET jumlah = '$jumlah' where pilihan_id = '$pilihan_id' ";
		}
		if(!empty($pilihan)){
			$queryselect = "UPDATE polling_pilihan SET pilihan='$pilihan' where pilihan_id = '$pilihan_id' ";
		}
		$rsselect = $this->registry->db->Execute($queryselect);
		if($rsselect){
		  if($rsselect->RecordCount() > 0){
			while($row = $rsselect->FetchNextObject()){
			  $data[] = $row;
			}
		  }
		}else throw new Exception("Gagal mengambil data update pilihan");
		return $data;
	}
	
	
	/////////////////tabel polling_hasil////////////////////////
	public function UserMemilih($polling_id,$userid,$pilihan_id){
		$data = array();
		$datapilihan = $this->SelectPilihan($polling_id,$pilihan_id,NULL);
		foreach($datapilihan as $pilih){
			$jumlah = $pilih->JUMLAH;
		}
		$jumlah = 1+$jumlah;
		
		$this->UpdatePilihan($pilihan_id,$jumlah,NULL);		
		$queryselect = "INSERT INTO polling_hasil(polling_id,pilihan_id,user_id) VALUES('$polling_id','$pilihan_id','$userid')";
		$rsselect = $this->registry->db->Execute($queryselect);
		if($rsselect){
		  if($rsselect->RecordCount() > 0){
			while($row = $rsselect->FetchNextObject()){
			  $data[] = $row;
			}
		  }
		}else throw new Exception("Gagal update data pilihan");
		return $data;
	}
	
	public function JumlahPilihan($polling_id){
		$queryselect = "SELECT * FROM polling_hasil where polling_id = '$polling_id' ";
		$rsselect = $this->registry->db->Execute($queryselect);
		if($rsselect){
		  if($rsselect->RecordCount() > 0){
			while($row = $rsselect->FetchNextObject()){
			  $data[] = $row;
			}
		  }
		}else throw new Exception("Gagal mengambil data pilihan");
		return $rsselect->RecordCount();
	}
	
	public function UserSudahMemilih($polling_id){
		$user = $_SESSION['userid'];
		$queryselect = "SELECT * FROM polling_hasil where polling_id = '$polling_id' AND user_id = '$user'";
		$rsselect = $this->registry->db->Execute($queryselect);
		if($rsselect){
		  if($rsselect->RecordCount() > 0){
			while($row = $rsselect->FetchNextObject()){
			  $data[] = $row;
			}
		  }
		}else throw new Exception("Gagal mengambil data hasil polling");
		return $rsselect->RecordCount();
	}
	
	public function PilihanUser($polling_id){
		$data = array();
		$queryselect = "SELECT * FROM polling_hasil where polling_id = '$polling_id'";
		$rsselect = $this->registry->db->Execute($queryselect);
		if($rsselect){
		  if($rsselect->RecordCount() > 0){
			while($row = $rsselect->FetchNextObject()){
			  $data[] = $row;
			}
		  }
		}else throw new Exception("Gagal mengambil data hasil polling");
		return $data;
	}
	
	public function JumlahPemilih($polling_id){
		$queryselect = "SELECT * FROM polling_hasil where polling_id = '$polling_id'";
		$rsselect = $this->registry->db->Execute($queryselect);
		if($rsselect){
		  if($rsselect->RecordCount() > 0){
			while($row = $rsselect->FetchNextObject()){
			  $data[] = $row;
			}
		  }
		}else throw new Exception("Gagal mengambil data hasil polling");
		return $rsselect->RecordCount();
	}
	
}
?>