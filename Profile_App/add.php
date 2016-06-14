<?php
    require_once("config/dbConnect.php");
    include("ImagePath.php");

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
        $update = (isset($_POST['checkUpdate']) && 1 == $_POST['checkUpdate']) ? 1 : 0;
        $employeeIdUpdate = isset($_POST['employeeId']) ? $_POST['employeeId'] : ''; 

        // Image upload
        $name = $_FILES['image']['name']; //file name uploaded
        $file_size = $_FILES['image']['size'];
        $file_tmp = $_FILES['image']['tmp_name'];
        $file_type = $_FILES['image']['type'];
        //$file_ext = strtolower(end(explode('.',$_FILES['image']['name'])));

        echo "$name". '<br />'. "$file_size". '<br />';

        $extensions = array("jpeg","jpg","png");
        // If(in_array($file_ext,$extensions) === false) {
         // $errors[]="extension not allowed, please choose a JPEG or PNG file.";
        //}

        $maxSize = 2097152;

        // Move image to desired folder
        if(isset($name) && !empty($name)){
            move_uploaded_file($file_tmp, ImagePath.$name);
        }
        

       if(1 == $update){
   
         // Update details
        $empUpdate = "UPDATE Employee
            SET title = '$title', firstName = '$firstName', middleName = '$middleName', lastName = '$lastName', dateOfBirth = '$dob',
                                 gender = '$gender', phone = '$phone', email = '$email', maritalStatus = '$marStatus', empStatus = '$empStatus',
                                 commId = '$communication', employer = '$employer', image = '$name', note = '$note'
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
        $employeeInsert = "INSERT INTO Employee(title, firstName, middleName, lastName, dateOfBirth, gender, phone, email, maritalStatus, empStatus, commId, image, note, employer)
         VALUES ('$title', '$firstName', '$middleName', '$lastName', '$dob', '$gender', $phone, '$email', '$marStatus', '$empStatus', '$communication','$name', '$note', '$employer')";


         $result  = mysqli_query($conn, $employeeInsert);
   
         $employeeId = mysqli_insert_id($conn);
         // Writing sql query to insert personal details
        $address = "INSERT INTO Address(addressType, street, city, zip, state, empId) 
          values('office', '$ofcStreet', '$ofcCity', '$ofcZip', '$ofcState', '$employeeId'), ('residence', '$resStreet', '$resCity', '$resZip', '$resState', '$employeeId')";
        $AddressResult = mysqli_query($conn, $address);

        echo $employeeInsert;
        echo $address;
   
         if (! $result) {
           echo "Insertion failed " . mysql_error();
           setcookie('errors', 'fail');
           //header('Location:registration.php');
         }
       }
   
         echo "Thanks for Your Interest.";
   
         //Print auto-generated id
         echo "New record has id: " . mysqli_insert_id($conn);
   
         //header('Location:list.php');
      ?>