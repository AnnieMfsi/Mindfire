<?php
   require_once("config/dbConnect.php");


   // Validate Post Data and insert Record
   if(!empty($_POST)) {

      // include validate file
      include('helper/validate.php');

      if (!$error) {
            if($update) {
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

                if (! $result && ! $AddressResult) {
                    echo "Insertion failed " . mysql_error();
                    
                }
           }

           //Redirect User to Employee List Page
           header('Location:list.php');
        }
   } 
   else {
      $errorList = array("titleErr" => "", "firstNameErr" => "", "middleNameErr" => "", "lastNameErr" => "", "emailErr" => "", "phoneErr" => "", "genderErr" => "", "dobErr" => "", "resStreetErr" => "", "resCityErr" => "", "resZipErr" => "", "resStateErr" => "", "ofcStreetErr" => "", "ofcCityErr" => "", "ofcZipErr" => "", "ofcStateErr" => "", "marStatusErr" => "", "empStatusErr" => "", "employerErr" => "", "commViaErr" => "", "noteErr" => "", "imageErr" => "", "ofcStreetErr" => "", "dobErr" => "", "ofcCityErr" => "", "ofcZipErr" => "", "ofcStateErr" => "");
   }

   // Check if edit clicked, update flag value
   if(isset($_GET['edit'])) {
      $update = 1;
      $empId = $_GET['edit'];
      $selectQuery = "SELECT Employee.empId, Employee.title, Employee.firstName, Employee.middleName, Employee.lastName, Employee.email, Employee.phone, Employee.gender, Employee.dateOfBirth, 
         Residence.street AS resStreet, Residence.city AS resCity , Residence.zip AS resZip, Residence.state AS resState,
         Office.street AS ofcStreet, Office.city AS ofcCity , Office.zip AS ofcZip, Office.state AS ofcState,
         Employee.maritalStatus, Employee.empStatus, Employee.image,
         Employee.employer, Employee.commId, Employee.note
         FROM Employee 
         JOIN Address AS Residence ON Employee.empId = Residence.empId AND Residence.addressType = 'residence'
         JOIN Address AS Office ON Employee.empId = Office.empId AND Office.addressType = 'office'
         HAVING EmpID = $empId";

      $result  = mysqli_query($conn, $selectQuery);
      $row = mysqli_fetch_assoc($result);
   }
   else {
      // Flag value is 0
      $update = 0;
   }
?>
<!DOCTYPE html>
<html lang="en">
   <head>
      <meta charset="utf-8">
      <meta http-equiv="X-UA-Compatible" content="IE=edge">
      <meta name="viewport" content="width=device-width, initial-scale=1">
      <title>Registration Form</title>
      <!-- Bootstrap Core CSS -->
      <link href="css/bootstrap.min.css" rel="stylesheet">
      <!-- Custom CSS -->
      <link href="css/styles.css" rel="stylesheet">
      <style type="text/css">
      </style>
   </head>
   <body>
      <?php include('template/header.php'); ?>
      <!-- Page Content -->
      <div class="container">
         <div class="row">
            <div class="col-lg-12">
               <div class="error">
                  <?php 
                     //if (isset($_COOKIE)) { ?>
                  <!-- some error occured. -->
                  <?php //} ?> 
               </div>
               <form action="registration.php<?php echo ($update) ? '?edit='.$row['empId']: '';?>" method="POST" class="form-horizontal" enctype="multipart/form-data">
                  <fieldset>
                     <!-- Form Name-->
                     <?php 
                        // If the form is for updating
                        if ($update) {
                           ?>
                     <h1>Update Form</h1>
                     <?php
                        }
                           else{// If it is a new registration form
                              ?>
                     <h1>Registration Form</h1>
                     <?php
                        }
                        ?>                     
                     <div class="well">
                        <h3>Personal Details</h3>
                        <!-- Hidden fields to fetch flag value and employee id -->
                        <input type="hidden" name="checkUpdate" value="<?php echo $update; ?>">
                        <input type="hidden" name="employeeId" value="<?php echo ($update) ? $row['empId'] : 0; ?>">
                        
                        <!-- Feilds for name-->
                        <div class="row form-group">
                           <label class="col-lg-2 col-md-2 col-sm-2 col-xs-12">Name</label>
                           <div class="col-lg-2 col-md-2 col-sm-2 col-xs-12">
                              <!-- Check and assign the value if it is new or update form -->
                              <input type="text" name = "title" class="form-control" id="inputTitle" placeholder="Mr/Ms" value="<?php echo ($update) ? $row['title'] : (isset($_POST['title']) ? $_POST['title'] : ''); ?>"><span class="error"><?php echo $errorList['titleErr'];?></span>
                           </div>
                           <div class="col-lg-2 col-md-2 col-sm-2 col-xs-12">
                              <input type="text" name = "firstName" class="form-control" id="inputFirstName" placeholder="First Name" value="<?php echo ($update) ? $row['firstName'] : (isset($_POST['firstName']) ? $_POST['firstName'] : ''); ?>"><span class="error"><?php echo $errorList['firstNameErr'];?></span>
                           </div>
                           <div class="col-lg-2 col-md-2 col-sm-2 col-xs-12">
                              <input type="text" name = "middleName" class="form-control" id="inputMiddleName" placeholder="Middle Name" value="<?php echo ($update) ? $row['middleName'] : (isset($_POST['middleName']) ? $_POST['middleName'] : ''); ?>"><span class="error"><?php echo $errorList['middleNameErr'];?></span>
                           </div>
                           <div class="col-lg-2 col-md-2 col-sm-2 col-xs-12">
                              <input type="text" name = "lastName" class="form-control" id="inputLastName" placeholder="Last Name" value="<?php echo ($update) ? $row['lastName'] : (isset($_POST['lastName']) ? $_POST['lastName'] : ''); ?>"><span class="error"><?php echo $errorList['lastNameErr'];?></span>
                           </div>
                        </div>

                        <!-- Email input-->
                        <div class="row form-group">
                           <label class="col-lg-2 col-md-2 col-sm-2 col-xs-12 " for="textinput">Email</label>  
                           <div class="col-lg-4 col-md-4 col-sm-4 col-xs-12">
                              <!-- Check and assign the value if it is new or update form -->
                              <input id="textinput" name="email" type="text" placeholder="name@email.com" class="form-control input-md" value="<?php echo ($update) ? $row['email'] : (isset($_POST['email']) ? $_POST['email'] : ''); ?>"><span class="error"><?php echo $errorList['emailErr'];?></span>
                           </div>
                        </div>
                        <!-- Phone number input-->
                        <div class="row form-group">
                           <label class="col-lg-2 col-md-2 col-sm-2 col-xs-12 " for="number">Mobile</label>  
                           <div class="col-lg-4 col-md-4 col-sm-4 col-xs-12">
                              <!-- Check and assign the value if it is new or update form -->
                              <input id="number" name="phone" type="text" placeholder="9999999999" class="form-control input-md" value="<?php echo ($update) ? $row['phone'] : (isset($_POST['phone']) ? $_POST['phone'] : ''); ?>"><span class="error"><?php echo $errorList['phoneErr'];?></span>
                           </div>
                        </div>
                        <!--Radio button for gender-->
                        <div class="row form-group">
                           <label class="col-lg-2 col-md-2 col-sm-2 col-xs-12 " for="gender">Gender</label>
                           <div class="col-md-4">
                              <label class="radio-inline" for="gender-0">
                                 <!-- Check and select the radio button if it is new or update form -->
                                 <input type="radio" name="gender" id="gender-0" value="male" <?php echo ($update) ? ($row['gender'] == 'male' ? "checked=checked" : '') : "checked=checked" ;?> >
                                 Male
                              </label>
                              <label class="radio-inline" for="gender-1">
                              <input type="radio" name="gender" id="gender-1" value="female" <?php echo ($update) ? ($row['gender'] == 'female' ? "checked=checked" : '') : ((isset($_POST['gender']) && 'female' == $_POST['gender']) ? "checked=checked" : ''); ?>>
                              Female
                              </label> 
                              <label class="radio-inline" for="gender-2">
                              <input type="radio" name="gender" id="gender-2" value="others" <?php echo ($update) ? ($row['gender'] == 'others' ? "checked=checked" : '') : ((isset($_POST['gender']) && 'others' == $_POST['gender']) ? "checked=checked" : ''); ?>>
                              Others
                              </label>
                           </div>
                        </div>
                        <!--Date picker for DOB-->
                        <div class="row form-group">
                           <label class="col-lg-2 col-md-2 col-sm-2 col-xs-12">D.O.B</label>
                           <div class="col-lg-4 col-md-4 col-sm-4 col-xs-12">
                              <!-- Check and assign the value if it is new or update form -->
                              <input type='date'  name="dob" class="form-control" value="<?php echo ($update) ? $row['dateOfBirth'] : (isset($_POST['dob']) ? $_POST['dob'] : ''); ?>"/><span class="error"><?php echo $errorList['dobErr'];?></span>
                           </div>
                        </div>
                     </div>
                     <hr>

                     <div class="well">
                        <h3>Address Details</h3>
                        <!-- Address input-->
                        <!-- Resident Address-->
                        <div class="row form-group address">
                           <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
                              <label for="Address">Residence Address</label> 
                              <!-- Check and assign the value if it is new or update form -->
                              <!-- Street Name-->
                              <input id="Address" name="resStreet" type="text" placeholder="Street" class="form-control input-md address" value="<?php echo ($update) ? $row['resStreet'] : (isset($_POST['resStreet']) ? $_POST['resStreet'] : '');?>"><span class="error"><?php echo $errorList['resStreetErr'];?></span>
                              <!-- City-->
                              <input id="city" name="resCity" type="text" placeholder="city" class="form-control input-md address" value="<?php echo ($update) ? $row['resCity'] : (isset($_POST['resCity']) ? $_POST['resCity'] : '');?>"><span class="error"><?php echo $errorList['resCityErr'];?></span>
                              <!-- ZIp -->
                              <input id="zip" name="resZip" type="text" placeholder="Zip" class="form-control input-md address" value="<?php echo ($update) ? $row['resZip'] : (isset($_POST['resZip']) ? $_POST['resZip'] : '');?>"><span class="error"><?php echo $errorList['resZipErr'];?></span>
                              <!-- Select State -->
                              <select id="state" name="resState" class="form-control address">
                                 <option value="0">Select State</option>
                                 <option value="Andaman and Nicobar Islands" <?php echo ($update && 'Andaman and Nicobar Islands' == $row['resState']) ? 'selected' : (((isset($_POST['resState']) && 'Andaman and Nicobar Islands' == $_POST['resState']) ? 'selected' : '')); ?>>Andaman and Nicobar Islands</option>
                                 <option value="Andhra Pradesh" <?php echo ($update && 'Andhra Pradesh' == $row['resState']) ? 'selected' : (((isset($_POST['resState']) && 'Andhra Pradesh' == $_POST['resState']) ? 'selected' : '')); ?>>Andhra Pradesh</option>
                                 <option value="Arunachal Pradesh" <?php echo ($update && 'Arunachal Pradesh' == $row['resState']) ? 'selected' : (((isset($_POST['resState']) && 'Arunachal Pradesh' == $_POST['resState']) ? 'selected' : '')); ?>>Arunachal Pradesh</option>
                                 <option value="Assam" <?php echo ($update && 'Assam' == $row['resState']) ? 'selected' : (((isset($_POST['resState']) && 'Assam' == $_POST['resState']) ? 'selected' : '')); ?>>Assam</option>
                                 <option value="Bihar" <?php echo ($update && 'Bihar' == $row['resState']) ? 'selected' : (((isset($_POST['resState']) && 'Bihar' == $_POST['resState']) ? 'selected' : '')); ?>>Bihar</option>
                                 <option value="Chandigarh" <?php echo ($update && 'Chandigarh' == $row['resState']) ? 'selected' : (((isset($_POST['resState']) && 'Chandigarh' == $_POST['resState']) ? 'selected' : '')); ?>>Chandigarh</option>
                                 <option value="Chhattisgarh" <?php echo ($update && 'Chhattisgarh' == $row['resState']) ? 'selected' : (((isset($_POST['resState']) && 'Chhattisgarh' == $_POST['resState']) ? 'selected' : '')); ?>>Chhattisgarh</option>
                                 <option value="Dadra and Nagar Haveli" <?php echo ($update && 'Dadra and Nagar Haveli' == $row['resState']) ? 'selected' : (((isset($_POST['resState']) && 'Dadra and Nagar Haveli' == $_POST['resState']) ? 'selected' : '')); ?>>Dadra and Nagar Haveli</option>
                                 <option value="Daman and Diu" <?php echo ($update && 'Daman and Diu' == $row['resState']) ? 'selected' : (((isset($_POST['resState']) && 'Daman and Diu' == $_POST['resState']) ? 'selected' : '')); ?>>Daman and Diu</option>
                                 <option value="Delhi"<?php echo ($update && 'Delhi' == $row['resState']) ? 'selected' : (((isset($_POST['resState']) && 'Delhi' == $_POST['resState']) ? 'selected' : '')); ?>>Delhi</option>
                                 <option value="Goa" <?php echo ($update && 'Goa' == $row['resState']) ? 'selected' : (((isset($_POST['resState']) && 'Goa' == $_POST['resState']) ? 'selected' : '')); ?>>Goa</option>
                                 <option value="Gujarat"<?php echo ($update && 'Gujarat' == $row['resState']) ? 'selected' : (((isset($_POST['resState']) && 'Gujarat' == $_POST['resState']) ? 'selected' : '')); ?>>Gujarat</option>
                                 <option value="Haryana" <?php echo ($update && 'Haryana' == $row['resState']) ? 'selected' : (((isset($_POST['resState']) && 'Haryana' == $_POST['resState']) ? 'selected' : '')); ?>>Haryana</option>
                                 <option value="Himachal Pradesh" <?php echo ($update && 'Himachal Pradesh' == $row['resState']) ? 'selected' : (((isset($_POST['resState']) && 'Himachal Pradesh' == $_POST['resState']) ? 'selected' : '')); ?>>Himachal Pradesh</option>
                                 <option value="Jammu and Kashmir" <?php echo ($update && 'Jammu and Kashmir' == $row['resState']) ? 'selected' : (((isset($_POST['resState']) && 'Jammu and Kashmir' == $_POST['resState']) ? 'selected' : '')); ?>>Jammu and Kashmir</option>
                                 <option value="Jharkhand" <?php echo ($update && 'Jharkhand' == $row['resState']) ? 'selected' : (((isset($_POST['resState']) && 'Jharkhand' == $_POST['resState']) ? 'selected' : '')); ?>>Jharkhand</option>
                                 <option value="Karnataka" <?php echo ($update && 'Karnataka' == $row['resState']) ? 'selected' : (((isset($_POST['resState']) && 'Karnataka' == $_POST['resState']) ? 'selected' : '')); ?>>Karnataka</option>
                                 <option value="Kerala" <?php echo ($update && 'Kerala' == $row['resState']) ? 'selected' : (((isset($_POST['resState']) && 'Kerala' == $_POST['resState']) ? 'selected' : '')); ?>>Kerala</option>
                                 <option value="Lakshadweep" <?php echo ($update && 'Lakshadweep' == $row['resState']) ? 'selected' : (((isset($_POST['resState']) && 'Lakshadweep' == $_POST['resState']) ? 'selected' : '')); ?>>Lakshadweep</option>
                                 <option value="Madhya Pradesh" <?php echo ($update && 'Madhya Pradesh' == $row['resState']) ? 'selected' : (((isset($_POST['resState']) && 'Madhya Pradesh' == $_POST['resState']) ? 'selected' : '')); ?>>Madhya Pradesh</option>
                                 <option value="Maharashtra" <?php echo ($update && 'Maharashtra' == $row['resState']) ? 'selected' : (((isset($_POST['resState']) && 'Maharashtra' == $_POST['resState']) ? 'selected' : '')); ?>>Maharashtra</option>
                                 <option value="Manipur" <?php echo ($update && 'Manipur' == $row['resState']) ? 'selected' : (((isset($_POST['resState']) && 'Manipur' == $_POST['resState']) ? 'selected' : '')); ?>>Manipur</option>
                                 <option value="Meghalaya"<?php echo ($update && 'Meghalaya' == $row['resState']) ? 'selected' : (((isset($_POST['resState']) && 'Meghalaya' == $_POST['resState']) ? 'selected' : '')); ?>>Meghalaya</option>
                                 <option value="Mizoram"<?php echo ($update && 'Mizoram' == $row['resState']) ? 'selected' : (((isset($_POST['resState']) && 'Mizoram' == $_POST['resState']) ? 'selected' : '')); ?>>Mizoram</option>
                                 <option value="Nagaland"<?php echo ($update && 'Nagaland' == $row['resState']) ? 'selected' : (((isset($_POST['resState']) && 'Nagaland' == $_POST['resState']) ? 'selected' : '')); ?>>Nagaland</option>
                                 <option value="Orissa"<?php echo ($update && 'Orissa' == $row['resState']) ? 'selected' : (((isset($_POST['resState']) && 'Orissa' == $_POST['resState']) ? 'selected' : '')); ?>>Orissa</option>
                                 <option value="Pondicherry"<?php echo ($update && 'Pondicherry' == $row['resState']) ? 'selected' : (((isset($_POST['resState']) && 'Pondicherry' == $_POST['resState']) ? 'selected' : '')); ?>>Pondicherry</option>
                                 <option value="Punjab" <?php echo ($update && 'Punjab' == $row['resState']) ? 'selected' : (((isset($_POST['resState']) && 'Punjab' == $_POST['resState']) ? 'selected' : '')); ?>>Punjab</option>
                                 <option value="Rajasthan"<?php echo ($update && 'Rajasthan' == $row['resState']) ? 'selected' : (((isset($_POST['resState']) && 'Rajasthan' == $_POST['resState']) ? 'selected' : '')); ?>>Rajasthan</option>
                                 <option value="Sikkim"<?php echo ($update && 'Sikkim' == $row['resState']) ? 'selected' : (((isset($_POST['resState']) && 'Sikkim' == $_POST['resState']) ? 'selected' : '')); ?>>Sikkim</option>
                                 <option value="Tamil Nadu" <?php echo ($update && 'Tamil Nadu' == $row['resState']) ? 'selected' : (((isset($_POST['resState']) && 'Tamil Nadu' == $_POST['resState']) ? 'selected' : '')); ?>>Tamil Nadu</option>
                                 <option value="Tripura" <?php echo ($update && 'Tripura' == $row['resState']) ? 'selected' : (((isset($_POST['resState']) && 'Tripura' == $_POST['resState']) ? 'selected' : '')); ?>>Tripura</option>
                                 <option value="Uttaranchal" <?php echo ($update && 'Uttaranchal' == $row['resState']) ? 'selected' : (((isset($_POST['resState']) && 'Uttaranchal' == $_POST['resState']) ? 'selected' : '')); ?>>Uttaranchal</option>
                                 <option value="Uttar Pradesh" <?php echo ($update && 'Uttar Pradesh' == $row['resState']) ? 'selected' : (((isset($_POST['resState']) && 'Uttar Pradesh' == $_POST['resState']) ? 'selected' : '')); ?>>Uttar Pradesh</option>
                                 <option value="West Bengal" <?php echo ($update && 'West Bengal' == $row['resState']) ? 'selected' : (((isset($_POST['resState']) && 'West Bengal' == $_POST['resState']) ? 'selected' : '')); ?>>West Bengal</option>
                              </select><span class="error"><?php echo $errorList['resStateErr'];?></span>
                           </div>
                           <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
                              <label for="Address">Office Address</label>
                              <!-- Check and assign the value if it is new or update form -->
                              <!--Street Name-->
                              <input id="ofcStreet" name="ofcStreet" type="text" placeholder="Street" class="form-control input-md address" value= "<?php echo ($update) ? $row['ofcStreet'] : (isset($_POST['ofcStreet']) ? $_POST['ofcStreet'] : '');?>"">
                              <!-- City-->                          
                              <input id="OfcCity" name="ofcCity" type="text" placeholder="city" class="form-control input-md address" value= "<?php echo ($update) ? $row['ofcCity'] : (isset($_POST['ofcCity']) ? $_POST['ofcCity'] : '');?>">
                              <!-- Zip-->
                              <input id="OfcZip" name="ofcZip" type="text" placeholder="Zip" class="form-control input-md address" value= "<?php echo ($update) ? $row['ofcZip'] : (isset($_POST['ofcZip']) ? $_POST['ofcZip'] : '');?>">
                              <!-- Select State -->
                              <select id="ofcState" name="ofcState" class="form-control address" value="<?php echo ($update) ? $row['ofcState'] : (isset($_POST['ofcState']) ? $_POST['ofcState'] : '');?> ">
                                 <option value="0">Select State</option>
                                 <option value="Andaman and Nicobar Islands" <?php echo ($update && 'Andaman and Nicobar Islands' == $row['ofcState']) ? 'selected' : (((isset($_POST['ofcState']) && 'Andaman and Nicobar Islands' == $_POST['ofcState']) ? 'selected' : '')); ?>>Andaman and Nicobar Islands</option>
                                 <option value="Andhra Pradesh" <?php echo ($update && 'Andhra Pradesh' == $row['ofcState']) ? 'selected' : (((isset($_POST['ofcState']) && 'Andhra Pradesh' == $_POST['ofcState']) ? 'selected' : '')); ?>>Andhra Pradesh</option>
                                 <option value="Arunachal Pradesh" <?php echo ($update && 'Arunachal Pradesh' == $row['ofcState']) ? 'selected' : (((isset($_POST['ofcState']) && 'Arunachal Pradesh' == $_POST['ofcState']) ? 'selected' : '')); ?>>Arunachal Pradesh</option>
                                 <option value="Assam" <?php echo ($update && 'Assam' == $row['ofcState']) ? 'selected' : (((isset($_POST['ofcState']) && 'Assam' == $_POST['ofcState']) ? 'selected' : '')); ?>>Assam</option>
                                 <option value="Bihar" <?php echo ($update && 'Bihar' == $row['ofcState']) ? 'selected' : (((isset($_POST['ofcState']) && 'Bihar' == $_POST['ofcState']) ? 'selected' : '')); ?>>Bihar</option>
                                 <option value="Chandigarh" <?php echo ($update && 'Chandigarh' == $row['ofcState']) ? 'selected' : (((isset($_POST['ofcState']) && 'Chandigarh' == $_POST['ofcState']) ? 'selected' : '')); ?>>Chandigarh</option>
                                 <option value="Chhattisgarh" <?php echo ($update && 'Chhattisgarh' == $row['ofcState']) ? 'selected' : (((isset($_POST['ofcState']) && 'Chhattisgarh' == $_POST['ofcState']) ? 'selected' : '')); ?>>Chhattisgarh</option>
                                 <option value="Dadra and Nagar Haveli" <?php echo ($update && 'Dadra and Nagar Haveli' == $row['ofcState']) ? 'selected' : (((isset($_POST['ofcState']) && 'Dadra and Nagar Haveli' == $_POST['ofcState']) ? 'selected' : '')); ?>>Dadra and Nagar Haveli</option>
                                 <option value="Daman and Diu" <?php echo ($update && 'Daman and Diu' == $row['ofcState']) ? 'selected' : (((isset($_POST['ofcState']) && 'Daman and Diu' == $_POST['ofcState']) ? 'selected' : '')); ?>>Daman and Diu</option>
                                 <option value="Delhi"<?php echo ($update && 'Delhi' == $row['ofcState']) ? 'selected' : (((isset($_POST['ofcState']) && 'Delhi' == $_POST['ofcState']) ? 'selected' : '')); ?>>Delhi</option>
                                 <option value="Goa" <?php echo ($update && 'Goa' == $row['ofcState']) ? 'selected' : (((isset($_POST['ofcState']) && 'Goa' == $_POST['ofcState']) ? 'selected' : '')); ?>>Goa</option>
                                 <option value="Gujarat"<?php echo ($update && 'Gujarat' == $row['ofcState']) ? 'selected' : (((isset($_POST['ofcState']) && 'Gujarat' == $_POST['ofcState']) ? 'selected' : '')); ?>>Gujarat</option>
                                 <option value="Haryana" <?php echo ($update && 'Haryana' == $row['ofcState']) ? 'selected' : (((isset($_POST['ofcState']) && 'Haryana' == $_POST['ofcState']) ? 'selected' : '')); ?>>Haryana</option>
                                 <option value="Himachal Pradesh" <?php echo ($update && 'Himachal Pradesh' == $row['ofcState']) ? 'selected' : (((isset($_POST['ofcState']) && 'Himachal Pradesh' == $_POST['ofcState']) ? 'selected' : '')); ?>>Himachal Pradesh</option>
                                 <option value="Jammu and Kashmir" <?php echo ($update && 'Jammu and Kashmir' == $row['ofcState']) ? 'selected' : (((isset($_POST['ofcState']) && 'Jammu and Kashmir' == $_POST['ofcState']) ? 'selected' : '')); ?>>Jammu and Kashmir</option>
                                 <option value="Jharkhand" <?php echo ($update && 'Jharkhand' == $row['ofcState']) ? 'selected' : (((isset($_POST['ofcState']) && 'Jharkhand' == $_POST['ofcState']) ? 'selected' : '')); ?>>Jharkhand</option>
                                 <option value="Karnataka" <?php echo ($update && 'Karnataka' == $row['ofcState']) ? 'selected' : (((isset($_POST['ofcState']) && 'Karnataka' == $_POST['ofcState']) ? 'selected' : '')); ?>>Karnataka</option>
                                 <option value="Kerala" <?php echo ($update && 'Kerala' == $row['ofcState']) ? 'selected' : (((isset($_POST['ofcState']) && 'Kerala' == $_POST['ofcState']) ? 'selected' : '')); ?>>Kerala</option>
                                 <option value="Lakshadweep" <?php echo ($update && 'Lakshadweep' == $row['ofcState']) ? 'selected' : (((isset($_POST['ofcState']) && 'Lakshadweep' == $_POST['ofcState']) ? 'selected' : '')); ?>>Lakshadweep</option>
                                 <option value="Madhya Pradesh" <?php echo ($update && 'Madhya Pradesh' == $row['ofcState']) ? 'selected' : (((isset($_POST['ofcState']) && 'Madhya Pradesh' == $_POST['ofcState']) ? 'selected' : '')); ?>>Madhya Pradesh</option>
                                 <option value="Maharashtra" <?php echo ($update && 'Maharashtra' == $row['ofcState']) ? 'selected' : (((isset($_POST['ofcState']) && 'Maharashtra' == $_POST['ofcState']) ? 'selected' : '')); ?>>Maharashtra</option>
                                 <option value="Manipur" <?php echo ($update && 'Manipur' == $row['ofcState']) ? 'selected' : (((isset($_POST['ofcState']) && 'Manipur' == $_POST['ofcState']) ? 'selected' : '')); ?>>Manipur</option>
                                 <option value="Meghalaya"<?php echo ($update && 'Meghalaya' == $row['ofcState']) ? 'selected' : (((isset($_POST['ofcState']) && 'Meghalaya' == $_POST['ofcState']) ? 'selected' : '')); ?>>Meghalaya</option>
                                 <option value="Mizoram"<?php echo ($update && 'Mizoram' == $row['ofcState']) ? 'selected' : (((isset($_POST['ofcState']) && 'Mizoram' == $_POST['ofcState']) ? 'selected' : '')); ?>>Mizoram</option>
                                 <option value="Nagaland"<?php echo ($update && 'Nagaland' == $row['ofcState']) ? 'selected' : (((isset($_POST['ofcState']) && 'Nagaland' == $_POST['ofcState']) ? 'selected' : '')); ?>>Nagaland</option>
                                 <option value="Orissa"<?php echo ($update && 'Orissa' == $row['ofcState']) ? 'selected' : (((isset($_POST['ofcState']) && 'Orissa' == $_POST['ofcState']) ? 'selected' : '')); ?>>Orissa</option>
                                 <option value="Pondicherry"<?php echo ($update && 'Pondicherry' == $row['ofcState']) ? 'selected' : (((isset($_POST['ofcState']) && 'Pondicherry' == $_POST['ofcState']) ? 'selected' : '')); ?>>Pondicherry</option>
                                 <option value="Punjab" <?php echo ($update && 'Punjab' == $row['ofcState']) ? 'selected' : (((isset($_POST['ofcState']) && 'Punjab' == $_POST['ofcState']) ? 'selected' : '')); ?>>Punjab</option>
                                 <option value="Rajasthan"<?php echo ($update && 'Rajasthan' == $row['ofcState']) ? 'selected' : (((isset($_POST['ofcState']) && 'Rajasthan' == $_POST['ofcState']) ? 'selected' : '')); ?>>Rajasthan</option>
                                 <option value="Sikkim"<?php echo ($update && 'Sikkim' == $row['ofcState']) ? 'selected' : (((isset($_POST['ofcState']) && 'Sikkim' == $_POST['ofcState']) ? 'selected' : '')); ?>>Sikkim</option>
                                 <option value="Tamil Nadu" <?php echo ($update && 'Tamil Nadu' == $row['ofcState']) ? 'selected' : (((isset($_POST['ofcState']) && 'Tamil Nadu' == $_POST['ofcState']) ? 'selected' : '')); ?>>Tamil Nadu</option>
                                 <option value="Tripura" <?php echo ($update && 'Tripura' == $row['ofcState']) ? 'selected' : (((isset($_POST['ofcState']) && 'Tripura' == $_POST['ofcState']) ? 'selected' : '')); ?>>Tripura</option>
                                 <option value="Uttaranchal" <?php echo ($update && 'Uttaranchal' == $row['ofcState']) ? 'selected' : (((isset($_POST['ofcState']) && 'Uttaranchal' == $_POST['ofcState']) ? 'selected' : '')); ?>>Uttaranchal</option>
                                 <option value="Uttar Pradesh" <?php echo ($update && 'Uttar Pradesh' == $row['ofcState']) ? 'selected' : (((isset($_POST['ofcState']) && 'Uttar Pradesh' == $_POST['ofcState']) ? 'selected' : '')); ?>>Uttar Pradesh</option>
                                 <option value="West Bengal" <?php echo ($update && 'West Bengal' == $row['ofcState']) ? 'selected' : (((isset($_POST['ofcState']) && 'West Bengal' == $_POST['ofcState']) ? 'selected' : '')); ?>>West Bengal</option>
                              </select>
                           </div>
                        </div>
                     </div>
                     <div class="well">
                        <h3>Other Details</h3>
                        <!-- Marital Status-->
                        <div class="form-group">
                           <label class= "col-lg-2 col-md-2 col-sm-2 col-xs-12" for="marStatus">Marital Status</label>
                           <div class="col-lg-4 col-md-4 col-sm-4 col-xs-12">
                              <!-- Check and select from drop down if it is new or update form -->
                              <select id="marStatus" name="marStatus" class="form-control" >
                                 <option value="0">Status</option>
                                 <option value="single" <?php echo ($update && 'single' == $row['marStatus']) ? 'selected' : (((isset($_POST['marStatus']) && 'single' == $_POST['marStatus']) ? 'selected' : '')); ?>>Single</option>
                                 <option value="married" <?php echo ($update && 'married' == $row['marStatus']) ? 'selected' : (((isset($_POST['marStatus']) && 'married' == $_POST['marStatus']) ? 'selected' : '')); ?>>Married</option>
                                 <option value="divorced" <?php echo ($update && 'divorced' == $row['marStatus']) ? 'selected' : (((isset($_POST['marStatus']) && 'divorced' == $_POST['marStatus']) ? 'selected' : '')); ?>>Divorced</option>
                                 <option value="widow" <?php echo ($update && 'widow' == $row['marStatus']) ? 'selected' : (((isset($_POST['marStatus']) && 'widow' == $_POST['marStatus']) ? 'selected' : '')); ?>>Widow</option>
                                 <option value="widower" <?php echo ($update && 'widower' == $row['marStatus']) ? 'selected' : (((isset($_POST['marStatus']) && 'widower' == $_POST['marStatus']) ? 'selected' : '')); ?>>Widower</option>
                              </select><span class="error"><?php echo $errorList['marStatusErr'];?></span>
                           </div>
                        </div>
                        <!-- Radio button for employment status-->
                        <div class="form-group">
                           <label class="col-lg-2 col-md-2 col-sm-2 col-xs-12" for="empStatus">
                           Employement Status</label>
                           <div class="col-lg-4 col-md-4 col-sm-4 col-xs-12">
                              <div class="row">
                                 <!-- Check and select the radio button if it is new or update form -->
                                 <div class="radio col-lg-6 col-md-6 col-sm-6 col-xs-12">
                                    <label><input type="radio" name="empStatus" value="employed" <?php echo ($update) ? ($row['empStatus'] == 'employed' ? "checked=checked" : '') : "checked=checked"; ?>>Employed</label>
                                 </div>
                                 <div class="radio col-lg-6 col-md-6 col-sm-6 col-xs-12">
                                    <label><input type="radio" name="empStatus" value="unemployed" <?php echo ($update) ? ($row['empStatus'] == 'unemployed' ? "checked=checked" : '') : ((isset($_POST['empStatus']) && 'unemployed' == $_POST['empStatus']) ? "checked=checked" : ''); ?>>Unemployed</label>
                                 </div>
                              </div>
                              <div class="row">
                                 <div class="radio col-lg-6 col-md-6 col-sm-6 col-xs-12">
                                    <label><input type="radio" name="empStatus" value="self-employed" <?php echo ($update) ? ($row['empStatus'] == 'self-employed' ? "checked=checked" : '') : ((isset($_POST['empStatus']) && 'self-employed' == $_POST['empStatus']) ? "checked=checked" : ''); ?>>Self-Employed</label>
                                 </div>
                                 <div class="radio col-lg- col-md-6 col-sm-6 col-xs-12">
                                    <label><input type="radio" name="empStatus" value="student" <?php echo ($update) ? ($row['empStatus'] == 'student' ? "checked=checked" : '') : ((isset($_POST['empStatus']) && 'student' == $_POST['empStatus']) ? "checked=checked" : ''); ?>>Student</label>
                                 </div>
                              </div>
                           </div>
                        </div>
                        <div class="form-group">
                           <label class="col-lg-2 col-md-2 col-sm-2 col-xs-12" for="textinput">Employer</label>  
                           <div class="col-lg-4 col-md-4 col-sm-4 col-xs-12">
                              <!-- Check and assign value if it is new or update form -->
                              <input id="textinput" name="employer" type="text" class="form-control input-md" value=" <?php echo ($update) ? $row['employer'] : ''; ?> "><span class="error"><?php echo $errorList['employerErr'];?></span>
                           </div>
                        </div>
                        <!-- Image Upload -->
                        <div class="form-group">
                           <label class="col-lg-2 col-md-2 col-sm-2 col-xs-12" for="textinput">Upload Image</label> 
                           
                           <input type="file" name="image"  value="<?php echo ($update) ? $row['image'] : (isset($_POST['image']) ? $_POST['image'] : ''); ?>" />
                           <?php
                              if($update){?>
                                <!-- Modal -->
                           <a href="" data-target="#empImage" data-toggle="modal">Current Picture</a>
                            <div id="empImage" class="modal fade" role="dialog">
                              <div class="modal-dialog">
                                <!-- Modal content-->
                                <div class="modal-content">
                                  <div class="modal-header">
                                    <h4 class="modal-title">Your Image</h4>
                                  </div>
                                  <div class = "modal-body">
                                    <img src = "<?php echo IMAGEPATH.($update ? $row['image'] : (isset($_POST['image']) ? $_POST['image'] : '')); ?>" alt = "No image" height = "300" width = "500">
                                  </div>  
                                  <div class="modal-footer">
                                    <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                                  </div>
                              </div>

                              </div>
                            </div>
                            <?php
                              }
                            ?>
                           <span class="error"><?php echo $errorList['imageErr'];?></span>
                        </div>

                        <!-- Communication Medium -->
                        <?php $communicationIds = isset($row['commId']) ? explode(',', $row['commId']) : []; ?>
                        <div class="form-group">
                           <label class="col-lg-2 col-md-2 col-sm-2 col-xs-12" for="Communication">Communicate via</label>
                           <div class="col-lg-4 col-md-4 col-sm-4 col-xs-12">
                              <div class="row">
                                 <!-- Check and select check box if it is new or update form -->
                                 <div class="checkbox col-lg-6 col-md-6 col-sm-6 col-xs-12">
                                    <label for="Communication-0">
                                    <input type="checkbox" name="comm[]" id="Communication-0" value="1" <?php echo ($update) ? (in_array('1', $communicationIds) ? "checked=checked" : '') : ((isset($_POST['comm']) && !empty($_POST['comm']) && in_array('1', $_POST['comm'])) ? "checked=checked" : '' );?>>
                                    E-Mail
                                    </label>
                                 </div>
                                 <div class="checkbox col-lg-6 col-md-6 col-sm-6 col-xs-12">
                                    <label for="Communication-1">
                                    <input type="checkbox" name="comm[]" id="Communication-1" value="2" <?php echo ($update) ? (in_array('2', $communicationIds) ? "checked=checked" : '') : ((isset($_POST['comm']) && !empty($_POST['comm']) && in_array('2', $_POST['comm'])) ? "checked=checked" : '' );?>>
                                    Message
                                    </label>
                                 </div>
                              </div>
                              <div class="row">
                                 <div class="checkbox col-lg-6 col-md-6 col-sm-6 col-xs-12">
                                    <label for="Communication-2">
                                    <input type="checkbox" name="comm[]" id="Communication-2" value="3" <?php echo ($update) ? (in_array('3', $communicationIds) ? "checked=checked" : '') : ((isset($_POST['comm']) && !empty($_POST['comm']) && in_array('3', $_POST['comm'])) ? "checked=checked" : '' );?>>
                                    Phone
                                    </label>
                                 </div>
                                 <div class="checkbox col-lg-6 col-md-6 col-sm-6 col-xs-12">
                                    <label for="Communication-3">
                                    <input type="checkbox" name="comm[]" id="Communication-3" value="4" <?php echo ($update) ? (in_array('4', $communicationIds) ? "checked=checked" : '') : ((isset($_POST['comm']) && !empty($_POST['comm']) && in_array('4', $_POST['comm'])) ? "checked=checked" : '' );?>>
                                    Any
                                    </label>
                                 </div><span class="error"><?php echo $errorList['commViaErr'];?></span>
                              </div>
                           </div>
                        </div>
                        <!-- Textarea -->
                        <div class="form-group">
                           <label class="col-lg-2 col-md-2 col-sm-2 col-xs-12" for="Note">Note</label>
                           <div class="col-lg-8 col-md-8 col-sm-8 col-xs-12">
                              <!-- check and display note if it is new or update form -->                  
                              <textarea class="form-control" id="Note" name="note" rows="6" placeholder="Write something about yourself"> <?php echo ($update) ? $row['note'] : ''; ?></textarea>
                           </div>
                        </div>
                        <div class="row text-center">
                           <?php 
                              if (1 == $update) {
                                 // If update form, update and clear button
                                 ?>
                           <button type="submit" class="btn btn-success" role="button">Update
                           </button>
                           <button type="reset" class="btn btn-primary" role="button">Clear
                           </button> 
                           <?php
                              }
                              else{
                                    // If new form, submit and reset button
                              ?>
                                 <button type="submit" class="btn btn-success" role="button">Submit
                                 </button>
                                 <button type="reset" class="btn btn-primary" role="button">Reset
                                 </button>
                           <?php
                              }
                              ?> 
                        </div>
                     </div>
                  </fieldset>
               </form>
            </div>
         </div>
      </div>
      <!-- Container -->
      <!-- jQuery -->
      <script src="js/jquery.js"></script>
      <!-- Bootstrap Core JavaScript -->
      <script src="js/bootstrap.min.js"></script>
   </body>
</html>