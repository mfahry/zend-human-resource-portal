<?php
$getType 	= $this->registry->mAbsenType->selectDB_typeAbsen();
echo "<select name=\"cmbAbsen\" id=\"cmbAbsen\">
		<option value=\"-1\"> All </option>";	
  		foreach($getType as $data){
	  		if(($data->TYPE_ID != 0)&&($data->TYPE_ID != 1)&&($data->TYPE_ID != 8)&&($data->TYPE_ID != 10)&&($data->TYPE_ID != 11))
		  echo "<option value=\"".$data->TYPE_ID."\"> ".$data->TYPE_NAME." </option>";
  		}
echo "</select>";
?>