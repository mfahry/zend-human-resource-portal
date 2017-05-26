<!-- last Edited by de_haynain!-->
<?php     
	
	echo "<table>
		<tr><td>
			<select name = \"cmbDayStat\">
				<option value=\"0\"".(($stat==0)?"selected":"")."> Libur </option>
				<option value=\"1\"".(($stat==1)?"selected":"")."> Masuk </option>
			</select>
		</td></tr>
	</table>";
?>