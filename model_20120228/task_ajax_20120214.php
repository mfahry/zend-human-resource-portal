<?php
ob_start();
session_start();
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
//$registry->db->PConnect('localhost','root','','portalnw_db');
$registry->db->PConnect('localhost','root','4dm1ns3rv3r','portalnw_db');

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
		
			$usrId = $_POST[$rowId."_c0"];
			$task = $_POST[$rowId."_c2"];			
			$taskid = $registry->mTask->get_maxID();
			
			if(strstr($task,"<") && strstr($task,">")){
				$task1 = explode("<",$task);
				$task2 = explode(">",$task1[1]);
				$usr3 = explode(",",$task2[0]);

				for($i=0; $i<count($usr3); $i++){
					$registry->mTask->insertDB_userTask($taskid,$usr3[$i],'0');
					$nick .= $registry->mTask->get_userNick($usr3[$i]).", ";
				}
				//$nicks = rtrim($nick,', ');
				$task = $task1[0]." &lt;".$nick."&gt; ".$task2[1];
				
				$inputBy = $registry->mTask->get_userNick($usrId);
				$inputby = " (input by $inputBy)";
			}
			
			$target = '';
			
			if(strstr($task,"(") && strstr($task,")")){
				$task3 = explode("(",$task);
				$task4 = explode(")",$task3[1]);
				
				$task = $task3[0]." ".$task4[1];
				
				$target = $task4[0];
			}
				
			$task = $task.$inputby;
			
			$task = str_replace(", &gt;","&gt;",$task);
			$task = str_replace("  "," ",$task);
			$task = str_replace("  "," ",$task);
			
			$registry->mTask->insertDB_task($taskid, $usrId, $task, $_POST[$rowId."_c4"], $target, $_POST['CalendarIDperiod']);//, $_POST[$rowId."_c2"]);
			$registry->mTask->insertDB_userTask($taskid,$usrId,'1');
			$registry->mTaskStatus->insertDB_taskStatus($_POST[$rowId."_c3"], $taskid);//, $_POST[$rowId."_c2"]);
			$action =  "insert";
			
		break;
		
		case "deleted":
			// $action = delete_row($rowId);
			$registry->mTaskStatus->deleteDB_userTaskStatus($_POST[$rowId."_c0"]);
			$registry->mTask->deleteDB_task($_POST[$rowId."_c0"]);
			$registry->mTask->deleteDB_userTask($_POST[$rowId."_c0"]);
			
			$action = "delete";	
		break;
		
		default:
			// $action = update_row($rowId);
			if(intval($_POST[$rowId."_c3"])>100){
				echo "status maksimum 100%";
			}else{
				/*$task = $_POST[$rowId."_c2"];
				
				if(strstr($task,"<") && strstr($task,">")){
					$task1 = explode("<",$task);
					$task2 = explode(">",$task1[1]);
					$usr3 = explode(",",$task2[0]);

					for($i=0; $i<count($usr3); $i++){
						$registry->mTaskStatus->updateDB_showTaskStatus($_POST[$rowId."_c0"]);
						$registry->mTaskStatus->updateDB_taskUser($_POST[$rowId."_c0"],$task,$_POST[$rowId."_c4"],$usr3[$i]);
						$registry->mTaskStatus->insertDB_taskStatus(intval($_POST[$rowId."_c3"]), $_POST[$rowId."_c0"]);
						$action =  "update";
					}
				}*/
				
				$task = str_replace("  "," ",$_POST[$rowId."_c2"]);
				$task = str_replace("  "," ",$task);
				
				$registry->mTaskStatus->updateDB_showTaskStatus($_POST[$rowId."_c0"]);
				$registry->mTaskStatus->updateDB_task($_POST[$rowId."_c0"],$task,$_POST[$rowId."_c1"],$_POST[$rowId."_c4"]);
				$registry->mTaskStatus->insertDB_taskStatus(intval($_POST[$rowId."_c3"]), $_POST[$rowId."_c0"]);
				//$registry->mTaskStatus->updateDB_taskPriority(intval($_POST[$rowId."_c4"]), $_POST[$rowId."_c0"]);

				$action = "update";
			}
		break;
	}	
	echo "<action type='".$action."' sid='".$rowId."' tid='".$newId."'/>";
	
}

echo "</data>";
?>