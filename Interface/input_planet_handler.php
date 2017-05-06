<!-- Inserts new planet -->
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

		$nameInput = $_POST["NAME"];	//must be set
		$distanceFromCenterInput = $_POST["DISTANCE_FROM_CENTER"];
		$massInput = $_POST["MASS"];
		$solarSystemInput = $_POST["SOLAR_SYSTEM"]; //must be set and match existing value in DB
		

		//must have PK and FK
		if(!empty($nameInput) and !empty($solarSystemInput)){
			$ssMatch = oci_parse($conn, "SELECT SOLAR_SYSTEM FROM STAR where UPPER(SOLAR_SYSTEM) LIKE UPPER('" . $solarSystemInput . "')");
			oci_execute($ssMatch);
			//checking if solar system/star input matches existing value
			if(oci_fetch($ssMatch)){
				$sqlPlanetInsert = oci_parse($conn, 
					"INSERT INTO PLANET 
					(NAME,SOLAR_SYSTEM,DISTANCE_FROM_CENTER,MASS) 
					VALUES (:name,:solarsystem,:distancefromcenter,:mass)");

				oci_bind_by_name($sqlPlanetInsert, ":name", $nameInput);
				oci_bind_by_name($sqlPlanetInsert, ":solarsystem", $solarSystemInput);
				oci_bind_by_name($sqlPlanetInsert, ":distancefromcenter", $massInput);

				if(oci_execute($sqlStarInsert)){
					echo "Succesfully inserted into PLANET.";
				}else{
					echo "ERROR:Unable to execute SQL statement";
				}
			}else{
				echo "ERROR: must input existing star";
			}
		}else{
// TODO: take this away
			echo "ERROR: must input planet name AND its star";
		}

	$stid = oci_parse($conn, 'SELECT * FROM PLANET');
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

?>
</html>
