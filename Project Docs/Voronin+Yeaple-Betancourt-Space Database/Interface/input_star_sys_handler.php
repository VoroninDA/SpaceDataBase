<html>
 <head>
  <title></title>
   <link href="style.css" rel="stylesheet">
 </head>
 <p><a href="index.php"><input type="reset" value="Back to main menu"></a></p>
<?php
	//toggle error reporting
	error_reporting(0);

	// Create connection to Oracle
		$conn = oci_connect('yeaplebetamn', 'V00672813', 'localhost:20037/xe'); // this is localhost, i.e., jasmine.cs.vcu.edu
		if (!$conn) {
		$m = oci_error();
		echo $m['ERROR: Oracle connection lost'], "\n";
		exit;
		}
		else {
			//print "</p>Connected to Oracle!</p>";
		}

		$solarSystemInput = $_POST["SOLAR_SYSTEM"];	//must be set
		$heatInput = $_POST["HEAT"];
		$dateDiscoveredInput = strtotime($_POST["DATE_DISCOVERED"]);
		$dateDiscoveredInput = date('j-M-y',$dateDiscoveredInput);
		$distanceFromEarthInput = $_POST["DISTANCE_FROM_EARTH"];
		$classificationInput = $_POST["CLASSIFICATION"];	//must be set
		/* if(!empty($solarSystemInput) and !empty($classificationInput)){
			$sqlStarInsert = oci_parse($conn, 
				"EXECUTE ADDPROFILE ($newProfName, $newPasswordText)");
				*/

		//must have PK
		if(!empty($solarSystemInput) and !empty($classificationInput)){
			$sqlStarInsert = oci_parse($conn, 
				"INSERT INTO STAR 
				(SOLAR_SYSTEM,HEAT,DATE_DISCOVERED,DISTANCE_FROM_EARTH,CLASSIFICATION) 
				VALUES (:solarsystem,:heat,:datediscovered,:distancefromearth,:classification)");

			oci_bind_by_name($sqlStarInsert, ":solarsystem", $solarSystemInput);
			oci_bind_by_name($sqlStarInsert, ":heat", $heatInput);
			oci_bind_by_name($sqlStarInsert, ":datediscovered", $dateDiscoveredInput);
			oci_bind_by_name($sqlStarInsert, ":distancefromearth", $distanceFromEarthInput);
			oci_bind_by_name($sqlStarInsert, ":classification", $classificationInput);

			if(oci_execute($sqlStarInsert)){
				echo "Succesfully inserted into STAR";
			}else{
				echo "ERROR: Unable to execute SQL statement";
				header('Location: input_star.html');
			}
		}else{
// TODO: take this away
			echo "ERROR: Must input solar system AND classification";
			header('Location: input_star_sys.html');
		}

		$stid = oci_parse($conn, 'SELECT * FROM STAR');
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

		oci_close($conn);

	// header('Location: stars.php');

?>
</html>