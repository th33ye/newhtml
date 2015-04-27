<?php

//require_once("config.php");
//include('config.php');

define("DB_SERVER","127.0.0.1");
//define("DB_USER","coredev1");
//define("DB_PASS","5aBong1aBen5");
//define("DB_NAME","ABENMACH_SabongnowDev1");
define("DB_USER", "coreprodadm");
define("DB_PASS", "123CoreProdAdm890");
define("DB_NAME", "ABENMACH_SabongnowProd");
define("SELF",$_SERVER['PHP_SELF']);

/* application info */
define("APP_NAME","Game Console");
define("APP_VER","v2 BETA");
define("APP_FULLNAME",APP_NAME." ".APP_VER);
define("APP_COMPANY","Abenmach Technologies");

class MySQLDatabase 
{
    public function __construct()
    {
        $this->connection();
        $this->selected_db_a();
    }

    public function connection()
    {
        //$this->connection = mysql_pconnect(DB_SERVER, DB_USER, DB_PASS) or die(mysql_error());
        $this->connection = mysql_connect(DB_SERVER, DB_USER, DB_PASS) or die(mysql_error());
    }

    public function selected_db_a()
    {
        $selected_db = mysql_select_db(DB_NAME, $this->connection) or die(mysql_error());
    }
}
$database = new MySQLDatabase();
