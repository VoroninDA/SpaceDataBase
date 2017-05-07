<!-- Searches for planet name -->
<!-- http://www.tutorialrepublic.com/php-tutorial/php-mysql-ajax-live-search.php -->
<?php
	// Create connection to Oracle
		$conn = oci_connect('yeaplebetamn', 'V00672813', 'localhost:20037/xe'); // this is localhost, i.e., jasmine.cs.vcu.edu
		if (!$conn) {
		$m = oci_error();
		echo $m['Oracle connection lost'], "\n";
		exit;
		}
		else {
		//print "</p>Connected to Oracle!</p>";
		}

		//TODO: do an escape function to avoid security risks

		$term = $_REQUEST['term']; //actual search box input

	// Perform the logic of the query
	if(isset($term)){
		//attempt select query execution
		$sql = "SELECT NAME FROM PLANET where UPPER(NAME) LIKE UPPER('%" . $term . "%')";
		$query = oci_parse($conn, $sql); //resource statement
		//$executed = oci_execute($query); //simply executes query, boolean returned
		//$fetched = oci_fetch($query); //boolean returned
		//oci_result not needed but returns full string
		//$result = oci_result($query, 'FIRST_NAME'); //string returned, fetched by oci_fetch

		if(oci_execute($query)){
			while($row = oci_fetch_array($query)){
				echo "<p>" . $row['NAME'] . "</p>";
			}
			if(oci_num_rows($query)<1){
			echo "<p>No matches found </p>";
			}
			//close result set
			oci_free_statement($query);
		}else{
			echo "ERROR: Unable to execute SQL statement.";
		}
	}
	oci_close($conn);

?>