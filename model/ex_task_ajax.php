<?php
error_reporting(E_ALL ^ E_NOTICE);

include_once "../dbsconf/adodb5/adodb.inc.php";
include_once "../model/mTask.php";
include_once "../model/mTaskStatus.php";
include_once "../config/registry.cfg.php";
global $db;

$registry = new registry;
$registry->db = ADONewConnection('mysql');

$registry->mTask = new mTask($registry);
$registry->mTaskStatus = new mTaskStatus($registry);
$registry->db->PConnect('localhost','root','4dm1ns3rv3r','portalnw_db');
/* 
function add_row($rowId){	
	$sql = 	"INSERT INTO task(user_id, input_dtm, task, task_status_id, ip_address)
			VALUES('".$_SESSION['userid']."', now(), '".$_POST[$rowId."_c1"]."','".$_POST[$rowId."_c2"]."', '".$_SERVER['REMOTE_ADDR']."')";
	
	$db->Execute($sql);
	
	$action =  "insert";	
	
}

function update_row($rowId){
    $sql = 	"UPDATE task SET task ='".$_POST[$rowId."_c1"]."', status_task ='".$_POST[$rowId."_c2"]."', ip_address = '".$_SERVER['REMOTE_ADDR']."' WHERE task_id ='".$_POST[$rowId."_c0"]."'";
	
	$rs = $db->Execute($sql);

	$action = "update";
	
}
 
function delete_row($rowId){

	$sql = "DELETE FROM task WHERE task_id=".$_POST[$rowId."_c0"];
	$db->Execute($sql);
	
	$action = "delete";	
}
*/



header("Content-type: text/xml");
echo('<?xml version="1.0" encoding="iso-8859-1"?>'); 

echo "<data>";
$ids = explode(",",$_POST["ids"]);
//for each row
for ($i=0; $i < sizeof($ids); $i++) { 
	$rowId = $ids[$i]; //id or row which was updated 
	$newId = $rowId; //will be used for insert operation	
	$mode = $_POST[$rowId."_!nativeeditor_status"]; //get request mode
	
	switch($mode){
		case "inserted":
			// $action = add_row($rowId);
			$registry->mTask->insertDB_delegationtask($_POST[$rowId."_c0"], $_POST[$rowId."_c3"], $_POST[$rowId."_c5"]);//, $_POST[$rowId."_c2"]);
			$taskid = $registry->mTask->get_maxID();
			$registry->mTaskStatus->insertDB_taskStatus($_POST[$rowId."_c4"], $taskid);//, $_POST[$rowId."_c2"]);
			$action =  "insert";	
		break;
		case "deleted":
			// $action = delete_row($rowId);
			$registry->mTaskStatus->deleteDB_userTaskStatus($_POST[$rowId."_c0"]);
			$registry->mTask->deleteDB_userTask($_POST[$rowId."_c0"]);
			
			$action = "delete";	
		break;
		default:
			// $action = update_row($rowId);
			$registry->mTaskStatus->updateDB_showTaskStatus($_POST[$rowId."_c0"]);
			$registry->mTaskStatus->updateDB_task($_POST[$rowId."_c0"],$_POST[$rowId."_c2"],$_POST[$rowId."_c4"]);
			$registry->mTaskStatus->insertDB_taskStatus(intval($_POST[$rowId."_c3"]), $_POST[$rowId."_c0"]);
			//$registry->mTaskStatus->updateDB_taskPriority(intval($_POST[$rowId."_c4"]), $_POST[$rowId."_c0"]);

			$action = "update";
		break; 
	}	
	echo "<action type='".$action."' sid='".$rowId."' tid='".$newId."'/>";	
}

echo "</data>";

?>
