<div align="center" valign="center" class="confirm">
	<table width="90%" class="box">
		<tr class="alertRed">
			<td><img src="./includes/img/AlertCautionIcon.png" width="50" height="50"></td>
			<td>
			Anda tidak menginputkan Absen masuk untuk tanggal : <br> 
            <ol>
            	<?php
				foreach($getAbsentYesterday as $data){ ?>
					<li>
                    	<div>
						<?php 
						echo '<div style="float:left; width:70px;">'.$this->registry->mCalendar->select_calendarID('','','',$data->CALENDAR_ID,1).' </div>'; 
						$dataRec0 	= $this->registry->mAbsenTemp->selectDB_absenTemp($_SESSION['userid'],'user_id',NULL,$data->CALENDAR_ID,'','',''); 
						
						if(count($dataRec0)>0){ 
							//echo '<ol>';
							$active = 0;
							$wait = false;
							$error = 0;
							foreach($dataRec0 as $reject){
								if($reject->STATUS == 0)
									$wait = true;
								elseif($reject->STATUS == 1 && $reject->ACTIVATED == 'no')
									$active++; 
								elseif($reject->STATUS == 1 && $reject->ACTIVATED == 'yes')
									$error++; 
							}
							 if($wait)
								echo ' <img width="15" height="15" src="includes/img/waiting.ico" class="vtip" title="* Menunggu persetujuan rekan anda.">';
							if($error > 0)
								echo ' <img width="15" height="15" src="includes/img/notification.ico" class="vtip" title="* Rekomendasi error(absen_temp:status_yes:'.$data->CALENDAR_ID.'), hubungi administrator." >'; 
							if($active>=2)
								echo ' <img width="15" height="15" src="includes/img/success.ico" class="vtip" title="* Rekomendasi telah disetujui, update absen anda melalui notifikasi.">';
							//echo '</ol>';
						} 
						echo '<br>';
						?>
                        </div>
                    </li>
				<?php
                }
				?>
            </ol>
			konfirmasi kepada pihak HRD atau gunakan rekomendasi untuk Absen masuk kemarin. <br> 
			<td>
		</tr>
	</table>
</div>