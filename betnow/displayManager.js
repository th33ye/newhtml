// JavaScript Document

/********************/
/*   Bet Manager 	*/
/*  Author : P F B  */
/********************/
function ProcessDisplay()
{
	gameId = document.getElementById('gameId').value;	
	arenaId = document.getElementById('arenaId').value;	
	userId = document.getElementById('userId').value;
	
	//PostOdds('GetOddsValues.php', 'gameId=' + gameId + '&arenaId=' + arenaId);	
	//PostGameDisplay('GameDisplay.php', 'userId=' + userId + '&arenaId=' + arenaId);	
	PostAllDisplay('UpdatingDisplays.php', 'userId=' + userId + '&arenaId=' + arenaId + '&gameId=' + gameId);
	

	if (document.getElementById('btnCreateNewFight') != null)
	{	
		DisableButtonsPerStatus();
	}
	else
	{
		DisableBettingTable();
	}

}


function UpdateDisplay(displayOut)
{	
	displayParts = displayOut.split('/');	
    GameDisplay(displayParts[0]);
	FillOdds(displayParts[1]);
	
	gameStatus = document.getElementById('betStatus').innerHTML;
	gameResult = document.getElementById('gameResult').innerHTML;
	
	if (document.getElementById('betsLoaded') != null)
	{	
		//Load once when loaded it will be set as 1
		loaded = document.getElementById('betsLoaded').value;
		

		if (loaded == 0 )	
		{
			document.getElementById('betsLoaded').value = 1;
			clearBetTable();
			LoadMyBets();
		}
		
		
		
		if (gameStatus == 'Betting Close' && gameResult == '')
		{
			loaded1 = document.getElementById('betsLoaded1').value;
			
			if (loaded1 == 0)
			{
				document.getElementById('betsLoaded1').value = 1;
				clearBetTable();
				LoadMyBets();
			}
				
		}
		else if (gameStatus == 'Betting Will Open Soon' && gameResult == '')
		{
			document.getElementById('betsLoaded1').value = 0;
		}
		else if (gameStatus == 'Game Has Been Ended')
		{
			EndGame();
		}
		
		
		
		//if (gameStatus == 
		//if (
		
	}

}



function GameDisplay(gameDisplayVal)
{
		strgamestat = gameDisplayVal;
		statparts = strgamestat.split('|');
		
		for (x=0;x<statparts.length;x++)
		{
			document.getElementById('gameId').value = 	statparts[0];
			document.getElementById('gameNo').innerHTML = 	statparts[1];
			document.getElementById('betStatus').innerHTML = 	statparts[2];
			document.getElementById('gameResult').innerHTML = 	statparts[3];
			document.getElementById('userCredits').innerHTML = 	statparts[4];
			document.getElementById('userCreditsHidden').value = statparts[4];


			if (statparts[2] == 'Betting Open')
			{
				$('#btnPlaceBet').attr('disabled', false);
				$('#btnCancelBet').attr('disabled', false);
				$('#Odds').attr('disabled', false);
				$('#Betamount').attr('disabled', false);								
			}
			else
			{
				$('#btnPlaceBet').attr('disabled', true);
				$('#btnCancelBet').attr('disabled', true);
				$('#Odds').attr('disabled', true);
				$('#Betamount').attr('disabled', true);										

			}
			
		}
	
}


function FillOdds(result)
{

	OddIds = document.getElementById("oddsIdList").value;
	var Odds = result.split(",");	
		
	betStatus = document.getElementById('betStatus').innerHTML;
	gameResult = document.getElementById('gameResult').innerHTML;
	
	if ((betStatus == 'Betting Open' && gameResult == '') || (betStatus == 'Betting Close' && gameResult == ''))
	{	
		for (x=0;x<Odds.length;x++)
		{
			var OddParts = Odds[x].split('|');
			
			if ((OddParts[0] != '') && (OddParts[0] != null))
			{
				if (document.getElementById(OddParts[0]) != null &&  document.getElementById(OddParts[0]) != '')
				{						
						document.getElementById(OddParts[0]).innerHTML = OddParts[1].replace('.00','');								
				}
			}
			
		}
	}
	else
	{		
		var OddList = OddIds.split(",");
		
		for (x=0;x<OddList.length;x++)
		{
				if (document.getElementById(OddList[x]) != null)
				{
					document.getElementById(OddList[x]).innerHTML = '';
				}
		}	
	}

	//	CompareOdds(result);	
	var OddList = OddIds.split(",");	
	for (x=0;x<OddList.length;x++)
	{
		if (result.indexOf(OddList[x]) == -1)
		{
			if (document.getElementById(OddList[x]) != null)
			{
				document.getElementById(OddList[x]).innerHTML = '';
			}
		}
	}	

}


function DisableButtonsPerStatus()
{
	var betStatus=document.getElementById('betStatus').innerHTML;
	var gameResult=document.getElementById('gameResult').innerHTML;

	
	if (betStatus == 'Betting Will Open Soon')
	{
		$('#btnCreateNewFight').attr('disabled', true);
		$('#btnOpenBetting').attr('disabled', false);
		$('#btnAnnounceMeronAsWinner').attr('disabled', true);
		$('#btnAnnounceWalaAsWinner').attr('disabled', true);
		$('#getbtnCreateNewFight').attr('disabled', true);
		$('#btnCloseBetting').attr('disabled', true);
		$('#btnSetAsDraw').attr('disabled', true);			
		$('#btnSetAsCancelled').attr('disabled', false);
		$('#specialBetting').attr('disabled', true);
		$('#btnEndGame').attr('disabled', true);
	}
	else if (betStatus == 'Betting Close')
	{
		$('#specialBetting').attr('disabled', true);
		if (gameResult == 'Game Cancelled')
		{
			$('#btnCreateNewFight').attr('disabled', false);
			$('#btnOpenBetting').attr('disabled', true);
			$('#btnCloseBetting').attr('disabled', true);
			$('#btnAnnounceMeronAsWinner').attr('disabled', true);
			$('#btnAnnounceWalaAsWinner').attr('disabled', true);
			$('#btnSetAsDraw').attr('disabled', true);			
			$('#btnSetAsCancelled').attr('disabled', true);
			$('#btnEndGame').attr('disabled', false);
		}
		else if (gameResult == 'Game Draw')
		{
			$('#btnCreateNewFight').attr('disabled', false);
			$('#btnCloseBetting').attr('disabled', true);
			$('#btnOpenBetting').attr('disabled', true);
			$('#btnAnnounceMeronAsWinner').attr('disabled', true);
			$('#btnAnnounceWalaAsWinner').attr('disabled', true);
			$('#btnSetAsDraw').attr('disabled', true);			
			$('#btnSetAsCancelled').attr('disabled', true);
			$('#btnEndGame').attr('disabled', false);
		}
		else if ((gameResult == 'MERON WINS') || (gameResult == 'WALA WINS'))
		{
			$('#btnCreateNewFight').attr('disabled', false);
			$('#btnCloseBetting').attr('disabled', true);
			$('#btnOpenBetting').attr('disabled', true);
			$('#btnAnnounceMeronAsWinner').attr('disabled', true);
			$('#btnAnnounceWalaAsWinner').attr('disabled', true);
			$('#btnSetAsDraw').attr('disabled', true);			
			$('#btnSetAsCancelled').attr('disabled', true);
			$('#btnEndGame').attr('disabled', false);
		}
		else
		{
			$('#btnCreateNewFight').attr('disabled', true);
			$('#btnCloseBetting').attr('disabled', true);
			$('#btnOpenBetting').attr('disabled', true);
			$('#btnAnnounceMeronAsWinner').attr('disabled', false);
			$('#btnAnnounceWalaAsWinner').attr('disabled', false);
			$('#btnSetAsDraw').attr('disabled', false);			
			$('#btnSetAsCancelled').attr('disabled', false);
			$('#btnEndGame').attr('disabled', true);
		}
	}
	else if (betStatus == 'Betting Open')
	{
		$('#btnCreateNewFight').attr('disabled', true);
		$('#btnCloseBetting').attr('disabled', false);
		$('#btnOpenBetting').attr('disabled', true);
		$('#btnAnnounceMeronAsWinner').attr('disabled', true);
		$('#btnAnnounceWalaAsWinner').attr('disabled', true);
		$('#btnSetAsDraw').attr('disabled', true);			
		$('#btnSetAsCancelled').attr('disabled', false);
		$('#specialBetting').attr('disabled', false);
		$('#btnEndGame').attr('disabled', true);
	}	
	else if (betStatus == 'Game Has Been Ended')
	{
		$('#btnCreateNewFight').attr('disabled', false);
		$('#btnCloseBetting').attr('disabled', true);
		$('#btnOpenBetting').attr('disabled', true);
		$('#btnAnnounceMeronAsWinner').attr('disabled', true);
		$('#btnAnnounceWalaAsWinner').attr('disabled', true);
		$('#btnSetAsDraw').attr('disabled', true);			
		$('#btnSetAsCancelled').attr('disabled', true);
		$('#specialBetting').attr('disabled', true);
		$('#btnEndGame').attr('disabled', true);
	}	


}



function DisableEnableBetTable(EnableDisable)
{	
	var betStatus=document.getElementById('betStatus').innerHTML;
	var gameResult=document.getElementById('gameResult').innerHTML;
	var OddIds = document.getElementById("oddsIdList").value;

	var OddList = OddIds.split(",");
	
	for (x=0;x<OddList.length;x++)
	{		
		odd = OddList[x];
		Oid = odd.substring(1,5);
		
		if (document.getElementById('bm-' + Oid) != null)
		{			
			$('#bm-' + Oid).attr('disabled', EnableDisable);
			$('#bw-' + Oid).attr('disabled', EnableDisable);
		}
	}	
}



function DisableBettingTable()
{
	var betStatus=document.getElementById('betStatus').innerHTML;
	var gameResult=document.getElementById('gameResult').innerHTML;
	var OddIds = document.getElementById("oddsIdList").value;

	var OddList = OddIds.split(",");
	
	for (x=0;x<OddList.length;x++)
	{
		odd = OddList[x];
		Oid = odd.substring(1,5);
		if (betStatus == 'Betting Open')
		{	
			DisableEnableBetTable(false);

		}
		else if((betStatus == 'Betting Close') &&  (gameResult == ''))
		{ 				
			DisableEnableBetTable(true);	
		}
		else
		{
			if (document.getElementById('bm-' + Oid) != null)
			{
				clearBetTable();
				DisableEnableBetTable(true);
			}			
		}		
	
	}	
	

}


function LoadBettingConsole()
{
	$.ajax({url:"BettingConsole.php", success:function(result){$("#gameConsole").html(result);}});	
	$('#bettingOrig').hide();
}

function LoadMyBetsTable()
{
	$.ajax({url:"SpecialBetting.php", success:function(result){$("#bettingTable").html(result);}});

}

function LoadOddIds()
{
	GetOddIds('OddsList.php','');
}

function LoadVideoConsole()
{
	arenaId = document.getElementById('arenaId').value;	
	userId = document.getElementById('userId').value;
	
	PostLoadVideo("videolink.php", "userId=" + userId + "&arenaId=" + arenaId);
}


function EndGame()
{
	alert('Thank you for playing, game has been ended your gaming console will be logged-out');
	window.location = 'Logout.php';
}


