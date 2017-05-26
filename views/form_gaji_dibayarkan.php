<?php
require_once("../dbsconf/DbConnect.php"); 
global $CONN;

$userid = $_POST['userid'];

$sql = "SELECT gaji_id,(g_pokok+g_tunjKesehatan+g_transportasi+g_tunjJabatan+g_tunjKomunikasi) gapok,g_tunjRapat,g_iuranharitua FROM gaji WHERE user_id='$userid' AND end_dtm='0000-00-00 00:00:00' ORDER BY gaji_id DESC";
$rs = $CONN->Execute($sql);

if($rs){
	$gapok = $rs->fields['gapok'];
	$rapat = $rs->fields['g_tunjRapat'];
	$iuran = $rs->fields['g_iuranharitua'];
}
$sql2 = "SELECT * FROM m_gaji WHERE end_dtm='0000-00-00 00:00:00'";
$rs2 = $CONN->Execute($sql2);

$m = 1;
while(!$rs2->EOF){
	/* $mgaji_id = $rs2->fields['mgaji_id'];
	$mg_desc = $rs2->fields['mg_desc'];
	$mg_value = $rs2->fields['mg_value']; */
	
	if($rs2->fields['mgaji_id'] == 1){
		$spj1 = $rs2->fields['mg_value'];
	}
	if($rs2->fields['mgaji_id'] == 2){
		$spj2 = $rs2->fields['mg_value'];
	}
	if($rs2->fields['mgaji_id'] == 3){
		$spj3 = $rs2->fields['mg_value'];
	}
	if($rs2->fields['mgaji_id'] == 4){
		$spj4 = $rs2->fields['mg_value'];
	}
	if($rs2->fields['mgaji_id'] == 5){
		$spj5 = $rs2->fields['mg_value'];
	}
	if($rs2->fields['mgaji_id'] == 6){
		$spj6 = $rs2->fields['mg_value'];
	}
	
	$rs2->MoveNext();
	$m++;
}
?>
<script type="text/javascript" src="includes/js/validasi.js"></script>
<div>
<form method="post" action="">
<div style="width:400px;display:block;">
	<div style="width:175px;float:left;padding:2px;">
		Periode
	</div>
	<div style="width:200px;float:left;padding:2px;">
		: 
		<select id="bulan" name="bulan">
		<?php
		for($i=1;$i<=12;$i++){
			$m = date("m", mktime(0, 0, 0, ($i+1), 0, 0));//date("m");
			$M = date("M", mktime(0, 0, 0, ($i+1), 0, 0));//date("M");
			echo "<option value='$m'".(date("m")==$m?" selected":"").">$M</option>\n";
		}
		?>
		</select> 
		<select id="tahun" name="tahun">
		<?php
		for($y=(date("Y")-2);$y<=(date("Y")+2);$y++){
			echo "<option".(date("Y")==$y?" selected":"").">$y</option>\n";
		}
		?>
		</select>
	</div>
	<div style="clear:both;"></div>
	<div style="width:175px;float:left;padding:2px;">
		Gaji Bulanan
	</div>
	<div style="width:200px;float:left;padding:2px;">
		: <input id="gajibulanan" value="<? echo $gapok?>" readonly="readonly" style="border:1px solid #ccc;text-align:right;padding:0 5px;" onkeyup="valid(this,'numbers')" onblur="valid(this,'numbers')" />
	</div>
	<div style="clear:both;"></div>
	<div style="width:175px;float:left;padding:2px;">
		Potongan Koperasi
	</div>
	<div style="width:200px;float:left;padding:2px;">
		: <input id="potonganKoperasi" placeholder="0" value="<? echo $pKop?>" style="border:1px solid #ccc;text-align:right;padding:0 5px;" onkeyup="valid(this,'numbers')" onblur="valid(this,'numbers')" />
	</div>
	<div style="clear:both;"></div>
	<div style="width:175px;float:left;padding:2px;">
		Potongan PPH 21
	</div>
	<div style="width:200px;float:left;padding:2px;">
		: <input class="gaji" id="potonganPajak" placeholder="0" value="<? echo $pPph?>" style="border:1px solid #ccc;text-align:right;padding:0 5px;" onkeyup="valid(this,'numbers')" onblur="valid(this,'numbers')" />
	</div>
	<div style="clear:both;"></div>
	<div style="width:175px;float:left;padding:2px;">
		Potongan Iuran Hari Tua
	</div>
	<div style="width:200px;float:left;padding:2px;">
		: <input class="gaji" id="iuranharitua" placeholder="0" value="<? echo $iuran?>" style="border:1px solid #ccc;text-align:right;padding:0 5px;" onkeyup="valid(this,'numbers')" onblur="valid(this,'numbers')" />
	</div>
	<div style="clear:both;"></div>
	<div style="width:175px;float:left;padding:2px;">
		SPJ Lokal Sehari
	</div>
	<div style="width:200px;float:left;padding:2px;">
		: <input id="SPJLokal1" placeholder="0" value="" style="border:1px solid #ccc;text-align:right;padding:0 5px;width:50px;" onkeyup="valid(this,'numbers')" onblur="valid(this,'numbers')" />
		<input type="hidden" id="SPJLokal1_val" value="<?=$spj1?>" />
		Hari ( <? echo number_format($spj1, 0, '', '.')?> ) <!--a href="javascript:void(0);" onclick="setFee('edit',1)" style="font-size:11px;text-decoration:underline;">Edit</a-->
	</div>
	<div style="clear:both;"></div>
	<div style="width:175px;float:left;padding:2px;">
		SPJ Lokal Transport
	</div>
	<div style="width:200px;float:left;padding:2px;">
		: <input id="SPJLokal2" placeholder="0" value="<? echo $spjTrans?>" style="border:1px solid #ccc;text-align:right;padding:0 5px;width:50px;" onkeyup="valid(this,'numbers')" onblur="valid(this,'numbers')" />
		<input type="hidden" id="SPJLokal2_val" value="<?=$spj2?>" />
		Hari ( <? echo number_format($spj2, 0, '', '.')?> ) <!--a href="javascript:void(0);" onclick="setFee('edit',2)" style="font-size:11px;text-decoration:underline;">Edit</a-->
	</div>
	<div style="clear:both;"></div>
	<div style="width:175px;float:left;padding:2px;">
		Uang Makan
	</div>
	<div style="width:200px;float:left;padding:2px;">
		: <input id="feeMakan" placeholder="0" value="<? echo $feeMakan?>" style="border:1px solid #ccc;text-align:right;padding:0 5px;width:50px;" onkeyup="valid(this,'numbers')" onblur="valid(this,'numbers')" />
		<input type="hidden" id="feeMakan_val" value="<?=$spj4?>" />
		Hari ( <? echo number_format($spj4, 0, '', '.')?> ) <!--a href="javascript:void(0);" onclick="setFee('edit',4)" style="font-size:11px;text-decoration:underline;">Edit</a-->
	</div>
	<div style="clear:both;"></div>
	<div style="width:175px;float:left;padding:2px;">
		Pengganti Puasa
	</div>
	<div style="width:200px;float:left;padding:2px;">
		: <input id="puasa" placeholder="0" value="<? echo $puasa?>" style="border:1px solid #ccc;text-align:right;padding:0 5px;width:50px;" onkeyup="valid(this,'numbers')" onblur="valid(this,'numbers')" />
		<input type="hidden" id="puasa_val" value="<?=$spj3?>" />
		Hari ( <? echo number_format($spj3, 0, '', '.')?> ) <!--a href="javascript:void(0);" onclick="setFee('edit',3)" style="font-size:11px;text-decoration:underline;">Edit</a-->
	</div>
	<div style="clear:both;"></div>
	<div style="width:175px;float:left;padding:2px;">
		Lembur Hari Kerja
	</div>
	<div style="width:200px;float:left;padding:2px;">
		: <input id="lemburMlm" placeholder="0" value="<? echo $lemburHK?>" style="border:1px solid #ccc;text-align:right;padding:0 5px;width:50px;" onkeyup="valid(this,'numbers')" onblur="valid(this,'numbers')" />
		<input type="hidden" id="lemburMlm_val" value="<?=$spj5?>" />
		Jam ( <? echo number_format($spj5, 0, '', '.')?> ) <!--a href="javascript:void(0);" onclick="setFee('edit',5)" style="font-size:11px;text-decoration:underline;">Edit</a-->
	</div>
	<div style="clear:both;"></div>
	<div style="width:175px;float:left;padding:2px;">
		Lembur Non Hari Kerja
	</div>
	<div style="width:200px;float:left;padding:2px;">
		: <input id="lemburDayOff" placeholder="0" value="<? echo $lemburNHK?>" style="border:1px solid #ccc;text-align:right;padding:0 5px;width:50px;" onkeyup="valid(this,'numbers')" onblur="valid(this,'numbers')" />
		<input type="hidden" id="lemburDayOff_val" value="<?=$spj6?>" />
		Jam ( <? echo number_format($spj6, 0, '', '.')?> ) <!--a href="javascript:void(0);" onclick="setFee('edit',6)" style="font-size:11px;text-decoration:underline;">Edit</a-->
	</div>
	<div style="clear:both;"></div>
	<div style="width:175px;float:left;padding:2px;">
		Sewa Infrastruktur
	</div>
	<div style="width:200px;float:left;padding:2px;">
		: <input id="sewaInfra" placeholder="0" value="<? echo $infra?>" style="border:1px solid #ccc;text-align:right;padding:0 5px;" onkeyup="valid(this,'numbers')" onblur="valid(this,'numbers')" />
	</div>
	<div style="clear:both;"></div>
	<div style="width:175px;float:left;padding:2px;">
		Uang Rapat
	</div>
	<div style="width:200px;float:left;padding:2px;">
		: <input id="rapat" placeholder="0" value="<? echo $rapat?>" style="border:1px solid #ccc;text-align:right;padding:0 5px;" readonly="readonly" />
	</div>
	<div style="clear:both;"></div>
	<div style="width:175px;float:left;padding:2px;">
		Bonus
	</div>
	<div style="width:200px;float:left;padding:2px;">
		: <input id="pemantra" placeholder="0" value="<? echo $pemantra?>" style="border:1px solid #ccc;text-align:right;padding:0 5px;" onkeyup="valid(this,'numbers')" onblur="valid(this,'numbers')" />
	</div>
	<div style="clear:both;"></div>
	<div style="width:175px;float:left;padding:2px;">
		THR
	</div>
	<div style="width:200px;float:left;padding:2px;">
		: <input id="thr" placeholder="0" value="<? echo $thr?>" style="border:1px solid #ccc;text-align:right;padding:0 5px;" onkeyup="valid(this,'numbers')" onblur="valid(this,'numbers')" />
	</div>
	<div style="clear:both;"></div>
	<div style="width:175px;float:left;padding:2px;">
		Total
	</div>
	<div style="width:200px;float:left;padding:2px;">
		: <input id="total" style="border:1px solid #ccc;text-align:right;padding:0 5px;" value=""  readonly="readonly" />
	</div>
	<div style="clear:both;"></div>
</div>
</form>
</div>
<script>
$("#dialogGaji").dialog({
	buttons	: {
		"Simpan":function(){
			param = 'userid=<? echo $_POST['userid'];?>&periode='+$("#tahun").val()+'-'+$("#bulan").val()+'&gajibulanan='+$("#gajibulanan").val();
			param += '&potonganKoperasi='+$("#potonganKoperasi").val()+'&potonganPajak='+$("#potonganPajak").val();
			param += '&SPJLokal1='+$("#SPJLokal1").val()+'&SPJLokal2='+$("#SPJLokal2").val()+'&feeMakan='+$("#feeMakan").val();
			param += '&lemburMlm='+$("#lemburMlm").val()+'&lemburDayOff='+$("#lemburDayOff").val();
			param += '&puasa='+$("#puasa").val()+'&sewaInfra='+$("#sewaInfra").val();
			param += '&SPJLokal1_val='+$("#SPJLokal1_val").val()+'&SPJLokal2_val='+$("#SPJLokal2_val").val();
			param += '&lemburMlm_val='+$("#lemburMlm_val").val()+'&lemburDayOff_val='+$("#lemburDayOff_val").val();
			param += '&puasa_val='+$("#puasa_val").val()+'&feeMakan_val='+$("#feeMakan_val").val();
			param += '&rapat='+$("#rapat").val()+'&pemantra='+$("#pemantra").val()+'&thr='+$("#thr").val();
			param += '&iuranharitua='+$("#iuranharitua").val();
			$.ajax({
				type	: 'post',
				url		: 'views/form_gaji_dibayarkan_act.php',
				data	: param,
				success	: function(msg){
					if(msg=='ok'){
						alert('Data gaji dibayarkan sudah disimpan.');
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

var total = <? echo ($gapok+$rapat+$infra)-$iuran?>;
$("#total").val(total);

$('input').keyup(function(){
   var potonganKoperasi = $('#potonganKoperasi').val(),
        potonganPajak = $('#potonganPajak').val(),
        SPJLokal1 = ($('#SPJLokal1').val()*$('#SPJLokal1_val').val()),
        SPJLokal2 = ($('#SPJLokal2').val()*$('#SPJLokal2_val').val()),
        feeMakan = ($('#feeMakan').val()*$('#feeMakan_val').val()),
        puasa = ($('#puasa').val()*$('#puasa_val').val()),
        lemburMlm = ($('#lemburMlm').val()*$('#lemburMlm_val').val()),
        lemburDayOff = ($('#lemburDayOff').val()*$('#lemburDayOff_val').val()),
        sewaInfra = ($('#sewaInfra').val()*1),
        pemantra = ($('#pemantra').val()*1),
        thr = ($('#thr').val()*1),
		result;

    //if (potonganKoperasi!='' && potonganPajak!='' && SPJLokal1!=''){
        result = (total- potonganKoperasi - potonganPajak + SPJLokal1 + SPJLokal2 + feeMakan + puasa + lemburMlm + lemburDayOff + sewaInfra + pemantra + thr);
        $('#total').val(result);
    //}
});
</script>