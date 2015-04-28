

/********************/
/*   Bet Manager 	*/
/*  Author : P F B  */
/********************/

function PlaceOrCancelBet(betMode)
{
		
	var qString = "";
	var betamount = "";
	var betType = "";
	var betOdds = "";
	var betOddsCtrl = "";
	var userId = "";
	var gameId = "";
	var arenaId = "";
		
	
	userId = document.getElementById('userId').value;
	gameId = document.getElementById('gameId').value;
	arenaId = document.getElementById('arenaId').value;
	
	betamount = document.getElementById('Betamount').value;
	betOddsCtrl = document.getElementById('Odds');
	betOdds = betOddsCtrl[betOddsCtrl.selectedIndex].id;	
	
	if (document.getElementById('rbMeron').checked == true)
	{
		betType = 'm';
	}
	else
	{
		betType = 'w';
	}

			
	qString = 'arenaId=' + arenaId + '&betamount=' + betamount + '&betType=' + betType + 
			  '&betOdds=' + betOdds + '&gameId=' + gameId + '&userId=' + userId + '&betMode=' + betMode  ;
			  
	if (betMode == 'place')
	{
		var creditAvailable = 0;
		
		if (document.getElementById("userCreditsHidden") != null)
		{

			creditAvailable = document.getElementById("userCreditsHidden").value;

            /* DEBUG: th33ye */
            if (parseFloat(creditAvailable) >= parseFloat(betamount))
            {
				PostData('PlaceBet.php', qString, 'BetStatus');
                /*
                    DEBUG: th33ye
                 */
                clearBetTable();
				LoadMyBets();
			}
			else
			{
				alert('Your credit is insufficient to place this bet.');
			}
		}
		
	}
	else if (betMode == 'cancel')
	{	
		var yesno = confirm('Are you sure you want to modify the bet on this odd? Click OK to proceed.' );
		
		if (yesno)
		{	
			PostCancelBet('CancelBet.php', qString, currentOdd);
			//LoadMyBets();
		}
	
	}
	
}


function CancelBetManual(betType, betamount, betOdds, currentOdd)
{

	var userId = "";
	var gameId = "";
	var arenaId = "";
	
	var qString = "";
		
	userId = document.getElementById('userId').value;
	gameId = document.getElementById('gameId').value;
	arenaId = document.getElementById('arenaId').value;
		
		
	qString = 'arenaId=' + arenaId + '&betamount=' + betamount + '&betType=' + betType + 
			  '&betOdds=' + betOdds + '&gameId=' + gameId + '&userId=' + userId + '&betMode=cancel'   ;
		  
	PostCancelBet('CancelBet.php', qString, currentOdd);
	
	
}



function PlaceBetManual(betamount, betType, betOdds)
{
		var qString = "";
		var userId = "";
		var gameId = "";
		var arenaId = "";
		
		userId = document.getElementById('userId').value;
		gameId = document.getElementById('gameId').value;
		arenaId = document.getElementById('arenaId').value;
					
		qString = 'arenaId=' + arenaId + '&betamount=' + betamount + '&betType=' + betType + 
				  '&betOdds=' + betOdds + '&gameId=' + gameId + '&userId=' + userId + '&betMode=place'  ;
				  
	
		var creditAvailable = 0;
		
		if (document.getElementById("userCreditsHidden") != null)
		{
			creditAvailable = document.getElementById("userCreditsHidden").value;					
	
			prevAmount = document.getElementById('b' + betType + '-' + betOdds + 'h').value;
			
			//alert(prevAmount);
			
			if (prevAmount == '')
			{
				prevAmount = 0;
			}
			
					
			if (parseInt(prevAmount) > parseInt(betamount))
			{					
				document.getElementById('b' + betType + '-' + betOdds + 'h').value = betamount;
				CancelBetManual(betType, parseInt(prevAmount) - parseInt(betamount), betOdds, 'b' + betType + '-' + betOdds);				
			}
			else
			{
				if (parseFloat(creditAvailable) >= parseFloat(betamount))
				{
					if (parseInt(betamount) > 0)
					{
						if (parseInt(betamount) >= 5)
						{						
			
							if (parseInt(betamount) > parseInt(prevAmount))
							{
								newbet = parseFloat(betamount) - parseFloat(prevAmount);
								qString = 'arenaId=' + arenaId + '&betamount=' + newbet + 
								'&betType=' + betType + '&betOdds=' + betOdds + '&gameId=' + gameId + '&userId=' + userId + 
								'&betMode=place';
								PostData('PlaceBet.php', qString, 'BetStatus', 'b' + betType + '-' + betOdds);
								
							
							}
							
							
						}
						else
						{
							document.getElementById('b' + betType + '-' + betOdds).value = prevAmount;
							alert('Bet should not be less than 5 points.');
						}
					}
				}
				else
				{
					alert('Your credit is insufficient to place this bet.');
				}
			}
	
		}
			

}


function ConfirmBet(placeOrCancel)
{
	PlaceOrCancelBet(placeOrCancel);
}

function UpdateBetTable(userId, arenaId, gameId, currentOdd)
{		
	PostUpdateBetTable('MyBets.php', 'gameId=' + gameId + '&arenaId=' + arenaId + '&userId=' + userId, currentOdd);
}

function EnableDisableBettingTable()
{	
	OddIds = document.getElementById("oddsIdList").value;

	var OddList = OddIds.split(",");
		
	for (x=0;x<OddList.length;x++)
	{
		if (document.getElementById(OddList[x]) != null)
		{
			document.getElementById(OddList[x]).innerHTML = '';
		}
	}	
}


function FillBetTable(result, currentOdd)
{		
	
	OddIds = document.getElementById("oddsIdList").value;
	var Odds = result.split(",");	
		
	betStatus = document.getElementById('betStatus').innerHTML;
	gameResult = document.getElementById('gameResult').innerHTML;
	
	if ((betStatus == 'Betting Open' && gameResult == '') || (betStatus == 'Betting Close' && gameResult == ''))
	{	
		for (u=0;u<Odds.length;u++)
		{
			var OddParts = Odds[u].split('|');
			
			if ((OddParts[0] != '') && (OddParts[0] != null))
			{
				if (document.getElementById(OddParts[0]) != null &&  document.getElementById(OddParts[0]) != '')
				{						
						document.getElementById(OddParts[0]).value = OddParts[1].replace('.00','');								
						document.getElementById(OddParts[0] +'h').value = OddParts[1].replace('.00','');
					
				}
			}
			
		}
		
		

					
		if (currentOdd != null)
		{
			document.getElementById(currentOdd + 'h').value = document.getElementById(currentOdd).value;
		}

		LoadWinnings();
		
	
	}
}

function LoadWinnings()
{
	//document.getElementById('win1').innerHTML = "100";
	
	//alert('loading winnings');
	OddIds = document.getElementById("oddsIdList").value;
	
	Odd = OddIds.split(',');
	
	for (i=0;i<Odd.length;i++)
	{
		//oddId = 
		bt = Odd[i].substring(0,1);	
		
		if (bt == 'w')
		{ 	
			Oid = Odd[i].substring(1,5);
			OddMult = document.getElementById('OddId-' + Oid).innerHTML;	
			mult = OddMult.split('-');
			wMult = parseFloat(mult[0]) /  parseFloat(mult[1]);
			mMult = parseFloat(mult[1]) /  parseFloat(mult[0]);
			
  
			betW = document.getElementById('bw-' + Oid).value ;
			betM = document.getElementById('bm-' + Oid).value ;

			if (betW == '')
			{
				betW = 0;
			}
			if (betM == '')
			{	
				betM = 0;
			}
						
			winW = parseFloat(betW) * parseFloat(wMult);			
			winM = parseFloat(betM) * parseFloat(mMult);
						

			totalWin = (betW * (parseFloat(mult[1]) /  parseFloat(mult[0]))) - betM;
			
			mrk = '';
			
			if (winW > winM)
			{
				totalWin = ((betW * (parseFloat(mult[1]) /  parseFloat(mult[0]))) - betM);
				mrk = '(W)';
			}
			else if (winW < winM)
			{
				totalWin = ((betM * (parseFloat(mult[0]) /  parseFloat(mult[1]))) - betW);
				mrk = '(M)';
			}
			else
			{
				mrk = '';
			}
			
			if (totalWin == 0)
			{
				mrk = '';
			}			
			
			if (parseFloat(totalWin) < 0)
			{
				totalWin = totalWin * -1;
			}
			
			totalWin = totalWin * .965;
							 
			document.getElementById('win' + Oid).innerHTML = mrk + totalWin.toFixed(2);
			
		}
	}

	
	//for (x=0;x<OddIds.length 
}





function clearBetTable()
{	
	//var betStatus=document.getElementById('betStatus').innerHTML;
	//var gameResult=document.getElementById('gameResult').innerHTML;
	var OddIds = document.getElementById("oddsIdList").value;

	var OddList = OddIds.split(",");
	
	for (k=0;k<OddList.length;k++)
	{		
		odd = OddList[k];
		Oid = odd.substring(1,5);
		
		if (document.getElementById('bm-' + Oid) != null)
		{
			document.getElementById('bm-' + Oid).value = '';
			document.getElementById('bw-' + Oid).value = '';
			document.getElementById('bm-' + Oid +'h').value = 0;
			document.getElementById('bw-' + Oid +'h').value = 0;
			document.getElementById('win' + Oid).innerHTML = "0.00";
		}
	}	
}




function keyPressed(e, ctrl)
{	
	var qString = "";
	var userId = "";
	var gameId = "";
	var arenaId = "";
	var chId = ctrl.id;
	var idSpl = chId.split('-');
	
	userId = document.getElementById('userId').value;
	gameId = document.getElementById('gameId').value;
	
		
	qString = 'betOdds=' + idSpl[1] + '&gameId=' + gameId + '&userId=' + userId + '&betType=' + idSpl[0].substring(1);

	PostPlaceBet('GetCurrentBet.php', qString, e, ctrl);

}

function PlaceBetAfterKeyPressed(currentBetOnOdd, e, ctrl)
{
	if (e.keyCode == 13)
	{
		if (parseInt(ctrl.value) > -1)
		{
			var chId = ctrl.id;
			var idSpl = chId.split('-');		
						
			//alert(idSpl[0].substring(1));			
			creditAvailable = document.getElementById("userCreditsHidden").value;
			creditAvailable = parseFloat(creditAvailable) + parseFloat(currentBetOnOdd);
			
			//alert(creditAvailable);
			
			betamount = ctrl.value;
			
			//Get current bet on the current ODD
			//Put On the container
			//Add to current credit

			// Added by - arvin (09/25/2012)
			// remove the decimal in user's bet
			betamount = parseInt(betamount);
			// end debug
			if (parseInt(betamount) % 5 == 0)
			{
				if (parseFloat(creditAvailable) >= parseFloat(betamount))
				{
					if (document.getElementById(idSpl[0] + '-' + (parseInt(idSpl[1]) + 1)) != null)
					{
						document.getElementById(idSpl[0] + '-' + (parseInt(idSpl[1]) + 1)).focus();
					}

					PlaceBetManual(betamount, idSpl[0].substring(1), idSpl[1]);	
					
				}
				else
				{
					ctrl.value = '';


					alert('Your credit is insufficient to place this bet.');
				}
			}
			else
			{
				alert('Please make sure that your bet is increments 5. e.g. 10, 15, 20 .... 100, 115, 120');
			}
			
			
		}
		else
		{
			alert('Please enter a valid bet.');
		}
		
	}
}


function LoadMyBets(currentOdd)
{
		//alert('loading My bets');
		gameId = document.getElementById('gameId').value;	
		arenaId = document.getElementById('arenaId').value;	
		userId = document.getElementById('userId').value;
		UpdateBetTable(userId, arenaId, gameId, currentOdd);
}
