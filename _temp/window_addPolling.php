<div id="window_addPolling" style="display:none">
<form action="index.php?mod=polling/InsertPolling" method="post">
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
</form>	
</div>