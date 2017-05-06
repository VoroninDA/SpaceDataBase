<html>
 <head>
  <title>SpaceDatabase</title>
   <link href="style.css" rel="stylesheet">
 </head>
 <p><a href="index.php"><input type="reset" value="Back to main menu"></a></p>
 <?php 
	 // Create connection to Oracle
		$conn = oci_connect('yeaplebetamn', 'V00672813', 'localhost:20037/xe'); // this is localhost, i.e., jasmine.cs.vcu.edu
		if (!$conn) {
		$m = oci_error();
		echo $m['message'], "\n";
		exit;
		}
		else {
		//print "</p>Connected to Oracle!</p>";
		}

	echo "STAR";
$stid = oci_parse($conn, 'SELECT * FROM STAR');
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



	echo "PLANET";
	$stid = oci_parse($conn, 'SELECT * FROM PLANET');
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



			echo "MOON";
		$stid = oci_parse($conn, 
				'SELECT S.ID,S.ORBITS,S.DISTANCE_FROM_CENTER,M.MASS
				FROM SATELLITE S 
				INNER JOIN MOON M ON S.ID=M.ID');
	if (!$stid) {
	    $e = oci_error($conn);
	    trigger_error(htmlentities($e['message'], ENT_QUOTES), E_USER_ERROR);
		}

	oci_execute($stid);
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

			echo "ARTIFICIAL";
		$stid = oci_parse($conn, 
				'SELECT S.ID,S.ORBITS,S.DISTANCE_FROM_CENTER,A.LAUNCHED_BY,A.DATE_LAUNCHED,A.COST 
				FROM SATELLITE S 
				INNER JOIN ARTIFICIAL A ON S.ID=A.ID');
	if (!$stid) {
	    $e = oci_error($conn);
	    trigger_error(htmlentities($e['message'], ENT_QUOTES), E_USER_ERROR);
		}

	oci_execute($stid);
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


 ?> 
</html>