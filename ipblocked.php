<?php
require_once('ip2location.class.php');
$ip = new ip2location;
$ip->open('./databases/IP-COUNTRY.BIN');
$record = $ip->getAll($_SERVER["REMOTE_ADDR"]);
$country = $record->countryShort;
$countryFull = $record->countryLong;
/*
if ((($country=="PH" ) or ($country=="PH" )) and (IpExempted() == false))
{
	header("location:ipblocked_message.php");
}

function IpExempted()
{
	if (($_SERVER["REMOTE_ADDR"] == "202.124.132.109" ) or ($_SERVER["REMOTE_ADDR"] == "202.124.132.108" ) or ($_SERVER["REMOTE_ADDR"] == "202.124.132.107" ) or ($_SERVER["REMOTE_ADDR"] == "202.124.151.50" ) or ($_SERVER["REMOTE_ADDR"] == "202.124.132.106" ) or ($_SERVER["REMOTE_ADDR"] == "202.124.152.174" ) or ($_SERVER["REMOTE_ADDR"] == "121.54.92.134" ) or ($_SERVER["REMOTE_ADDR"] == "203.177.18.203" ) or ($_SERVER["REMOTE_ADDR"] == "203.177.18.205" ) or ($_SERVER["REMOTE_ADDR"] == "202.124.151.51" ) or ($_SERVER["REMOTE_ADDR"] == "202.124.151.52" ) or ($_SERVER["REMOTE_ADDR"] == "202.124.151.53" ) or ($_SERVER["REMOTE_ADDR"] == "202.124.151.54" ) or ($_SERVER["REMOTE_ADDR"] == "121.54.64.40" ))
	{
		return true;
	}
	else
	{
		return false;
	}
}
*/

?>
