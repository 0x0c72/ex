<?php
	// $mysqli = new mysqli('localhost', 'corpjuk', 'grools2!', 'testdb1');

	if ($mysqli->connect_errno) {
		echo "Failed to connect to MySQL: (" . $mysqli->connect_errno . ") " . $mysqli->connect_error;
	}

	if (!($stmt = $mysqli->prepare("INSERT INTO test (username) VALUES (?)"))) {
		echo "Prepare failed: (" . $mysqli->errno . ") " . $mysqli->error;
	}

	$username = 'chris';

	if (!$stmt->bind_param("s", $username)) {
		echo "Binding parameters failed: (" . $stmt->errno . ") " . $stmt->error;
	}

	if (!$stmt->execute()) {
		echo "Execute failed: (" . $stmt->errno . ") " . $stmt->error;
	}
?>