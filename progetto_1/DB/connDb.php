<?php
	$servername= "localhost";
	$username = "programmazionewebunibg";
	$dbname= "my_programmazionewebunibg";
	$password = null;
	$error = false;
	
	try {
		$conn = new PDO("mysql:host=" . $servername . ";" .
										"dbname=" . $dbname, 
											$username, $password);
		// set the PDO error mode to exception
		$conn->setAttribute(PDO::ATTR_ERRMODE, 
												PDO::ERRMODE_EXCEPTION);
	} catch(PDOException$e) {
		echo "<p>DB Error on connection: " . $e->getMessage() . "</p>";
		$error = true;
	}
?>
