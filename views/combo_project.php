<?php 
$getProject = $this->registry->mUser->selectDB_project();
if($submit == 1){		
	if($multiple != NULL){?>
		<select name = "cmbProject[]" multiple="multiple" onChange="javascript:submit();" style="width:auto; height:50%;" id="cmbProject" class="validate[required]">
	<?php 
	}else{ ?>
		<select name="cmbProject" onChange="javascript:submit();" style="width:auto;" id="cmbProject" >
<?php        
	}
}else{
	if($multiple != NULL){
		//echo "<select name = \"cmbUser[]\"  multiple=\"multiple\" id=\"cmbUser\" class=\"validate[required]\" style=\"width:auto; height:50%;\">";
	?>
		<select name="cmbProject[]" id="cmbProject" class="validate[required]" multiple="multiple">
	<?php }else{ ?>
		<select name = "cmbProject" id="cmbProject" class="validate[required]" style="width:auto">
		<!--<select name = "cmbUser" id="cmbUser" class="validate[required]">!-->				
	<?php
	}
}
if($multiple == NULL){
	echo "<OPTION value = \"\" selected> Choose Project </OPTION>"; 
}
?>

<?php
foreach($getProject as $data){ 
	//if($data->USER_ID!=$_SESSION['userid']){ 
?>
	<OPTION value = "<?php echo $data->TSK; ?>" <?php 
	if(isset($_POST['cmbProject'])){
		if($data->TSK==$_POST['cmbProject']){
			echo "selected";
		}
	}?>><?php echo ucwords($data->TSK); ?>
	</OPTION>
	<?php
	//}
}

echo "</select>";?>
 