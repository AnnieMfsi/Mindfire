<?php 
   /*
      @Author : Mfsi_Annapurnaa
      @purpose : handle thelisting of employee data. 
               : Deletion of a row
   */

   require_once('config/dbConnect.php');
   // Delete a row
   if(isset($_GET['delete']))
   {
      $empId = $_GET['delete'];

      // Extract image name and delete it
      $imgQuery = "SELECT image FROM Employee WHERE Employee.empId = $empId";
      $img = mysqli_fetch_array(mysqli_query($conn, $imgQuery));
      unlink(IMAGEPATH.$img['image']);

      $deleteAddress = "DELETE
         FROM Address
         WHERE Address.empId = $empId";
      $deleteEmployee = "DELETE
         FROM Employee
         WHERE Employee.empId = $empId"; 

      $delResultAddr = mysqli_query($conn, $deleteAddress); 
      $delResultEmp = mysqli_query($conn, $deleteEmployee); 

      if (! $delResultAddr && ! $delResultEmp)
      {
         echo 'Deletion failed' . mysql_error(); 
         header('Location:list.php');
      }
   }

   // Query to fetch data from database
   $displayQuery = "SELECT Employee.empId AS EmpID, CONCAT(Employee.title, ' ', Employee.firstName, 
      ' ', Employee.middleName, ' ', Employee.lastName) AS Name, Employee.email AS EmailID, 
      Employee.phone AS Phone, Employee.gender AS Gender, Employee.dateOfBirth AS Dob, 
      CONCAT(Residence.street, '<br />' , Residence.city , '<br />', Residence.zip,'<br />', 
      Residence.state ) AS Res,
      CONCAT(Office.street, '<br />', Office.city , '<br />',  Office.zip, '<br />', Office.state) AS Ofc,
      Employee.maritalStatus AS marStatus, Employee.empStatus AS EmploymentStatus, 
      Employee.employer AS Employer, Employee.commId AS Communication, Employee.image AS Image, 
      Employee.note AS Note
      FROM Employee 
      JOIN Address AS Residence ON Employee.empId = Residence.empId 
      AND Residence.addressType = 'residence'
      JOIN Address AS Office ON Employee.empId = Office.empId 
      AND Office.addressType = 'office'";

   $result = mysqli_query($conn, $displayQuery);
   if (! $result)
      {
         echo 'Deletion failed' . mysql_error(); 
         header('Location:list.php');
      }
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
      <?php include('template/header.php'); ?>
      <!-- Page Content -->
      <div class="container-fluid">
         <table class="table table-responsive">
            <tbody>
                  <tr>
                  <!-- Column headers -->
                     <th>Serial No.</th>
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
                      <th>Image</th>
                     <th>Note</th>
                     <th>Edit</th>
                     <th>Delete</th>
                  </tr>
               <?php
               $i = 0;
               // Continue till the last record 
                  while ($row = mysqli_fetch_array($result, MYSQLI_ASSOC)) {
                     ++$i;?>
                     <tr>
                        <?php foreach ($row as $key => $value)
                        {
                        ?>
                        <td> <?php 
                        if ('EmpID' === $key)
                        {
                           $value = $i;
                           echo $value;
                        }
                        else if ('Communication' === $key)
                        {
                           $commQuery = "SELECT CommMedium FROM  `Communication` WHERE  `CommId` 
                              IN ($value)";
                           $commResult = mysqli_query($conn, $commQuery);

                           while ($commRow = mysqli_fetch_array($commResult, MYSQLI_ASSOC))
                           {
                              foreach ($commRow as $key => $value)
                              {
                                 echo $value . '<br /> ';
                              }
                           }
                        }
                        else if ('Image' === $key) 
                           { ?>
                           <img src = "<?php echo IMAGEPATH.$value;?>" alt = "No image" height = "50"
                               width = "50"><?php
                        }
                        else 
                        {
                           echo $value;
                        }                        
                        ?> </td>
                        <?php 
                        } 
                        ?>
                        <!--Edit graphic-->
                        <td><a href="registration.php?edit=<?php echo $row['EmpID']; ?>">
                           <span class="glyphicon glyphicon-pencil"></span>
                           </a>
                        </td>
                        <!--Delete graphic-->
                        <td><a href="list.php?delete=<?php echo $row['EmpID']; ?>">
                           <span class="glyphicon glyphicon-remove"></span>
                           </a>
                        </td>
                     </tr>
                  <?php 
                  }
                  ?>
            </tbody>
         </table>
      </div>
      <!-- Container -->
      <!-- Bootstrap Core JavaScript -->
      <script src="js/bootstrap.min.js"></script>
   </body>
</html>