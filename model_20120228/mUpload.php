<?php
class MUpload{
	private $registry;
	
  	function __construct( $registry ) {
		$this->registry = $registry;
	}

	public function folderList(){
		$data = array();
		$query = "SELECT * FROM folder_kerja where folder_parent=0 order by folder_name";
					
		$rs = $this->registry->db->Execute($query);
		if($rs){
		  if($rs->RecordCount() > 0){
			while($row = $rs->FetchNextObject()){
			  $data[] = $row;
			}
		  }
		}else echo("Daftar folder kosong");
		return $data;
	}
	
	public function folderParent($pid){
		$pdata = array();
		$query = "SELECT * FROM folder_kerja where folder_parent=$pid";
		
		//echo $query;
					
		$rs = $this->registry->db->Execute($query);
		if($rs){
		  if($rs->RecordCount() > 0){
			while($row = $rs->FetchNextObject()){
			  $pdata[] = $row;
			}
		  }
		}else echo("Daftar folder kosong");
		return $pdata;
	}
	
	public function folderName($id){
		$data = array();
		$query = "SELECT folder_name FROM folder_kerja where folder_id=$id";
		
		//echo $query;
					
		$rs = $this->registry->db->Execute($query);
		if($rs){
		  if($rs->RecordCount() > 0){
			while($row = $rs->FetchNextObject()){
			  $data[] = $row;
			}
		  }
		}else echo("nama folder tidak ada");
		return $data;
	}
	
	function UploadFile($folderid,$namafile,$namafileori,$filetype){
		$query = "INSERT INTO file_kerja (folder_id,file_name,original_file_name,file_type,uploaded_by,uploaded_dtm) 
					VALUES ('".$folderid."','".$namafile."','".$namafileori."','".$filetype."','".$_SESSION['userid']."',now())";
		
		$this->registry->db->Execute($query);
	}
	
	function folderBaru($namafolder,$parentfolder){
		if($parentfolder){
			$query2 = "select folder_name from folder_kerja where folder_id=$parentfolder";
	
			$rs2 = $this->registry->db->Execute($query2);
			$parent = $rs2->fields[0];
			
			$newFolder = "$parent/$namafolder";
		} else {
			$newFolder = "$namafolder";				
		}
		if(@mkdir("upload/$newFolder", 0755)){
		
			$queryFI = "SHOW TABLE STATUS LIKE 'folder_kerja'";
			$rsFI = $this->registry->db->Execute($queryFI);
			$rowFI = $rsFI->FetchNextObject();
			
			$folder_id = $rowFI->AUTO_INCREMENT;
			
			$query = "INSERT INTO folder_kerja (folder_id,folder_name,folder_parent,create_by,create_dtm) 
					VALUES ($folder_id,'".$namafolder."','".$parentfolder."','".$_SESSION['userid']."',now())";
		
			$rs = $this->registry->db->Execute($query);
			if($rs){
				chmod("upload/$newFolder", 0755);
				//exec("chmod -R 0777 /mnt/Kerja/$newFolder");
				return $folder_id;
			} else {
				$folder_id = "gagal menambah folder baru";
			}
		} else $folder_id = "gagal menambah folder baru";
		
		/*$query = "INSERT INTO folder_kerja (folder_name,folder_parent,create_by,create_dtm) 
					VALUES ('".$namafolder."','".$parentfolder."','".$_SESSION['userid']."',now())";
		
		$rs = $this->registry->db->Execute($query);
		if($rs){
			if($parentfolder){
				$query2 = "select folder_name from folder_kerja where folder_id=$parentfolder";
		
				$rs2 = $this->registry->db->Execute($query2);
				$parent = $rs2->fields[0];
				
				$newFolder = "$parent/$namafolder";
			} else {
				$newFolder = "$namafolder";				
			}
			@mkdir("\\\\192.168.1.3\NW_Document\Kerja\$newFolder\\", 0777);
			//@chmod("/Kerja/$newFolder", 0777);
			
			/*@mkdir("/mnt/Kerja/$newFolder");
			@chmod("/Kerja/$newFolder", 0777);
		} else $newFolder = "gagal menambah folder baru";*/
		
		return $newFolder;
	}
}
?>