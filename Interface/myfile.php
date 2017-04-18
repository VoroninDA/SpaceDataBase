<html>
 <head>
  <title>PHP<->Orcl Test</title>
   <link href="style.css" rel="stylesheet">
 </head>
 <?php 
	 //test
	 echo "<p>Hello World</p>"; 
	 echo "<p>This is the myfile.php for testing</p>";

	 // copy-pasta from Dr. Cano's php example to test
	 // Create connection to Oracle
		$conn = oci_connect('yeaplebetamn', 'V00672813', 'localhost:20037/xe'); // this is localhost, i.e., jasmine.cs.vcu.edu
		if (!$conn) {
		$m = oci_error();
		echo $m['message'], "\n";
		exit;
		}
		else {
		print "</p>Connected to Oracle!</p>";
		}
		// // Close the Oracle connection
		// oci_close($conn);



	echo "<p>Printing out employees table</p>";	

	// Prepare the statement
	$stid = oci_parse($conn, 'SELECT * FROM employees');
	if (!$stid) {
	    $e = oci_error($conn);
	    trigger_error(htmlentities($e['message'], ENT_QUOTES), E_USER_ERROR);
	}

	// Perform the logic of the query
	$r = oci_execute($stid);
	if (!$r) {
	    $e = oci_error($stid);
	    trigger_error(htmlentities($e['message'], ENT_QUOTES), E_USER_ERROR);
	}

	// Fetch the results of the query
	print "<table border='1'>\n";
	while ($row = oci_fetch_array($stid, OCI_ASSOC+OCI_RETURN_NULLS)) {
	    print "<tr>\n";
	    foreach ($row as $item) {
	        print "    <td>" . ($item !== null ? htmlentities($item, ENT_QUOTES) : "&nbsp;") . "</td>\n";
	    }
	    print "</tr>\n";
	}
	print "</table>\n";

	oci_free_statement($stid);
	oci_close($conn);
 ?> 
 </body>
</html>