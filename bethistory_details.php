<?php
session_start();
include('ipblocked.php');
//include('secQCheck.php');
	$seq_id = $_REQUEST['sid'];
	$fight_id = $_REQUEST['id'];
	$game_id = $_REQUEST['gid'];
	$win_id = $_REQUEST['wid'];
	
	
	if (isset($_SESSION['user_username']) ) 
	{	
		if ($_SESSION['user_username']== "") 
		{
			header("location:index.php"); 
		}
		
		function ShowResult($fid, $sid, $gid)
		{
			include 'dbconn_normal.php';
			$sql = "SELECT c.*, o.odd_name FROM credithistory c " .
					" LEFT JOIN odds o ON o.odd_id = credit_hist_odd_id " .
					" where c.credit_hist_user_id = " . $_SESSION['user_id'] .
					" and c.credit_hist_game_id = " . $gid .
					" and c.credit_hist_fight_id = " .$fid ;
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
					echo "	<td width=15%><div align=center class=style10><span class=style9><strong>Previous Credit </strong></span></div></td>";
					echo "	<td width=19%><div align=center class=style10><span class=style9><strong>Action </strong></span></div></td>";
					echo "	<td width=24%><div align=center class=style10><span class=style9><strong>Current Credit </strong></span></div></td>";
					echo "  </tr>	";
					$bet_counter = 1;
				while($row = mysql_fetch_array($result))
				{ 
				
					if ($row['credit_hist_cock_id'] == 1)
					{
						$beton = "<font  color='#3300CC'>WALA</font>";
					}
					elseif ($row['credit_hist_cock_id'] == 2)
					{
						$beton = "<font  color='red'>MERON</font>";
					}
					else
					{
						$beton = "";
					}
						
					
					if ($row['credit_hist_trans_id'] == 3) //PLACE BET
					{
						$current_credit = $row['credit_hist_credits'] - $row['credit_hist_amount'];
					}
					elseif ($row['credit_hist_trans_id'] == 4) //CANCEL BET
					{
						$current_credit =  $row['credit_hist_amount'] + $row['credit_hist_credits'];
					}
					elseif ($row['credit_hist_trans_id'] == 5) //RETURNED
					{
						$current_credit =  $row['credit_hist_amount'] + $row['credit_hist_credits'];
						$beton = "";
					}
					elseif ($row['credit_hist_trans_id'] == 6) //RETURNED
					{
						$current_credit =  $row['credit_hist_amount'] + $row['credit_hist_credits'];
						$beton = "";
					}
					elseif ($row['credit_hist_trans_id'] == 7) //WINNIGS
					{
						$current_credit =  $row['credit_hist_amount'] + $row['credit_hist_credits'];
						$beton = "";
					}
					elseif ($row['credit_hist_trans_id'] == 11) //WINNIGS
					{
						$current_credit =  $row['credit_hist_credits'] + $row['credit_hist_amount'] ;
						$beton = "";
					}
					elseif ($row['credit_hist_trans_id'] == 12) //WINNIGS
					{
						$current_credit =  $row['credit_hist_credits'] - $row['credit_hist_amount'] ;
						$beton = "";
					}
					//$fid, $sid, $gid
					echo" <tr>";
					if ($beton =="") 
					{
					echo" <td><div align=center class=style13><strong>". $bet_counter ."</strong></div></td>";
					}
					else
					{
					echo" <td><div align=center class=style13><strong><a href='bethistory_details2.php?fid=". $fid ."&gid=". $gid ."&sid=". $sid ."&oddid=". $row['credit_hist_odd_id']."' >". $bet_counter ."</a></strong></div></td>";
					}
					echo" 	<td><div align=center class=style13><strong>". $beton ."</strong></div></td>";
					echo" 	<td><div align=center class=style13>". $row['odd_name'] ."</div></td>";
					echo" 	<td><div align=center class=style13>". number_format($row['credit_hist_amount'],2) ."</div></td>";
					echo" 	<td><div align=center class=style13>". number_format($row['credit_hist_credits'],2) ."</div></td>";
					echo" 	<td><div align=center class=style13>". $row['credit_hist_comments'] ."</div></td>";
					echo" 	<td><div align=center class=style13>". number_format($current_credit,2) ."</div></td>";
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
                                         
                                         <p>Fight Number : <strong><?php echo $seq_id ?></strong></p>
                                         <p>Result : <strong><?php 
										 if ($win_id == 0)
										 	echo "Cancelled Fight"							 ;
										 elseif ($win_id == 1)
										 	echo "WALA Wins";
										 elseif ($win_id == 2)
										 	echo "MERON Wins";
										 elseif ($win_id == 3)
											 echo "It's a Draw";
										 ?></strong></p>
                                         
					<p>
					<?php 
					//if($fight_date <> "")
					//{	
						ShowResult($fight_id, $seq_id, $game_id); 
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

