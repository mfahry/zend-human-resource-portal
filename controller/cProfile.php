<?php
class CProfile extends Controllers {

	public function index() {
		try{
 			$this->registry->view->tasklisttop5 = $this->registry->mTask->selectDB_taskTop5(isset($_SESSION['userid'])?$_SESSION['userid']:'',100);
			$this->registry->view->dataUnion = $this->registry->mStatus->selectDB_homeUnion(isset($_SESSION['userid'])?$_SESSION['userid']:'');
 			$this->registry->view->content = "tab_profile";
		}catch(Exception $e){
			$this->registry->error  = $e->getMessage();
			$this->registry->view->content	= 'errorMsg'; 
		}
		$this->registry->view->show("template");
	}
	
	public function updateProfile(){
		try{
			$this->registry->mUser->updateDB_userProfile($_POST['nama'], $_POST['alamat'], $_POST['email'], $_POST['password'], $_POST['fimage'], $_POST['phone'], $_SESSION['userid']);
			$this->index();
			/*if($_POST['checkbox'] == "checkbox"){ //password juga diganti
				if(md5($_POST['passlama']) == ($_POST['passasli'])){ //password lama sama.
					if(($_POST['passbaru1']) == ($_POST['passbaru2'])){//password baru 1 dan 2 sama
						$datafile = $_FILES['fileField'];
						$namafile = $datafile['name'];
						$ukuran = $datafile['size'];
						$file_sementara = $datafile['tmp_name'];
						if(empty($namafile)){ //cek file kosong.
							//update semua isi profile tanpa foto baru
							$this->registry->mProfile->updateDataPasswordProfile($_SESSION['userid'],md5($_POST['passbaru2']),$_POST['nama'],$_POST['email'],$_POST['alamat'],$_POST['phone']);
							
							$wall="<b>is update Profile.</b>";
							$this->registry->mStatus->UpdateMyStatus($wall,$_SESSION['userid']);
							echo "<script>";
							echo "alert('Update Profile: Data Diri dan  Password Berhasil')";
							echo "</script>";
							echo "<script>location.href=\"index.php?mod=profile\"</script>";
						}else{// file tidak Kosong.							
							if (file_exists($_SERVER['DOCUMENT_ROOT'] .
							"/new.neuronportal/includes/img/photo/$namafile")){ //cek file udah ada atau sama di Folder apa gg??
								echo "<script>";
								echo "alert('File $namafile sudah ada. Jika Ingin Upload lagi Ganti nama File!!');";
								echo "</script>";
								echo "<script>location.href=\"index.php?mod=profile\"</script>";
							}else if(!ereg("image",$datafile["type"])){ //cek file tipenya bukan gambar/
									echo "<script>";
									echo "alert('$namafile Bukan Gambar!!');";
									echo "</script>";
									echo "<script>location.href=\"index.php?mod=profile/GantiProfile\"</script>";
							}
							else{//file tidak ada di folder dan tidak sama serta jenisnya adalah gambar.
								//update semua isi profile
								$this->registry->mProfile->updateDataFotoPasswordProfile($_SESSION['userid'],md5($_POST['passbaru2']),$_POST['nama'],$_POST['email'],$_POST['alamat'],$_POST['phone'],$namafile,$file_sementara);
								
								$wall="<b>is change photo profile.</b>";
								$this->registry->mStatus->UpdateMyStatus($wall,$_SESSION['userid']);
								
								echo "<script>";
								echo "alert('Update Profile: Foto, Data Diri dan Password Berhasil')";
								echo "</script>";
								echo "<script>location.href=\"index.php?mod=profile\"</script>";
								}
						}
					}else{//password baru 1 dan 2 tidak sama.
						echo "<script>";
						echo "alert('Password baru 1 dan 2 tidak sama')";
						echo "</script>";
						echo "<script>location.href=\"index.php?mod=profile/GantiProfile\"</script>";
					}
				}else{//password lama salah
					echo "<script>";
					echo "alert('Password lama salah')";
					echo "</script>";
					echo "<script>location.href=\"index.php?mod=profile/GantiProfile\"</script>";
				}
			}else{//password tidak di ganti
				$datafile = $_FILES['fileField'];
				$namafile = $datafile['name'];
				$ukuran = $datafile['size'];
				$file_sementara = $datafile['tmp_name'];
				if(empty($namafile)){ //cek file kosong.
					//update semua isi profile tanpa foto dan password baru
					$this->registry->mProfile->updateDataProfile($_SESSION['userid'],$_POST['nama'],$_POST['email'],$_POST['alamat'],$_POST['phone']);
					
					$wall="<b>is update Profile.</b>";
					$this->registry->mStatus->UpdateMyStatus($wall,$_SESSION['userid']);
					
					echo "<script>";
					echo "alert('Update Profile: Data Diri Berhasil')";
					echo "</script>";
					echo "<script>location.href=\"index.php?mod=profile\"</script>";
				}else{// file tidak Kosong.							
					if (file_exists($_SERVER['DOCUMENT_ROOT'] .
						"/new.neuronportal/includes/img/photo/$namafile")){ //cek file udah ada atau sama di Folder apa gg??
						echo "<script>";
						echo "alert('File $namafile sudah ada. Jika Ingin Upload lagi Ganti nama File!!');";
						echo "</script>";
						echo "<script>location.href=\"index.php?mod=profile\"</script>";
					}else if(!ereg("image",$datafile["type"])){ //cek file tipenya bukan gambar/
						echo "<script>";
						echo "alert('$namafile Bukan Gambar!!');";
						echo "</script>";
						echo "<script>location.href=\"index.php?mod=profile/GantiProfile\"</script>";
					}else{//file tidak ada di folder dan tidak sama serta jenisnya adalah gambar.
						//update semua isi profile tanpa password baru
						$this->registry->mProfile->updateDataFotoProfile($_SESSION['userid'],$_POST['nama'],$_POST['email'],$_POST['alamat'],$_POST['phone'],$namafile,$file_sementara);
						
						$wall="<b>is change photo profile.</b>";
						$this->registry->mStatus->UpdateMyStatus($wall,$_SESSION['userid']);
						
						echo "<script>";
						echo "alert('Update Profile: Foto dan Data Diri Berhasil')";
						echo "</script>";
						echo "<script>location.href=\"index.php?mod=profile\"</script>";
					}
				}
			}*/
		}catch(Exception $e){
			$this->registry->error  = $e->getMessage();
			$this->registry->view->content	= 'errorMsg';
			$this->registry->view->show('template');
		}
	}
	#2011-11-01:update all from form cv
	public function updateCv(){
		try{
			$this->registry->mUser->updateDB_userCv($_SESSION['userid'], $_POST['nama'], $_POST['alamat'], 
			$_POST['email'], $_POST['phone'], $_POST['kota'], $_POST['zipcode']);
			$this->index();
		
		}catch(Exception $e){
			$this->registry->error  = $e->getMessage();
			$this->registry->view->content	= 'errorMsg';
			$this->registry->view->show('template');
		}
	}
	public function updateCvEdu(){
		try{
			$this->registry->mUser->updateDB_educationCv($_SESSION['userid'], 
			$_POST['sname'], $_POST['kotapendidikan'], $_POST['year'], $_POST['pendidikan'], $_POST['Deskripsi1'], $_POST['schid']);
			$this->index();
		
		}catch(Exception $e){
			$this->registry->error  = $e->getMessage();
			$this->registry->view->content	= 'errorMsg';
			$this->registry->view->show('template');
		}
	}
	public function updateCvExp(){
		try{
			$this->registry->mUser->updateDB_companyCv($_SESSION['userid'], $_POST['Perusahaan'], 
			$_POST['KotaSpesifikasi'], $_POST['yearhire'], $_POST['obspecification'], $_POST['Deskripsi2'], $_POST['compid']);
			$this->index();
		
		}catch(Exception $e){
			$this->registry->error  = $e->getMessage();
			$this->registry->view->content	= 'errorMsg';
			$this->registry->view->show('template');
		}
	}
	public function updateCvOther(){
		try{
			$this->registry->mUser->updateDB_additionalCv($_SESSION['userid'], $_POST['pekerjaan'], $_POST['otherjobid']);
			$this->index();
		
		}catch(Exception $e){
			$this->registry->error  = $e->getMessage();
			$this->registry->view->content	= 'errorMsg';
			$this->registry->view->show('template');
		}
	}
	public function updateCvSkill(){
		try{
			$this->registry->mUser->updateDB_skillCv($_SESSION['userid'], $_POST['skill'], $_POST['skillid']);	
			$this->index();
		
		}catch(Exception $e){
			$this->registry->error  = $e->getMessage();
			$this->registry->view->content	= 'errorMsg';
			$this->registry->view->show('template');
		}
	}
	
	public function GantiProfile(){
		try{
			$this->registry->view->content = "grid_table_profile";
			$this->registry->view->show("template");
		}catch(Exception $e){
			$this->registry->error  = $e->getMessage();
			$this->registry->view->content	= 'errorMsg';
			$this->registry->view->show('template');
		}
	}
		
		
}	
?>