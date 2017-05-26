<table width="743" border="0" align="center" bgcolor="#FFFFFF" style="padding:5px;" height="300">
  <tr>
    <td width="737" valign="top">
    <form method="post" name="absenKembaliY" id="absenKembaliY" onsubmit="return validasiAbsenKembaliY();" action="index.php">
        <table>
          <tr>
            <td colspan="3" class="alertRed">Kemarin Anda tidak menginputkan Absensi Kembali Anda!</td>
          </tr>
          <tr>
            <td colspan="3" class="header3BoldBlue">Absensi kembali ke kantor anda  :</td>
          </tr>
          <tr>
            <td valign="top"><strong>Untuk tanggal</strong></td>
            <td valign="top"><strong>:</strong></td>
          </tr>
          <tr>
            <td valign="top"><strong>Jam </strong></td>
            <td valign="top"><strong>:</strong></td>
            <td><input name="" type="text" value="17:00" />
              &nbsp;&nbsp;(HH:MM)</td>
          </tr>
          <tr>
            <td valign="top"><strong>Keterangan</strong></td>
            <td valign="top"><strong>:</strong></td>
            <td><label>
              <textarea name="" cols="45" rows="5"></textarea>
              </label></td>
          </tr>
          <tr>
            <td valign="top"><strong>Work Summary</strong></td>
            <td valign="top"><strong>:</strong></td>
            <td><label>
              <textarea name="" cols="45" rows="5"></textarea>
              </label></td>
          </tr>
          <input name="" type="hidden" value="" />
          <input name="tAbsen" type="hidden" value="0" />
          <input name="ipAddress" type="hidden" value="" />
          <tr>
           <td align="right" colspan="3"><input name="ctrOut" type="hidden" value="" />
            <input type="submit" name="submitKembaliY" value=" Submit" class="btn-submit"/></td>
            <td align="right">&nbsp;</td>
          </tr>
        </table>
      </form>
      <form method="post" name="absenPulangY" id="absenPulangY" onSubmit="return validasiAbsenPulangY();" action="index.php">
        <table border="0">
          <tr>
            <td colspan="3" class="alertRed">Kemarin Anda tidak menginputkan Absensi Pulang Anda!</td>
          </tr>
          <tr>
            <td><b>Jenis Absen</b></td>
            <td colspan="2" class="header3BoldBlue"><label>
              <input type="radio" name="radio" id="radio" value="0" checked />
              Absen Pulang</label></td>
          </tr>
          <tr>
            <td><input name="" type="hidden" value="" /></td>
            <td><input name="ipAddress" type="hidden" value="" /></td>
            <td>&nbsp;</td>
          </tr>
          <tr>
            <td valign="top"><strong>Untuk tanggal</strong></td>
            <td valign="top"><strong>:</strong></td>
          </tr>
          <tr>
            <td valign="top"><strong>Jam </strong></td>
            <td valign="top"><strong>:</strong></td>
            <td><input name="" type="text" value="17:00"/>
              &nbsp;&nbsp;(HH:MM)</td>
          </tr>
          <tr>
            <td valign="top"><strong>Keterangan</strong></td>
            <td valign="top"><strong>:</strong></td>
            <td><label>
              <textarea name="" cols="45" rows="5"></textarea>
              </label></td>
          </tr>
          <tr>
            <td valign="top"><strong>Work Summary</strong></td>
            <td valign="top"><strong>:</strong></td>
            <td><label>
              <textarea name="" cols="45" rows="5"></textarea>
              </label>
            </td>
          </tr>
          <tr>
            <td align="right" colspan="3"><input name="ctrHarian" type="hidden" value="" />
              <input name="SubmitPulangY" type="submit" value=" Submit" class="btn-submit"/></td>
          </tr>
        </table>
      </form>
  </tr>
</table>
