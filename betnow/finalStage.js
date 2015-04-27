// 

function SetModule(codeId, arenaId, gameNo)
{
	 PostFinalStage('FinalStage.php', 'codeId=' + codeId + '&arenaId=' + arenaId + '&gameNo=' + gameNo) ;
}


function GetGameNo()
{
	
	var gameNo = prompt("Create New Game?", parseInt(document.getElementById('gameNo').innerHTML) + 1);
	var arenaId = document.getElementById('arenaId').value;
	if (parseInt(gameNo) > 0)
	{
		SetModule(0, arenaId, gameNo);		
	}
	else
	{
		alert('Invalid Game Number');
	}

}


function OpenBetting()
{	
	var yesno = confirm('Open Betting Now? Click OK to proceed.' );
	var arenaId = document.getElementById('arenaId').value;
	if (yesno)
	{	
		SetModule(1, arenaId, 0);	
	}
}

function ConfirmCloseBetting()
{
	
	var yesno = confirm('Close Betting Now? Click OK to proceed.' );
	var arenaId = document.getElementById('arenaId').value;
	if (yesno)
	{	
		SetModule(2, arenaId, 0);
	}
	
}

function ConfirmMWinner()
{
	
	var yesno = confirm('Meron Wins? Click OK to proceed.' );
	var arenaId = document.getElementById('arenaId').value;
	if (yesno)
	{	
		SetModule(3, arenaId, 0);
	}
	
}

function ConfirmWWinner()
{
	
	var yesno = confirm('Wala Wins? Click OK to proceed.' );
	var arenaId = document.getElementById('arenaId').value;
	if (yesno)
	{	
		SetModule(4, arenaId, 0);
	}
	
}


function ConfirmEndGame()
{
	
	var yesno = confirm('This will end the game completely, do you want to proceed?' );
	var arenaId = document.getElementById('arenaId').value;
	if (yesno)
	{	
		SetModule(7, arenaId, 0);
	}
	
}


function ConfirmDrawOrCancel(drawOrCancel)
{

	var yesno = confirm(drawOrCancel + ' Game ?, Click OK to proceed.' );
	
	if (yesno)
	{	
		if(drawOrCancel == 'Draw')
		{		
			SetModule(5, arenaId, 0);
		}
		else if(drawOrCancel == 'Cancel')
		{
			SetModule(6, arenaId, 0);
		}		   
		
	}
	
}



