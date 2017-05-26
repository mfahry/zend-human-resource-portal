<link rel="stylesheet" type="text/css" href="includes/dhtmlx/dhtmlxGrid/dhtmlxgrid.css">
<link rel="stylesheet" type="text/css" href="includes/dhtmlx/dhtmlxGrid/skins/dhtmlxgrid_dhx_skyblue.css">
<link rel="stylesheet" type="text/css" href="includes/dhtmlx/dhtmlxGrid/skins/dhtmlxgrid_dhx_black.css">
<script type="text/javascript" src="includes/dhtmlx/dhtmlxGrid/dhtmlxcommon.js"></script>
<script type="text/javascript" src="includes/dhtmlx/dhtmlxGrid/dhtmlxgrid.js"></script>
<script type="text/javascript" src="includes/dhtmlx/dhtmlxGrid/dhtmlxgridcell.js"></script>
<script type="text/javascript" src="includes/dhtmlx/dhtmlxGrid/ext/dhtmlxgrid_start.js"></script> 
<script type="text/javascript" src="includes/dhtmlx/dhtmlxDataProcessor/codebase/dhtmlxdataprocessor.js"></script>

<table id="gridBox2" name="grid2" align="center" width="751">
	<input name="CalendarIDperiod" type="hidden" value="1<?php echo $calendar_id;?>" />
	<tr>
		<td width="1"> </td>
		<td width="55" align="center"><b>Prioritas</b></td>
		<td width="400" align="center"><b>Task</b></td>
		<td width="75" align="center"><b>Status (%)</b></td>
		<td width="110" align="center"><b>Target</b></td> 
		<td width="110" align="center"><b>Date</b></td> 
	</tr>
   
	<?php 
	if(count($tasklist)){
		foreach($tasklist as $data2){
			if($data2->STATUS < 100){
				echo '<tr>';
				echo '	<td style="color:transparent;">'.$data2->TASK_ID.'</td>';
				echo '	<td align="center">'.$data2->PRIORITY_ID.'</td>';
				echo '	<td align="left">'.$data2->TASK.'</td>';
				echo '	<td align="center">'.$data2->STATUS.'</td>';
				echo '	<td align="center">'.$data2->TARGET.'</td>';						
				echo '	<td align="center">'.$data2->UPDATE_DTM.'</td>';						
				echo '</tr>';
			}
		}
	}
	?>
</table>
<script>
grid2 = new dhtmlXGridFromTable("gridbox2");
grid2.setImagePath("includes/dhtmlx/dhtmlxGrid/imgs/");
grid2.setSkin("dhx_black");
grid2.enableAutoWidth(true, 751, 580);
grid2.enableAutoHeight(true, 500, 600);
grid2.setSizes();
grid2.setColTypes("ro,ed,txt,ed,ed");
grid2.attachEvent("onEditCell",function(stage,rowId,cInd){
    if(cInd==3 && stage==1){
        grid2.editor.obj.onkeypress = function(e){
            if(this.value > 100){
				alert('maksimum 100');
				this.value='';
                return false;
            } else {
				return true;
			}
        }
    }
    return true;
});
</script>