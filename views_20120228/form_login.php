
<script type="text/javascript" src="includes/JQuery/jquery-1.4.2.js"></script>
<SCRIPT language="javascript" src="includes/JQuery/script/validation_engine.js"></SCRIPT>
<SCRIPT language="javascript" src="includes/JQuery/script/validation_engine-id.js"></SCRIPT>
<link rel="stylesheet" type="text/css" href="includes/JQuery/styles/validation_engine.css"/> 

<SCRIPT>

$(function() {
      $("#formLogin").validationEngine({
		inlineValidation: false,
		success :  false
	   });
	   
});

</SCRIPT>
<?php echo isset($message)?$message:''; ?>
<form id="formLogin" name="formLogin" method="post" action="index.php?mod=index/loginValidation">
  <table>
    <tr>
      <td width="61"><label>User ID</label></td>
      <td width="3">:</td>
      <td width="144"><input type="text" name="tUsername" id="tUserId" class="validate[required,length[0,10]] text-input" />
      </td>
    </tr>
    <tr>
      <td><label>Password</label></td>
      <td>:</td>
      <td><input type="password" name="tPassword" id="tPassword" class="validate[required,length[0,15]] text-input" />
      </td>
    </tr>
    <tr>
      <td></td>
      <td></td>
      <td><input type="submit" name="cmdLogin" id="cmdLogin" value="Login" class="btn"/>
      </td>
    </tr>
  </table>
</form>


