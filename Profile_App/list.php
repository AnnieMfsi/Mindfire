<?php 
   $host = 'localhost';
   $uName = 'root';
   $password = 'mindfire';
   $database = 'RegistrationInfo';  
   
   //making and checking connection
   $conn = mysqli_connect($host, $uName, $password, $database);
   if (mysqli_connect_error($conn)) {
      die('Failed to connect to database' .mysqli_connect_error());
     }
   
   // Delete a row
      if(isset($_GET['delete'])){
      $empId = $_GET['delete'];
      $deleteQuery1 = "DELETE
               FROM Address
               WHERE Address.empId = $empId";
      $deleteQuery2 = "DELETE
               FROM Employee
               WHERE Employee.empId = $empId";   
      if (mysqli_query($conn, $deleteQuery1) && mysqli_query($conn, $deleteQuery2)) {
      header('Location:list.php');
      }             
   
   }  
   
   
   //query to fetch data from database
   
         $displayQuery = "SELECT Employee.empId AS EmpID, CONCAT(Employee.title, ' ', Employee.firstName, ' ', Employee.middleName, ' ', Employee.lastName) AS Name, Employee.email AS EmailID, Employee.phone AS Phone, Employee.gender AS Gender, Employee.dateOfBirth AS Dob, 
                           CONCAT(Residence.street, Residence.city , Residence.zip, Residence.state ) AS Res,
                           CONCAT(Office.street, Office.city , Office.zip, Office.state ) AS Ofc,
                           Employee.maritalStatus AS MaritalStatus, Employee.empStatus AS EmploymentStatus, 
                           Employee.employer AS Employer, Employee.commId AS Communication, Employee.note AS Note

                        FROM Employee 
                        JOIN Address AS Residence ON Employee.empId = Residence.empId AND Residence.addressType = 'residence'
                        JOIN Address AS Office ON Employee.empId = Office.empId AND Office.addressType = 'office'";
   
   
   
   $result = mysqli_query($conn, $displayQuery);
   
   ?>
<!DOCTYPE html>
<html lang="en">
   <head>
      <meta charset="utf-8">
      <meta http-equiv="X-UA-Compatible" content="IE=edge">
      <meta name="viewport" content="width=device-width, initial-scale=1">
      <meta name="description" content="">
      <meta name="author" content="">
      <title>Get Empl0yed</title>
      <!-- Bootstrap Core CSS -->
      <link href="css/bootstrap.min.css" rel="stylesheet">
      <!-- Custom CSS -->
      <link href="css/styles.css" rel="stylesheet">
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
                  <a href="registration.html">Registration</a>
               </li>
            </ul>
         </div>
         <!-- /.container -->
      </nav>
      <!-- Page Content -->
      <div class="container-fluid">
         <table class=" table table-responsive">
            <tbody>
            <thead>
               <tr>
                  <th>Emp Id</th>
                  <th>Name</th>
                  <th>Email</th>
                  <th>Phone</th>
                  <th>Gender</th>
                  <th>Date of Birth</th>
                  <th>Office Address</th>
                  <th>Residential Address</th>
                  <th>Marital  Status</th>
                  <th>Employement Status</th>
                  <th>Employer</th>
                  <th>Communication</th>
                  <th>Note</th>
                  <th>Edit</th>
                  <th>Delete</th>
               </tr>
            </thead>
            <?php 
               while ($row = mysqli_fetch_array($result, MYSQLI_ASSOC)) { ?>
            <tr>
               <?php foreach ($row as $key => $value) {
                     
                      ?>
               <td> <?php 
                  echo $value
                  ?> </td>
               <?php } ?>
               <td><a href="registration.php?edit=<?php echo $row['EmpID']; ?>">
                  <span class="glyphicon glyphicon-pencil"></span>
                  </a>
               </td>
               <td><a href="list.php?delete=<?php echo $row['EmpID']; ?>">
                  <span class="glyphicon glyphicon-remove"></span>
                  </a>
               </td>
            </tr>
            <?php }?>
            </tbody>
         </table>
      </div>
      <!-- /.container -->
      <!-- jQuery -->
      <script src="js/jquery.js"></script>
      <!-- Bootstrap Core JavaScript -->
      <script src="js/bootstrap.min.js"></script>
   </body>
</html>