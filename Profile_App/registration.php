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
   
    $selectQuery = "SELECT Employee.empId AS EmpID, Employee.title, Employee.firstName, Employee.middleName, Employee.lastName, Employee.email, Employee.phone, Employee.gender, Employee.dateOfBirth, 
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
                     echo date('m/d/Y', strtotime($row['dateOfBirth']));
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
                              <input type='date'  name="dob" class="form-control" value="<?php echo ($update) ? date('m/d/Y', strtotime($row['dateOfBirth'])) : ''; ?>"/>
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
                              <select id="state" name="resState" class="form-control address" <?php echo ($update) ? $row['resState'] : ''; ?>>
                                 <option value="0">Select State</option>
                                 <option value="Andaman and Nicobar Islands">Andaman and Nicobar Islands</option>
                                 <option value="Andhra Pradesh">Andhra Pradesh</option>
                                 <option value="Arunachal Pradesh">Arunachal Pradesh</option>
                                 <option value="Assam">Assam</option>
                                 <option value="Bihar">Bihar</option>
                                 <option value="Chandigarh">Chandigarh</option>
                                 <option value="Chhattisgarh">Chhattisgarh</option>
                                 <option value="Dadra and Nagar Haveli">Dadra and Nagar Haveli</option>
                                 <option value="Daman and Diu">Daman and Diu</option>
                                 <option value="Delhi">Delhi</option>
                                 <option value="Goa">Goa</option>
                                 <option value="Gujarat">Gujarat</option>
                                 <option value="Haryana">Haryana</option>
                                 <option value="Himachal Pradesh">Himachal Pradesh</option>
                                 <option value="Jammu and Kashmir">Jammu and Kashmir</option>
                                 <option value="Jharkhand">Jharkhand</option>
                                 <option value="Karnataka">Karnataka</option>
                                 <option value="Kerala">Kerala</option>
                                 <option value="Lakshadweep">Lakshadweep</option>
                                 <option value="Madhya Pradesh">Madhya Pradesh</option>
                                 <option value="Maharashtra">Maharashtra</option>
                                 <option value="Manipur">Manipur</option>
                                 <option value="Meghalaya">Meghalaya</option>
                                 <option value="Mizoram">Mizoram</option>
                                 <option value="Nagaland">Nagaland</option>
                                 <option value="Orissa">Orissa</option>
                                 <option value="Pondicherry">Pondicherry</option>
                                 <option value="Punjab">Punjab</option>
                                 <option value="Rajasthan">Rajasthan</option>
                                 <option value="Sikkim">Sikkim</option>
                                 <option value="Tamil Nadu">Tamil Nadu</option>
                                 <option value="Tripura">Tripura</option>
                                 <option value="Uttaranchal">Uttaranchal</option>
                                 <option value="Uttar Pradesh">Uttar Pradesh</option>
                                 <option value="West Bengal">West Bengal</option>
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
                                 <option value="Andhra Pradesh">Andhra Pradesh</option>
                                 <option value="Arunachal Pradesh">Arunachal Pradesh</option>
                                 <option value="Assam">Assam</option>
                                 <option value="Bihar">Bihar</option>
                                 <option value="Chandigarh">Chandigarh</option>
                                 <option value="Chhattisgarh">Chhattisgarh</option>
                                 <option value="Dadra and Nagar Haveli">Dadra and Nagar Haveli</option>
                                 <option value="Daman and Diu">Daman and Diu</option>
                                 <option value="Delhi">Delhi</option>
                                 <option value="Goa">Goa</option>
                                 <option value="Gujarat">Gujarat</option>
                                 <option value="Haryana">Haryana</option>
                                 <option value="Himachal Pradesh">Himachal Pradesh</option>
                                 <option value="Jammu and Kashmir">Jammu and Kashmir</option>
                                 <option value="Jharkhand">Jharkhand</option>
                                 <option value="Karnataka">Karnataka</option>
                                 <option value="Kerala">Kerala</option>
                                 <option value="Lakshadweep">Lakshadweep</option>
                                 <option value="Madhya Pradesh">Madhya Pradesh</option>
                                 <option value="Maharashtra">Maharashtra</option>
                                 <option value="Manipur">Manipur</option>
                                 <option value="Meghalaya">Meghalaya</option>
                                 <option value="Mizoram">Mizoram</option>
                                 <option value="Nagaland">Nagaland</option>
                                 <option value="Orissa">Orissa</option>
                                 <option value="Pondicherry">Pondicherry</option>
                                 <option value="Punjab">Punjab</option>
                                 <option value="Rajasthan">Rajasthan</option>
                                 <option value="Sikkim">Sikkim</option>
                                 <option value="Tamil Nadu">Tamil Nadu</option>
                                 <option value="Tripura">Tripura</option>
                                 <option value="Uttaranchal">Uttaranchal</option>
                                 <option value="Uttar Pradesh">Uttar Pradesh</option>
                                 <option value="West Bengal">West Bengal</option>
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
                                 <option value="single">Single</option>
                                 <option value="married">Married</option>
                                 <option value="divorced">Divorced</option>
                                 <option value="widow">Widow</option>
                                 <option value="widower">Widower</option>
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
                                    <input type="checkbox" name="comm[]" id="Communication-0" value="1">
                                    E-Mail
                                    </label>
                                 </div>
                                 <div class="checkbox col-lg-6 col-md-6 col-sm-6 col-xs-12">
                                    <label for="Communication-1">
                                    <input type="checkbox" name="comm[]" id="Communication-1" value="2">
                                    Message
                                    </label>
                                 </div>
                              </div>
                              <div class="row">
                                 <div class="checkbox col-lg-6 col-md-6 col-sm-6 col-xs-12">
                                    <label for="Communication-2">
                                    <input type="checkbox" name="comm[]" id="Communication-2" value="3">
                                    Phone
                                    </label>
                                 </div>
                                 <div class="checkbox col-lg-6 col-md-6 col-sm-6 col-xs-12">
                                    <label for="Communication-3">
                                    <input type="checkbox" name="comm[]" id="Communication-3" value="4">
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