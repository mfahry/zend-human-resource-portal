<?php

class CKnowledge extends Controllers {
	
	public function index() {
		try{
			#ambil task  list utk side bar
			$this->registry->view->tasklisttop5 = $this->registry->mTask->selectDB_taskTop5(isset($_SESSION['userid'])?$_SESSION['userid']:'',100);
			
			$this->registry->view->knowledge = $this->registry->mKnowledge->get_newKnowledge();
			$this->registry->view->content = "form_artikel";
			$this->registry->view->show("template");
		}catch(Exception $e){
			$this->registry->error  = $e->getMessage();
			$this->registry->view->content	= 'errorMsg';
			$this->registry->view->show('template');
		}
	}
	public function test(){
		try{
			$this->registry->view->tasklisttop5 = $this->registry->mTask->selectDB_taskTop5(isset($_SESSION['userid'])?$_SESSION['userid']:'',100);
			$this->registry->view->knowledge = $this->registry->mKnowledge->get_newKnowledge('',$_POST['searchbar']);
			$this->registry->view->content = "form_artikel";
		}catch(Exception $e){
				$this->registry->error  = $e->getMessage();
				$this->registry->view->content	= 'errorMsg';
		}
		$this->registry->view->show("template");	
	}
	public function detail($catid, $id){
		try{
			//$this->registry->view->tasklist  = $this->registry->mTask->selectDB_task(isset($_SESSION['userid'])?$_SESSION['userid']:'', 100);
			$this->registry->view->tasklisttop5 = $this->registry->mTask->selectDB_taskTop5(isset($_SESSION['userid'])?$_SESSION['userid']:'',100);
			$this->registry->view->newKnowledge = $this->registry->mKnowledge->get_newKnowledge($catid);	
			$this->registry->view->knowledge = $this->registry->mKnowledge->get_byID($id);
			$this->registry->view->content = "form_artikel";
 		}catch(Exception $e){
			$this->registry->error  = $e->getMessage();
			$this->registry->view->content	= 'errorMsg';
		}
		$this->registry->view->show("template");
	}
	
	public function UploadArtikel(){
		try{
			$datafile = $_FILES['fileField'];
			if(($_POST['judul'] == "") && ($_POST['deskripsi'] == "")){//cek judul dan deskripsi kosong
				echo "<script>";
				echo "alert('Judul dan Diskripsi Tidak Boleh kosong!!')";
				echo "</script>";
				echo "<script>location.href=\"index.php?mod=knowledge/addKnowledge\"</script>";
			}else{
				//if(ini_get('magic_quotes_gpc')){
					 $_POST['judul']=addslashes($_POST['judul']);
					 $_POST['deskripsi']=addslashes($_POST['deskripsi']);
				//}
				
				$namafile = $datafile['name'];
				$ukuran = $datafile['size'];
				$file_sementara = $datafile['tmp_name'];
				if (!empty($namafile)){//cekfile tidak kosong
					if(file_exists($_SERVER['DOCUMENT_ROOT'] ."/neuronPortal/includes/File/$namafile")){//cek file sudah ada dengan nama yang sama.
						echo "<script>alert('File $namafile sudah ada. Jika Ingin Upload lagi Ganti nama File!!')</script>";
						echo "<script>location.href=\"index.php?mod=knowledge/addKnowledge\"</script>";
					}else{//file belum ada di tempat penyimpanan
						$adafile="ya";
						
						//$wall="<h3> telah menulis knowledge ".ucfirst($_POST['judul'])."</h3>";
						//$this->registry->mStatus->InsertMyStatus($wall,$_SESSION['userid']);
						
						$this->registry->mKnowledge->UploadArtikel($_SESSION['userid'],$_POST['judul'],$_POST['deskripsi'],$_POST['kategori'],$namafile,$file_sementara,$adafile);	
					}
				}else{//tidak upload file
					$adafile="tidak";
					$this->registry->mKnowledge->UploadArtikel($_SESSION['userid'],$_POST['judul'],$_POST['deskripsi'],$_POST['kategori'],$namafile,$file_sementara,$adafile);
					
					//$wall="<b>is post knowledge ".$_POST['judul'].".<br> Please see in menu KNOWLEDGE.</b>";
					//$this->registry->mStatus->InsertMyStatus($wall,$_SESSION['userid']);
				}
			}
		}catch(Exception $e){
			$this->registry->error  = $e->getMessage();
			$this->registry->view->content	= 'errorMsg';
			$this->registry->view->show('template');
		}
	}
	
	public function category($idcat){
		try{
			$this->registry->view->tasklisttop5 = $this->registry->mTask->selectDB_taskTop5(isset($_SESSION['userid'])?$_SESSION['userid']:'',100);
			//$this->registry->view->tasklist = $this->registry->mTask->selectDB_task(isset($_SESSION['userid'])?$_SESSION['userid']:'', 100);
			$this->registry->view->knowledge = $this->registry->mKnowledge->get_byID($idcat, 'k.cat_id');
			$this->registry->view->content = "form_artikel";
			$this->registry->view->show('template');
			//$this->registry->mKnowledge->ShowArtikel();
		}catch(Exception $e){
			$this->registry->error  = $e->getMessage();
			$this->registry->view->content	= 'errorMsg';
			$this->registry->view->show('template');
		}
	}
	
	public function UploadKnowledge(){
		try{
			$this->registry->view->show("form_upload_knowledge");
		}catch(Exception $e){
			$this->registry->error  = $e->getMessage();
			$this->registry->view->content	= 'errorMsg';
			$this->registry->view->show('template');
		}
	}

	public function updateknowledge($id){
		try{
			$_POST['judul']=addslashes($_POST['judul']);
			$_POST['deskripsi']=addslashes($_POST['deskripsi']);
			$datafile = $_FILES['fileField'];
			$namafile = $datafile['name'];
			$ukuran = $datafile['size'];
			$file_sementara = $datafile['tmp_name'];
			if (!empty($namafile)){//cekfile tidak kosong
				if(file_exists($_SERVER['DOCUMENT_ROOT'] ."/neuronPortal/includes/File/$namafile")){//cek file sudah ada dengan nama yang sama.
					echo "<script>alert('File $namafile sudah ada. Jika Ingin Upload lagi Ganti nama File!!')</script>";
					echo "<script>location.href=\"index.php?mod=knowledge\"</script>";
				}else{//file belum ada di tempat penyimpanan
					$adafile="ya";						
					$this->registry->mKnowledge->updateknowledge($id,$_POST['judul'],$_POST['deskripsi'],$_POST['kategori'],$namafile,$file_sementara,$adafile);	
				}
			}else{//tidak upload file
				$adafile="tidak";
				$this->registry->mKnowledge->updateknowledge($id,$_POST['judul'],$_POST['deskripsi'],$_POST['kategori'],$namafile,$file_sementara,$adafile);
			}
		}catch(Exception $e){
			$this->registry->error  = $e->getMessage();
			$this->registry->view->content	= 'errorMsg';
		}
		$this->registry->view->show('template');
	}	
	
	public function AddCategory(){	
		try{
			$this->registry->mCategoryList->addCategory($_POST['kategori']);
		}catch(Exception $e){
			$this->registry->error  = $e->getMessage();
			$this->registry->view->content	= 'errorMsg';
			$this->registry->view->show('template');
		}
	}
	
	public function DeleteKnowledge($id){
		try{
			$this->registry->mKnowledge->deleteDB_knowledge($id);
		}catch(Exception $e){
			$this->registry->error  = $e->getMessage();
			$this->registry->view->content	= 'errorMsg';
			$this->registry->view->show('template');
		}
	}
	
	
	
}

?>