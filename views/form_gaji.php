<?php
require_once("../dbsconf/DbConnect.php"); 
global $CONN;

$userid = $_POST['userid'];

if($userid){
	$sql = "SELECT * FROM gaji WHERE user_id='$userid' AND end_dtm='0000-00-00 00:00:00' ORDER BY gaji_id DESC";
	$rs = $CONN->Execute($sql);
	
	if($rs){
		$gapok = $rs->fields['g_pokok'];
		$tKes = $rs->fields['g_tunjKesehatan'];
		$tTrans = $rs->fields['g_transportasi'];
		$tJab = $rs->fields['g_tunjJabatan'];
		$tKom = $rs->fields['g_tunjKomunikasi'];
		$rapat = $rs->fields['g_tunjRapat'];
		$iuranharitua = $rs->fields['g_iuranharitua'];
	}
}
?>
<script type="text/javascript" src="includes/js/validasi.js"></script>
<div>
<form method="post" action="">
<div style="width:300px;display:block;">
	<div style="width:175px;float:left;padding:2px;">
		Gaji Pokok
	</div>
	<div style="width:110px;float:left;padding:2px;">
		: <input id="gapok" value="<? echo $gapok?>" style="width:100px;border:1px solid #ccc;text-align:right;padding:0 5px;" onkeyup="valid(this,'numbers')" onblur="valid(this,'numbers')" />
	</div>
	<div style="clear:both;"></div>
	<div style="width:175px;float:left;padding:2px;">
		Tunjangan Jabatan
	</div>
	<div style="width:110px;float:left;padding:2px;">
		: <input id="tJab" value="<? echo $tJab?>" style="width:100px;border:1px solid #ccc;text-align:right;padding:0 5px;" onkeyup="valid(this,'numbers')" onblur="valid(this,'numbers')" />
	</div>
	<div style="clear:both;"></div>
	<div style="width:175px;float:left;padding:2px;">
		Tunjangan Kesehatan
	</div>
	<div style="width:110px;float:left;padding:2px;">
		: <input id="tKes" value="<? echo $tKes?>" style="width:100px;border:1px solid #ccc;text-align:right;padding:0 5px;" onkeyup="valid(this,'numbers')" onblur="valid(this,'numbers')" />
	</div>
	<div style="clear:both;"></div>
	<div style="width:175px;float:left;padding:2px;">
		Tunjangan Komunikasi
	</div>
	<div style="width:110px;float:left;padding:2px;">
		: <input id="tKom" value="<? echo $tKom?>" style="width:100px;border:1px solid #ccc;text-align:right;padding:0 5px;" onkeyup="valid(this,'numbers')" onblur="valid(this,'numbers')" />
	</div>
	<div style="clear:both;"></div>
	<div style="width:175px;float:left;padding:2px;">
		Tunjangan Transportasi
	</div>
	<div style="width:110px;float:left;padding:2px;">
		: <input id="tTrans" value="<? echo $tTrans?>" style="width:100px;border:1px solid #ccc;text-align:right;padding:0 5px;" onkeyup="valid(this,'numbers')" onblur="valid(this,'numbers')" />
	</div>
	<div style="clear:both;"></div>
	<div style="width:175px;float:left;padding:2px;">
		Uang Rapat
	</div>
	<div style="width:110px;float:left;padding:2px;">
		: <input id="rapat" value="<? echo $rapat?>" style="width:100px;border:1px solid #ccc;text-align:right;padding:0 5px;" onkeyup="valid(this,'numbers')" onblur="valid(this,'numbers')" />
	</div>
	<div style="clear:both;"></div>
	<div style="width:175px;float:left;padding:2px;">
		Potongan Iuran Hari Tua
	</div>
	<div style="width:110px;float:left;padding:2px;">
		: <input id="iuranharitua" value="<? echo $iuranharitua?>" style="width:100px;border:1px solid #ccc;text-align:right;padding:0 5px;" onkeyup="valid(this,'numbers')" onblur="valid(this,'numbers')" />
	</div>
	<div style="clear:both;"></div>
</div>
</form>
</div>
<script>
$("#dialogGaji").dialog({
	buttons	: {
		"Simpan":function(){
			param = 'userid=<? echo $_POST['userid'];?>&gapok='+$("#gapok").val();
			param += '&tJab='+$("#tJab").val()+'&tKes='+$("#tKes").val();
			param += '&tKom='+$("#tKom").val()+'&tTrans='+$("#tTrans").val()+'&rapat='+$("#rapat").val();
			param += '&iuranharitua='+$("#iuranharitua").val();
			$.ajax({
				type	: 'post',
				url		: 'views/form_gaji_act.php',
				data	: param,
				success	: function(msg){
					//$("#dialogGaji").html(msg);
					if(msg=='ok'){
						alert('Data gaji sudah disimpan.');
						$("#dialogGaji").dialog("close");
					}
				}
			});
		},
		"Tutup":function(){
			$("#dialogGaji").dialog("close");
		}
	}	
});
</script>