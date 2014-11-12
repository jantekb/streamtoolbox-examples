<?php

    $dbHost = "localhost";      //Location Of Database usually its localhost 
    $dbUser = "wtbexample";           //Database User Name 
    $dbPass = "wtbexample123";         //Database Password 
    $dbDatabase = "wtbexampledb";    //Database Name 
     
    $db = mysql_connect($dbHost,$dbUser,$dbPass)or die("Error connecting to database.");
    mysql_select_db($dbDatabase, $db)or die("Couldn't select the database."); 

?>