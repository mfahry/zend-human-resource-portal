<form name: "form_contact" method="post" action="sendmail.php">

  <!– form contact –>
<?php
$ip = getenv("REMOTE_ADDR");
$httpref = getenv ("HTTP_REFERER");
$httpagent = getenv ("HTTP_USER_AGENT");
?>
  
  <input type="hidden" name="ip" value="<?php echo $ip ?>" />
  <input type="hidden" name="httpref" value="<?php echo $httpref ?>" />
  <input type="hidden" name="httpagent" value="<?php echo $httpagent ?>" />
  
<table>
    <tr valign="top">
		<td><label>Your Name</label></td>
      <td>:</td>
  		<td><input type="text" name="visitor" size="35" /></td>
  	</tr>
    <tr valign="top">
		<td><label>Your Email</label></td>
      <td>:</td>
  		<td><input type="text" name="visitormail" size="35" /></td>
    </tr>   
    <tr valign="top">
		<td><label>Subject</label></td>
      <td>:</td>
  		<td><input type="text" name="subjectmail" size="35" /></td>
    </tr>   
    <tr valign="top">
    	<td><label>Mail Message</label></td>
      <td>:</td>
        <td><textarea name="notes" rows="10" cols="40"></textarea></td>
  		<td>&nbsp;</td>
    </tr>
    <tr valign="top">
    	<td></td>
        <td></td>
        <td><input type="submit" value="Send Mail" disabled="disabled" class="btn disabled" /></td>
    </tr>
</table>

</form>