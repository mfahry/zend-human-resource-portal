
<link rel="stylesheet" type="text/css" href="includes/dhtmlx/dhtmlxGrid/dhtmlxgrid.css">
<link rel="stylesheet" type="text/css" href="includes/dhtmlx/dhtmlxGrid/skins/dhtmlxgrid_dhx_skyblue.css">

<script type="text/javascript" src="includes/dhtmlx/dhtmlxGrid/dhtmlxcommon.js"></script>
<script type="text/javascript" src="includes/dhtmlx/dhtmlxGrid/dhtmlxgrid.js"></script>
<script type="text/javascript" src="includes/dhtmlx/dhtmlxGrid/dhtmlxgridcell.js"></script>
<script type="text/javascript" src="includes/dhtmlx/dhtmlxGrid/ext/dhtmlxgrid_start.js"></script>
<script type="text/javascript" src="includes/dhtmlx/dhtmlxGrid/ext/dhtmlxgrid_validation.js"></script>
<script type="text/javascript" src="includes/dhtmlx/dhtmlxDataProcessor/codebase/dhtmlxdataprocessor.js"></script>

<link rel="STYLESHEET" type="text/css" href="includes/dhtmlx/dhtmlxCalendar/codebase/dhtmlxcalendar.css">
<script>

window.dhx_globalImgPath = "includes/dhtmlx/dhtmlxCalendar/codebase/imgs/";

</script>
<script  src="includes/dhtmlx/dhtmlxCalendar/codebase/dhtmlxcommon.js"></script>
<script  src="includes/dhtmlx/dhtmlxCalendar/codebase/dhtmlxcalendar.js"></script>
<script>

var mCal,mCal2;
 
window.onload = function() {
    var dhxCalendarData = {
        parent: 'calInput',
        isAutoDraw: false
    };
	var dhxCalendarData2 = {
        parent: 'calInput2',
        isAutoDraw: false
    };
    mCal = new dhtmlxCalendarObject(dhxCalendarData);
	mCal2 = new dhtmlxCalendarObject(dhxCalendarData2);
}
</script>

<?php
$ada = $this->registry->mPolling->PollingBelumAda();
if($ada !=0){
?>

<ul>
	<li><a href="#" onclick="add()">Tambah</a></li>
	<li><a href="#" onclick="delete_r()">Hapus</a></li>
</ul>
<table id="polling">
	<tr>
		<th width="30">No </th>
		<th width="440"> Pertanyaan </th>
		<th width="110"> Start Date </th>
		<th width="110"> End Date </th>
		<!--<th width="50"> Edit </th>
		<th width="50"> Delete <th>-->
	</tr>
<?php
	$data = $this->registry->mPolling->SelectPolling(NULL,$ada);
	foreach($data as $polling){
		$pollingid = $polling->POLLING_ID;
		$pertanyaan = $polling->QUESTION;
		$start = $polling->START_DATE;
		$end = $polling->END_DATE;
		$i = 1;

?>
	<tr>
		<td><a href="index.php?mod=polling/DetailPolling/<?php echo $pollingid;?>"><?php echo $i; ?></a></td>
		<td><?php echo $pertanyaan; ?></td>
		<td><?php echo $start; ?></td>
		<td><?php echo $end; ?></td>
		<!--<td align="center" width="50"><a href="index.php?mod=polling/EditPolling/<?php //echo $pollingid;?>"> Edit </a> </td>
		<td align="center" width="50"><a href="index.php?mod=polling/DeletePolling/<?php //echo $pollingid;?>" onClick ="return confirm('Yakinkah dihapus?')"> Delete </a></td>-->
	</tr>
<?php
		$i = $i+1;
	}
}
?>
</table>

<!--<form action="index.php?mod=polling/InsertPolling" method="post">
<table width="600" id="dynamicInput">
	<tr>
		<td>Question: </td>
		<td><textarea name="question" id="textarea" cols="12" rows="5"></textarea></td>
	</tr>
	<tr>
		<td>Start Date: </td>
		<td><input type="text" name="start" id="calInput" style="width:50"></td>
	</tr>
	<tr>
		<td>End Date: </td>
		<td><input type="text" name="end" id="calInput2" style="width:50"></td>
	</tr>
	<tr>
		<td>Jawaban Pilihan: </td>
	</tr>
	<tr>
		<td><input type="text" name="pilihan[]" style="width:100"></td>
		<td><input class="btn" type="button" value="Add TextField" onClick="addInput('dynamicInput');" /></td>
	</tr>
</table>
 <br><br><br><input class="btn" type="submit" value="INSERT POLLING" name="polling">
</form>	-->
<?php
	$this->registry->view->show('window_formPolling');

$url = explode('/',$_GET['mod']);
if (isset($url[1])){
	if($url[1] == 'EditPolling'){
		$this->registry->view->data = $this->registry->mPolling->SelectPolling($pollingid,NULL);
		$this->registry->view->datapilihan = $this->registry->mPolling->SelectPilihan($pollingid,NULL);
		$this->registry->view->show('window_edit_polling');
	}if($url[1] == 'DetailPolling'){
		$this->registry->view->data = $this->registry->mPolling->SelectPolling($pollingid,NULL);
		$this->registry->view->datapilihan = $this->registry->mPolling->SelectPilihan($pollingid,NULL);
		$this->registry->view->show('window_detail_polling');
	}	
}

echo 	'<script>';
echo 	'grid = new dhtmlXGridFromTable("polling");';
echo 	'grid.setImagePath("includes/dhtmlx/dhtmlxGrid/codebase/imgs/");';
echo 	'grid.setSkin("dhx_skyblue");';
echo 	'grid.enableAutoWidth(true,800,600);';
echo 	'grid.enableAutoHeight(true, 600,600);';
echo 	'grid.setSizes();';
echo 	'grid.setColTypes("ro,ro,ro,ro,ro,ro,ro");';
echo 	'grid.enableValidation(true);';
echo 	'grid.setColValidators("null","NotEmpty","ValidInteger");';


echo 'function add() {';
echo	'var dhxWins = null;';
echo	'if (!dhxWins){';
echo 	'	dhxWins = new dhtmlXWindows();';
echo	'	dhxWins.setImagePath("includes/dhtmlx/dhtmlxWindows/imgs/");';
echo	'	dhxWins.setSkin("dhx_skyblue");';
echo	'	document.getElementById("window_formPolling").style.display = "block";';
echo 	'}';

echo 	'if (!dhxWins.window("winFin")) {';
echo	'	var winFin = dhxWins.createWindow("w1", 350, 200, 600, 500);';
//echo	'	winFin.attachObject("windowInputTask");';
echo	'	winFin.setText("Input Task");';
echo	'	winFin.setModal(true);';
echo	'	winFin.setIcon("dhxwins_dhx_blue/active/icon_blank.gif");';
echo	'	winFin.allowResize();';
echo	'	winFin.allowMove();';
echo	'	winFin.button("park").hide();';
echo	'	winFin.button("minmax1").hide();';
echo	'	winFin.button("minmax2").hide();';
echo	'	winFin.attachEvent("onClose",function(win){';
echo	'		if (win.getId() == "w1") {';
echo 	'			win.detachObject();';
echo 	'			win.hide();';
echo	'			winFin.setModal(false);';
echo 	'		}';
echo 	'	})';
echo 	'}else{';
echo 	'	var w1 = dhxWins.window("winFin");';
echo 	'	w1.show();';
echo 	'}';
echo 	'winFin.attachObject("window_formPolling");';
echo '}';

echo 	'</script>';
?>


<script>
var counter = 1;
var limit = 6;
function addInput(divName){
     if (counter == limit)  {
          alert("Maaf Pilihan Di batasi sampai 6");
     }
     else {
          var newdiv = document.createElement('table');
		  var num = counter + 1;
		  //var divIdName = 'dynamic'+num;
		  //newdiv.setAttribute('id',divIdName);
          newdiv.innerHTML = "<input type='text' name='pilihan[]' id='"+num+"'>"; /*<a href=\'#\' onclick=\'removeElement("+divIdName+")\'> Delete</a>";*/
          document.getElementById(divName).appendChild(newdiv);
          counter++;
     }
}

function removeElement(id) {
  var d = document.getElementById('dynamicInput');
  var olddiv = document.getElementById(id);
  d.removeChild(olddiv);
}
</script>