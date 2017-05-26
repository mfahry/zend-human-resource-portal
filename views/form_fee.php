<?php
require_once("../dbsconf/DbConnect.php"); 
global $CONN;

$userid = $_POST['userid'];
$act 	= $_POST['act'];
$id 	= $_POST['id'];

if($userid){
	$sql = "SELECT * FROM gaji WHERE user_id='$userid' AND end_dtm='0000-00-00 00:00:00' ORDER BY gaji_id DESC";
	$rs = $CONN->Execute($sql);
	
	if($rs){
		$gapok = $rs->fields['g_pokok'];
		$tKes = $rs->fields['g_tunjKesehatan'];
		$tTrans = $rs->fields['g_transportasi'];
		$tJab = $rs->fields['g_tunjJabatan'];
		$tKom = $rs->fields['g_tunjKomunikasi'];
	}
}

if($id){
	$sql2 = "SELECT * FROM m_gaji WHERE mgaji_id='$id'";
	$rs2 = $CONN->Execute($sql2);
	
	if($rs2){
		$mg_desc = $rs2->fields['mg_desc'];
		$mg_value = $rs2->fields['mg_value'];
	}
}
?>
<script type="text/javascript" src="includes/js/validasi.js"></script>
<style>
#tblFee table{
	border:1px solid #fff;
	border-collapse:collapse;
}
#tblFee table th{
	border:1px solid #ccc;
	border-collapse:collapse;
	background:#fff;
	color:#000;
	font-size:13px;
	font-weight:bold;
	padding:5px 0;
}
#tblFee table td{
	border:1px solid #fff;
	border-collapse:collapse;
	padding:2px 3px;
	color:#fff;
}
</style>
<script>
<?php
if($act=='edit'){
	?>
	$("#tblFee").hide();
	$("#formFee").show();
	
	$("#dialogFee").dialog({
		buttons	: {
			"Simpan":function(){
				param = 'mg_desc='+$("#mg_desc").val()+'&mg_value='+$("#mg_value").val();
				param += '&act=edit&id=<?=$id?>';
				
				$.ajax({
					type	: 'post',
					url		: 'views/form_fee_act.php',
					data	: param,
					success	: function(msg){
						if(msg=='ok'){
							alert('Data fee sudah disimpan.');
							$("#dialogFee").dialog("close");
							setFee();
						}else{
							alert(msg);
						}
					}
				});
			},
			"Daftar":function(){
				$("#dialogFee").dialog("close");
				setFee();
			},
			"Tutup":function(){
				$("#dialogFee").dialog("close");
			}
		}
	});
	<?php
}else{
	?>
	$("#formFee").hide();
	$("#tblFee").show();
	
	$("#dialogFee").dialog({
		buttons	: {
			"Tambah":function(){
				$("#tblFee").hide();
				$("#formFee").show();
				
				$("#dialogFee").dialog({
					buttons	: {
						"Simpan":function(){
							param = 'mg_desc='+$("#mg_desc").val()+'&mg_value='+$("#mg_value").val();
							
							$.ajax({
								type	: 'post',
								url		: 'views/form_fee_act.php',
								data	: param,
								success	: function(msg){
									if(msg=='ok'){
										alert('Data fee sudah disimpan.');
										$("#dialogFee").dialog("close");
									}else{
										alert(msg);
									}
								}
							});
						},
						"Daftar":function(){
							$("#dialogFee").dialog("close");
							setFee();
						},
						"Tutup":function(){
							$("#dialogFee").dialog("close");
						}
					}
				});
			},
			"Tutup":function(){
				$("#dialogFee").dialog("close");
			}
		}	
	});
	<?php
}
?>
</script>
<div id="tblFee">
	<table>
		<tr>
			<th width="40" align="center">No.</th>
			<th width="250" align="center">Deskripsi</th>
			<th width="80" align="center">Nilai</th>
			<th width="80" align="center">Edit</th>
		</tr>
		<?php
			$query = "select * from m_gaji where end_dtm='0000-00-00 00:00:00'";
			$data = $CONN->Execute($query);
			$i=1;
			while(!$data->EOF){
				echo "<tr>
					<td align='right'>$i</td>
					<td>".$data->fields['mg_desc']."</td>
					<td align='right'>".number_format($data->fields['mg_value'], 0, '', '.')."</td>
					<td align='center'><a href='javascript:void(0);' onclick=\"setFee('edit',".$data->fields['mgaji_id'].")\">Edit</a> | 
					<a href='javascript:void(0);' onclick=\"setFee('del',".$data->fields['mgaji_id'].")\">Delete</a></td>
				</tr>";
				$data->MoveNext();
				$i++;
			}
		?>
	</table>
</div>
<div id="formFee">
<form method="post" action="">
<div style="width:300px;display:block;">
	<div style="width:100px;float:left;padding:2px;">
		Keterangan Fee
	</div>
	<div style="width:170px;float:left;padding:2px;">
		: <input id="mg_desc" value="<?=$mg_desc?>" style="width:150px;border:1px solid #ccc;padding:0 5px;text-transform:uppercase;" />
	</div>
	<div style="clear:both;"></div>
	<div style="width:100px;float:left;padding:2px;">
		Nilai Fee
	</div>
	<div style="width:170px;float:left;padding:2px;">
		: <input id="mg_value" value="<?=$mg_value?>" style="width:100px;border:1px solid #ccc;text-align:right;padding:0 5px;" onkeyup="valid(this,'numbers')" onblur="valid(this,'numbers')" />
	</div>
	<div style="clear:both;"></div>
</div>
</form>
</div>