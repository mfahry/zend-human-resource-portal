<?php
ob_start();
?>
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<title>Neuronworks Indonesia : #Portal</title>
<link rel="shortcut icon" href="includes/img/favicon.ico" />
<meta http-equiv="Content-Language" content="English" />
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
<meta name="author" content="Neuronworks Indonesia" />
<meta name="description" content="Aplikasi portal - Neuronworks Indonesia" />
<meta name="keywords" content="portal, absensi" />
<link rel="stylesheet" type="text/css" href="<?php echo CSS_PATH;?>style.css" media="screen" />

<script type="text/javascript" src="includes/JQuery/jquery-1.4.2.js"></script>
<link rel="stylesheet" type="text/css" href="includes/JQuery/styles/vtip.css" />
<script type="text/javascript" src="includes/JQuery/script/vtip.js"></script>
<script type="text/javascript" src="includes/JQuery/jquery.watermark.js"></script>

<?php if($this->registry->mUser->isLoggedOn()==TRUE){ ?>

<script type="text/javascript" src="includes/JQuery/script/jclock.js"></script>
<script>
$(function(){
	$('#jclock').jclock({
		format: '%A %b %d, %Y %H:%M:%S' 
	});
	  
	/*setInterval(function() {  
		$(".right_side").load(location.href+" .right_side>*","").fadeIn("slow");;	
		
	}, 300000);*/
});

function waitPreloadPageIn() { //DOM
	if (document.getElementById){
		document.getElementById('prepagein').style.display='none';
		document.getElementById('html_1').style.display='block';
	}else{
		if (document.layers){ //NS4
			document.prepagein.display='none';
			document.html_1.style.display='block';
		}
		else { //IE4
			document.all.prepagein.style.display='none';
			document.all.html_1.style.display='block';
		}
	}
}
</script>
<?php } ?>

</head>

<body>
<div id="topbar">
  <div class="content">
    <div class="wrap content"> 
      <!--<form action="#" method="post">
        <div class="se">
          <input class="text" name="search" type="text" value="Search..."  onblur="if(this.value=='') this.value='Search...';" onfocus="if(this.value=='Search...') this.value='';" />
        </div>
      </form>-->
      <h1><a href="www.neuronworks.co.id" title=""><img src="<?php echo IMG_PATH;?>logonw.png" width="33%" height="73%"  align="bottom"/></a></h1>
    </div>
  </div>
</div>
<div id="subbar" style="background-color:#eeeeee">
  <div class="content"> 
    <?php 
		$this->registry->view->show("menu_main");
		if($this->registry->mUser->isLoggedOn()==TRUE){ //jika login
	?>
      <div class="usermenu"> <a href="index.php?mod=profile" title="Profile"><?php echo $_SESSION['username']; ?></a> &nbsp;<a href="index.php?mod=index/logout" class="vtip logbutton" title="Logout">&nbsp; &Phi; &nbsp;</a> </div>
      <?php }else{ ?>
      <div class="usermenu"> Login&nbsp;<a href="index.php?mod=index/login" class="vtip logbutton login" title="Login">&nbsp; &Phi; &nbsp;</a> </div>
      <?php } ?>
      <div style="clear:both"></div> 
  </div>
</div>

<?php if($this->registry->mUser->isLoggedOn()==TRUE){ ?>
<div class="content">
  <div id="main" style="height:40px">
    <div style="padding-left:10px; float:left; width:160px"> <font color="#DD0000"><b>Employee of the week :</b></font> <img src="<?php echo IMG_PATH;?>Star.png" width="18" height="15"/>&nbsp;Mr. Phitias Dasa P
    </div>
    <div><!--20110608: new dashboard-->
	<?php 
		$datamq = $this->registry->mTask->display_marques();
			if(count($datamq)>0){				
				foreach($datamq as $data){ 
	?>
	<marquee class="box" style="width:540px;color:#FF0000;" scrolldelay="140" onMouseOver="this.stop()" onMouseOut="this.start()"><?php echo ($data->DESCRIPTION); ?></marquee> 	
    
    <div id="jclock" style="float:right;margin-right:15px;font-weight:bold;"></div>
    <div style="clear:both"></div>
    <?php 
				}
			}
	?></div><!--div for marque-->
  </div>
</div>

<?php }else{?>
<div class="content">
  <div id="main" style="vertical-align:middle; padding-top:10px; padding-bottom:7px; background-color:#000000; text-align:center"> <img src="<?php echo IMG_PATH;?>header.jpg" width="913"/> </div>
</div>
<?php } ?>
<div class="content">
  <div id="main">
    <div class="padding">
      <div class="right_side">
<?php 
	if(isset($_GET['mod'])) $url = explode('/',$_GET['mod']);
		
	/*if ( (isset($url[0])&&$url[0]!='staffing')&&(isset($url[0])&&$url[0]!='reporting')&&(isset($url[0])&&$url[0]!='recommendation')&&
	(isset($url[0])&&$url[0]!='setting')&&(isset($url[0])&&$url[0]!='document')|| (!isset($url[0])) ){*/
	if ( (isset($url[0])&&$url[0]!='staffing')&&(isset($url[0])&&$url[0]!='reporting')&&(isset($url[0])&&$url[0]!='recommendation')&&
	(isset($url[0])&&$url[0]!='setting')&&(isset($url[0])&&$url[0]!='document')|| (!isset($url[0])) ){
 			
		if($this->registry->mUser->isLoggedOn()==TRUE){
			$this->registry->view->show('form_notification');
			
 			if ($_SESSION['level_id']==3)
 				$this->registry->view->show('form_currentTask');
							
		}
		if($this->registry->mUser->isLoggedOn() && (isset($url[0])&&$url[0]=='knowledge')){
			echo '<h3>Tools</h3>';
			echo '<ul>';
			echo '<li><a href="index.php?mod=knowledge/addKnowledge">Tulis Knowledge</a></li>';
			echo  '</ul>';
		}
		if(isset($url[0])&&$url[0]=='knowledge') $this->registry->view->show('form_categoryKnowledge'); 
		else{
			if($this->registry->mUser->isLoggedOn()==false)
				$this->registry->view->show('form_categoryKnowledge');
				
			$this->registry->view->show('form_newKnowledge'); 
		}
	} 
	/*if(isset($_SESSION['userid']) && $_SESSION['level_id'] == 3){
		$ada = $this->registry->mPolling->PollingBelumAda();
		if($ada != 0){
			$this->registry->view->show('view_pilih_polling'); 
		}
	}*/
?>
      </div>
      <div id="left_side">
        <div class="intro">
          <div class="pad">
            <?php
				  if(isset($confirm)) $this->registry->view->show($confirm);
				  if(isset($subContent)) $this->registry->view->show($subContent);
 				  $this->registry->view->show($content);
				  
				   if($this->registry->mUser->isLoggedOn()==TRUE){
						$user_id		= $_SESSION['userid'];
						$session_stat	= 1;
						$session_id		= session_id();
						
						/*
						$logOut     = $this->registry->mUser->cekAutomaticallyLogout($_SESSION['userid']);
						$expLogOut = explode("#",$logOut);
						
						if (($logOut!= NULL) && ($expLogOut[1]!="")){ 
							if ($expLogOut[1] == $_SERVER['REMOTE_ADDR']){
								$this->registry->mUser->delete_sessionLog($_SESSION['userid'], 1, $logOut);
								$this->registry->mUser->doLogout(); 
							}	 
						}*/
						echo '<meta http-equiv="refresh" content="3600;url=index.php?mod=index/logout">';
				   }else{
						$user_id		= 'guest';
						$session_stat	= 0;
						$session_id		= 0;
					}
				  $this->registry->mUser->insert_sessionLog($session_id,$user_id,$session_stat);
			 ?>
          </div>
        </div>
      </div>
      
  <?php if(isset($url[1]) && $url[1]=='detail'){
	$this->registry->view->show('slider_knowledge');
}
?>    
    </div>
    <div class="clear"></div>
  </div>
  <div id="footer"><br />
    &copy; Copyright <?php echo date('Y'); ?>, Neuronworks Indonesia </div>
</div>
</body>
</html>