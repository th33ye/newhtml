<?php
/* 
 * Database connection
 */
require_once("config.php");

class MySQLDatabase {
    /****Function Construct****/
    public function __construct(){
        $this->connection();
        $this->selected_db_a();
        //$this->selected_db_b();
    }

    /****Database connection****/
    public function connection(){
        // Offline
         //$this->connection = mysql_pconnect(DB_SERVER, DB_USER, DB_PASS) or die(mysql_error());
        // Online
        $this->connection = mysql_pconnect(DB_SERVER, DB_USER, DB_PASS) or die(mysql_error());
    }

    /****Database selection****/
    public function selected_db_a(){
        $selected_db = mysql_select_db('ABENMACH_SabongnowProd', $this->connection) or die(mysql_error());
    }
}
$database = new MySQLDatabase();

