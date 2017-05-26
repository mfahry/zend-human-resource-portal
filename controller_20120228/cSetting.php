<?php

class CSetting extends Controllers {
	
	public function index($editcal=0,$calid=0) {
		$this->registry->view->editcal = $editcal;
		$this->registry->view->calid = $calid;
		$this->registry->view->content = 'tab_setting';
		$this->registry->view->show('template');
	}
	
	public function editCategory($catID,$ket){
		$this->registry->view->editcal = 0;
		$this->registry->view->calid = 0;
		$this->registry->view->catID = $catID;
		$this->registry->view->dataCategory = $this->registry->mNewsCategory->selectNamePublish($catID);
		$this->registry->view->ket = $ket;
		$this->registry->view->setActive = '2';
		$this->registry->view->setWindowActive = '1';
		$this->registry->view->content='tab_setting';
		$this->registry->view->show('template');
	}
	
	public function saveCalendar(){
		try{
			$this->registry->mCalendar->updateDbCalendar($_POST['calid'], $_POST['cmbDayStat'], $_POST['txaDescCal']);
			//echo "<script>location.href=\"index.php?mod=setting\"<\/script>";	
		}catch(Exception $e){
			
		}	
	}
	
	public function saveCategory(){
		try{
			if($_POST['ket']=='add')
				$this->registry->mNewsCategory->insertDBNewsCategory($_POST['tCatName'],$_POST['publish']);
			elseif($_POST['ket']=='edit')
				$this->registry->mNewsCategory->updateDB_category($_POST['catid'],$_POST['tCatName'],$_POST['publish']);
				
		}catch(Exception $e){
			
		}	
	}
	
	public function showEditCalendar($editcal,$calid){
		$this->registry->view->editcal = $editcal;
		$this->registry->view->calid = $calid;
		$this->registry->view->content = 'tab_setting';
		$this->registry->view->show('template');
	}
	
	/*
	public function deleteCategory($catID){
		$this->registry->view->editcal = 0;
		$this->registry->view->calid = 0;
		$this->registry->view->catID = $catID;
		$this->registry->view->dataCategory = $this->registry->mNewsCategory->selectNamePublish($catID);
		$this->registry->view->setActive = '3';
		$this->registry->view->setWindowActive = '2';
		$this->registry->view->content='tabAdminCalendar';
		$this->registry->view->show('template');
	}
	*/
	public function deleteCategory($catID){ 
		try{
			$this->registry->mNewsCategory->deleteNewsCategory($catID); 
			echo '<script>location.href = "index.php?mod=setting";</script>';
		}catch(Exception $e){
			
		}
		$this->registry->view->show('template');
	}
	
	public function showTabNewsCategory() {
		$this->registry->view->editcal = 0;
		$this->registry->view->calid = 0;
		$this->registry->view->setActive = '2';
		$this->registry->view->content = 'tab_setting';
		$this->registry->view->show('template');
	}
}