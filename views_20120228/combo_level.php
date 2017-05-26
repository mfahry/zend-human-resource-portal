<?php	
	$rs = $this->registry->mUser->selectDB_level();	
	echo "<select name='leveluser_id' id='leveluser_id' class='validate[required]'>";?>
	<option value="">--Pilih Level User--</option>
<?php
	foreach($rs as $data){
		if(isset($level)){ 
			echo "<option value=".$data->LEVEL_ID." ".(($level == $data->LEVEL_ID)?"selected":"").">".$data->NAME."</option>";
 		}else{
			echo "<option value=".$data->LEVEL_ID." ".(($level_id == $data->LEVEL_ID)?"selected":"").">".$data->NAME."</option>";
		}
	}
		
	echo "</select>";
?>