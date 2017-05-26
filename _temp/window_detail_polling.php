<link rel="stylesheet" type="text/css" href="includes/dhtmlx/dhtmlxWindows/dhtmlxwindows.css">
<link rel="stylesheet" type="text/css" href="includes/dhtmlx/dhtmlxWindows/skins/dhtmlxwindows_dhx_skyblue.css">
<script src="includes/dhtmlx/dhtmlxWindows/dhtmlxcommon.js"></script>
<script src="includes/dhtmlx/dhtmlxWindows/dhtmlxwindows.js"></script>
<script src="includes/dhtmlx/dhtmlxWindows/dhtmlxcontainer.js"></script>

<?php
	foreach($data as $polling){
	$pollingid = $polling->POLLING_ID;
	$pertanyaan = $polling->QUESTION;
	$start = $polling->START_DATE;
	$end = $polling->END_DATE;
	}
if (isset($_SESSION['userid'])){ 
?>
<table id="detailpolling" style="width:auto height=auto" style="display:none" bgcolor="#0099FF">
	<tr>
		<td bgcolor="#0099FF">Question: </td>
		<td bgcolor="#0099FF"><?php echo $pertanyaan; ?></td>
	</tr>
	<tr>
		<td bgcolor="#0099FF">Start Date: </td>
		<td bgcolor="#0099FF"><?php echo $start;?></td>
	</tr>
	<tr>
		<td bgcolor="#0099FF">End Date: </td>
		<td bgcolor="#0099FF"><?php echo $end;?></td>
	</tr>
	<?php
	$i=1;
	foreach($datapilihan as $pil){
		$pilihan_id = $pil->PILIHAN_ID;
		$pilihan = $pil->PILIHAN;		
	echo "<tr>";
	echo "	<td bgcolor=\"#0099FF\">Jawaban Pilihan".$i.": </td>";
	echo "	<td bgcolor=\"#0099FF\">$pilihan</td>";
	echo "</tr>";
		$i=$i+1;
		}
	?>
</table>
<?php
}
?>
<script>
var dhxWins = new dhtmlXWindows();
dhxWins.setImagePath("includes/dhtmlx/dhtmlxWindows/imgs/");
dhxWins.setSkin("dhx_skyblue");
document.getElementById("detailpolling").style.display = "none";
var winFin = dhxWins.createWindow("w1", 250, 100, 400, 400);
winFin.attachObject("detailpolling");
winFin.setText("Detail Polling");
winFin.setModal(false);
winFin.setIcon("dhxwins_dhx_blue/active/icon_blank.gif");
winFin.allowResize(true);
</script>