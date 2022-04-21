<?php

    $serverName = "DESKTOP-Q5PEO1M"; //change the server name if you want to access this on your local server
    $databaseName = "Teachers"; 

    $connectionInfo = array("Database"=>$databaseName); 

    /* Connect using SQL Server Authentication. */  
    $conn = sqlsrv_connect( $serverName, $connectionInfo);

    if(!$conn)
    {
        echo "Connection not established";
    }
?>
