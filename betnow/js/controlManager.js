/* 
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

var interval;
$(document).ready(function() {
   interval = setInterval(trackLogin, 1000);
});

function trackLogin()
{
    $.ajax({
        type    : 'GET',
        url     : 'checkLogin.php',
        dataType: 'json',
        success : function(data) {
            if (data.logout == '1') {
                clearInterval(interval);
                alert('You have been logged out. You will now be redirected to home page.');
                document.location.href = "index.php";
            }
        }
    });
}
