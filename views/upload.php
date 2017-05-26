<?php
$dir = "	\NW Document\Kerja\BUSDEV\\";

if($_POST['filter']){
	$namafile = basename($_FILES['fileField']['name']);
	list($fname,$fext) =  explode('.', $namafile);
	$fext = strtolower($fext);
	$namafile = date("YmdHis").'_'.$sdid.'.'.$fext;

	$destfile = $dir.$namafile;

	if(move_uploaded_file($_FILES['fileField']['tmp_name'], $destfile)){
		chmod($destfile, 0777);
		echo "berhasil<br />";
	}
}
?>
<form enctype="multipart/form-data" target="frastatus" method="post" action="">	
	<td align="right"><b>File </b></td>
	<td><b>:</b></td> 
	<td><input type="file" name="fileField" id="fileField" /></td>
	<tr>
		<td></td>
		<td></td>
		<td>
			<input type="submit" name="filter" value="Simpan" />
		</td>
	</tr>
	</table>
</form>