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

<form name="frm" method="post" action="login_process.php" onSubmit="return CheckLogin()">
    <table width="185" border="0" cellpadding="0" cellspacing="0" class="RightPanel">
        <tr>
            <td>
                <h3>Members Login</h3>
                <label>Username</label>
                <input type="text" name="username" id="username" class="Textbox" />
                <br />
                
                <label>Password</label>
                <input type="password" name="password" id="password" class="Textbox" />
                <br />
                <!-- <p> -->
                    <input type="image" name="imageField" src="images/Btn_Login_Norm.gif" />
                <!-- </p> -->
            </td>
        </tr>
        <tr>
            <td>
                <h3>Don't Have an Account?</h3>
                <a href="register.php" onMouseOut="MM_swapImgRestore()" onMouseOver="MM_swapImage('Sign Up','','images/Btn_SignUp_Over.gif',1)">
                    <img src="images/Btn_SignUp_Norm.gif" name="Sign Up" width="76" height="32" border="0" id="Sign Up" />
                </a>
            </td>
        </tr>
        <?php
        if (isset($_SESSION['errormessage']) && $_SESSION['errormessage'] <> "") {
           // DISPLAY ERROR MESSAGE
        ?>
        <tr>
            <td align="center"><span style="color:#FF0000; font-size: 10;"><?php echo $_SESSION['errormessage']; ?></span></td>
        </tr>
        <?php
        }
        ?>
    </table>  
</form>
