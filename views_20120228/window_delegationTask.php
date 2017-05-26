<div id = "windowDelegationTask" class="window" style="display:none;" align="center"> 
    <SCRIPT language="javascript" src="includes/JQuery/script/validation_engine.js"></SCRIPT>
    <SCRIPT language="javascript" src="includes/JQuery/script/validation_engine-id.js"></SCRIPT>
    <link rel="stylesheet" type="text/css" href="includes/JQuery/styles/validation_engine.css"/> 
    <SCRIPT language="javascript" src="includes/JQuery/jquery.autocomplete.js"></SCRIPT>
    
    <SCRIPT>
    
    $(function() {
        $("#frmWindowDelegationTask").validationEngine({
			inlineValidation: false,
			success : function(){add_r();}	  
		});
           
    });
    
	    
	
    </SCRIPT>
  <form name="frmWindowDelegationTask" id="frmWindowDelegationTask" method="post" >
    <br>
    <br>
    <table>
      <tr valign="top">
        <td> Isikan task </td>
        <td> : </td>
        <td><textarea name="inputTask" id="inputTask" class="validate[required,custom[noSpecialCaracters],length[3,150]]" cols="25"></textarea></td>
      </tr>
         <?php
			$datausr = $this->registry->mTask->selectDB_team($_SESSION['userid']);			
		?>
		<tr valign="top">
		<td> Delegasikan ke </td>
		<td> : </td>
		<td><select name="delegasiUser" id="delegasiUser" style="width:150px;">
			<?php if(count($datausr)>0){				
				foreach($datausr as $data){ ?>
			<option value="<?php echo ($data->CHILDUSER_ID);?>" selected="selected"><?php echo $this->registry->mUser->get_fullName($data->CHILDUSER_ID);?></option>
			 <?php 
					}
				}?>     
			</select>
		</td>
		</tr>
      <tr valign="top">
        <td> Prosentase Task </td>
        <td> : </td>
        <td><input name="prosentaseTask" id="prosentaseTask" type="text" class="validate[required,custom[onlyNumber],length[1,3]] text-input"  style="width:50px;">
          % </td>
      </tr>
      <tr valign="top" style="display:none;">
        <td> Prioritas Task </td>
        <td> : </td>
        <td><input name="priorityTask" id="priorityTask" type="text"  class="validate[required,custom[onlyNumber] text-input"  style="width:50px;" value='1'>
        </td>
      </tr>
     <tr valign="top">
        <td colspan="2"></td> 
        <td><input name="submitTask" type="submit" class="btn" value="submit" id="submitTask"></td>
      </tr>
    </table>
  </form>
</div>
