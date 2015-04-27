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
            refreshFightResults();
//            setInterval("refreshOnlineUsers()", 3000);
        });

        function refreshFightResults() {
            $.post("php/results-ajax.php", '',
            function(data){
                if(data.success == '1') {
                    $('#tblResults').remove();
                    var tbl = $('<table id=\'tblResults\'></table>');
                    tbl.append('<tr><th>G</th><th>R</th></tr>');
                    jQuery.each(data.fight_data, function(i, val) {
                        var tr = $('<tr></tr>');

                        $.each(val, function(i, newVal) {
                            var td = $('<td></td>').text(newVal);
                            tr.append(td);
                        });
                        tbl.append(tr);
                        $('#running-result').append(tbl);
                    });
                } // end if
            }, "json");
            setTimeout('refreshFightResults()', 3000);
       }

    </script>
</head>

<body>
	<div id="running-result"></div>
</body>
</html>
