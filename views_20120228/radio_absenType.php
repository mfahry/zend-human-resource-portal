<table border=0>
  <?php
$getType 	= $this->registry->mAbsenType->selectDB_typeAbsen();
$kolom		= 6;
$i = 1;
$idRadio=1;

if($getType != 0){
	foreach($getType as $data){
		if($i >= $kolom){
			?>
  <tr>
    <?php
			$i = 0;
		}
		$i++;
		?>
    <?php
	/*<?php 
			#2011-05-19: new selection
			}else{
				#if(($data->TYPE_ID == 013)){
				if(($data->TYPE_ID != 0)&&($data->TYPE_ID!=1)&&($data->TYPE_ID!=2)&&($data->TYPE_ID!=3)&&($data->TYPE_ID!=4)&&($data->TYPE_ID!=6)&&($data->TYPE_ID!=7)&&($data->TYPE_ID!=8)&&($data->TYPE_ID!=10)&&($data->TYPE_ID!=12)){
	?> 
    <td><input type="radio" name="rbAbsen"  class="validate[required] radio" id="rbAbsen2" value="<?php echo $data->TYPE_ID; ?>"/></td>
    <td><label for="rbAbsen"> <?php echo $data->TYPE_NAME; ?> </label></td>*/
	
		if($rec != NULL){
			//if(($data->TYPE_ID != 0)&&($data->TYPE_ID!=1)&&($data->TYPE_ID!=2)&&($data->TYPE_ID!=3)&&($data->TYPE_ID!=4)&&($data->TYPE_ID!=6)&&($data->TYPE_ID!=7)&&($data->TYPE_ID!=8)&&($data->TYPE_ID!=10)&&($data->TYPE_ID!=12)){
			if(($data->TYPE_ID != 0) && ($data->TYPE_ID != 1) && ($data->TYPE_ID != 10) && ($data->TYPE_ID != 12) && ($data->TYPE_ID != 14)){
				if((isset($SESSION['level_id'])) && ($_SESSION['level_id']!=3)){
					
					?>
    <td><input type="radio" class="validate[required] radio" id="rbAbsen" name="rbAbsen" value="<?php echo $data->TYPE_ID; ?>" ></td>		  
    <td><label for="rbAbsen"><?php echo $data->TYPE_NAME; ?></label></td>
    <?php
				}else{
					if((($data->TYPE_ID)!=7) && (($data->TYPE_ID)!=8)){
						?>
    <td><input type="radio"  class="validate[required] radio"name="rbAbsen" id="rbAbsen"  value="<?php echo $data->TYPE_ID; ?>"></td>
    <td><label for="rbAbsen"><?php echo $data->TYPE_NAME; ?></label></td>
    <?php
					}
				}
			}
		}else{
			if($_SESSION['level_id']!=3){
 				//if($idRadio !=1){  
					if(($data->TYPE_ID==6)||($data->TYPE_ID==7)){
	?> 
    <td><input type="radio" name="rbAbsen"  class="validate[required] radio" id="rbAbsen" value="<?php echo $data->TYPE_ID; ?>" onClick="showDate()" /></td>
    <td><label for="rbAbsen"> <?php echo $data->TYPE_NAME; ?> </label></td>
    <?php
 					}else{
						if(($data->TYPE_ID!=2)&&($data->TYPE_ID!=3)){
	?> 
    <td><input type="radio" name="rbAbsen"  class="validate[required] radio" id="rbAbsen" value="<?php echo $data->TYPE_ID; ?>" onchange="hideDate()" /></td>
    <td><label for="rbAbsen"> <?php echo $data->TYPE_NAME; ?> </label></td>
    
    <?php
						//}
					}
				}
				
			}else{
				if((($data->TYPE_ID)!=0) && (($data->TYPE_ID)!=2) && (($data->TYPE_ID)!=3)  && (($data->TYPE_ID)!=7)){
 					if($idRadio !=1){   
	
	?>				 <?php	
					if($data->TYPE_ID == 8){
					?>	
                    <td><input type="radio" name="rbAbsen" id="rbAbsen" class="lembur"  value="<?php echo $data->TYPE_ID; ?>" onClick="<?php echo ($data->TYPE_ID==6)?'showDate()':'hideDate()';?>"/></td>
					<?php 
					}elseif($data->TYPE_ID == 1){ ?>
					<td><input type="radio" name="rbAbsen" id="rbAbsen" class="abs_masuk"  value="<?php echo $data->TYPE_ID; ?>" onClick="<?php echo ($data->TYPE_ID==6)?'showDate()':'hideDate()';?>"/></td>
					<?php 
                    }elseif($data->TYPE_ID == 4){ ?>
					<td><input type="radio" name="rbAbsen" id="rbAbsen" class="abs_kuliah"  value="<?php echo $data->TYPE_ID; ?>" onClick="<?php echo ($data->TYPE_ID==6)?'showDate()':'hideDate()';?>"/></td>
                    <?php 
                    }elseif(($data->TYPE_ID == 5)||($data->TYPE_ID == 6)||($data->TYPE_ID == 13)){ ?>
					<td><input type="radio" name="rbAbsen" id="rbAbsen" class="abs_spj"  value="<?php echo $data->TYPE_ID; ?>" onClick="<?php echo ($data->TYPE_ID==6)?'showDate()':'hideDate()';?>"/></td>
					<?php 
                    }elseif($data->TYPE_ID == 14){ ?>
					<td><input type="radio" name="rbAbsen" id="rbAbsen" class="abs_puasa"  value="<?php echo $data->TYPE_ID; ?>" onClick="<?php echo ($data->TYPE_ID==6)?'showDate()':'hideDate()';?>"/></td>
                                  
					<?php }else{ ?>
                    <td><input type="radio" name="rbAbsen" id="rbAbsen" class="abs_type"  value="<?php echo $data->TYPE_ID; ?>" onClick="<?php echo ($data->TYPE_ID==6)?'showDate()':'hideDate()';?>"/></td>
					
					<?php }?>
    <!--td><input type="radio" name="rbAbsen"  class="validate[required] radio" id="rbAbsen" value="<?php //echo $data->TYPE_ID; ?>" onClick="<?php //echo ($data->TYPE_ID==6)?'showDate()':'hideDate()';?>" /></td-->

    <td><label for="rbAbsen"> <?php echo $data->TYPE_NAME; ?> </label></td>
    
    <?php
 					}
				}
			}
		}
		?>
    <?php
		$idRadio++;
	}
}
?>
  </tr>
</table>
<!--</form>!--> 

<script language="JavaScript">

	function showDate() {
		var date2 = document.getElementById('absen_2'); 
		date2.style.visibility = 'visible';  
	}

	function hideDate() {
		var date2 = document.getElementById('absen_2'); 
		date2.style.visibility = 'hidden';  
	}
	 function showClock() {
		var date3 = document.getElementById('absen_3'); 
		date3.style.visibility = 'visible'; 
		var date4 = document.getElementById('absen_4'); 
		date4.style.visibility = 'visible';  
	}
	
	function hideClock() {
		var date3 = document.getElementById('absen_3'); 
		date3.style.visibility = 'hidden'; 
		var date4 = document.getElementById('absen_4'); 
		date4.style.visibility = 'hidden';   
	}

</script>