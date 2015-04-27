<?php
session_start();
include('ipblocked.php');
//include('secQCheck.php');
	$seq_id = $_REQUEST['sid'];
	$fight_id = $_REQUEST['fid'];
	$game_id = $_REQUEST['gid'];
	$oddid = $_REQUEST['oddid'];
	
	if (isset($_SESSION['user_username']) ) 
	{	
		if ($_SESSION['user_username']== "") 
		{
			header("location:index.php"); 
		}
		
		function ShowResult($fid, $sid, $gid, $oddid)
		{
			include 'dbconn_normal.php';
			
			$sql = "select o.odd_name, ub.user_username, b.* from betsreport b " .
					" left join (select u.user_username, bs.bet_id from betsreport bs " .
					" join users u on u.user_id  = bs.bet_user_id " .
					" where bs.bet_game_id = " . $gid .
					" and bs.bet_fight_id = " . $fid .
					" and bs.bet_odd_id = ". $oddid .") ub on b.bet_ref_bet_id = ub.bet_id " .
					" join odds o on o.odd_id = b.bet_odd_id " .
					" where b.bet_user_id = " . $_SESSION['user_id'] .
					" and b.bet_game_id = " . $gid .
					" and b.bet_fight_id = " . $fid .
					" and b.bet_odd_id = " . $oddid;

			//echo($sql);
			$result = mysql_query($sql);
			if ($result)
			{
					echo "<table width=100% border=1 cellspacing=0 cellpadding=0>	";
					echo "  <tr>	";
					echo "	<td width=10%><div align=center class=style10><span class=style9><strong> # </strong></span></div></td>	";
					echo "	<td width=12%><div align=center class=style10><span class=style9><strong>Bet On </strong></span></div></td>	";
					echo "	<td width=12%><div align=center class=style10><span class=style9><strong>Odd </strong></span></div></td>	";
					echo "	<td width=15%><div align=center class=style10><span class=style9><strong>Amount </strong></span></div></td>	";
					echo "	<td width=15%><div align=center class=style10><span class=style9><strong>Remarks </strong></span></div></td>";
					//echo "	<td width=19%><div align=center class=style10><span class=style9><strong>Action </strong></span></div></td>";
					//echo "	<td width=24%><div align=center class=style10><span class=style9><strong>Current Credit </strong></span></div></td>";
					echo "  </tr>	";
					$bet_counter = 1;
				while($row = mysql_fetch_array($result))
				{ 
				
					if ($row['bet_cock_id'] == 1)
					{
						$beton = "<font  color='#3300CC'>WALA</font>";
					}
					elseif ($row['bet_cock_id'] == 2)
					{
						$beton = "<font  color='red'>MERON</font>";
					}
					else
					{
						$beton = "";
					}
					
					if ($row['bet_match_flag'] == 1)
					{
						//$remarks = "Matched with " . $row['user_username'] ;
						$remarks = "Matched";
					}
					elseif ($row['bet_cancel_flag'] == 1)
					{
						$remarks = "Cancelled" ;
					}
						
					//odd_name, user_username, betsreport_id, bet_id, bet_arena_id, bet_user_id, bet_odd_id, bet_game_id, bet_fight_id, 
					//bet_room_id, bet_amount, bet_cock_id, bet_ref_bet_id, bet_match_flag, bet_cancel_flag, bet_date_created, bet_date_updated, bet_created_by, bet_updated_by
					echo" <tr>";
					echo" <td><div align=center class=style13>". $bet_counter ."</div></td>";
					echo" 	<td><div align=center class=style13><strong>". $beton ."</strong></div></td>";
					echo" 	<td><div align=center class=style13>". $row['odd_name'] ."</div></td>";
					echo" 	<td><div align=center class=style13>". number_format($row['bet_amount'],2) ."</div></td>";
					echo" 	<td><div align=center class=style13>". $remarks ."</div></td>";
					//echo" 	<td><div align=center class=style13>". $row['credit_hist_comments'] ."</div></td>";
					//echo" 	<td><div align=center class=style13>". number_format($current_credit,2) ."</div></td>";
					echo"   </tr>";
					$bet_counter = $bet_counter + 1;
					
				} 
				
				echo "</table>";
				mysql_close($link2);
			}
			else
			{
				echo "	<p>No result found. Please try again.</p>";
			}
		}
	}
	else
	{
		header("location:index.php"); 
	}
?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Sabong Now</title>
<link href="CFA.css" rel="stylesheet" type="text/css" />
</head>

<body class="body">
	<!--Site Wrapper -->
<div class="site-wrapper" align="center">
<!--Header -->
			<div class="header-wrapper"></div>
            <!--End Header -->
            
            <!--Navigation -->
  <table  class="Nav-wrapper" border="0" cellspacing="0" cellpadding="0">
  <tr>
    <td width="30" class="navStart"></td>
    <td width="88" align="center">
    <a class="BtnHome" href="#"></a></td>
    <td width="112" align="center">
    <a class="BtnAbout" href="about.php"></a></td>
    <td width="125" align="center">
    <a class="BtnHowTo" href="howtoplay.php"></a></td>
    <td width="95" align="center">
    <a class="BtnRegister" href="register.php"></a></td>
    <td width="92" align="center">
    <a class="BtnCashier" href="#"></a></td>
    <td width="102" align="center">
    <a class="BtnSupport" href="support.php"></a></td>
    <td width="189 align="center"">
    <a class="BtnAboutCF" href="aboutcockfighting.php"></a></td>
    <td width="131" align="center">
    <a class="BtnLicense" href="license.php"></a></td>
    <td width="36" class="navEnd"></td>
  </tr>
</table>
	<!--End of Navigation -->
        
    <!--Body Wrapper -->
<table  class="body-wrapper" width="1000"border="0" cellspacing="0" cellpadding="0">
  <tr>
    <td colspan="3" align="center" class="bodyTop">&nbsp;</td>
    </tr>
  <tr>
    <td width="160" align="right" valign="top" class="LeftPanel">
    
    	<?php 
	  		include 'leftnav.php'; 
	  	?>
    
    </td>
    <td width="650"  align="center" valign="top" class="content">
    
     <!--COntent -->		
    <div id="content">
    		 <h2>Bet Details</h2>
                                         
                                        
                                         
					<p>
					<?php 
					//if($fight_date <> "")
					//{	
						ShowResult($fight_id, $seq_id, $game_id, $oddid); 
					//}
					?>
    
    
    </div>
    <!--End of Main Content -->
    
    </td>
    <!--LogIn Panel -->
    
    <td width="185" align="left" valign="top">
    	<?php
			if (isset($_SESSION['errormessage']))
			{
				
				if (isset($_SESSION['user_username']) && $_SESSION['user_username'] <> "" ) 
				{
					include 'loginnav.php'; 
				}
				else
				{
					include 'loginform.php'; 
				}
			}
			else
			{
				if (isset($_SESSION['user_username']) && $_SESSION['user_username'] <> "" ) 
				{
					include 'loginnav.php'; 
				}
				else
				{
					include 'loginform.php'; 
				} 
			}
			?>
    </td>
  </tr>
  <tr>
    <td colspan="3" align="center">&nbsp;</td>
    </tr>
  <tr>
    <td colspan="3" align="center" class="bodyBottom">&nbsp;</td>
    </tr>
</table>
<!--End of Body Wrapper -->

<!--Footer Bar -->
<div class="FooterBar"></div>
<!--End of Footer Bar -->

<div class="footer">All Rights Reserved © 2010 - 2011 by www.sabongnow.com

</div>


  </div>
	<!--End of Site Wrapper -->
</body>
</html>

<?php 
if (isset($_SESSION['errormessage']))
{
	$_SESSION['errormessage'] = ""; 
}

if (isset($_SESSION['registermessage']))
{
	$_SESSION['registermessage'] = ""; 
}
?>

