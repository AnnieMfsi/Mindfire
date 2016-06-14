   <?php
    ini_set('display_errors', 1);//for errors to be printed on screen for user or not
    ini_set('display_startup_errors', 1);//for php start up errors during debugging
    error_reporting(E_ALL);


    //initialize the connection parameters

    $host = 'localhost';
    $uName = 'root';
    $password = 'mindfire';
    $database = 'RegistrationInfo';

    // making connection
    $conn = mysqli_connect($host, $uName, $password, $database);

    //checking connection
    if (mysqli_connect_error($conn)) {
    die('Failed to connect to database' .mysqli_connect_error());
    }



    
    ?>