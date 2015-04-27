/*
    gamestat.js
    Process game status result
    
    created by: dPhoenix
*/

function getGameStatus() {
    $.ajax({
        type:"POST",
        url:"gamestat.php",
        data: {
            'function':'gameresult'
        },
        dataType:"json",
        success: function(data) {
            $("#gamenumber").val(data.gamenumber);
            $("#gamestatus").val(data.gamestatus);
            $("#gameresult").val(data.gameresult);
        },
    });
}    