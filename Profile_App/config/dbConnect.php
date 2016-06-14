   <?php
    ini_set('display_errors', 1);// For errors to be printed on screen for user or not
    ini_set('display_startup_errors', 1);// For php start up errors during debugging
    error_reporting(E_ALL);

    // Initialize the connection parameters
    $host = 'localhost';
    $uName = 'root';
    $password = 'mindfire';
    $database = 'RegistrationInfo';

    // Making connection
    $conn = mysqli_connect($host, $uName, $password, $database);

    // Checking connection
    if (mysqli_connect_error($conn)) {
      die('Failed to connect to database' .mysqli_connect_error());
    }
    ?>