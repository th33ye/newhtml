<?php
/* 
 * Helpers
 */
ob_start();

class helpers {
    // Redirect pages
    function redirect($location){
        header("Location: ".$location);
    }
    // Validate sessions
    function validate_session($session, $location){
        if(!$session){
            $this->redirect($location);
        }
    }
}
$helpers = new helpers();
ob_end_flush();

