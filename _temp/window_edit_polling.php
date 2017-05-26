<link rel="stylesheet" type="text/css" href="includes/dhtmlx/dhtmlxWindows/dhtmlxwindows.css">
<link rel="stylesheet" type="text/css" href="includes/dhtmlx/dhtmlxWindows/skins/dhtmlxwindows_dhx_skyblue.css">
<script src="includes/dhtmlx/dhtmlxWindows/dhtmlxcommon.js"></script>
<script src="includes/dhtmlx/dhtmlxWindows/dhtmlxwindows.js"></script>
<script src="includes/dhtmlx/dhtmlxWindows/dhtmlxcontainer.js"></script>

<script type="text/javascript" src="includes/JQuery/jquery-1.3.2.min.js"></script> 

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
	foreach($data as $polling){
	$pollingid = $polling->POLLING_ID;
	$pertanyaan = $polling->QUESTION;
	$start = $polling->START_DATE;
	$end = $polling->END_DATE;
	}
?>
<div id="editpolling" width="500" height="500" style="display:none">
<form action="index.php?mod=polling/UpdatePolling/<?php echo $pollingid;?>" method="post">
<div id="dynamicInput">
<table style="width:auto height:auto">

	<tr>
		<td>Question: </td>
		<td><textarea name="question" id="textarea" cols="10" rows="5"><?php echo $pertanyaan; ?></textarea></td>
	</tr>
	<tr>
		<td>Start Date: </td>
		<td><input type="text" name="start" id="calInput" style="width:50" value="<?php echo $start;?>"></td>
	</tr>
	<tr>
		<td>End Date: </td>
		<td><input type="text" name="end" id="calInput2" style="width:50" value="<?php echo $end;?>"></td>
	</tr>
	<?php
	$jumlahpilihan = count($datapilihan);
		$i=1;
	foreach($datapilihan as $pil){
		$pilihan_id = $pil->PILIHAN_ID;
		$pilihan = $pil->PILIHAN;
		echo "<tr>";
		echo "	<td>Jawaban Pilihan".$i.": </td>";
		echo "	<td><input type=\"text\" name=\"pilihan[]\" style=\"width:100\" value=\"$pilihan\"></td>";
			$i=$i+1;
	}
	if($jumlahpilihan < 6){
		echo "	<td><input class=\"btn\" type=\"button\" value=\"Add TextField\" onClick=\"addInput('dynamicInput');\" /></td>";
	}	
		echo "</tr>";
		?>
</table>
</div>
	<br><br><input class="btn" type="submit" name="update" value="UPDATE" />
</form>	
</div>


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

var dhxWins = new dhtmlXWindows();
dhxWins.setImagePath("includes/dhtmlx/dhtmlxWindows/imgs/");
dhxWins.setSkin("dhx_skyblue");
document.getElementById("editpolling").style.display = "none";
var winFin = dhxWins.createWindow("w1", 250, 100, 500, 500);
winFin.attachObject("editpolling");
winFin.setText("Edit Polling");
winFin.setModal(false);
winFin.setIcon("dhxwins_dhx_blue/active/icon_blank.gif");
winFin.allowResize(true);

</script>