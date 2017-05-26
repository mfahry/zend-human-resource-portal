<?php
$data = $this->registry->mPollingbaru->InsertPolling($_POST['question'],$_POST['start'],$_POST['end']);
$looping = $_POST['jumlah'];

$i=1;
while($i<=$looping){
?>

<script type="text/javascript" src="includes/dhtmlx/dhtmlxDataProcessor/codebase/dhtmlxdataprocessor.js"></script>

<link rel="stylesheet" type="text/css" href="includes/dhtmlx/dhtmlxWindows/dhtmlxwindows.css">
<link rel="stylesheet" type="text/css" href="includes/dhtmlx/dhtmlxWindows/skins/dhtmlxwindows_dhx_skyblue.css">
<script src="includes/dhtmlx/dhtmlxWindows/dhtmlxcommon.js"></script>
<script src="includes/dhtmlx/dhtmlxWindows/dhtmlxwindows.js"></script>

<script src="includes/dhtmlx/dhtmlxWindows/dhtmlxcontainer.js"></script>




<div id="pilihan" width="400" height="400">
<form action="index.php?mod=polling/InsertPilihan/<?php echo $data; ?>" method="post" enctype="multipart/form-data" name="artikel">
<table width="850">
  <tr>
    <td> Pilihan <?php echo $i;?></td>
    <td><input type="text" name="pilihan"/></td>
  </tr>
</table>
</form>

</div>

<script>
var dhxWins = new dhtmlXWindows();
dhxWins.setImagePath("includes/dhtmlx/dhtmlxWindows/imgs/");
dhxWins.setSkin("dhx_skyblue");
document.getElementById("pilihan").style.display = "none";
var winFin = dhxWins.createWindow("w1", 250, 200, 600, 500);
winFin.attachObject("pilihan");
winFin.setText("Insert Pilihan Jawaban");
winFin.setModal(false);
winFin.setIcon("dhxwins_dhx_blue/active/icon_blank.gif");
winFin.allowResize(true);

</script>

<?php
	$i=$i+1;

}
?>