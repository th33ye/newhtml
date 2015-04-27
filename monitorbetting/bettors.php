<?php
	include('secure.php');
?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN"
    "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html>
<head>
    <meta http-equiv="Content-type" content="text/html; charset=utf-8" />
    <title>Admin Monitoring</title>
   <link href="css/monitor.css" rel="stylesheet" type="text/css" />
    <script src="js/jquery-1.5.2.js" type="text/javascript" charset="utf-8"></script>
    <script type="text/javascript" charset="utf-8">

        $(document).ready(function(){
            refreshFightBetters();
            //refreshFightResults();
            //refreshOnlineUsers();
            setInterval("refreshFightBetters()", 3000);
        });

        function refreshFightBetters() {
            $.post("php/fightbetters.php", '',
            function(data){
                if(data.success == '1') {
                    $('#tblBetters').remove();
                    var tbl = $('<table id=\'tblBetters\'></table>');
                    tbl.append('<tr><th>Game</th><th>Username</th><th>Bet</th><th>Odd Id</th><th>Odd</th><th>Bet Amount</th><th>User Credit</th></tr>');
                    jQuery.each(data.betting_data, function(i, val) {
                        var tr = $('<tr></tr>');

                        $.each(val, function(i, newVal) {
                            var td = $('<td></td>').text(newVal);
                            tr.append(td);
                        });
                        tbl.append(tr);
                        $('#betters').append(tbl);
                    });
                } // end if
            }, "json");
            setTimeout('refreshFightBetters()', 3000);
        }

        function refreshFightResults() {
            $.post("php/fightresults.php", '',
            function(data){
                if(data.success == '1') {
                    $('#tblResults').remove();
                    var tbl = $('<table id=\'tblResults\'></table>');
                    tbl.append('<tr><th>Arena</th><th>Game</th><th>Result</th><th>Bets</th><th>Rake</th></tr>');
                    jQuery.each(data.fight_data, function(i, val) {
                        var tr = $('<tr></tr>');

                        $.each(val, function(i, newVal) {
                            var td = $('<td></td>').text(newVal);
                            tr.append(td);
                        });
                        tbl.append(tr);
                        $('#result').append(tbl);
                    });
                } // end if
            }, "json");
            setTimeout('refreshFightResults()', 3000);
       }

       function loggedOutUser(userid) {
            $.ajax({
               type     : 'POST',
               url      : 'php/logoutuser.php',
               data     : {userid: userid},
               success  : function(data) {
                  if (data.success == '1') {
                     refreshOnlineUsers();
                  }
               }
            });
         }

         function popBlocker(userid) {
            $.ajax({
               type     : 'POST',
               url      : 'php/popblocker.php',
               data     : {userid: userid},
               success  : function(data) {
                  if (data.success == '1') {
                     refreshOnlineUsers();
                  }
               }
            });
         }

         function popUnblock(userid) {
            $.ajax({
               type     : 'POST',
               url      : 'php/popunblock.php',
               data     : {userid: userid},
               success  : function(data) {
                  if (data.success == '1') {
                     refreshOnlineUsers();
                  }
               }
            });
         }

         function refreshOnlineUsers() {
            $.ajax({
               type     : 'GET',
               url      : 'php/onlineusers.php',
               dataType : 'json',
               success  : function(data) {
                  if (data.success == '1') {
                     $('#tblUsers').remove();
                     var count = data.rows - 1;
                     var tbl = $('<table id=\'tblUsers\'></table>');
                     tbl.append('<tr><th>Id</th><th>Username</th><th>Country</th><th>Credits</th><th>Action</th></tr>');
                     for (var i=0;i<=count;i++) {
                        // prepare row data
                        var link = '<a href=\'javascript:loggedOutUser('+data.users_online[i].user_id+');\'>Log-out</a>&nbsp;'
                                 + '<a href=\'javascript:popBlocker('+data.users_online[i].user_id+');\'>Block</a>&nbsp;'
                                 + '<a href=\'javascript:popUnblock('+data.users_online[i].user_id+');\'>UnBlock</a>';
                        
                        var tr = '<tr><td>'+data.users_online[i].user_id+'</td>'
                                 + '<td>'+data.users_online[i].user_username+'</td>'
                                 + '<td>'+data.users_online[i].country+'</td>'
                                 + '<td>'+data.users_online[i].user_credits+'</td>'
                                 + '<td>'+link+'</td></tr>';
                        tbl.append(tr);
                     }
                     $('#users').append(tbl);
                  }
               }
            });
         }
      
    </script>
</head>

<body>
    <div id="betters"></div>
    <a href="menu.php">Main Menu</a>&nbsp;&nbsp;
    <a href="logout.php">Logout</a>
</body>
</html>
