<?php

	$stateList = array("Andaman and Nicobar Islands", "Andhra Pradesh", "Arunachal Pradesh", "Assam", "Bihar", "Chandigarh", "Chhattisgarh", "Dadra and Nagar Haveli", "Daman and Diu", "Delhi", "Goa", "Gujarat", "Haryana", "Himachal Pradesh", "Jammu and Kashmir", "Jharkhand", "Karnataka", "Kerala", "Lakshadweep", "Madhya Pradesh", "Maharashtra", "Manipur", "Meghalaya", "Mizoram", "Nagaland", "Orissa", "Pondicherry", "Punjab", "Rajasthan", "Sikkim", "Tamil Nadu", "Tripura", "Uttaranchal", "Uttar Pradesh", "West Bengal");

	/*
	 * Encodes the dropdown for states
	 *
	 * @access public function_name
	 * @param Address type
	 * @return 
	 */
	function stateDropdown($addressType){
		'<select id="' . $addressType . '" name="' . $addressType . '" class="form-control address">
			<option value="0">Select State</option>'
		foreach($stateList as $key => $item){ 
		'<option value = "' . $item . ' " ' . ($update && $item == $row['addressType']) ? 'selected' : ((isset($_POST['addressType']) && $item == $_POST['addressType']) ? 'selected' : '') . '>' . $item . '</option>' . } . '</select>'
	}
?>