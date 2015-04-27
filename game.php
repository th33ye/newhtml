<?php
	session_start();
	//include('ipblocked.php');
	if (isset($_SESSION['user_username'])) 
	{
	?>
	
	<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Game Console</title>

</head>

<script type="text/javascript" src="js/swfobject.js"></script>
    <title></title>
    <style type="text/css">
        body, html { background-color: white; margin: auto; height:100%; }
        #flashcontent { position:relative; margin: auto; text-align:center; height: 100%; width: 100%;}
    </style>
    
<script type="text/JavaScript">
<!--

//CLEANUP CODE WHEN USER CLICKS x OF BROWSER IE Tested only
var flash;

window.onload = function() {
	if(navigator.appName.indexOf("Microsoft") != -1) {
		flash = window.flashObject;
	}else {
		flash = window.document.flashObject
	}
}
var message = 'Are you sure you want to leave?'; 
window.onbeforeunload = function (evt) { 

	if (typeof evt == 'undefined') { 
		evt = window.event; 
	} 
	if (evt) { 
		flash.Logout();
	} 
} 

function handleError() {
	return true;
}

window.onerror = handleError;

//-->
</script>
</head>
<body>

    <form id="form1" runat="server" style="height:100%">
        <div id="flashcontent"></div>
        
        <script type="text/javascript">
                var so = new SWFObject("sabong_now.swf", "sabongnow", "100%", "100%", "9", "#FFFFFF");
                so.write("flashcontent");
        </script>
    </form>  
    
</body>
</html>

	
	<?php
	}
	else
	{
		header("location:index.php"); 
	}
?>





