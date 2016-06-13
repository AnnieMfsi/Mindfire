<?php
   ini_set('display_errors', 1);//for errors to be printed on screen for user or not
      ini_set('display_startup_errors', 1);//for php start up errors during debugging
      error_reporting(E_ALL);
   
   
   if(isset($_COOKIE['errors'])) {
        echo "Value is: " . $_COOKIE['errors'];
   } 
   
   if(isset($_GET['edit'])){
   	$update = 1;
   	$empId = $_GET['edit'];
   
   
   
   $host = 'localhost';
   $uName = 'root';
   $password = 'mindfire';
   $database = 'RegistrationInfo';  
   
   //making and checking connection
   $conn = mysqli_connect($host, $uName, $password, $database);
   if (mysqli_connect_error($conn)) {
     die('Failed to connect to database' .mysqli_connect_error());
    }
   
    $selectQuery = "SELECT Employee.empId, Employee.title, Employee.firstName, Employee.middleName, Employee.lastName, Employee.email, Employee.phone, Employee.gender, Employee.dateOfBirth, 
                          Residence.street AS resStreet, Residence.city AS resCity , Residence.zip AS resZip, Residence.state AS resState,
                          Office.street AS ofcStreet, Office.city AS ofcCity , Office.zip AS ofcZip, Office.state AS ofcState,
                          Employee.maritalStatus, Employee.empStatus, 
                          Employee.employer, Employee.commId, Employee.note
                       FROM Employee 
                       JOIN Address AS Residence ON Employee.empId = Residence.empId AND Residence.addressType = 'residence'
                       JOIN Address AS Office ON Employee.empId = Office.empId AND Office.addressType = 'office'
                       HAVING EmpID = $empId";
   
   $result  = mysqli_query($conn, $selectQuery);
   $row = mysqli_fetch_assoc($result);
   	print_r($row); echo '<br>';
      }

    else {
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
      <!-- Navigation -->
      <nav class="navbar navbar-inverse">
         <div class="container">
            <!-- Brand and toggle get grouped for better mobile display -->
            <div class="navbar-header">
               <p class="navbar-brand">GetEmpl0yed.com</p>
            </div>
            <!-- Collect the nav links, forms, and other content for toggling -->
            <ul class="nav navbar-nav">
               <li class="active">
                  <a href="home.html">Home</a>
               </li>
               <li>
                  <a href="registration.php">Registration</a>
               </li>
            </ul>
         </div>
         <!-- /.container -->
      </nav>
      <!-- Page Content -->
      <div class="container">
         <div class="row">
            <div class="col-lg-12">
               <div class="error">
                  <?php 
                     if (isset($_COOKIE)) { ?>
                  some error occured.
                  <?php } ?> 
               </div>
               <form action="add.php" method="POST" class="form-horizontal">
                  <fieldset>
                     <!-- Form Name -->
                     <?php 
                        if (1 == $update) {
                        	?>
                     <h1>Update Form</h1>
                     <?php
                        }
                        	else{
                        		?>
                     <h1>Registration Form</h1>
                     <?php
                        }
                        ?>                     
                     <div class="well">
                        <h3>Personal Details</h3>

                        <input type="hidden" name="checkUpdate" value="<?php echo $update; ?>">
                        <input type="hidden" name="employeeId" value="<?php echo ($update) ? $row['empId'] : 0; ?>">


                        <!--Feilds for name-->
                        <div class="row form-group">
                           <label class="col-lg-2 col-md-2 col-sm-2 col-xs-12">Name</label>
                           <div class="col-lg-1 col-md-1 col-sm-2 col-xs-12">
                              <input type="text" name = "title" class="form-control" id="inputTitle" placeholder="Mr/Ms" value="<?php echo ($update) ? $row['title'] : ''; ?>">
                           </div>
                           <div class="col-lg-2 col-md-2 col-sm-2 col-xs-12">
                              <input type="text" name = "firstName" class="form-control" id="inputFirstName" placeholder="First Name" value="<?php echo ($update) ? $row['firstName'] : ''; ?>">
                           </div>
                           <div class="col-lg-2 col-md-2 col-sm-2 col-xs-12">
                              <input type="text" name = "middleName" class="form-control" id="inputMiddleName" placeholder="Middle Name" value="<?php echo ($update) ? $row['middleName'] : ''; ?>">
                           </div>
                           <div class="col-lg-2 col-md-2 col-sm-2 col-xs-12">
                              <input type="text" name = "lastName" class="form-control" id="inputLastName" placeholder="Last Name" value="<?php echo ($update) ? $row['lastName'] : ''; ?>">
                           </div>
                        </div>
                        <!-- Email input-->
                        <div class="row form-group">
                           <label class="col-lg-2 col-md-2 col-sm-2 col-xs-12 " for="textinput">Email</label>  
                           <div class="col-lg-4 col-md-4 col-sm-4 col-xs-12">
                              <input id="textinput" name="email" type="text" placeholder="name@email.com" class="form-control input-md" value="<?php echo ($update) ? $row['email'] : ''; ?>">
                           </div>
                        </div>
                        <!-- phone number input-->
                        <div class="row form-group">
                           <label class="col-lg-2 col-md-2 col-sm-2 col-xs-12 " for="number">Mobile</label>  
                           <div class="col-lg-4 col-md-4 col-sm-4 col-xs-12">
                              <input id="number" name="phone" type="text" placeholder="9999999999" class="form-control input-md" value="<?php echo ($update) ? $row['phone'] : ''; ?>">
                           </div>
                        </div>
                        <!--radio button for gender-->
                        <div class="row form-group">
                           <label class="col-lg-2 col-md-2 col-sm-2 col-xs-12 " for="gender">Gender</label>
                           <div class="col-md-4"> 
                              <label class="radio-inline" for="gender-0">
                              <input type="radio" name="gender" id="gender-0" value="Male" <?php echo ($update) ? ($row['gender'] == 'male' ? "checked=checked" : '') : "checked=checked"; ?> >
                              Male
                              </label> 
                              <label class="radio-inline" for="gender-1">
                              <input type="radio" name="gender" id="gender-1" value="Female" <?php echo (($update) && $row['gender'] == 'female') ? "checked=checked" : ''; ?>>
                              Female
                              </label> 
                              <label class="radio-inline" for="gender-2">
                              <input type="radio" name="gender" id="gender-2" value="Others" <?php echo (($update) && $row['gender'] == 'others') ? "checked=checked" : ''; ?>>
                              Others
                              </label>
                           </div>
                        </div>
                        <!--date picker for DOB-->
                        <div class="row form-group">
                           <label class="col-lg-2 col-md-2 col-sm-2 col-xs-12">D.O.B</label>
                           <div class="col-lg-4 col-md-4 col-sm-4 col-xs-12">
                              <input type='date'  name="dob" class="form-control" value="<?php echo ($update) ? $row['dateOfBirth'] : ''; ?>"/>
                           </div>
                        </div>
                     </div>
                     <hr>
                     <div class="well">
                        <h3>Address Details</h3>
                        <!-- Address input-->
                        <!--Resident Address-->
                        <div class="row form-group address">
                           <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
                              <label for="Address">Residence Address</label> 
                              <!--Street Name-->
                              <input id="Address" name="resStreet" type="text" placeholder="Street" class="form-control input-md address" value=" <?php echo ($update) ? $row['resStreet'] : ''; ?> ">
                              <!-- City-->
                              <input id="city" name="resCity" type="text" placeholder="city" class="form-control input-md address" value=" <?php echo ($update) ? $row['resCity'] : ''; ?> ">
                              <!-- ZIp -->
                              <input id="zip" name="resZip" type="text" placeholder="Zip" class="form-control input-md address" value=" <?php echo ($update) ? $row['resZip'] : ''; ?> ">
                              <!-- Select State -->
                            <select id="state" name="resState" class="form-control address">
                            <option value="0">Select State</option>
                                 <option value="Andaman and Nicobar Islands" <?php echo ($update && 'Andaman and Nicobar Islands' == $row['resState']) ? 'selected' : ''; ?>>Andaman and Nicobar Islands</option>
                                 <option value="Andhra Pradesh" <?php echo ($update && 'Andhra Pradesh' == $row['resState']) ? 'selected' : ''; ?>>Andhra Pradesh</option>
                                 <option value="Arunachal Pradesh" <?php echo ($update && 'Arunachal Pradesh' == $row['resState']) ? 'selected' : ''; ?>>Arunachal Pradesh</option>
                                 <option value="Assam" <?php echo ($update && 'Assam' == $row['resState']) ? 'selected' : ''; ?>>Assam</option>
                                 <option value="Bihar" <?php echo ($update && 'Bihar' == $row['resState']) ? 'selected' : ''; ?>>Bihar</option>
                                 <option value="Chandigarh" <?php echo ($update && 'Chandigarh' == $row['resState']) ? 'selected' : ''; ?>>Chandigarh</option>
                                 <option value="Chhattisgarh" <?php echo ($update && 'Chhattisgarh' == $row['resState']) ? 'selected' : ''; ?>>Chhattisgarh</option>
                                 <option value="Dadra and Nagar Haveli" <?php echo ($update && 'Dadra and Nagar Haveli' == $row['resState']) ? 'selected' : ''; ?>>Dadra and Nagar Haveli</option>
                                 <option value="Daman and Diu" <?php echo ($update && 'Daman and Diu' == $row['resState']) ? 'selected' : ''; ?>>Daman and Diu</option>
                                 <option value="Delhi"<?php echo ($update && 'Delhi' == $row['resState']) ? 'selected' : ''; ?>>Delhi</option>
                                 <option value="Goa" <?php echo ($update && 'Goa' == $row['resState']) ? 'selected' : ''; ?>>Goa</option>
                                 <option value="Gujarat"<?php echo ($update && 'Gujarat' == $row['resState']) ? 'selected' : ''; ?>>Gujarat</option>
                                 <option value="Haryana" <?php echo ($update && 'Haryana' == $row['resState']) ? 'selected' : ''; ?>>Haryana</option>
                                 <option value="Himachal Pradesh" <?php echo ($update && 'Himachal Pradesh' == $row['resState']) ? 'selected' : ''; ?>>Himachal Pradesh</option>
                                 <option value="Jammu and Kashmir" <?php echo ($update && 'Jammu and Kashmir' == $row['resState']) ? 'selected' : ''; ?>>Jammu and Kashmir</option>
                                 <option value="Jharkhand" <?php echo ($update && 'Jharkhand' == $row['resState']) ? 'selected' : ''; ?>>Jharkhand</option>
                                 <option value="Karnataka" <?php echo ($update && 'Karnataka' == $row['resState']) ? 'selected' : ''; ?>>Karnataka</option>
                                 <option value="Kerala" <?php echo ($update && 'Kerala' == $row['resState']) ? 'selected' : ''; ?>>Kerala</option>
                                 <option value="Lakshadweep" <?php echo ($update && 'Lakshadweep' == $row['resState']) ? 'selected' : ''; ?>>Lakshadweep</option>
                                 <option value="Madhya Pradesh" <?php echo ($update && 'Madhya Pradesh' == $row['resState']) ? 'selected' : ''; ?>>Madhya Pradesh</option>
                                 <option value="Maharashtra" <?php echo ($update && 'Maharashtra' == $row['resState']) ? 'selected' : ''; ?>>Maharashtra</option>
                                 <option value="Manipur" <?php echo ($update && 'Manipur' == $row['resState']) ? 'selected' : ''; ?>>Manipur</option>
                                 <option value="Meghalaya"<?php echo ($update && 'Meghalaya' == $row['resState']) ? 'selected' : ''; ?>>Meghalaya</option>
                                 <option value="Mizoram"<?php echo ($update && 'Mizoram' == $row['resState']) ? 'selected' : ''; ?>>Mizoram</option>
                                 <option value="Nagaland"<?php echo ($update && 'Nagaland' == $row['resState']) ? 'selected' : ''; ?>"Nagaland</option>
                                 <option value="Orissa"<?php echo ($update && 'Orissa' == $row['resState']) ? 'selected' : ''; ?>>Orissa</option>
                                 <option value="Pondicherry"<?php echo ($update && 'Pondicherry' == $row['resState']) ? 'selected' : ''; ?>>Pondicherry</option>
                                 <option value="Punjab" <?php echo ($update && 'Punjab' == $row['resState']) ? 'selected' : ''; ?>>Punjab</option>
                                 <option value="Rajasthan"<?php echo ($update && 'Rajasthan' == $row['resState']) ? 'selected' : ''; ?>>Rajasthan</option>
                                 <option value="Sikkim"<?php echo ($update && 'Sikkim' == $row['resState']) ? 'selected' : ''; ?>>Sikkim</option>
                                 <option value="Tamil Nadu" <?php echo ($update && 'Tamil Nadu' == $row['resState']) ? 'selected' : ''; ?>>Tamil Nadu</option>
                                 <option value="Tripura" <?php echo ($update && 'Tripura' == $row['resState']) ? 'selected' : ''; ?>>Tripura</option>
                                 <option value="Uttaranchal" <?php echo ($update && 'Uttaranchal' == $row['resState']) ? 'selected' : ''; ?>>Uttaranchal</option>
                                 <option value="Uttar Pradesh" <?php echo ($update && 'Uttar Pradesh' == $row['resState']) ? 'selected' : ''; ?>>Uttar Pradesh</option>
                                 <option value="West Bengal" <?php echo ($update && 'West Bengal' == $row['resState']) ? 'selected' : ''; ?>>West Bengal</option>
                              </select>
                           </div>
                           <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
                              <label for="Address">Office Address</label>
                              <!--Street Name-->
                              <input id="OfcAddress" name="ofcAddress" type="text" placeholder="Street" class="form-control input-md address" value= " <?php echo ($update) ? $row['ofcStreet'] : ''; ?> ">
                              <!-- City-->                          
                              <input id="OfcCity" name="ofcCity" type="text" placeholder="city" class="form-control input-md address" value= " <?php echo ($update) ? $row['ofcCity'] : ''; ?> ">
                              <!-- Zip-->
                              <input id="OfcZip" name="ofcZip" type="text" placeholder="Zip" class="form-control input-md address" value= " <?php echo ($update) ? $row['ofcZip'] : ''; ?> ">
                              <!-- Select State -->
                              <select id="OfcState" name="ofcState" class="form-control address" value=" <?php echo ($update) ? $row['ofcState'] : ''; ?> ">
                                 <option value="0">Select State</option>
                                 <option value="Andaman and Nicobar Islands" <?php echo ($update && 'Andaman and Nicobar Islands' == $row['ofcState']) ? 'selected' : ''; ?>>Andaman and Nicobar Islands</option>
                                 <option value="Andhra Pradesh"<?php echo ($update && 'Andhra Pradesh' == $row['ofcState']) ? 'selected' : ''; ?>>Andhra Pradesh</option>
                                 <option value="Arunachal Pradesh"<?php echo ($update && 'Arunachal Pradesh' == $row['ofcState']) ? 'selected' : ''; ?>>Arunachal Pradesh</option>
                                 <option value="Assam"<?php echo ($update && 'Assam' == $row['ofcState']) ? 'selected' : ''; ?>>Assam</option>
                                 <option value="Bihar"<?php echo ($update && 'Bihar' == $row['ofcState']) ? 'selected' : ''; ?>>Bihar</option>
                                 <option value="Chandigarh"<?php echo ($update && 'Chandigarh' == $row['ofcState']) ? 'selected' : ''; ?>>Chandigarh</option>
                                 <option value="Chhattisgarh"<?php echo ($update && 'Chhattisgarh' == $row['ofcState']) ? 'selected' : ''; ?>>Chhattisgarh</option>
                                 <option value="Dadra and Nagar Haveli"<?php echo ($update && 'Dadra and Nagar Haveli' == $row['ofcState']) ? 'selected' : ''; ?>>Dadra and Nagar Haveli</option>
                                 <option value="Daman and Diu"<?php echo ($update && 'Daman and Diu' == $row['ofcState']) ? 'selected' : ''; ?>>Daman and Diu</option>
                                 <option value="Delhi"<?php echo ($update && 'Delhi' == $row['ofcState']) ? 'selected' : ''; ?>>Delhi</option>
                                 <option value="Goa"<?php echo ($update && 'Goa' == $row['ofcState']) ? 'selected' : ''; ?>>Goa</option>
                                 <option value="Gujarat"<?php echo ($update && 'Gujarat' == $row['ofcState']) ? 'selected' : ''; ?>>Gujarat</option>
                                 <option value="Haryana"<?php echo ($update && 'Haryana' == $row['ofcState']) ? 'selected' : ''; ?>>Haryana</option>
                                 <option value="Himachal Pradesh"<?php echo ($update && 'Himachal Pradesh' == $row['ofcState']) ? 'selected' : ''; ?>>Himachal Pradesh</option>
                                 <option value="Jammu and Kashmir"<?php echo ($update && 'Jammu and Kashmir' == $row['ofcState']) ? 'selected' : ''; ?>>Jammu and Kashmir</option>
                                 <option value="Jharkhand"<?php echo ($update && 'Jharkhand' == $row['ofcState']) ? 'selected' : ''; ?>>Jharkhand</option>
                                 <option value="Karnataka"<?php echo ($update && 'Karnataka' == $row['ofcState']) ? 'selected' : ''; ?>>Karnataka</option>
                                 <option value="Kerala"<?php echo ($update && 'Kerala' == $row['ofcState']) ? 'selected' : ''; ?>>Kerala</option>
                                 <option value="Lakshadweep"<?php echo ($update && 'Lakshadweep' == $row['ofcState']) ? 'selected' : ''; ?>>Lakshadweep</option>
                                 <option value="Madhya Pradesh"<?php echo ($update && 'Madhya Pradesh' == $row['ofcState']) ? 'selected' : ''; ?>>Madhya Pradesh</option>
                                 <option value="Maharashtra"<?php echo ($update && 'Maharashtra' == $row['ofcState']) ? 'selected' : ''; ?>>Maharashtra</option>
                                 <option value="Manipur"<?php echo ($update && 'Manipur' == $row['ofcState']) ? 'selected' : ''; ?>>Manipur</option>
                                 <option value="Meghalaya"<?php echo ($update && 'Meghalaya' == $row['ofcState']) ? 'selected' : ''; ?>>Meghalaya</option>
                                 <option value="Mizoram"<?php echo ($update && 'Mizoram' == $row['ofcState']) ? 'selected' : ''; ?>>Mizoram</option>
                                 <option value="Nagaland"<?php echo ($update && 'Nagaland' == $row['ofcState']) ? 'selected' : ''; ?>"Nagaland</option>
                                 <option value="Orissa"<?php echo ($update && 'Orissa' == $row['ofcState']) ? 'selected' : ''; ?>>Orissa</option>
                                 <option value="Pondicherry"<?php echo ($update && 'Pondicherry' == $row['ofcState']) ? 'selected' : ''; ?>>Pondicherry</option>
                                 <option value="Punjab" <?php echo ($update && 'Punjab' == $row['ofcState']) ? 'selected' : ''; ?>>Punjab</option>
                                 <option value="Rajasthan"<?php echo ($update && 'Rajasthan' == $row['ofcState']) ? 'selected' : ''; ?>>Rajasthan</option>
                                 <option value="Sikkim"<?php echo ($update && 'Sikkim' == $row['ofcState']) ? 'selected' : ''; ?>>Sikkim</option>
                                 <option value="Tamil Nadu" <?php echo ($update && 'Tamil Nadu' == $row['ofcState']) ? 'selected' : ''; ?>>Tamil Nadu</option>
                                 <option value="Tripura" <?php echo ($update && 'Tripura' == $row['ofcState']) ? 'selected' : ''; ?>>Tripura</option>
                                 <option value="Uttaranchal" <?php echo ($update && 'Uttaranchal' == $row['ofcState']) ? 'selected' : ''; ?>>Uttaranchal</option>
                                 <option value="Uttar Pradesh" <?php echo ($update && 'Uttar Pradesh' == $row['ofcState']) ? 'selected' : ''; ?>>Uttar Pradesh</option>
                                 <option value="West Bengal" <?php echo ($update && 'West Bengal' == $row['ofcState']) ? 'selected' : ''; ?>>West Bengal</option>
                              </select>
                           </div>
                        </div>
                     </div>
                     <div class="well">
                        <h3>Other Details</h3>
                        <!--Marital Status-->
                        <div class="form-group">
                           <label class= "col-lg-2 col-md-2 col-sm-2 col-xs-12" for="marStatus">Marital Status</label>
                           <div class="col-lg-4 col-md-4 col-sm-4 col-xs-12">
                              <select id="marStatus" name="marStatus" class="form-control" >
                                 <option value="0">Status</option>
                                 <option value="single" <?php echo  ($update && 'single' == $row['marStatus']) ? 'selected' : ''; ?>>Single</option>
                                 <option value="married" <?php echo ($update && 'married' == $row['marStatus']) ? 'selected' : ''; ?>>Married</option>
                                 <option value="divorced" <?php echo ($update && 'divorced' == $row['marStatus']) ? 'selected' : ''; ?>>Divorced</option>
                                 <option value="widow" <?php echo ($update && 'widow' == $row['marStatus']) ? 'selected' : ''; ?>>Widow</option>
                                 <option value="widower" <?php echo ($update && 'widower' == $row['marStatus']) ? 'selected' : ''; ?>>Widower</option>
                              </select>
                           </div>
                        </div>
                        <!--Radio button for employment status-->
                        <div class="form-group">
                           <label class="col-lg-2 col-md-2 col-sm-2 col-xs-12" for="empStatus">
                           Employement Status</label>
                           <div class="col-lg-4 col-md-4 col-sm-4 col-xs-12">
                              <div class="row">
                                 <div class="radio col-lg-6 col-md-6 col-sm-6 col-xs-12">
                                    <label><input type="radio" name="empStatus" value="employed" <?php echo ($update) ? ($row['empStatus'] == 'employed' ? "checked=checked" : '') : "checked=checked"; ?>>Employed</label>
                                 </div>
                                 <div class="radio col-lg-6 col-md-6 col-sm-6 col-xs-12">
                                    <label><input type="radio" name="empStatus" value="umemployed" <?php echo (($update) && $row['empStatus'] == 'umemployed') ? "checked=checked" : ''; ?>>Umemployed</label>
                                 </div>
                              </div>
                              <div class="row">
                                 <div class="radio col-lg-6 col-md-6 col-sm-6 col-xs-12">
                                    <label><input type="radio" name="empStatus" value="self-employed" <?php echo (($update) && $row['empStatus'] == 'self-employed') ? "checked=checked" : ''; ?>>Self-Employed</label>
                                 </div>
                                 <div class="radio col-lg- col-md-6 col-sm-6 col-xs-12">
                                    <label><input type="radio" name="empStatus" value="student" <?php echo (($update) && $row['empStatus'] == 'student') ? "checked=checked" : ''; ?>>Student</label>
                                 </div>
                              </div>
                           </div>
                        </div>
                        <div class="form-group">
                           <label class="col-lg-2 col-md-2 col-sm-2 col-xs-12" for="textinput">Employer</label>  
                           <div class="col-lg-4 col-md-4 col-sm-4 col-xs-12">
                              <input id="textinput" name="employer" type="text" class="form-control input-md" value=" <?php echo ($update) ? $row['employer'] : ''; ?> ">
                           </div>
                        </div>
                        <!-- Image Upload -->
                        <div class="form-group">
                           <label class="col-lg-2 col-md-2 col-sm-2 col-xs-12" for="textinput">Upload Image</label>  
                           <label class="btn btn-file col-lg-4 col-md-4 col-sm-4 col-xs-12" name= "image"><input type="file">
                           </label>
                        </div>
                        <!-- Communication Medium -->
                        <div class="form-group">
                           <label class="col-lg-2 col-md-2 col-sm-2 col-xs-12" for="Communication">Communicate via</label>
                           <div class="col-lg-4 col-md-4 col-sm-4 col-xs-12">
                              <div class="row">
                                 <div class="checkbox col-lg-6 col-md-6 col-sm-6 col-xs-12">
                                    <label for="Communication-0">
                                    <input type="checkbox" name="comm[]" id="Communication-0" value="1" <?php echo ($update) ? ($row['commId'] == '1' ? "checked=checked" : '') : "checked=checked"; ?>>
                                    E-Mail
                                    </label>
                                 </div>
                                 <div class="checkbox col-lg-6 col-md-6 col-sm-6 col-xs-12">
                                    <label for="Communication-1">
                                    <input type="checkbox" name="comm[]" id="Communication-1" value="2" <?php echo ($update) ? ($row['commId'] == '2' ? "checked=checked" : '') : "checked=checked"; ?>>
                                    Message
                                    </label>
                                 </div>
                              </div>
                              <div class="row">
                                 <div class="checkbox col-lg-6 col-md-6 col-sm-6 col-xs-12">
                                    <label for="Communication-2">
                                    <input type="checkbox" name="comm[]" id="Communication-2" value="3" <?php echo ($update) ? ($row['commId'] == '3' ? "checked=checked" : '') : "checked=checked"; ?>>
                                    Phone
                                    </label>
                                 </div>
                                 <div class="checkbox col-lg-6 col-md-6 col-sm-6 col-xs-12">
                                    <label for="Communication-3">
                                    <input type="checkbox" name="comm[]" id="Communication-3" value="4" <?php echo ($update) ? ($row['commId'] == '4' ? "checked=checked" : '') : "checked=checked"; ?>>
                                    Any
                                    </label>
                                 </div>
                              </div>
                           </div>
                        </div>
                        <!-- Textarea -->
                        <div class="form-group">
                           <label class="col-lg-2 col-md-2 col-sm-2 col-xs-12" for="Note">Note</label>
                           <div class="col-lg-8 col-md-8 col-sm-8 col-xs-12">                     
                              <textarea class="form-control" id="Note" name="note" rows="6" placeholder="Write something about yourself"> <?php echo ($update) ? $row['note'] : ''; ?></textarea>
                           </div>
                        </div>
                        <div class="row text-center">
                           <?php 
                              if (1 == $update) {
                              	?>
                           <button type="submit" class="btn btn-success" role="button">Update
                           </button>
                           <button type="reset" class="btn btn-primary" role="button">Clear
                           </button> 
                           <?php
                              }
                              	else{
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
      <!-- /.container -->
      <!-- jQuery -->
      <script src="js/jquery.js"></script>
      <!-- Bootstrap Core JavaScript -->
      <script src="js/bootstrap.min.js"></script>
   </body>
</html>