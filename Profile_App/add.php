<?php
        require_once("config/dbConnect.php");
        include("Constants.php");

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
        $errorList[] = "";

        // Define variables for each field and set to empty values
        $titleErr = $firstNameErr = $lastNameErr = $middleNameErr = $emailErr = $phoneErr = $genderErr = $dobErr = $resStreetErr = $resCityErr = $resZipErr = $resStateErr = $ofcStreetErr = $ofcCityErr = $ofcZipErr = $ofcStateErr = $marStatusErr = $empStatusErr = $employerErr = $commViaErr = $noteErr = $imageErr= "";


        // Image upload and image validation
        if (0 == $_FILES['image']['error']) {
            $name = $_FILES['image']['name']; //file name uploaded
            $imageSize = $_FILES['image']['size'];
            $imageTmp = $_FILES['image']['tmp_name'];
            $imageExt = $_FILES['image']['type'];

            // Image file type validation
            $exploded = explode('.',$_FILES['image']['name']);
            $imageExt =strtolower(end($exploded));
            $extensions = array("jpeg","jpg","png");
            if(in_array($imageExt,$extensions) === false) {
                $errorList['imageErrType'] = "Extension not allowed, please choose a JPEG or PNG file.";
            }

            // Image size validation
            $maxSize = 2097152;
            if($imageSize > $maxSize){
                $errorList['imageErr'] = 'File size must be excately 2 MB';
            }

            // Move image to desired folder
            if(isset($name) && !empty($name)){
                move_uploaded_file($imageTmp, ImagePath.$name);
            }

        }

        else{
            $errorList['imageErr'] = "Enter a valid image";
        }
        
        // Form Validation

        // Check Title
        if (empty($title)) {
            $titleErr = "Title is required";
            $errorList[] = $titleErr;
        }
        else {
            // Check if title only contains letters and whitespace
            if (!preg_match("/^[a-zA-Z ]*$/",$title)) {
                $titleErr = "Only letters and white space allowed";
                $errorList[] = $titleErr;
            }
        }

        // Check First Name
        if (empty($firstName)) {
            $errorList['firstNameErr'] = "First Name is required";
        } 
        else {
            // Check if first name only contains letters and whitespace
            if (!preg_match("/^[a-zA-Z ]*$/",$firstName)) {
                $errorList['firstNameErr'] = "Only letters and white space allowed"; 
                //$errorList[] = $firstNameErr;
            }
        }

        // Check Middle Name
        print_r($errorList);
        // Check if middle name only contains letters and whitespace
        if (!preg_match("/^[a-zA-Z ]*$/",$middleName)) {
            $errorList['middleNameErr'] = "Only letters and white space allowed"; 
        }

        // Check Last Name
        if (empty($lastName)) {
            $errorList['lastNameErr'] = "Last Name is required";
        } 
        else {
            // Check if last name only contains letters and whitespace
            if (!preg_match("/^[a-zA-Z ]*$/",$lastName)) {
                $errorList['lastNameErr'] = "Only letters and white space allowed"; 
            }
        }

        // Check Email
        if (empty($email)) {
            $errorList['emailErr'] = "Email is required";
        } 
        else {
            // Check if e-mail address is well-formed
            if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
                $errorList['emailErr'] = "Invalid email format"; 
            }
        }

        // Check Phone number
        if (empty($phone)) {
            $phoneErr = "phone number is required";
        } 
        else {
            // Check if number only contains digits
            if (!preg_match("/^\d{10}$/",$phone)) {
                $phoneErr = "Invalid contact number"; 
            }
        }

        // Check if Street for residence is entered
        if (empty($resStreet)) {
        $resStreetErr = "Residential street is required";
        }

        // Check if Zip code for residence
        if (empty($resZip)) {
        $resZipErr = "Residential Zip code is required";
        }


        // Check if resident state is selected
        if($resState == 0) {
            $resStateErr = 'Please select one on the List for residential state';
        }


        // Check if marital is selected   
        if ($marStatus == 0) {
        $marStatusErr = "Please specify your marital Status";
        }

        // Check if employer is specified
        if($empStatus == 'self-employed'){
            $_POST['employer'] = 'Self';
            $employer = $_POST['employer'];
        }
        elseif ($empStatus == 'employed') {
            $employerErr = "Specify Your employer"; 
        }
             
        // Check if means of communication is selected   
        if (empty($communication)) {
            $commViaErr = "Select atleast one communication medium";
        } 


       if(1 == $update) {
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
       else {
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
   
         //Print auto-generated id
         echo "New record has id: " . mysqli_insert_id($conn);
         //header('Location:list.php');
      ?>