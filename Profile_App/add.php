<?php
   ini_set('display_errors', 1);//for errors to be printed on screen for user or not
   ini_set('display_startup_errors', 1);//for php start up errors during debugging
   error_reporting(E_ALL);
   
   
     $host = 'localhost';
     $uName = 'root';
     $password = 'mindfire';
     $database = 'RegistrationInfo';
   
     $title = isset($_POST['title']) ? $_POST['title'] : '';
     $firstName = isset($_POST['firstName']) ? $_POST['firstName'] : '';
     $middleName = isset($_POST['middleName']) ? $_POST['middleName'] : '';
     $lastName = isset($_POST['lastName']) ? $_POST['lastName'] : '';
     $email = isset($_POST['email']) ? $_POST['email'] : '';
     $gender = isset($_POST['gender']) ? $_POST['gender'] : '';
     $dob = isset($_POST['dob']) ? $_POST['dob'] : '';
     $phone = isset($_POST['phone']) ? $_POST['phone'] : '';
     $email = isset($_POST['email']) ? $_POST['email'] : '';
     $resStreet =isset($_POST['resStreet']) ? $_POST['resStreet'] : '';
     $resCity =  isset($_POST['resCity']) ? $_POST['resCity'] : '';
     $resZip = isset($_POST['resZip']) ? $_POST['resZip'] : '';
     $resState = isset($_POST['resState']) ? $_POST['resState'] : '';
     $ofcStreet = isset($_POST['ofcStreet']) ? $_POST['ofcStreet'] : '';
     $ofcCity = isset($_POST['ofcCity']) ? $_POST['ofcCity'] : '';
     $ofcZip = isset($_POST['ofcZip']) ? $_POST['ofcZip'] : '';
     $ofcState = isset($_POST['ofcState']) ? $_POST['ofcState'] : '';
     $marStatus = isset($_POST['marStatus']) ? $_POST['marStatus'] : '';
     $empStatus = isset($_POST['empStatus']) ? $_POST['empStatus'] : '';
     $employer = isset($_POST['employer']) ? $_POST['employer'] : '';
     $image = isset($_POST['image']) ? $_POST['image'] : '';
     $communication = (isset($_POST['comm']) && !empty($_POST['comm'])) ? implode(", ", $_POST['comm']) : '';
     $note = isset($_POST['note']) ? $_POST['note'] : '';
   
   
     // making and checking connection
    $conn = mysqli_connect($host, $uName, $password, $database);
    if (mysqli_connect_error($conn)) {
      die('Failed to connect to database' .mysqli_connect_error());
    }
   
    // Insert personal details
     $employee = "INSERT INTO Employee(title, firstName, middleName, lastName, dateOfBirth, gender, phone, email, maritalStatus, commId, note, employer)
      VALUES ('$title', '$firstName', '$middleName', '$lastName', '$dob', '$gender', $phone, '$email', '$marStatus', '$communication', '$note', '$employer')";
   
      echo $employee;

      $result  = mysqli_query($conn, $employee);

      $employeeId = mysqli_insert_id($conn);
      // writing sql query to insert personal details
      $ofcAddress = "INSERT INTO Address(addressType, street, city, zip, state, empId) values('office', '$ofcStreet', '$ofcCity', '$ofcZip', '$ofcState', '$employeeId') ";
      $ofcAddressResult = mysqli_query($conn, $ofcAddress);

      $resAddress = "INSERT INTO Address(addressType, street, city, zip, state, empId) values('residence', '$resStreet', '$resCity', '$resZip', '$resState', '$employeeId')";
      $resAddressResult = mysqli_query($conn, $resAddress);

      if (! $result) {
        echo "Insertion failed " . mysql_error(); //exit();
        setcookie('errors', 'fail');
        print_r($_COOKIE);
        header('Location:registration.php');
      }

      echo "Thanks for Your Interest.";

      // Print auto-generated id
      echo "New record has id: " . mysqli_insert_id($conn);

      header('Location:list.php');
   
   
   ?>



   