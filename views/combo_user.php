<?php 
$getUser = $this->registry->mUser->selectDB_user();
if($submit == 1){		
	if($multiple != NULL){?>
		<select name = "cmbUser[]" multiple="multiple" onChange="javascript:submit();" style="width:auto; height:50%;" id="cmbUser" class="validate[required]">
	<?php 
	}else{ ?>
		<select name="cmbUser" onChange="javascript:submit();" style="width:auto;" id="cmbUser" class="validate[required]">
<?php        
	}
}else{
	if($multiple != NULL){
		//echo "<select name = \"cmbUser[]\"  multiple=\"multiple\" id=\"cmbUser\" class=\"validate[required]\" style=\"width:auto; height:50%;\">";
	?>
		<select name="cmbUser[]" id="cmbUser" class="validate[required]" multiple="multiple">
	<?php }else{ ?>
		<select name = "cmbUser" id="cmbUser" class="validate[required]" style="width:auto">
		<!--<select name = "cmbUser" id="cmbUser" class="validate[required]">!-->				
	<?php
	}
}
if($multiple == NULL){
	echo "<OPTION value = 0 selected> -- All -- </OPTION>"; 
}
?>

<?php
foreach($getUser as $data){ 
	if($data->USER_ID!=$_SESSION['userid']){ 
?>
	<OPTION value = "<?php echo $data->USER_ID; ?>" <?php 
	if(isset($_POST['cmbUser'])){
		if($data->USER_ID==$_POST['cmbUser']){ 
			echo "selected"; 
		}
	} ?>><?php echo ucwords($data->NAME); ?>
	</OPTION>
	<?php
	}
}
echo "</select>";?>
 
<SCRIPT language="javascript">
	/* This script and many more are available free online at
	The JavaScript Source!! http://javascript.internet.com
	Created by: Carl Leiby | http://leibys-place.com/ */
	
	/*function selectAll(listName, selected) {
	  var listBox = document.getElementById(listName);
	  for(i=0; i<listBox.length; i++) {
		listBox.options[i].selected=selected;
	  }
	  if( listBox.onchange ) {
		listBox.onchange();
	  }
	}
	
	function loopSelected()
	{
	  var SelectedValue = document.getElementById('cmbUserSelected');
	  var selectedArray = new Array();
	  var selObj = document.getElementById('cmbUser');
	  var i;
	  var count = 0;
	  var j;
	  for (i=0; i < selObj.options.length; i++) {
		if (selObj.options[i].selected) {
		  	selectedArray[count] = selObj.options[i].value;
			SelectedValue.options.add(new Option(selectedArray));
			count++;
		}
	  }
	}*/
</SCRIPT>