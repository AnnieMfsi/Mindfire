<?php

  if ($_POST["title"] || $_POST["firstName"] || $_POST["middleName"] || $_POST["lastName"] || 
  		$_POST["email"] || $_POST["mobile"] || $_POST["gender"] || $_POST["dob"] || 
  		$_POST["firstName"] || $_POST["firstName"] || $_POST["firstName"] || $_POST["firstName"] || 
  		$_POST["resStreet"] || $_POST["resCity"] || $_POST["resZip"] || $_POST["resState"] || 
  		$_POST["ofcStreet"] || $_POST["ofcCity"] || $_POST["ofcZip"] || $_POST["ofcState"]
  		|| $_POST["marStatus"] || $_POST["empStatus"] || $_POST["employer"] || $_POST["image"]
  		|| $_POST["communication"] || $_POST["note"]) {

  	echo $_POST['title'] ."<br />" .$_POST['firstName'] .$_POST['middleName'] ."<br />" .$_POST['lastName'] ."<br />" .$_POST['email'] .$_POST['mobile'] ."<br />" .$_POST['gender'] ."<br />" .$_POST['dob'];
  }
  else {
  	echo "string";
  }

?>