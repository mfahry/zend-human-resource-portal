<?php
require_once("../dbsconf/DbConnect.php"); 
global $CONN;

$act 	= $_POST['act'];
$id 	= $_POST['id'];	
$mg_desc = strtoupper($_POST['mg_desc']);
$mg_value = $_POST['mg_value'];

if($act=='del'){
	$sql = "delete from m_gaji where mgaji_id='$id'";
	$rs = $CONN->Execute($sql);
}elseif($act=='edit'){
	$sql = "update m_gaji set mg_desc='$mg_desc',
				mg_value='".$mg_value."' 
				where mgaji_id='$id'";
	$rs = $CONN->Execute($sql);
}else{
	$sql = "INSERT INTO m_gaji VALUES ('','$mg_desc','$mg_value',now(),'')";
	$rs = $CONN->Execute($sql);
}

if($rs){
	echo "ok";
}else{
	$CONN->ErrorMsg();
}
?>