<?php
session_start();

$link = mysql_connect('localhost','root','4dm1ns3rv3r');
//$link = mysql_connect('localhost','root','');

$db_selected = mysql_select_db('portalnw_db', $link);
if (!$db_selected) {
    die ('Can\'t use portalnw_db : ' . mysql_error());
}

$usr = str_replace("@","",str_replace("<","",$_POST['usr']));

$qName = "SELECT user_id,name FROM user where name like '%$usr%' and user_id !='".$_SESSION['userid']."' and HRDstatus='1' order by name";
$rName = mysql_query($qName);

while($rowName = mysql_fetch_object($rName)){	
	echo "<a href=\"javascript:void(0);\" onclick=\"addUsr('".strtoupper($rowName->user_id)."')\">".strtoupper($rowName->name)."</a><br />\n";
}

mysql_close($link);
?>