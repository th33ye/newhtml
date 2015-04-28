
/********************/
/*   Bet Manager 	*/
/*  Author : P F B  */
/********************/
function CreateGetXmlHttp()
{
	var xmlhttp;	
	
	if (window.XMLHttpRequest)
	{// code for IE7+, Firefox, Chrome, Opera, Safari
		  xmlhttp=new XMLHttpRequest();
	}
	else
  	{// code for IE6, IE5
		xmlhttp=new ActiveXObject("Microsoft.XMLHTTP");
	}
	
	return xmlhttp;
}


function PostData(PageUrl, QueryString, divId, currentOdd)
{
    /*
     DEBUG: th33ye
     */
    //$("#mybet").find("input").attr("disabled", "disabled");

    $("#mybet :input").attr("disabled", "disabled");

    xmlhttp15 = CreateGetXmlHttp();
	xmlhttp15.onreadystatechange=	
				function ReturnDisplay(currentOdd)
				{
				    //alert('loading bets');

                    if (xmlhttp15.readyState==4 && xmlhttp15.status==200)
                    {
                        //alert('ok naman');
                    	LoadMyBets(currentOdd);
						//if (xmlhttp.responseText != "")
						//{
						//}
					}
				}

    /*
        DEBUG: th33ye
     */

    //alert("POSTDATA: \n Value of PageUrl : " + PageUrl + "\n Value of QueryString : " + QueryString + "\n Value of divId : " + divId + "\n Value of currentOdd");

    /*
    $('#btnPlaceBet').attr('disabled', false);
    $('#btnCancelBet').attr('disabled', false);
    $('#Odds').attr('disabled', false);
    $('#Betamount').attr('disabled', false);
    */


	xmlhttp15.open("POST", PageUrl, true);
	xmlhttp15.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
	xmlhttp15.send(QueryString);
}




function PostGameDisplay(PageUrl, QueryString)
{
		
	xmlhttp = CreateGetXmlHttp();	
	xmlhttp.onreadystatechange=function GameStat()
		{
			  var statparts;  

			  if (xmlhttp.readyState==4 && xmlhttp.status==200)
			  {
					strgamestat = xmlhttp.responseText;
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
			  else
			  {
  				  //alert(xmlhttp.status + ' ' + xmlhttp.responseText);
			  }
		}
	
	
	xmlhttp.open("POST", PageUrl, true);
	xmlhttp.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
	xmlhttp.send(QueryString);
}


function PostAllDisplay(PageUrl, QueryString)
{	
	xmlhttp6 = CreateGetXmlHttp();	
	xmlhttp6.onreadystatechange=function GameDisp()
		{
			  var statparts;  

			  if (xmlhttp6.readyState==4 && xmlhttp6.status==200)
			  {
				  	if (document.getElementById('AllDisplay') != null)
					{
						document.getElementById('AllDisplay').value = xmlhttp6.responseText;
						UpdateDisplay(document.getElementById('AllDisplay').value);
					}
			  }	
		}
	
	
	xmlhttp6.open("POST", PageUrl, true);
	xmlhttp6.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
	xmlhttp6.send(QueryString);

	
}







function PostFinalStage(PageUrl, QueryString)
{
	xmlhttp = CreateGetXmlHttp();	
	xmlhttp.onreadystatechange=function SetFinalStage()
					{						
						  if (xmlhttp.readyState==4 && xmlhttp.status==200)
						  {

						  }
					}	
	
	xmlhttp.open("POST", PageUrl, true);
	xmlhttp.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
	xmlhttp.send(QueryString);
}




function PostOdds(PageUrl, QueryString)
{
//	alert(PageUrl);
	xmlhttp1 = CreateGetXmlHttp();	
	xmlhttp1.onreadystatechange=function SetOdds()
					{						
						  if (xmlhttp1.readyState==4 && xmlhttp1.status==200)
						  {
							  resulta = xmlhttp1.responseText;
							  FillOdds(resulta);

						  }
	
					}	
	
	xmlhttp1.open("POST", PageUrl, true);
	xmlhttp1.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
	xmlhttp1.send(QueryString);
}



function GetOddIds(PageUrl, QueryString)
{
//	alert(PageUrl);
	xmlhttp2 = CreateGetXmlHttp();	
	xmlhttp2.onreadystatechange=function GetOdds()
					{						
						  if (xmlhttp2.readyState==4 && xmlhttp2.status==200)
						  {
							  resulta = xmlhttp2.responseText;
							  document.getElementById("oddsIdList").value = resulta;

						  }
						  else
						  {

						  }
					}	
	
	xmlhttp2.open("POST", PageUrl, true);
	xmlhttp2.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
	xmlhttp2.send(QueryString);
}


function PostCancelBet(PageUrl, QueryString, currentOdd)
{
//	alert(PageUrl);
	xmlhttp3 = CreateGetXmlHttp();	
	xmlhttp3.onreadystatechange=function CancelBetM()
					{			
		  				  //LoadMyBets();			
						  if (xmlhttp3.readyState==4 && xmlhttp3.status==200)
						  {
							  	alert(xmlhttp3.responseText);
	 						    LoadMyBets(currentOdd);
						  }
					}	
	
	xmlhttp3.open("POST", PageUrl, true);
	xmlhttp3.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
	xmlhttp3.send(QueryString);
}


function PostUpdateBetTable(PageUrl, QueryString, currentOdd)
{
//	alert(PageUrl);	
	xmlhttp1 = CreateGetXmlHttp();	
	xmlhttp1.onreadystatechange=function SetBetTable()
					{						
						  if (xmlhttp1.readyState==4 && xmlhttp1.status==200)
						  {
						  	  
							  resulta = xmlhttp1.responseText;
							  FillBetTable(resulta, currentOdd);

						  }
						  else
						  {

						  }
					}	
	
	xmlhttp1.open("POST", PageUrl, true);
	xmlhttp1.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
	xmlhttp1.send(QueryString);
}


function PostLoadVideo(PageUrl, QueryString)
{
//	alert(PageUrl);
	xmlhttp1 = CreateGetXmlHttp();	
	xmlhttp1.onreadystatechange=function LoadVideoPost()
					{						
						  if (xmlhttp1.readyState==4 && xmlhttp1.status==200)
						  {
							  document.getElementById('videoContainer').innerHTML = xmlhttp1.responseText;
						  }						
					}	
	
	xmlhttp1.open("POST", PageUrl, true);
	xmlhttp1.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
	xmlhttp1.send(QueryString);
}


function PostPlaceBet(PageUrl, QueryString, e, ctrl)
{
	
	xmlhttp4=CreateGetXmlHttp();	
	xmlhttp4.onreadystatechange=
					function UpdateBetVal()
					{						
						  if (xmlhttp4.readyState==4 && xmlhttp4.status==200)
						  {
							  var currentBet = 0;
							  currentBetOnOdd = parseFloat(xmlhttp4.responseText);
							  PlaceBetAfterKeyPressed(currentBetOnOdd, e, ctrl);	
						  }						
					}	

    /*
       DEBUG: th33ye
     */

    //alert("PostPlaceBet: \n Value of PageUrl : " + PageUrl + "\n Value of QueryString : " + QueryString);

	xmlhttp4.open("POST", PageUrl, true);
	xmlhttp4.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
	xmlhttp4.send(QueryString);
	
	
}



