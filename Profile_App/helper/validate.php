<?php
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
        $update = (isset($_POST['checkUpdate']) && 1 == $_POST['checkUpdate']) ? TRUE : FALSE;
        $employeeIdUpdate = isset($_POST['employeeId']) ? $_POST['employeeId'] : ''; 
        $errorList = array("titleErr" => "", "firstNameErr" => "", "middleNameErr" => "", "lastNameErr" => "", "emailErr" => "", "phoneErr" => "", "genderErr" => "", "dobErr" => "", "resStreetErr" => "", "resCityErr" => "", "resZipErr" => "", "resStateErr" => "", "ofcStreetErr" => "", "ofcCityErr" => "", "ofcZipErr" => "", "ofcStateErr" => "", "marStatusErr" => "", "empStatusErr" => "", "employerErr" => "", "commViaErr" => "", "noteErr" => "", "imageErr" => "", "ofcStreetErr" => "", "dobErr" => "", "ofcCityErr" => "", "ofcZipErr" => "", "ofcStateErr" => "");
        $error = FALSE;

        // Image upload and image validation
        if (!$_FILES['image']['error']) {
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
                $error= TRUE;
            }

            // Image size validation
            $maxSize = 2097152;
            if($imageSize > $maxSize){
                $errorList['imageErr'] = 'File size must be excately 2 MB';
                $error= TRUE;
            }

            // Move image to desired folder
            if(isset($name) && !empty($name)){
                move_uploaded_file($imageTmp, IMAGEPATH.$name);
            }

        }

        else if (!$update) {
            $errorList['imageErr'] = "Enter a valid image";
            $error= TRUE;
        }
        
        // Form Validation

        // Check Title
        if (empty($title)) {
            $errorList['titleErr'] = "Title is required";
            $error= TRUE;
        }
        else {
            // Check if title only contains letters and whitespace
            if (!preg_match("/^[a-zA-Z ]*$/",$title)) {
                $errorList['titleErr'] = "Only letters allowed";
                $error= TRUE;
            }
        }

        // Check First Name
        if (empty($firstName)) {
            $errorList['firstNameErr'] = "First Name is required";
            $error= TRUE;
        } 
        else {
            // Check if first name only contains letters and whitespace
            if (!preg_match("/^[a-zA-Z ]*$/",$firstName)) {
                $errorList['firstNameErr'] = "Only letters allowed"; 
                $error= TRUE;
            }
        }

        // Check Middle Name only contains letters and whitespace
        if (!empty($middleName) && !preg_match("/^[a-zA-Z ]*$/",$middleName)) {
            $errorList['middleNameErr'] = "Only letters allowed"; 
            $error= TRUE;
        }

        // Check Last Name
        if (empty($lastName)) {
            $errorList['lastNameErr'] = "Last Name is required";
            $error= TRUE;
        } 
        else {
            // Check if last name only contains letters and whitespace
            if (!preg_match("/^[a-zA-Z ]*$/",$lastName)) {
                $errorList['lastNameErr'] = "Only letters allowed";
                $error= TRUE;
            }
        }

        // Check Email
        if (empty($email)) {
            $errorList['emailErr'] = "Email is required";
            $error= TRUE;
        } 
        else {
            // Check if e-mail address is well-formed
            if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
                $errorList['emailErr'] = "Invalid email format"; 
                $error= TRUE;
            }
        }

        // Check Phone number
        if (empty($phone)) {
            $errorList['phoneErr'] = "Phone number is required";
            $error= TRUE;
        } 
        else {
            // Check if number only contains digits
            if (!preg_match("/^\d{10}$/",$phone)) {
                $errorList['phoneErr'] = "Invalid contact number"; 
                $error= TRUE;
            }
        }

        // Check DOB
        if (empty($dob)) {
            $errorList['dobErr'] = "Date Of Birth is required";
            $error= TRUE;
        }


        // Check if Street for residence is entered
        if (empty($resStreet)) {
            $errorList['resStreetErr'] = "Residential street is required";
            $error= TRUE;
        }

        // Check if Street for residence is entered
        if (empty($resCity)) {
            $errorList['resCityErr'] = "Residential City is required";
            $error= TRUE;
        }

        // Check if Zip code for residence
        if (empty($resZip)) {
            $errorList['resZipErr'] = "Residential Zip code is required";
            $error= TRUE;
        }


        // Check if resident state is selected
        if($resState === 0) {
            $errorList['resStateErr'] = 'Please select one on the List for residential state';
            $error= TRUE;
        }

        // Check if marital is selected   
        if ($marStatus === 0) {
            $errorList['marStatusErr'] = "Please specify your marital Status";
            $error= TRUE;
        }

        // Check if employer is specified
        if($empStatus == 'self-employed'){
            $_POST['employer'] = 'Self';
            $employer = $_POST['employer'];
            $errorList['employerErr'] = ""; 
            $error= TRUE;
        }
        elseif ($empStatus == 'employed') {
            $errorList['employerErr'] = "Specify Your employer"; 
            $error= TRUE;
        }
             
        // Check if means of communication is selected   
        if (empty($communication)) {
            $errorList['commViaErr'] = "Select atleast one communication medium";
            $error= TRUE;
        }
?>