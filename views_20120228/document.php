<?php
mysql_connect('localhost','root','4dm1ns3rv3r');
mysql_select_db('portalnw_db');

$id = $_POST['id'];

$sql = "SELECT u.user_id, u.nick_name, a.file_name, a.original_file_name, a.file_type, a.uploaded_by, a.uploaded_dtm, b.folder_id, b.folder_name, b.folder_parent
		FROM user u JOIN file_kerja a ON a.uploaded_by = u.user_id 
		LEFT JOIN folder_kerja b ON b.folder_id = a.folder_id 
		WHERE a.folder_id = '".$id."' ORDER BY a.file_name";
//$sql = "SELECT * FROM file_kerja WHERE folder_id='$id' ORDER BY file_name";

$query = mysql_query($sql);
$recordCount = mysql_num_rows($query);

if($recordCount>0){
?>
	<script>
	$(function(){
		$(".filelist").mouseover(function(){
			$(this).css({'background-color': '#eee'});
		}).mouseout(function(){
			$(this).css({'background-color': '#fff'});
		});
		
		/*
		  1 = Left   Mousebutton
		  2 = Centre Mousebutton
		  3 = Right  Mousebutton
		*/

		/*$('.filelist').mousedown(function(e) {
			if (e.which === 3) {
				//alert(e.which)
				$('.vmenu').show();
			}
		}).mouseout(function(){
			$('.vmenu').hide();
		});*/
		
		$('.filelist').bind('contextmenu',function(e){
			$(".overlay").remove();
			
			$('<div class="overlay"></div>').css({
				left : '0px', top : '0px',position: 'abolute', 
				width: '100%', height: '100%', zIndex: '100', 
				border: '1px solid #ccc'
			}).click(function() {
				$(".overlay").remove();
			}).bind('contextmenu' , function(){
				return false;
			}).appendTo(this);
			
			$('.vmenu').show();

			return false;
		});

		$('.vmenu .first_li').live('click',function() {
			//var id = $('.filelist').;
			alert($(this).children().text());
			$('.vmenu').hide();
			$('.overlay').remove();
		});
	});
	</script>
	<style>
	.vmenu{ border:1px solid #aaa;position:absolute;background:#fff;display:none;font-size:11px;}
	.vmenu .first_li span{width:100px;display:block;padding:5px 10px;cursor:pointer}
	</style>
<?
	echo "<table><tr>";
	$i=1;
	while($row = mysql_fetch_object($query)){
		$name = $row->nick_name;
		$uploadeddtm = $row->uploaded_dtm;
		$file = $row->file_name;
		$fileori = $row->original_file_name;
		$filetype = $row->file_type;		
		$folder = $row->folder_name;
		$folderparent = $row->folder_parent;
		
		if($folderparent!=0){
			$query3 = "select * from folder_kerja where folder_id=$folderparent";	
			$rs3 = mysql_query($query3);
			$row3 = mysql_fetch_object($rs3);
			
			$parent = $row3->folder_name;
			
			$folder = "$parent/$folder";
		}
		
		$locate = "upload/".$folder;
		
		echo "<td width='210' align='left' class='filelist'>";
		echo "<p><a href=\"".$locate."/".$file."\" target=\"_blank\"><img src=\"includes/img/icons/".$filetype.".png\" align=\"left\" border='0' />";
		echo $fileori;
		echo "<br /><i style='font-size:10px;'>Upload By: $name";
		echo "<br />$uploadeddtm</i>";
		echo "</a></p></td>";
		
		if($i%3==0) echo "</tr>";
		else echo "";
		
		$i++;
	}
	echo "</table>";
	?>	
	<div class="vmenu">
		<div class="first_li"><span>Delete</span></div>
	</div>
	<?php
}else{
	echo 'no';
}
?>