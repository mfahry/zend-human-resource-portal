<?php

class CPolling extends Controllers {
	
	public function index() {
		try{
			$this->registry->view->show('view_pilih_polling');
		}catch(Exception $e){
			$this->registry->error  = $e->getMessage();
			$this->registry->view->content	= 'errorMsg';
			$this->registry->view->show('template');
		}
	}
	public function InsertPilihan(){
		try{
			$this->registry->mPolling->InsertPilihan($polling_id,$_POST['pilihan']);
		}catch(Exception $e){
			$this->registry->error  = $e->getMessage();
			$this->registry->view->content	= 'errorMsg';
			$this->registry->view->show('template');
		}
	}
	
	public function DetailPolling($pollingid){
		try{
			$this->registry->view->data = $this->registry->mPolling->SelectPolling($pollingid,NULL);
			$this->registry->view->datapilihan = $this->registry->mPolling->SelectPilihan($pollingid,NULL,NULL);
			//$url = explode('/',$_GET['mod']);
			//$this->registry->view->url = $url[1];
			//$this->registry->view->setWindowActive  = '2';
			$this->registry->view->content = "window_detail_polling";
			$this->registry->view->show('template');
		}catch(Exception $e){
			$this->registry->error  = $e->getMessage();
			$this->registry->view->content	= 'errorMsg';
			$this->registry->view->show('template');
		}
	}

	public function EditPolling($pollingid){
		try{
			$this->registry->view->data = $this->registry->mPolling->SelectPolling($pollingid,NULL);
			$this->registry->view->datapilihan = $this->registry->mPolling->SelectPilihan($pollingid,NULL,NULL);
			//$url = explode('/',$_GET['mod']);
			//$this->registry->view->url = $url[1];
			//$this->registry->view->setWindowActive  = '1';
			$this->registry->view->content = "window_edit_polling";
			$this->registry->view->show('template');
		}catch(Exception $e){
			$this->registry->error  = $e->getMessage();
			$this->registry->view->content	= 'errorMsg';
			$this->registry->view->show('template');
		}
	}
	
	public function SelectPolling($pollingid){
		try{
			$this->registry->view->data = $this->registry->mPolling->SelectPolling($pollingid,NULL);
			$this->registry->view->content = 'window_edit_polling';
			$this->registry->view->show('template');
		}catch(Exception $e){
			$this->registry->error  = $e->getMessage();
			$this->registry->view->content	= 'errorMsg';
			$this->registry->view->show('template');
		}
	}
	
	public function UpdatePolling($pollingid){
		try{
			if(empty($_POST["pilihan"][0]) || empty($_POST["pilihan"][1])){
				echo "<script>alert('Pilihan Jawaban harus lebih dari 1')</script>";
				echo "<script>location.href=\"index.php?mod=index/showAdminCalendar\"</script>";	
			}else{
				//update polling
				$this->registry->mPolling->UpdatePolling($pollingid,$_POST['question'],$_POST['start'],$_POST['end']);
				
				$datapilihan = $this->registry->mPolling->SelectPilihan($pollingid,NULL,NULL);
				$jumlahpilihan = count($datapilihan);
				$datalimit= $this->registry->mPolling->SelectPilihan($pollingid,NULL,$jumlahpilihan);
				foreach($datalimit as $pil){
					$pilihan_id = $pil->PILIHAN_ID;
				}
				$myInputs = $_POST["pilihan"];
				$i = 1;
				foreach($myInputs as $eachInput){
					if($i<=$jumlahpilihan){
						$this->registry->mPolling->UpdatePilihan($pilihan_id,NULL,$eachInput);
					}else{
						$this->registry->mPolling->InsertPilihan($eachInput,$pollingid);
					}
					$pilihan_id = $pilihan_id+1;
					$i = $i+1;
				}
				echo "<script>alert('Pilihan Jawaban harus lebih dari 1')</script>";
				echo "<script>location.href=\"index.php?mod=index/showAdminCalendar\"</script>";	
			}
		}catch(Exception $e){
			$this->registry->error  = $e->getMessage();
			$this->registry->view->content	= 'errorMsg';
			$this->registry->view->show('template');
		}
	}
	
	public function DeletePolling($id){
		try{
			$this->registry->mPolling->DeletePolling($id);
		}catch(Exception $e){
			$this->registry->error  = $e->getMessage();
			$this->registry->view->content	= 'errorMsg';
			$this->registry->view->show('template');
		}
	}
	
	public function InsertPolling(){
		try{
			
			$data = $this->registry->mPolling->SelectPolling();
			if(count($data)>0){
				foreach($data as $polling){
					$polling_id = $polling->POLLING_ID;
					$pertanyaan = $polling->QUESTION;
					$start = $polling->START_DATE;
					$end = $polling->END_DATE;
				}
				$date = date("Y-m-d");
				if($end>$date){
					echo "<script>alert('MAAF POLLING LAMA MASIH BERLAKU!')</script>";
				}else{
					if(empty($_POST["pilihan"][0]) || empty($_POST["pilihan"][1])){
						echo "<script>alert('Pilihan Jawaban harus lebih dari 1')</script>";
						echo "<script>location.href=\"index.php?mod=index/showAdminCalendar\"</script>";	
					}else{
					//insert polling
						$this->registry->mPolling->InsertPolling($_POST['question'],$_POST['start'],$_POST['end']);
						//insert pilihan
						$myInputs = $_POST["pilihan"];
						foreach ($myInputs as $eachInput) {
							 $this->registry->mPolling->InsertPilihan($eachInput,NULL);
						}
					}
					echo "<script>alert('Polling telah Masuk')</script>";
				}
			}else{
				if(empty($_POST["pilihan"][0]) || empty($_POST["pilihan"][1])){
					echo "<script>alert('Pilihan Jawaban harus lebih dari 1')</script>";
					echo "<script>location.href=\"index.php?mod=index/showAdminCalendar\"</script>";	
				}else{
					//insert polling
					$this->registry->mPolling->InsertPolling($_POST['question'],$_POST['start'],$_POST['end']);
					//insert pilihan
					$myInputs = $_POST["pilihan"];
					foreach ($myInputs as $eachInput) {
						 $this->registry->mPolling->InsertPilihan($eachInput,NULL);
					}
					echo "<script>alert('Polling telah Masuk')</script>";
				}
			}
			echo "<script>location.href=\"index.php?mod=index/showAdminCalendar\"</script>";
		}catch(Exception $e){
			$this->registry->error  = $e->getMessage();
			$this->registry->view->content	= 'errorMsg';
			$this->registry->view->show('template');
		}
	}
	
	public function UserMemilih(){
		try{
			$datapilihan = $this->registry->mPolling->SelectPilihan($_POST['polling'],NULL,NULL);
			foreach($datapilihan as $pilihan){
				$namapilihan = $pilihan->PILIHAN;
				$pilihan_id = $pilihan->PILIHAN_ID;
				if($_POST['pilihan'.$pilihan_id] == $pilihan_id){
					$this->registry->mPolling->UserMemilih($_POST['polling'],$_SESSION['userid'],$pilihan_id);
					echo "<script>alert('Terimakasih, Anda telah memilih')</script>";
				}
			}
			echo "<script>location.href=\"index.php?mod=index\"</script>";
		}catch(Exception $e){
			$this->registry->error  = $e->getMessage();
			$this->registry->view->content	= 'errorMsg';
			$this->registry->view->show('template');
		}
	}
	
}
?>