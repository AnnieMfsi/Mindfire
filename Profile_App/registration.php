<?php
/*
  @Author  : Mfsi_Annapurnaa
  @purpose : Registration form layout.
           : Update operaton on the emplolyee data
*/
   require_once('config/dbConnect.php');

  $stateList = array('Andaman and Nicobar Islands', 'Andhra Pradesh', 'Arunachal Pradesh', 'Assam', 
    'Bihar', 'Chandigar', 'Chhattisgarh', 'Dadra and Nagar Haveli', 'Daman and Diu', 'Delhi', 'Goa',
     'Gujarat', 'Haryana', 'Himachal Pradesh', 'Jammu and Kashmir', 'Jharkhand', 'Karnataka', 
     'Kerala', 'Lakshadweep', 'Madhya Pradesh', 'Maharashtra', 'Manipur', 'Meghalaya', 'Mizoram', 
     'Nagaland', 'Orissa', 'Pondicherry', 'Punjab', 'Rajasthan', 'Sikkim', 'Tamil Nadu', 'Tripura', 
     'Uttaranchal', 'Uttar Pradesh', 'West Bengal');

   // Validate Post Data and insert Record
   if(!empty($_POST))
   {
      // include validate file
      include('helper/validate.php');

      if(!$error)
      {

        if($update)
        {
        // Update details
        // Query for employee details
        $empUpdate = "UPDATE Employee
          SET title = '$title', firstName = '$firstName', middleName = '$middleName', 
          lastName = '$lastName', dateOfBirth = '$dob', gender = '$gender', phone = '$phone', 
          email = '$email', maritalStatus = '$marStatus', empStatus = '$empStatus', 
          commId = '$communication', employer = '$employer', image = '$name', note = '$note'
          WHERE empId = $employeeIdUpdate";

        // Query for Office address details
        $empOfcUpdate = "UPDATE Address
          SET street = '$ofcStreet', city = '$ofcCity', zip = '$ofcZip', state = '$ofcState'
          WHERE empId = '$employeeIdUpdate' AND addressType = 'office'" ;
        
        // Query for Residential address details
        $empResUpdate = "UPDATE Address
          SET street = '$resStreet', city = '$resCity', zip = '$resZip', state = '$resState'
          WHERE empId = '$employeeIdUpdate' AND addressType = 'residence' ";

        $result  = mysqli_query($conn, $empUpdate);
        $ofcResult = mysqli_query($conn, $empOfcUpdate);
        $resResult = mysqli_query($conn, $empResUpdate);

        if (! $result && ! $ofcResult && ! $resResult)
        {
              echo 'Update failed' . mysql_error();  
        }

      }
      else
      {
        // Insert personal details
        $employeeInsert = "INSERT INTO Employee(title, firstName, middleName, lastName, 
          dateOfBirth, gender, phone, email, maritalStatus, empStatus, commId, image, note, employer)
          VALUES ('$title', '$firstName', '$middleName', '$lastName', '$dob', '$gender', $phone, 
          '$email', '$marStatus', '$empStatus', '$communication','$name',
          '$note', '$employer')";

        $result  = mysqli_query($conn, $employeeInsert);
        $employeeId = mysqli_insert_id($conn);
        
        // Query to insert employee details
        $address = "INSERT INTO Address(addressType, street, city, zip, state, empId) 
            values('office', '$ofcStreet', '$ofcCity', '$ofcZip', '$ofcState', '$employeeId'), 
            ('residence', '$resStreet', '$resCity', '$resZip', '$resState', '$employeeId')";

        $AddressResult = mysqli_query($conn, $address);

        if(! $result && ! $AddressResult)
        {
            echo 'Insertion failed' . mysql_error();  
        }

      }

       //Redirect User to Employee List Page
     header('Location:list.php');
    }

  } 
  else
  {
    $errorList = array('titleErr' => '', 'firstNameErr' => '', 'middleNameErr' => '', 
      'lastNameErr' => '', 'emailErr' => '', 'phoneErr' => '', 'genderErr' => '', 'dobErr' => '',
       'resStreetErr' => '', 'resCityErr' => '', 'resZipErr' => '', 'resStateErr' => '', 
       'marStatusErr' => '', 'empStatusErr' => '', 'employerErr' => '', 'commViaErr' => '', 
       'noteErr' => '', 'imageErr' => '', 'dobErr' => '');
   }

 // Check if edit clicked, update flag value
 if(isset($_GET['edit']))
 {
    $update = TRUE;
    $empId = $_GET['edit'];
    $selectQuery = "SELECT Employee.empId, Employee.title, Employee.firstName, Employee.middleName, 
      Employee.lastName, Employee.email, Employee.phone, Employee.gender, Employee.dateOfBirth, 
      Residence.street AS resStreet, Residence.city AS resCity , Residence.zip AS resZip, 
      Residence.state AS resState, Office.street AS ofcStreet, Office.city AS ofcCity , Office.zip 
      AS ofcZip, Office.state AS ofcState, Employee.maritalStatus AS marStatus, Employee.empStatus, 
      Employee.image, Employee.employer, Employee.commId, Employee.note
      FROM Employee 
      JOIN Address AS Residence ON Employee.empId = Residence.empId AND Residence.addressType = 'residence'
      JOIN Address AS Office ON Employee.empId = Office.empId AND Office.addressType = 'office'
      HAVING EmpID = $empId";

    $result  = mysqli_query($conn, $selectQuery);
    $row = mysqli_fetch_assoc($result);
  }
  else
  {
    // Flag value is 0
    $update = FALSE;
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
               <form action="registration.php<?php echo ($update) ? '?edit=' . $row['empId']: '';?>" 
                  method="POST" class="form-horizontal" enctype="multipart/form-data">
                  <fieldset>
                     <!-- Form Name-->
                     <?php 
                        // If the form is for updating
                        if($update)
                        {
                      ?>
                          <h1>Update Form</h1>
                      <?php
                        }
                        else
                        {// If it is a new registration form
                      ?>
                          <h1>Registration Form</h1>
                      <?php
                        }
                      ?>                     
                     <div class="well">
                        <h3>Personal Details</h3>
                        <!-- Hidden fields to fetch flag value and employee id -->
                        <input type="hidden" name="checkUpdate" value="<?php echo $update; ?>">
                        <input type="hidden" name="employeeId" value="<?php echo ($update) ? 
                          $row['empId'] : FALSE; ?>">
                        <!-- Feilds for name-->
                        <div class="row form-group">
                           <label class="col-lg-2 col-md-2 col-sm-2 col-xs-12">Name</label>
                           <div class="col-lg-2 col-md-2 col-sm-2 col-xs-12">
                              <!-- Check and assign the value if it is new or update form -->
                              <input type="text" name = "title" class="form-control" id="inputTitle" 
                                placeholder="Mr/Ms" value="<?php echo ($update) ? $row['title'] : 
                                (isset($_POST['title']) ? $_POST['title'] : ''); ?>">
                              <span class="error"><?php echo $errorList['titleErr'];?></span>
                           </div>
                           <div class="col-lg-2 col-md-2 col-sm-2 col-xs-12">
                              <input type="text" name = "firstName" class="form-control" 
                                id="inputFirstName" placeholder="First Name" value="<?php 
                                echo ($update) ? $row['firstName'] : (isset($_POST['firstName']) ? 
                                $_POST['firstName'] : ''); ?>">
                              <span class="error"><?php echo $errorList['firstNameErr'];?></span>
                           </div>
                           <div class="col-lg-2 col-md-2 col-sm-2 col-xs-12">
                              <input type="text" name = "middleName" class="form-control" 
                                id="inputMiddleName" placeholder="Middle Name" value="<?php 
                                echo ($update) ? $row['middleName'] : (isset($_POST['middleName']) ? 
                                $_POST['middleName'] : ''); ?>">
                              <span class="error"><?php echo $errorList['middleNameErr'];?></span>
                           </div>
                           <div class="col-lg-2 col-md-2 col-sm-2 col-xs-12">
                              <input type="text" name = "lastName" class="form-control" 
                              id="inputLastName" placeholder="Last Name" value="<?php 
                              echo ($update) ? $row['lastName'] : (isset($_POST['lastName']) ? 
                              $_POST['lastName'] : ''); ?>">
                              <span class="error"><?php echo $errorList['lastNameErr'];?></span>
                           </div>
                        </div>
                        <!-- Email input-->
                        <div class="row form-group">
                           <label class="col-lg-2 col-md-2 col-sm-2 col-xs-12 " for="textinput">Email</label>  
                           <div class="col-lg-4 col-md-4 col-sm-4 col-xs-12">
                              <!-- Check and assign the value if it is new or update form -->
                              <input id="textinput" name="email" type="text" 
                                placeholder="name@email.com" class="form-control input-md" value="<?php 
                                echo ($update) ? $row['email'] : (isset($_POST['email']) ? $_POST['email'] : ''); ?>">
                              <span class="error"><?php echo $errorList['emailErr'];?></span>
                           </div>
                        </div>
                        <!-- Phone number input-->
                        <div class="row form-group">
                           <label class="col-lg-2 col-md-2 col-sm-2 col-xs-12 " for="number">Mobile</label>  
                           <div class="col-lg-4 col-md-4 col-sm-4 col-xs-12">
                              <!-- Check and assign the value if it is new or update form -->
                              <input id="number" name="phone" type="text" placeholder="9999999999" 
                                class="form-control input-md" value="<?php echo ($update) ? 
                                $row['phone'] : (isset($_POST['phone']) ? $_POST['phone'] : ''); ?>">
                              <span class="error"><?php echo $errorList['phoneErr'];?></span>
                           </div>
                        </div>
                        <!--Radio button for gender-->
                        <div class="row form-group">
                           <label class="col-lg-2 col-md-2 col-sm-2 col-xs-12 " for="gender">Gender</label>
                           <div class="col-md-4">
                              <label class="radio-inline" for="gender-0">
                                 <!-- Check and select the radio button if it is new or update form -->
                                 <input type="radio" name="gender" id="gender-0" value="male" 
                                    <?php echo ($update) ? ($row['gender'] == 'male' ? "checked=checked" : '') : 
                                      "checked=checked" ;?> >Male</label>
                              <label class="radio-inline" for="gender-1">
                                <input type="radio" name="gender" id="gender-1" value="female" 
                                  <?php echo ($update) ? ($row['gender'] == 'female' ? "checked=checked" : '') : 
                                    ((isset($_POST['gender']) && 'female' == $_POST['gender']) ? "checked=checked" : ''); ?>>
                                    Female</label> 
                              <label class="radio-inline" for="gender-2">
                              <input type="radio" name="gender" id="gender-2" value="others" 
                              <?php echo ($update) ? ($row['gender'] == 'others' ? "checked=checked" : '') : 
                              ((isset($_POST['gender']) && 'others' == $_POST['gender']) ? "checked=checked" : ''); ?>>
                              Others
                              </label>
                           </div>
                        </div>
                        <!--Date picker for DOB-->
                        <div class="row form-group">
                           <label class="col-lg-2 col-md-2 col-sm-2 col-xs-12">D.O.B</label>
                           <div class="col-lg-4 col-md-4 col-sm-4 col-xs-12">
                              <!-- Check and assign the value if it is new or update form -->
                              <input type='date'  name="dob" class="form-control" value="<?php 
                                echo ($update) ? $row['dateOfBirth'] : (isset($_POST['dob']) ? $_POST['dob'] : ''); ?>"/>
                              <span class="error"><?php echo $errorList['dobErr'];?></span>
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
                              <input id="Address" name="resStreet" type="text" placeholder="Street" 
                                class="form-control input-md address" value="<?php 
                                echo ($update) ? $row['resStreet'] : (isset($_POST['resStreet']) ? 
                                $_POST['resStreet'] : '');?>">
                              <span class="error"><?php echo $errorList['resStreetErr'];?></span>
                              <!-- City-->
                              <input id="city" name="resCity" type="text" placeholder="city" 
                                class="form-control input-md address" value="<?php echo ($update) ? 
                                $row['resCity'] : (isset($_POST['resCity']) ? $_POST['resCity'] : '');?>">
                              <span class="error"><?php echo $errorList['resCityErr'];?></span>
                              <!-- ZIp -->
                              <input id="zip" name="resZip" type="text" placeholder="Zip" 
                                class="form-control input-md address" value="<?php echo ($update) ? 
                                $row['resZip'] : (isset($_POST['resZip']) ? $_POST['resZip'] : '');?>">
                              <span class="error"><?php echo $errorList['resZipErr'];?></span>
                              <!-- Select State -->
                              <select id="resState" name="resState" class="form-control address">
                                 <option value="0">Select State</option>
                                 <?php 
                                 foreach($stateList as $key => $item)
                                  {
                                  ?>
                                 <option value = "<?php echo $item ?>" <?php echo ($update && $item == $row['resState']) ? 
                                   'selected' : ((isset($_POST['resState']) && $item == $_POST['resState']) ? 'selected' : ''); ?> >
                                   <?php echo $item ?></option>
                                   <?php 
                                      } 
                                    ?>
                              </select>
                              <span class="error"><?php echo $errorList['resStateErr'];?></span>
                           </div>
                           <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
                              <label for="Address">Office Address</label>
                              <!-- Check and assign the value if it is new or update form -->
                              <!--Street Name-->
                              <input id="ofcStreet" name="ofcStreet" type="text" placeholder="Street" 
                                class="form-control input-md address" value= "<?php echo ($update) ? $row['ofcStreet'] : 
                                (isset($_POST['ofcStreet']) ? $_POST['ofcStreet'] : '');?>"">
                              <!-- City-->                          
                              <input id="OfcCity" name="ofcCity" type="text" placeholder="city" 
                                class="form-control input-md address" value= "<?php echo ($update) ? $row['ofcCity'] : 
                                (isset($_POST['ofcCity']) ? $_POST['ofcCity'] : '');?>">
                              <!-- Zip-->
                              <input id="OfcZip" name="ofcZip" type="text" placeholder="Zip" 
                                class="form-control input-md address" value= "<?php echo ($update) ? $row['ofcZip'] : 
                                (isset($_POST['ofcZip']) ? $_POST['ofcZip'] : '');?>">
                              <!-- Select State -->
                              <select id="ofcState" name="ofcState" class="form-control address">
                                 <option value="0">Select State</option>
                                 <?php foreach($stateList as $key => $item){?>
                                 <option value = "<?php echo $item ?>" <?php echo ($update && $item == $row['ofcState']) ? 
                                   'selected' : ((isset($_POST['ofcState']) && $item == $_POST['ofcState']) ? 'selected' : ''); ?> >
                                   <?php echo $item ?></option>
                                   <?php 
                                      } ?>
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
                                 <option value="single" <?php echo ($update && 'married' == $row['marStatus']) ? 
                                   'selected' : (((isset($_POST['marStatus']) && 'married' == $_POST['marStatus']) ? 
                                   'selected' : '')); ?>>Single</option>
                                 <option value="married" <?php echo ($update && 'married' == $row['marStatus']) ? 
                                   'selected' : (((isset($_POST['marStatus']) && 'married' == $_POST['marStatus']) ? 
                                   'selected' : '')); ?>>Married</option>
                                 <option value="divorced" <?php echo ($update && 'divorced' == $row['marStatus']) ? 
                                   'selected' : (((isset($_POST['marStatus']) && 'divorced' == $_POST['marStatus']) ? 
                                   'selected' : '')); ?>>Divorced</option>
                                 <option value="widow" <?php echo ($update && 'widow' == $row['marStatus']) ? 
                                   'selected' : (((isset($_POST['marStatus']) && 'widow' == $_POST['marStatus']) ? 
                                   'selected' : '')); ?>>Widow</option>
                                 <option value="widower" <?php echo ($update && 'widower' == $row['marStatus']) ? 
                                   'selected' : (((isset($_POST['marStatus']) && 'widower' == $_POST['marStatus']) ? 
                                   'selected' : '')); ?>>Widower</option>
                              </select>
                              <span class="error"><?php echo $errorList['marStatusErr'];?></span>
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
                                    <label><input type="radio" name="empStatus" value="employed" 
                                      <?php echo ($update) ? ($row['empStatus'] == 'employed' ? 
                                      "checked=checked" : '') : "checked=checked"; ?>>Employed</label>
                                 </div>
                                 <div class="radio col-lg-6 col-md-6 col-sm-6 col-xs-12">
                                    <label><input type="radio" name="empStatus" value="unemployed" 
                                      <?php echo ($update) ? ($row['empStatus'] == 'unemployed' ? 
                                      "checked=checked" : '') : ((isset($_POST['empStatus']) && 'unemployed' == $_POST['empStatus']) ? 
                                      "checked=checked" : ''); ?>>Unemployed</label>
                                 </div>
                              </div>
                              <div class="row">
                                 <div class="radio col-lg-6 col-md-6 col-sm-6 col-xs-12">
                                    <label><input type="radio" name="empStatus" value="self-employed" 
                                      <?php echo ($update) ? ($row['empStatus'] == 'self-employed' ? 
                                      "checked=checked" : '') : ((isset($_POST['empStatus']) && 'self-employed' == $_POST['empStatus']) ? 
                                      "checked=checked" : ''); ?>>Self-Employed</label>
                                 </div>
                                 <div class="radio col-lg- col-md-6 col-sm-6 col-xs-12">
                                    <label><input type="radio" name="empStatus" value="student" 
                                      <?php echo ($update) ? ($row['empStatus'] == 'student' ? 
                                      "checked=checked" : '') : ((isset($_POST['empStatus']) && 'student' == $_POST['empStatus']) ? 
                                      "checked=checked" : ''); ?>>Student</label>
                                 </div>
                              </div>
                           </div>
                        </div>
                        <div class="form-group">
                           <label class="col-lg-2 col-md-2 col-sm-2 col-xs-12" for="textinput">Employer</label>  
                           <div class="col-lg-4 col-md-4 col-sm-4 col-xs-12">
                              <!-- Check and assign value if it is new or update form -->
                              <input id="textinput" name="employer" type="text" class="form-control input-md" 
                                value=" <?php echo ($update) ? $row['employer'] : ''; ?> ">
                              <span class="error"><?php echo $errorList['employerErr'];?></span>
                           </div>
                        </div>
                        <!-- Image Upload -->
                        <div class="form-group">
                           <label class="col-lg-2 col-md-2 col-sm-2 col-xs-12" for="textinput">Upload Image</label> 
                           <input type="file" name="image"  value="<?php echo ($update) ? $row['image'] : 
                            (isset($_POST['image']) ? $_POST['image'] : ''); ?>" />
                           <?php
                              if($update)
                                {
                            ?>
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
                                       <img src = "<?php echo IMAGEPATH.($update ? $row['image'] : (isset($_POST['image']) ?
                                        $_POST['image'] : '')); ?>" alt = "No image" height = "300" width = "500">
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
                                      <input type="checkbox" name="comm[]" id="Communication-0" value="1" 
                                      <?php echo ($update) ? (in_array('1', $communicationIds) ? "checked=checked" : '') : 
                                      ((isset($_POST['comm']) && !empty($_POST['comm']) && in_array('1', $_POST['comm'])) ? 
                                      "checked=checked" : '' );?>>E-Mail</label>
                                 </div>
                                 <div class="checkbox col-lg-6 col-md-6 col-sm-6 col-xs-12">
                                    <label for="Communication-1">
                                      <input type="checkbox" name="comm[]" id="Communication-1" value="2" 
                                      <?php echo ($update) ? (in_array('2', $communicationIds) ? "checked=checked" : '') : 
                                      ((isset($_POST['comm']) && !empty($_POST['comm']) && in_array('2', $_POST['comm'])) ? 
                                      "checked=checked" : '' );?>>Message</label>
                                 </div>
                              </div>
                              <div class="row">
                                 <div class="checkbox col-lg-6 col-md-6 col-sm-6 col-xs-12">
                                    <label for="Communication-2">
                                      <input type="checkbox" name="comm[]" id="Communication-2" value="3" 
                                      <?php echo ($update) ? (in_array('3', $communicationIds) ? "checked=checked" : '') : 
                                      ((isset($_POST['comm']) && !empty($_POST['comm']) && in_array('3', $_POST['comm'])) ? 
                                      "checked=checked" : '' );?>>Phone</label>
                                 </div>
                                 <div class="checkbox col-lg-6 col-md-6 col-sm-6 col-xs-12">
                                    <label for="Communication-3">
                                      <input type="checkbox" name="comm[]" id="Communication-3" value="4" 
                                      <?php echo ($update) ? (in_array('4', $communicationIds) ? "checked=checked" : '') : 
                                      ((isset($_POST['comm']) && !empty($_POST['comm']) && in_array('4', $_POST['comm'])) ? 
                                      "checked=checked" : '' );?>>Any</label>
                                 </div>
                                 <span class="error"><?php echo $errorList['commViaErr'];?></span>
                              </div>
                           </div>
                        </div>
                        <!-- Textarea -->
                        <div class="form-group">
                           <label class="col-lg-2 col-md-2 col-sm-2 col-xs-12" for="Note">Note</label>
                           <div class="col-lg-8 col-md-8 col-sm-8 col-xs-12">
                              <!-- check and display note if it is new or update form -->                  
                              <textarea class="form-control" id="Note" name="note" rows="6" 
                                placeholder="Write something about yourself"> <?php echo ($update) ? $row['note'] : ''; ?>
                              </textarea>
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