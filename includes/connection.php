<?php
 if (strpos($_SERVER['DOCUMENT_ROOT'], "xampp") == false){
    require($_SERVER["DOCUMENT_ROOT"] . "/../constants.php");
 }else{
    require($_SERVER['DOCUMENT_ROOT'] . "\cbe\constants.php");
}

    //1. Create a database connectivity
    $connection = mysql_connect(DB_SERVER,DB_USER,DB_PASSWORD);
    if(!$connection)
     {
        die("Database connection failed" . mysql_error());
     }
    //2. Select the database from the server
    $db_select= mysql_select_db(DB_NAME,$connection);
      if(!$db_select)
     {
        die("Database selection failed " . mysql_error());
     }
?>