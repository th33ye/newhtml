<script language="JavaScript">
<!--
  
//--------------CHECK THE FORM-----------------------------------------------
	   
	   function CheckLogin () {
	   
			if (document.frm.username.value=="")
			   {
				  alert("Username is a required field!");
				  document.frm.username.focus();
				  return false;
			   }
		   if (document.frm.password.value=="")
			   {
				  alert("Password is a required field!");
				  document.frm.password.focus();
				  return false;
			   }
		  return true;
		  }
//----------------------------------------------------------------------------          
// -->
</script>	

<form name="frm" method="post" action="admin_login_process.php" onSubmit="return CheckLogin()"> 
<table width="185" border="0" cellpadding="0" cellspacing="0" class="RightPanel">
 <tr>
 <td>
 <h3>Login</h3>
 Username
 <input type="text" name="username" id="username" class="Textbox" />
 <br />
 Password
 <input type="password" name="password" id="password" class="Textbox" />
<br />
<p>
 <input type="image" name="imageField" src="Btn_Login_Norm.gif" />
 </p> </td>
</tr>


<?php
  if (isset($_SESSION['errormessage']) && $_SESSION['errormessage'] <> "")
  {
  // DISPLAY ERROR MESSAGE
  ?>
  <tr>
	<td align="center"><br /><strong><?php echo $_SESSION['errormessage']; ?></strong></td>
  </tr>
 
  <?php
		}
?>
</table>  
</form>

