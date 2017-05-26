<?php if($this->registry->mUser->isLoggedOn()==TRUE){ ?>
<link rel="stylesheet" type="text/css" href="includes/dhtmlx/dhtmlxWindows/dhtmlxwindows.css">
<link rel="stylesheet" type="text/css" href="includes/dhtmlx/dhtmlxWindows/skins/dhtmlxwindows_dhx_skyblue.css">
<script src="includes/dhtmlx/dhtmlxWindows/dhtmlxcommon.js"></script>
<script src="includes/dhtmlx/dhtmlxWindows/dhtmlxwindows.js"></script>
<script src="includes/dhtmlx/dhtmlxWindows/dhtmlxcontainer.js"></script>

<div style="width:100px;float:right;">
    <a class="btn" href="index.php?mod=knowledge/addKnowledge">Tulis Knwoledge</a>
</div>
<?php
}

echo '<ol class="mpart">';
if(count($knowledge)>0){
	foreach($knowledge as $artikel){
		$id = $artikel->KNOWLEDGE_ID;
		$uploader = $artikel->USERID_UPLOADER;
		$judul = $artikel->JUDUL;
		$deskripsi = $artikel->DESKRIPSI;
		$file = $artikel->FILE;
		$tanggal = $artikel->DATE;
		$kategori_id = $artikel->CAT_ID;
		
		$dat = $this->registry->mCategoryList->selectCategoryList(NULL,$kategori_id);
		if(count($dat)>0){
			
			foreach($dat as $kat){
				$kategori = $kat->CAT_NAME;		
			
			//$tgl = substr($tanggal, 8, 2);
			//$bln = substr($tanggal, 5, 2);
			//$thn = substr($tanggal, 0, 4);		
				
				$user = $this->registry->mUser->select_user($uploader);
				foreach($user as $nama){
					$namauser = $nama->NAME;
					echo '<li style="padding-top:10px;">';	
					echo '<h2>'.$judul.'</h2>';
					echo '<div class="date">
								<h3 style="float:left;">
									Posted by : '.$namauser.' on '.$tanggal.' 
									in <a href="index.php?mod=knowledge/ShowArtikel/'.$kategori_id.'">'.$kategori.'</a>';
									
					if($file!=""){
						echo ", File : <a href=\"includes/File/$file\" target=\"_blank\" > $file </a>";
					}	
					echo '		</h3>    	
							<div class=".clear"></div>';
					if((isset($_SESSION['userid'])&&($_SESSION['userid']==$uploader))||((isset($_SESSION['level_id'])&& $_SESSION['level_id']==2)||(isset($_SESSION['level_id'])&& $_SESSION['level_id']==1))){
						echo "<div style='float:right;'>";
						echo "	<a href=\"index.php?mod=knowledge/DeleteKnowledge/$id\" onClick = \"return confirm('Yakinkah dihapus?')\">Delete</a>";
						echo "  <a href=\"index.php?mod=knowledge/ShowUpdateKnowledge/$id\">Update</a>";
						echo "</div>";
					}	
					echo	'	</div>';
					echo "$deskripsi<br><hr>";
					echo "~~~~~";
					echo "</li>";
				}
			}
		}else echo "Data kosong";
	}
}else echo "Data knowledge kosong";
echo '</ol>';
 if(isset($_GET['mod'])){
	$url = explode('/',$_GET['mod']);
	if (isset($url[1])){
		if($url[1] == 'addKnowledge'){
			$this->registry->view->show('form_upload_knowledge');
		}
		if($url[1] == 'ShowUpdateKnowledge'){
			$id=$url[2];
			$this->registry->view->knowledge = $this->registry->mKnowledge->ShowToEdit($id);
			$this->registry->view->show('form_update_knowledge');
		}
	}
 }
?>


