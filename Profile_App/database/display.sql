SELECT Employee.empId, CONCAT(Employee.title, ' ', Employee.firstName, ' ', Employee.middleName, ' ', Employee.lastName) AS Name, Employee.email AS EmailID, 
		Employee.phone AS Phone, Employee.gender AS Gender, Address.addressType AS AddressType, Address.street AS Street, 
		Address.city AS City, Address.zip AS Zip, Address.state AS State, Employee.maritalStatus AS MaritalStatus, Employee.empStatus AS EmploymentStatus, 
		Employee.employer AS Employer, Employee.commId AS Communication, Employee.note AS note
		FROM Employee JOIN
		Address ON Employee.empId = Address.empId




<div class="error">
            	 <?php 
            	 	if (isset($_COOKIE)) { ?>
                           some error occured.
            	 	<?php } ?> </div>