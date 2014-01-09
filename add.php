<?php

	// Form Validation	

	$name = '';
	$gender = '';
	$address = '';
	$email = '';
	$username = '';
	$password = '';
	$output = '';

	if(isset($_POST['formSubmitted']) && $_POST['password'] == $_POST['password2']) {
		// collect all input and trim to remove leading and trailing whitespaces
		$name = trim($_POST['name']);
		$gender = trim($_POST['gender']);
		$address = trim($_POST['address']);
		$email = trim($_POST['email']);
		$username = trim($_POST['username']);
		$password = trim($_POST['password']);
		$passconfirm = trim($_POST['password2']);
		
		$errors = array();
		
		// Validate the input
		if (strlen($name) == 0)
			array_push($errors, "Please enter your name.");
		
		if (!(strcmp($gender, "Male") || strcmp($gender, "Female") || strcmp($gender, "Other"))) 
			array_push($errors, "Please specify your gender.");
		 
		if (strlen($address) == 0) 
			array_push($errors, "Please specify your address.");
		
		if (!filter_var($email, FILTER_VALIDATE_EMAIL))
			array_push($errors, "Please specify a valid email address.");
		
		if (strlen($username) == 0)
			array_push($errors, "Please enter a valid username.");
		
		if (strlen($password) < 5)
			array_push($errors, "Please enter a password. Passwords must contain at least 5 characters.");
		
		// If no errors were found, proceed with storing the user input
		if (count($errors) == 0) {
			array_push($errors, "No errors were found. Thanks!");
		 }
		//Prepare errors for output
		$output = '';
		foreach($errors as $val) {
			$output .= "<p class='output'>".$val."</p>";
		}
		echo $output;
	}

	// Database Access and Add User

	$password = hash('sha512', $password);

	$mysqli = new mysqli('localhost', 'corpjuk', 'grools2!', 'testdb1');

	if ($mysqli->connect_errno) {
		echo "Failed to connect to MySQL: (" . $mysqli->connect_errno . ") " . $mysqli->connect_error;
	}

	if (!($stmt = $mysqli->prepare("INSERT INTO test (name, gender, address, email, username, password) VALUES (?,?,?,?,?,?)"))) {
		echo "Prepare failed: (" . $mysqli->errno . ") " . $mysqli->error;
	}

	// SHA2(CONCAT('$password', '$username'), 512)

	if (!$stmt->bind_param("ssssss", $name, $gender, $address, $email, $username, $password)) {
		echo "Binding parameters failed: (" . $stmt->errno . ") " . $stmt->error;
	}

	if (!$stmt->execute()) {
		echo "Execute failed: (" . $stmt->errno . ") " . $stmt->error;
	}
	$stmt->close();
/* 
	TODO: select from database based on form input


	$stmt = $mysqli->prepare("SELECT * FROM REGISTRY where name = ?");
	if ($stmt->execute(array($_GET['name']))) {
		while ($row = $stmt->fetch()) {
			print_r($row);
		}
	}
*/	

?>