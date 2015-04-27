
var timerID = 0;
var interval = 2000;

function UpdateTimer() 
{
	if (document.getElementById('signalFlag').value == 'Go')
	{
		Stop();
		document.getElementById('signalFlag').value = '';
	}
	else if (document.getElementById('signalFlag').value == 'Cancelled')
	{
		Stop();
	}
	else if (document.getElementById('signalFlag').value == 'Started')
	{
		timerID = setTimeout("UpdateTimer()", interval);
		var d = new Date();
		document.getElementById('CurrentTime').value = d.getSeconds();
		ProcessDisplay();

	}
}


function Start()
{	
	document.getElementById('signalFlag').value = 'Started';
	timerID  = setTimeout("UpdateTimer()", interval);
			
}

function Stop()
{
	alert('stopped');
	document.getElementById('signalFlag').value = '';
	timerID = 0;
	//URLNew = '';
}// JavaScript Document



