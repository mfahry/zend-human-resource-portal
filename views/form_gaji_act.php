<?php
require_once("../dbsconf/DbConnect.php"); 
global $CONN;

$userid = $_POST['userid'];
$gapok = $_POST['gapok'];
$tJab = $_POST['tJab'];
$tKes = $_POST['tKes'];
$tKom = $_POST['tKom'];
$tTrans = $_POST['tTrans'];
$rapat = $_POST['rapat'];
$iuranharitua = $_POST['iuranharitua'];

$query = "update gaji set end_dtm=now() where end_dtm='0000-00-00 00:00:00' and user_id='$userid'";
$data = $CONN->Execute($query);

$sql = "INSERT INTO gaji VALUES ('','$userid','$gapok','$tKes','$tTrans','$tJab','$tKom','$rapat','$iuranharitua',now(),'')";
$rs = $CONN->Execute($sql);

if($rs){
	echo "ok";
}else{
	$CONN->ErrorMsg();
}
?>