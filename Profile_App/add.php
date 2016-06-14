<?php
   require_once("config/dbConnect.php");   
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
        $communication = (isset($_POST['comm']) && !empty($_POST['comm'])) ? implode(", " , $_POST['comm']) : '';
        $note = isset($_POST['note']) ? $_POST['note'] : '';
        $update = isset($_POST['checkUpdate']) ? 1 : 0;
        $employeeIdUpdate = isset($_POST['employeeId']) ? $_POST['employeeId'] : '';
      
      
   
        echo "$update";
        echo '<br/>' . "$employeeIdUpdate";
   
        
   
       if(1 == $update){
   
         //update details
         $empUpdate = "UPDATE Employee
                             SET title = '$title', firstName = '$firstName', middleName = '$middleName', lastName = '$lastName', dateOfBirth = '$dob',
                                 gender = '$gender', phone = '$phone', email = '$email', maritalStatus = '$marStatus', empStatus = '$empStatus',
                                 commId = '$communication', employer = '$employer', note = '$note'
                             WHERE empId = $employeeIdUpdate";
         $empOfcUpdate = "UPDATE Address
                           SET street = '$ofcStreet', city = '$ofcCity', zip = '$ofcZip', state = '$ofcState'
                           WHERE empId = '$employeeIdUpdate' AND addressType = 'office'" ;
         $empResUpdate = "UPDATE Address
                           SET street = '$resStreet', city = '$resCity', zip = '$resZip', state = '$resState'
                           WHERE empId = '$employeeIdUpdate' AND addressType = 'residence' ";
   
         $result  = mysqli_query($conn, $empUpdate);
         mysqli_query($conn, $empOfcUpdate);
         mysqli_query($conn, $empResUpdate);
   
         echo $empUpdate . '<br />';
         echo $empOfcUpdate . '<br />';
         echo $empResUpdate . '<br />';
   
   
       }
       else{
         
   
         // Insert personal details
        $employeeInsert = "INSERT INTO Employee(title, firstName, middleName, lastName, dateOfBirth, gender, phone, email, maritalStatus, empStatus, commId, note, employer)
         VALUES ('$title', '$firstName', '$middleName', '$lastName', '$dob', '$gender', $phone, '$email', '$marStatus', '$empStatus', '$communication', '$note', '$employer')";
      
         echo $employeeInsert;
   
         $result  = mysqli_query($conn, $employeeInsert);
   
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
       }
   
         echo "Thanks for Your Interest.";
   
         //Print auto-generated id
         echo "New record has id: " . mysqli_insert_id($conn);
   
         header('Location:list.php');
      
      
      ?>