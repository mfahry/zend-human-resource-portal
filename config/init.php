<?php

include SITE_PATH . '/config/' . 'controllers.cfg'.EXT;
include SITE_PATH . '/config/' . 'registry.cfg'.EXT;
include SITE_PATH . '/config/' . 'router.cfg'.EXT;
include SITE_PATH . '/config/' . 'views.cfg'.EXT;
include SITE_PATH . '/dbsconf/' . 'DbConnect'.EXT;
$registry = new registry;

function __autoload($class_name) {
		$filename = $class_name. EXT;
		$file = SITE_PATH . '/model/' . $filename;

	if (file_exists($file) == false) return false;
	include ($file);
}

global $db;
$registry->db 					= ADONewConnection('mysql');
$registry->db->PConnect('localhost','root','4dm1ns3rv3r','portalnw_db');
//$registry->db->debug = true;
$registry->mUser 				= new mUser($registry);
$registry->mAbsenType 		   	= new mAbsenType($registry);
$registry->mAbsensiHarian 		= new mAbsensiHarian($registry);
//$registry->mAttendanceComment	= new mAttendanceComment($registry);
$registry->mAbsenTemp 			= new mAbsenTemp($registry);
$registry->mCalendar 		    = new mCalendar($registry);
$registry->mAbsenOut 		    = new mAbsenOut($registry);
$registry->mCalendar 		    = new mCalendar($registry);
$registry->mTask				= new mTask($registry);
//$registry->mTaskComment			= new mTaskComment($registry);
$registry->mComment				= new mComment($registry);
$registry->mProfile				= new mProfile($registry);
$registry->mKnowledge				= new mKnowledge($registry);
$registry->mStatus				= new mStatus($registry);
$registry->mCategoryList		= new mCategoryList($registry);
//$registry->mPolling				= new mPolling($registry);
//$registry->mWallComment			= new mWallComment($registry);
$registry->mKnowledge			= new mKnowledge($registry);
//$registry->mKnowledgeComment	= new mKnowledgeComment($registry);
$registry->mNewsCategory		= new mNewsCategory($registry);
$registry->mTaskStatus			= new mTaskStatus($registry);
$registry->mUpload				= new mUpload($registry);
$registry->mDocument			= new mDocument($registry);
$registry->mFeedback			= new mFeedback($registry);

?>
