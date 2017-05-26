<?php

class MProfile{
	private $registry;

  	function __construct( $registry ) {
		$this->registry = $registry;
	}
	
	/*
	public function updatePassword($userid, $password){
		$query 	= "UPDATE user SET password = '$password' where user_id='$userid' ";
		$rs = $this->registry->db->Execute($query);	
		if(!$rs) throw new Exception("Gagal mengupdate status login");	
	}
	
	public function updatePicture($namafile,$userid,$file_sementara){
		if(copy($file_sementara, $_SERVER['DOCUMENT_ROOT'] .
      		"/new.neuronportal/includes/img/photo/$namafile")){
			$query 	= "UPDATE user SET photo = '$namafile' where user_id='$userid' ";
			$rs = $this->registry->db->Execute($query);
			if(!$rs){
			throw new Exception("Gagal mengupdate photo");
			}
			unlink($file_sementara);
		}
	
	}
	*/
	
	public function updateDataProfile($userid,$nama,$email,$alamat,$phone){
		$query 	= "UPDATE user SET name = '$nama', alamat  = '$alamat', email = '$email', phone = '$phone' where user_id='$userid' ";
		$rs = $this->registry->db->Execute($query);	
		if(!$rs) throw new Exception("Gagal mengupdate Profile");	
	}
	
	public function updateDataPasswordProfile($userid,$password,$nama,$email,$alamat,$phone){
		$query 	= "UPDATE user SET name = '$nama', password = '$password',alamat  = '$alamat', email = '$email', phone = '$phone' where user_id='$userid' ";
		$rs = $this->registry->db->Execute($query);	
		if(!$rs) throw new Exception("Gagal mengupdate Profile");	
	}
	
	public function updateDataFotoProfile($userid,$nama,$email,$alamat,$phone,$namafile,$file_sementara){
		if(copy($file_sementara, IMG_PATH ."/photo/$namafile")){
			$query 	= "UPDATE user SET name = '$nama', alamat  = '$alamat', email = '$email', phone = '$phone', photo = '$namafile' where user_id='$userid' ";
			$rs = $this->registry->db->Execute($query);	
			if(!$rs) throw new Exception("Gagal mengupdate Profile");	
			unlink($file_sementara);
		}
	}
	
	public function updateDataFotoPasswordProfile($userid,$password,$nama,$email,$alamat,$phone,$namafile,$file_sementara){
		if(copy($file_sementara, IMG_PATH ."/photo/$namafile")){
			$query 	= "UPDATE user SET name = '$nama', password = '$password', alamat  = '$alamat', email = '$email', phone = '$phone', photo = '$namafile' where user_id='$userid' ";
			$rs = $this->registry->db->Execute($query);	
			if(!$rs) throw new Exception("Gagal mengupdate Profile");	
			unlink($file_sementara);
		}
	}
	
}
?>