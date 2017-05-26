<?php
$link = mysql_connect('localhost','root','4dm1ns3rv3r');
//$link = mysql_connect('localhost','root','');

$db_selected = mysql_select_db('portalnw_db', $link);
if (!$db_selected) {
    die ('Can\'t use portalnw_db : ' . mysql_error());
}

$task = str_replace("[","",str_replace("#","",$_POST['task']));

$qTask = "SELECT distinct lower(substr(task,locate('[',task)+1,(locate(']',task)-2))) as tsk FROM task
			where task like '[%$task%]%' order by tsk";
$rTask = mysql_query($qTask);

while($row = mysql_fetch_object($rTask)){
	$task = explode(']',$row->tsk);
	$task = str_replace('[','',$task[0]);
	
	echo "<a href=\"javascript:void(0);\" class='autoSug' onclick=\"addTask('".strtoupper($task)."')\">".strtoupper($task)."</a><br />\n";
}

mysql_close($link);
?>