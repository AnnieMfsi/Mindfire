<?php
    /*
      @Author  : Mfsi_Annapurnaa
      @purpose : Make db connection
    */
    //including the file containing the consta
    include('constants.php');
    // Initialize the connection parameters
    $host = DBHOST;
    $uName = DBUSER;
    $password = DBPASSWORD;
    $database = DBNAME;

    // Making connection
    $conn = mysqli_connect($host, $uName, $password, $database);

    // Checking connection
    if(mysqli_connect_error($conn)) 
    {
      die('Failed to connect to database' .mysqli_connect_error());
    }
?>