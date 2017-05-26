<style>
#folderList ul{
	list-style-type:none;
	padding-left: 12px;
	margin-left: 12px;
}
.foldLi{
	clear: left;
	float:left;
}
.foldLi a:link, a:visited{
	text-decoration: none;
	font-size: 12px;
	color: #006;
}
.foldLi a:hover, a:active{
	text-decoration: underline;
	font-size: 12px;
	color: #600;
}

.foldLi2 a:link, a:visited{
	text-decoration: underline;
	font-weight:bold;
	color: #F00;
}

.filelist{
	padding:5px;
}
.fileList a:link, a:visited{
	text-decoration: none;
	font-size: 12px;
	color: #006;
}
.fileList a:hover, a:active{
	text-decoration: underline;
}
</style>
<script language="javascript">
function openTree(id){	
	var elm = $('ul[parent='+id+']');
	
	if(elm != undefined){
		if(elm.css('display') == 'none'){
			elm.show();
			$('#img'+id).attr('src','includes/img/folderopen.jpg');
		}else{
			elm.hide();
			$('#img'+id).attr('src','includes/img/folderclose2.jpg');
		}
	}
}

function openFolder(id){
	$(".foldLi").removeClass('foldLi2');	
	$('li[folder='+id+']').addClass('foldLi2');
	$.ajax({
		type	: 'post',
		url		: 'views/document.php',
		data	: 'id='+id,
		success	: function(doc){
			if(doc == 'no'){
				$("#fileList").hide();
			}else{
				$("#fileList").show();
				$("#fileList").html(doc);
			}
		}
	});
}
</script>
 
<?php
function loop($data,$parent){
	if(isset($data[$parent])){
		$str = '<ul parent="'.$parent.'" '.($parent>0?'style="display:none;"':'').'>'."\n";
		foreach($data[$parent] as $value){
			$child = loop($data,$value->folder_id); 
			$str .= '<li class="foldLi" folder="'.$value->folder_id.'">';
			$str .= ($child) ? '<a href="javascript:void(0);" onclick="javascript:openTree('.$value->folder_id.')"><img src="includes/img/folderclose2.jpg" id="img'.$value->folder_id.'" border="0"></a>' : '<img src="includes/img/folderclose1.jpg">';
			$str .= ($child) ? '<a href="javascript:void(0);" onclick="javascript:openTree('.$value->folder_id.')">'.$value->folder_name.'</a>'."\n":'<a href="javascript:void(0);" onclick="openFolder('.($value->folder_id).');">'.$value->folder_name.'</a></li>'."\n";
			if($child) $str .= $child;
		}
		$str .= ($child) ? "</ul>\n":"</ul>\n</li>\n";
		return $str;
	}else return false;	  
}

mysql_connect('localhost','root','4dm1ns3rv3r');
mysql_select_db('portalnw_db');

$query = mysql_query('SELECT * FROM folder_kerja ORDER BY folder_name');
$data = array();
while($row = mysql_fetch_object($query)){
	$data[$row->folder_parent][] = $row;
}
?>
<div style="width:900px;height:auto !important;">
	<div style="width:200px;float:left;" id="folderList">
	<?php
	echo loop($data,0);
	?>
	</div>
	<div style="width:680px;float:right;" id="fileList"></div>
</div>