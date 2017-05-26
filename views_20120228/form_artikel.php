<script>
$(function(){
	$("#searchbar").watermark('watermark','Search Knowledge');
});
</script>
<style>
.watermark{
	color:#555;
	font-style:italic;
}
</style>
<div  width="800px" style="float:right;">
<form name="formsearchknowledge" method="post" action="index.php?mod=knowledge/test">
  <table>
    <tr>
      <td><input type="text" name="searchbar" id="searchbar" value="<?php echo $_POST['searchbar'];?>" size="40"/></td>
      <td><input type="submit" name="submitsearch" class="btn" value="Search"/></td> 
    </tr>
  </table>
</form>
</div>
<div><br /><br /><br /></div>
<?php 
$detail = 'no';
if($this->registry->mUser->isLoggedOn()==TRUE){ 
?>
	<link rel="stylesheet" type="text/css" href="includes/dhtmlx/dhtmlxWindows/dhtmlxwindows.css">
	<link rel="stylesheet" type="text/css" href="includes/dhtmlx/dhtmlxWindows/skins/dhtmlxwindows_dhx_skyblue.css">
	<script src="includes/dhtmlx/dhtmlxWindows/dhtmlxcommon.js"></script>
	<script src="includes/dhtmlx/dhtmlxWindows/dhtmlxwindows.js"></script>
	<script src="includes/dhtmlx/dhtmlxWindows/dhtmlxcontainer.js"></script>

	<!--<div style="width:100px;float:right;">
		<a class="btn" href="index.php?mod=knowledge/addKnowledge">Tulis Knowledge</a>
	</div>-->
	<?php
}
$url = isset($_GET['mod'])? explode('/',$_GET['mod']):'';
echo '<ol class="mpart">';
if(count($knowledge)>0){
	foreach($knowledge as $artikel){
		
		$queryCom = mysql_query("SELECT * FROM comment where identifier='knowledge-comment' and parent_id='".$artikel->KNOWLEDGE_ID."'");
		$comRec = mysql_num_rows($queryCom);
		
		if($this->registry->mUser->isLoggedOn()==TRUE && $artikel->CAT_ID == 5){
			echo '<li style="padding-top:10px;">';	
			echo '<h2><a href="index.php?mod=knowledge/detail/'.$artikel->CAT_ID.'/'.$artikel->KNOWLEDGE_ID.'">'.$artikel->JUDUL.'</a></h2>';
			echo '<div class="date">
					<h3 style="float:left;">
						Posted by : '.$artikel->UNAME.' on '.$artikel->DATE.' 
						in <a href="index.php?mod=knowledge/category/'.$artikel->CAT_ID.'">'.$artikel->CAT_NAME.'</a> ';
			echo "($comRec Comments)";
							
			if($artikel->FILE!="")
				echo ", File : <a href=\"includes/File/".$artikel->FILE."\" target=\"_blank\" > ".$artikel->FILE." </a>";
			
			echo '	</h3>    	
				<div class=".clear"></div>';
			if((isset($_SESSION['userid'])&&($_SESSION['userid']==$artikel->USER_ID))||((isset($_SESSION['level_id'])&& $_SESSION['level_id']==2)||(isset($_SESSION['level_id'])&& $_SESSION['level_id']==1))){
				echo "<div style='float:right;'>";
				echo "	<a href=\"index.php?mod=knowledge/DeleteKnowledge/".$artikel->KNOWLEDGE_ID."\" onClick = \"return confirm('Hapus knowledge ini?')\">Delete</a>";
				echo "  <a href=\"index.php?mod=knowledge/ShowUpdateKnowledge/".$artikel->KNOWLEDGE_ID."\">Update</a>";
				echo "</div>";
			}	
			echo	'	</div>';
			if(isset($url[1]) && $url[1]=='detail'){
				echo $artikel->DESKRIPSI;
				$detail = 'ok';
			}else
				echo $this->registry->mKnowledge->shortAlinea($artikel->DESKRIPSI,'','<br><br><a href="index.php?mod=knowledge/detail/'.$artikel->CAT_ID.'/'.$artikel->KNOWLEDGE_ID.'"> Selengkapnya...</a>',500)."<br><hr>";
			echo "</li>";
		}elseif($artikel->CAT_ID != 5){
			echo '<li style="padding-top:10px;display:block;height:auto !important;">';	
			echo '<h2><a href="index.php?mod=knowledge/detail/'.$artikel->CAT_ID.'/'.$artikel->KNOWLEDGE_ID.'">'.$artikel->JUDUL.'</a></h2>';
			echo '<div class="date">
					<h3 style="float:left;">
						Posted by : '.$artikel->UNAME.' on '.$artikel->DATE.' 
						in <a href="index.php?mod=knowledge/category/'.$artikel->CAT_ID.'">'.$artikel->CAT_NAME.'</a> ';
			echo "(<a href=\"index.php?mod=knowledge/detail/".$artikel->CAT_ID."/".$artikel->KNOWLEDGE_ID."#comment\">$comRec Comments</a>)";
			
			if($artikel->FILE!="")
				echo ", File : <a href=\"includes/File/".$artikel->FILE."\" target=\"_blank\" > ".$artikel->FILE." </a>";
			
			echo '	</h3>    	
				<div class="clear"></div>';
			if((isset($_SESSION['userid'])&&($_SESSION['userid']==$artikel->USER_ID))||((isset($_SESSION['level_id'])&& $_SESSION['level_id']==2)||(isset($_SESSION['level_id'])&& $_SESSION['level_id']==1))){
				echo "<div style='float:right;'>";
				echo "	<a href=\"index.php?mod=knowledge/DeleteKnowledge/".$artikel->KNOWLEDGE_ID."\" onClick = \"return confirm('Hapus knowledge ini?')\">Delete</a>";
				echo "  <a href=\"index.php?mod=knowledge/ShowUpdateKnowledge/".$artikel->KNOWLEDGE_ID."\">Update</a>";
				echo "</div>";
			}	
			echo	'	</div>
				<div style="clear:both;"></div>';
			if(isset($url[1]) && $url[1]=='detail'){
				echo $artikel->DESKRIPSI;
				$detail = 'ok';
			}else
				echo $this->registry->mKnowledge->shortAlinea(str_replace('<img','<img height="100"',$artikel->DESKRIPSI),'','<br><br><a href="index.php?mod=knowledge/detail/'.$artikel->CAT_ID.'/'.$artikel->KNOWLEDGE_ID.'"> Selengkapnya...</a>',500)."<br><hr>";
			echo "</li>";
		}
	}
}else echo "Data knowledge kosong";
echo '</ol>';

if($detail == 'ok'){
echo "<br />";
echo "<div style=\"clear:both;background:#ddd;width:100%;height:auto !important;padding:5px;\">";
echo "<a name=\"comment\">Komentar:</a><br />";
$i=1;
while($rCom = mysql_fetch_object($queryCom)){
	
	$cnt = explode('~',$rCom->content);
	
	$comSender = $cnt[0];
	$content = $cnt[1];

	$qUsr = mysql_query("SELECT name FROM user WHERE user_id='".$comSender."'");
	$rUsr = mysql_fetch_object($qUsr);
	
	echo "<div style='width:100%;padding:10px 0; border-top:1px dotted #333;'>";
	echo "<b><span style='font-size:11px;font-style:italic;'>$i. ".$rUsr->name." ".$rCom->input_dtm."</span></b><br />";
	echo $content;
	//echo "<div style=''></div>";
	echo "</div>";
	$i++;
}

$url = $_SERVER['REQUEST_URI'];

if((isset($_SESSION['userid']))||((isset($_SESSION['level_id'])&& $_SESSION['level_id']==2)||(isset($_SESSION['level_id'])&& $_SESSION['level_id']==1))){
	echo '<form name="frmStatus" id="frmStatus">';
	echo '<div class="wrapTstatus"><a name="comLast">Tambah Komentar</a><br />
			<textarea name="comment" id="tstatus" style="width:508px;"></textarea>
			<input type="button" value="Simpan" id="btnstatus" name="saveComment" class="btn" />
		  </div>';
	echo '</form>';
	?>
	<script>
	$("input[name=saveComment]").click(function(){
		txt = $("textarea[name=comment]").val();
		if(txt == ''){
			alert('komentar nya manaaaa....?????');
			$("textarea[name=comment]").focus();
		}else{
			param = 'kl_id=<?=$artikel->KNOWLEDGE_ID?>';
			param += '&idf=knowledge-comment';
			param += '&usrid=<?=$artikel->USER_ID?>';
			param += '&com='+txt;
			
			$.ajax({
				type	: 'post',
				url		: 'views/commentAdd.php',
				data	: param,
				success	: function(msg){
					if(msg=='ok'){
						alert('Komentar anda sudah tersimpan.');
						location.href="<?=$url?>#comLast";
						location.reload();
					}else{
						alert(msg);
					}
				}
			});
		}
	});
	</script>
	<?php
}
echo "</div>";
}

if (isset($url[1])){
	if($url[1] == 'addKnowledge'){
		$this->registry->view->show('form_upload_knowledge');
	}
	if($url[1] == 'ShowUpdateKnowledge'){
		$id=$url[2];
		$this->registry->view->knowledge = $this->registry->mKnowledge->ShowToEdit($id);
		$this->registry->view->show('form_update_knowledge');
	}
}
?>