<?php
if(isset($_GET['mod'])){
	$url = explode('/',$_GET['mod']);
	
	if(isset($url[0])){
		if($url[0] == 'attendance') $tabActive = 'attendance';
		elseif($url[0] == 'knowledge') $tabActive = 'knowledge';
		elseif($url[0] == 'recommendation') $tabActive = 'recommendation';
		elseif($url[0] == 'staffing') $tabActive = 'staffing';	
		elseif($url[0] == 'document') $tabActive = 'document';	
		elseif($url[0] == 'reporting') $tabActive = 'reporting';
		elseif($url[0] == 'setting') $tabActive = 'setting';
		elseif($url[0] == 'feedback') $tabActive = 'feedback';
		elseif($url[0] == 'index'){
			if(isset($url[1])){
				if($url[1] == 'about') $tabActive = 'about';
				elseif($url[1] == 'contact') $tabActive = 'contact'; 
				elseif($url[1] == 'login') $tabActive = 'home'; 
				elseif($url[1] == 'logout') $tabActive = 'home'; 
			}else{
				$tabActive = 'home';
			}
		}else $tabActive = 'home';
	} 
	 
	
}else{
	$tabActive = 'home';
}
?>
<div style="float:left;">
<ul id="nav">
	<li><a href="index.php" title="home" class="home <?php echo ($tabActive=='home')?'active':''; ?>">Home</a></li>

	<?php 
	if (isset($_SESSION['userid'])){
		if($_SESSION['level_id'] == 3){ //team
	?>
	<li><a href="index.php?mod=attendance" title="Absensi" class="attendance <?php echo ($tabActive=='attendance')?'active':''; ?>">Attendance</a></li>
	<li><a href="index.php?mod=reporting" title="Laporan Absen" class="reporting <?php echo ($tabActive=='reporting')?'active':''; ?>">Reporting</a></li>
	<li><a href="index.php?mod=recommendation" title="Organization" class="recommendation <?php echo ($tabActive=='recommendation')?'active':''; ?>">Organization</a></li>
	<li><a href="index.php?mod=knowledge" title="Knnowledge" class="knowledge <?php echo ($tabActive=='knowledge')?'active':''; ?>">Knowledge</a></li>
    <li><a href="index.php?mod=feedback" title="Feedback" class="feedback <?php echo ($tabActive=='feedback')?'active':''; ?>">Feedback</a></li>
	
	<?php 
		}elseif($_SESSION['level_id'] == 2){ //hrd
	?>
	<li><a href="index.php?mod=staffing" title="employee" class="staffing <?php echo ($tabActive=='staffing')?'active':''; ?>">Staffing</a></li>
	<li><a href="index.php?mod=reporting" title="Laporan Absen" class="reporting <?php echo ($tabActive=='reporting')?'active':''; ?>">Reporting</a></li>
	<li><a href="index.php?mod=recommendation" title="Organization" class="recommendation <?php echo ($tabActive=='recommendation')?'active':''; ?>">Recommendation</a></li>
    <li><a href="index.php?mod=document" title="Documentation" class="document <?php echo ($tabActive=='document')?'active':''; ?>">Document</a></li>
	<li><a href="index.php?mod=knowledge" title="Knnowledge" class="knowledge <?php echo ($tabActive=='knowledge')?'active':''; ?>">Knowledge</a></li>
    <li><a href="index.php?mod=feedback" title="Feedback" class="feedback <?php echo ($tabActive=='feedback')?'active':''; ?>">Feedback</a></li>
	<!--<li><strong><a href="index.php?mod=absen/statusAbsenRecomend" title="Status Rekomendasi">Status Rekomendasi Absen</a></strong></li>!-->
	
	<?php
		}elseif($_SESSION['level_id'] == 1){ //admin
	?>
	<li><a href="index.php?mod=staffing" title="employee" class="staffing <?php echo ($tabActive=='staffing')?'active':''; ?>">Staffing</a></li>
	<li><a href="index.php?mod=setting" title="setting" class="setting <?php echo ($tabActive=='setting')?'active':''; ?>">Setting</a></li>
	<li><a href="index.php?mod=knowledge" title="Knnowledge" class="knowledge <?php echo ($tabActive=='knowledge')?'active':''; ?>">Knowledge</a></li>
	
	<?php
		}
	?>
	<?php
	}else{ // guest ?>
	<li><a href="index.php?mod=knowledge" title="Knnowledge" class="knowledge <?php echo ($tabActive=='knowledge')?'active':''; ?>">Knowledge</a></li>
	<li><a href="index.php?mod=index/about" title="Abous us" class="about <?php echo ($tabActive=='about')?'active':''; ?>">About</a></li>
	<li><a href="index.php?mod=index/contact" title="contact" class="contact <?php echo ($tabActive=='contact')?'active':''; ?>">Contact</a></li>
	<?php
	}
	?>
</ul>
</div>