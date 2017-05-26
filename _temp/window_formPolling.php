<link rel="stylesheet" type="text/css" href="includes/dhtmlx/dhtmlxWindows/dhtmlxwindows.css">
<link rel="stylesheet" type="text/css" href="includes/dhtmlx/dhtmlxWindows/skins/dhtmlxwindows_dhx_skyblue.css">
<script src="includes/dhtmlx/dhtmlxWindows/dhtmlxcommon.js"></script>
<script src="includes/dhtmlx/dhtmlxWindows/dhtmlxwindows.js"></script>
<script src="includes/dhtmlx/dhtmlxWindows/dhtmlxcontainer.js"></script>

<script type="text/javascript" src="includes/JQuery/script/dynamicForm.js"></script>
<script>
$(function () {
    $("#dynamic").dynamicForm("#plus", "#min", {limit:4});
    /*$("#duplicate3").dynamicForm("#plus3", "#minus3",
        {
            limit:3,
            createColor: 'yellow',
            removeColor: 'red'
        }
    );*/
});
</script>
<div id="window_formPolling" style="display:none">
<form action="index.php?mod=polling/InsertPolling" method="post">
<table>
	<tr>
		<td>Pertanyaan</td>
        <td>:</td>
		<td><textarea name="question" id="textarea" cols="12" rows="5"></textarea></td>
	</tr>
	<tr>
		<td>Start Date</td>
        <td>:</td>
		<td><input type="text" name="start" id="calInput" style="width:50"></td>
	</tr>
	<tr>
		<td>End Date</td>
        <td>:</td>
		<td><input type="text" name="end" id="calInput2" style="width:50"></td>
	</tr>
	<tr>
		<td>Pilihan</td>
        <td>:</td>
		<td>
        <p id="dynamic">
            <input type="text" name="pilihan[]" style="width:100">
        </p>
        <p>
        	<span style="clear:none; float:right;">
            	<a id="min" href="#" style="display:none">[-]</a>
            	<a id="plus" href="#">[+]</a>
           	</span>
         </p>
        </td>
	</tr>
</table>
 <br><br><br><input class="btn" type="submit" value="INSERT POLLING" name="polling">
</form>	
</div>