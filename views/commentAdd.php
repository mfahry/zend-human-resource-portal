<?php
session_start();
$link = mysql_connect('localhost','root','4dm1ns3rv3r');
//$link = mysql_connect('localhost','root','');

$db_selected = mysql_select_db('portalnw_db', $link);
if (!$db_selected) {
    die ('Can\'t use portalnw_db : ' . mysql_error());
}

$kl_id = $_POST['kl_id'];
$idf = $_POST['idf'];
$user_id = $_POST['usrid'];
$com = $_SESSION['userid']."~".$_POST['com'];

$qCom = "INSERT INTO comment (parent_id,identifier,user_id,content,input_dtm) 
			VALUES ('$kl_id','$idf','$user_id','$com',now())";
$rCom = mysql_query($qCom);

if($rCom){
	echo "ok";
} else {
	echo mysql_error();
}
?>