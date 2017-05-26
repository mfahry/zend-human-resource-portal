<style type="text/css">
<!--
.style1 {
	color: #FFFFFF;
	font-weight: bold;
}
.style2 {color: #996600}
-->
</style>
<?php
$query = "SELECT * FROM gaji WHERE user_id=".$_SESSION['userid'];
//echo $query;
$datauser   = $CONN->Execute($query);
$cntUser = 0;
if($dataU = $datauser->FetchNextObject()){
	
}
?>
<form name="formReportBulan" id="formReportBulan" method="post" action="index.php?mod=reporting/monthly">
  <table width="858">
    <tr>
      <?php if($_SESSION['level_id'] == 2){ ?>
      <td width="45" height="34"><?php
				$this->registry->view->show("combo_user");
			?></td>
      <?php } ?>
      <td width="45"><?php 
				$this->registry->view->type="month";
				$this->registry->view->show("combo_date");?></td>
      <td width="45"><?php 
				$this->registry->view->type="year";
				$this->registry->view->show("combo_date");?></td>
      <td width="116"><input type="submit" name="submitCalendar" id="submitCalendar" class="btn" value="Submit"/></td>
      <td width="385"></td>
      <?php if(isset($_POST['submitCalendar'])) { ?>
      <td width="194" ><?php
				if(($_SESSION['level_id'] == 2)/*&&(isset($_POST['submitCalendar']))*/){ ?>
        <a href="index.php?mod=reporting/monthlyToExcel/<?php echo $_POST['cmbUser'];?>/<?php echo $_POST['cmbMonth']; ?>/<?php echo $_POST['cmbYear']; ?>" class="merahBold"><img src="includes/img/excel.gif" border="0" align="absmiddle" alt="untuk mendownload excel" />&nbsp;Export to Excel</a>
        <?php
				}
				?></td>
      <?php } ?>
    </tr>
  </table>
</form>
 
<!--center> 
<b>Absen bulan <?php echo $bln_1." ".$year; ?> tgl 26 <?php echo $bln_2; ?> s/d 25 <?php echo $bln_1; ?></b>
</center-->
<br />
<style>
#tblPayroll{
	border-collapse:collapse;
}
#tblPayroll td{
	padding:5px;
}
</style>
<div style="height:300px;overflow:auto;padding:5px;">
<table width="805" id="tblPayroll" border=0 cellpadding=0 cellspacing=0>
 <tr>
  <td colspan=6 bgcolor="#333333"><span class="style1">RINCIAN GAJI</span></td>
  </tr>
 <tr>
   <td colspan="2">&nbsp;</td>
   <td>&nbsp;</td>
   <td></td>
   <td>&nbsp;</td>
   <td>&nbsp;</td>
 </tr>
 <tr>
  <td width="300" colspan="2" bgcolor="#CCCCCC"><strong>Gaji Pokok</strong></td>
  <td width="8" bgcolor="#CCCCCC">&nbsp;</td>
  <td width="180" bgcolor="#CCCCCC"></td>
  <td width="180" bgcolor="#CCCCCC">&nbsp;</td>
  <td width="180" bgcolor="#CCCCCC">&nbsp;</td>
 </tr>
 <tr>
  <td width="80">&nbsp;</td>
  <td width="200">Gaji Pokok</td>
  <td>:</td>
  <td><div align="right">1</div></td>
  <td>&nbsp;</td>
  <td>&nbsp;</td>
 </tr>
 <tr>
  <td width="80">&nbsp;</td>
  <td width="200">Tunjangan Jabatan</td>
  <td>:</td>
  <td><div align="right">1</div></td>
  <td>&nbsp;</td>
  <td>&nbsp;</td>
 </tr>
 <tr>
  <td>&nbsp;</td>
  <td>Tunjangan Kesehatan</td>
  <td>:</td>
  <td><div align="right">1</div></td>
  <td>&nbsp;</td>
  <td>&nbsp;</td>
 </tr>
 <tr>
  <td>&nbsp;</td>
  <td>Tunjangan Komunikasi</td>
  <td>:</td>
  <td><div align="right">1</div></td>
  <td>&nbsp;</td>
  <td>&nbsp;</td>
 </tr>
 <tr>
  <td>&nbsp;</td>
  <td>Tunjangan Transportasi</td>
  <td>:</td>
  <td><div align="right">1</div></td>
  <td>&nbsp;</td>
  <td>&nbsp;</td>
 </tr>
 <tr>
  <td colspan=2><strong>Jumlah Gaji dan Tunjangan</strong></td>
  <td>:</td>
  <td><div align="right"><strong>Rp</strong></div></td>
  <td><div align="right"><strong>1</strong></div></td>
  <td>&nbsp;</td>
 </tr>
 <tr>
   <td colspan=2>&nbsp;</td>
   <td></td>
   <td></td>
   <td>&nbsp;</td>
   <td>&nbsp;</td>
 </tr>
 <tr>
  <td colspan=2 bgcolor="#CCCCCC"><strong>Pengurangan</strong></td>
  <td bgcolor="#CCCCCC"></td>
  <td bgcolor="#CCCCCC"></td>
  <td bgcolor="#CCCCCC">&nbsp;</td>
  <td bgcolor="#CCCCCC">&nbsp;</td>
 </tr>
 <tr>
  <td><span class="style2"></span></td>
  <td><span class="style2">Potongan Koperasi</span></td>
  <td><span class="style2">:</span></td>
  <td><div align="right" class="style2">1</div></td>
  <td><span class="style2"></span></td>
  <td><span class="style2"></span></td>
 </tr>
 <tr>
  <td><span class="style2"></span></td>
  <td><span class="style2">Potongan Terlambat</span></td>
  <td><span class="style2">:</span></td>
  <td><div align="right" class="style2">1</div></td>
  <td><span class="style2"></span></td>
  <td><span class="style2"></span></td>
 </tr>
 <tr>
  <td><span class="style2"></span></td>
  <td><span class="style2">Potongan PPH 21</span></td>
  <td><span class="style2">:</span></td>
  <td><div align="right" class="style2">1</div></td>
  <td><span class="style2"></span></td>
  <td><span class="style2"></span></td>
 </tr>
 <tr>
  <td colspan=2><span class="style2"><strong>Jumlah Pengurangan</strong></span></td>
  <td><span class="style2"><strong>:</strong></span></td>
  <td><div align="right" class="style2"><strong>Rp</strong></div></td>
  <td><div align="right" class="style2"><strong>1</strong></div></td>
  <td><span class="style2"></span></td>
 </tr>
 <tr>
  <td><span class="style2"></span></td>
  <td><span class="style2"><strong>Total 1</strong></span></td>
  <td><span class="style2"><strong>:</strong></span></td>
  <td><span class="style2"></span></td>
  <td><div align="right" class="style2"><strong>Rp</strong></div></td>
  <td><div align="right" class="style2"><strong>1</strong></div></td>
 </tr>
 <tr>
   <td colspan=2>&nbsp;</td>
   <td></td>
   <td></td>
   <td>&nbsp;</td>
   <td>&nbsp;</td>
 </tr>
 <tr bgcolor="#CCCCCC">
  <td colspan=2><strong>Penambahan</strong></td>
  <td></td>
  <td></td>
  <td>&nbsp;</td>
  <td>&nbsp;</td>
 </tr>
 <tr>
  <td>&nbsp;</td>
  <td>Perjalanan Dinas Lokal</td>
  <td>:</td>
  <td><div align="right">1</div></td>
  <td>&nbsp;</td>
  <td>&nbsp;</td>
 </tr>
 <tr>
  <td>&nbsp;</td>
  <td>Uang Makan</td>
  <td>:</td>
  <td><div align="right">1</div></td>
  <td>&nbsp;</td>
  <td>&nbsp;</td>
 </tr>
 <tr>
  <td>&nbsp;</td>
  <td>Lembur Hari Kerja</td>
  <td>:</td>
  <td><div align="right">1</div></td>
  <td>&nbsp;</td>
  <td>&nbsp;</td>
 </tr>
 <tr>
  <td>&nbsp;</td>
  <td>Lembur Non Hari Kerja</td>
  <td>:</td>
  <td><div align="right">1</div></td>
  <td>&nbsp;</td>
  <td>&nbsp;</td>
 </tr>
 <tr>
  <td>&nbsp;</td>
  <td>Pengganti Puasa</td>
  <td>:</td>
  <td><div align="right">1</div></td>
  </tr>
 <tr>
  <td>&nbsp;</td>
  <td>Sewa Infrastruktur</td>
  <td>:</td>
  <td><div align="right">1</div></td>
  <td>&nbsp;</td>
  <td>&nbsp;</td>
 </tr>
 <tr>
  <td>&nbsp;</td>
  <td>Uang Rapat</td>
  <td>:</td>
  <td><div align="right">1</div></td>
  <td>&nbsp;</td>
  <td>&nbsp;</td>
 </tr>
 <tr>
  <td>&nbsp;</td>
  <td>Bonus</td>
  <td>:</td>
  <td><div align="right">1</div></td>
  <td>&nbsp;</td>
  <td>&nbsp;</td>
 </tr>
 <tr>
   <td colspan=2>&nbsp;</td>
   <td>&nbsp;</td>
   <td>&nbsp;</td>
   <td>&nbsp;</td>
   <td>&nbsp;</td>
 </tr>
 <tr>
  <td colspan=2><strong>Jumlah Penambahan</strong></td>
  <td>:</td>
  <td><div align="right"><strong>Rp</strong></div></td>
  <td><div align="right"><strong>1</strong></div></td>
  <td>&nbsp;</td>
 </tr>
 <tr>
  <td>&nbsp;</td>
  <td><strong>Total 2</strong></td>
  <td>:</td>
  <td></td>
  <td><div align="right"><strong>Rp</strong></div></td>
  <td><div align="right"><strong>1</strong></div></td>
 </tr>
 <tr>
   <td colspan=2>&nbsp;</td>
   <td>&nbsp;</td>
   <td colspan="3">&nbsp;</td>
 </tr>
 <tr>
  <td colspan=2 bgcolor="#CCCCCC"><strong>Gaji yang dibayarkan</strong></td>
  <td bgcolor="#CCCCCC"><strong>:</strong></td>
  <td colspan="3" bgcolor="#CCCCCC"><strong>Rp. 1.000.000,00</strong></td>
  </tr>
 <tr>
  <td colspan="2" style='border-top:none'><strong>Terbilang</strong></td>
  <td style='border-top:none'><strong>:</strong></td>
  <td colspan="3" style='border-top:none'><strong>Sekian ajah</strong></td>
  </tr>
</table>
</div>