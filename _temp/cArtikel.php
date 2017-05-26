<?php

class CKnowledge extends Controllers {
	
	public function index() {
		$this->registry->view->knowledge = $this->registry->mArtikel->ShowArtikel();
		$this->registry->view->content = "form_show_artikel";
		$this->registry->view->show("template");
	}
	
	public function UploadArtikel(){
		try{
			$datafile = $_FILES['fileField'];
			if(($_POST['judul'] == "") && ($_POST['deskripsi'] == "")){//cek judul dan deskripsi kosong
				echo "<script>";
				echo "alert('Judul dan Diskripsi Tidak Boleh kosong!!')";
				echo "</script>";
				echo "<script>location.href=\"index.php?mod=knowledge\"</script>";
			}else{
				$namafile = $datafile['name'];
				$ukuran = $datafile['size'];
				$file_sementara = $datafile['tmp_name'];
				if (!empty($namafile)){//cekfile tidak kosong
					if(file_exists($_SERVER['DOCUMENT_ROOT'] .
					"/new.neuronportal/includes/File/$namafile")){//cek file sudah ada dengan nama yang sama.
						echo "<script>alert('File $namafile sudah ada. Jika Ingin Upload lagi Ganti nama File!!')</script>";
						echo "<script>location.href=\"index.php?mod=knowledge\"</script>";
					}else{//file belum ada di tempat penyimpanan
						$adafile="ya";
						
						$wall="<b>is post knowledge ".$_POST['judul'].".<br> Please see in menu KNOWLEDGE.</b>";
						$this->registry->mStatus->InsertMyStatus($wall,$_SESSION['userid']);
						
						$this->registry->mArtikel->UploadArtikel($_SESSION['userid'],$_POST['judul'],$_POST['deskripsi'],$_POST['kategori'],$namafile,$file_sementara,$adafile);	
					}
				}else{//tidak upload file
					$adafile="tidak";
					$this->registry->mArtikel->UploadArtikel($_SESSION['userid'],$_POST['judul'],$_POST['deskripsi'],$_POST['kategori'],$namafile,$file_sementara,$adafile);
					
					$wall="<b>is post knowledge ".$_POST['judul'].".<br> Please see in menu KNOWLEDGE.</b>";
					$this->registry->mStatus->InsertMyStatus($wall,$_SESSION['userid']);
				}
			}
		}catch(Exception $e){
			$this->registry->error  = $e->getMessage();
			$this->registry->view->content	= 'errorMsg';
			$this->registry->view->show('template');
		}
	}
	
	public function ShowArtikel($idcat){
		try{
			$this->registry->view->knowledge = $this->registry->mArtikel->ShowArtikel($idcat);
			$this->registry->view->content = "form_show_artikel";
			$this->registry->view->show('template');
			//$this->registry->mArtikel->ShowArtikel();
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
	
	
	public function AddCategory(){	
		try{
			$this->registry->mCategoryList->addCategory($_POST['kategori']);
		}catch(Exception $e){
			$this->registry->error  = $e->getMessage();
			$this->registry->view->content	= 'errorMsg';
			$this->registry->view->show('template');
		}
	}

}

?>