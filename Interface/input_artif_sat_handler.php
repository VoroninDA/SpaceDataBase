<!-- inserts new satellite with classification artitficial and given name -->
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
		date_default_timezone_set('America/New_York');

		$idArtSatInput = $_POST["ID"]; //must be set
		$distanceInput = $_POST["DISTANCE_FROM_CENTER"];
		$launchedByInput = $_POST["LAUNCHED_BY"];
		$dateLaunchedInput = strtotime($_POST["DATE_LAUNCHED"]);
		$dateLaunchedInput = date('j-M-y',$dateLaunchedInput);
		$costInput = $_POST["COST"];
		$orbitsInput = $_POST["ORBITS"]; //must be set and match existing value in DB


		if(!empty($idArtSatInput) and !empty($orbitsInput)){
			$planetMatch = oci_parse($conn, "SELECT NAME FROM PLANET where UPPER(NAME) LIKE UPPER('" . $orbitsInput . "')");
			oci_execute($planetMatch);
			//checking if planet input matches existing value
			if(oci_fetch($planetMatch)){
				//inserts with classification artificial
				$sqlIDSat = oci_parse($conn, "INSERT INTO SATELLITE (ID,ORBITS,DISTANCE_FROM_CENTER,CLASSIFICATION) VALUES (:idartsat,:orbits,:distancefromcenter,'artificial')");
				//inserts into artificial
				$sqlIDArt = oci_parse($conn, "INSERT INTO ARTIFICIAL (ID,LAUNCHED_BY,DATE_LAUNCHED,COST) VALUES (:idartsat,:launchedby,:datelaunched,:cost)");
				// $sqlIDSat = oci_parse($conn, "INSERT INTO SATELLITE (ID,LAUNCHED_BY,DATE_LAUNCHED) VALUES (:idartsat,:launched_by,to_date(:date_launched))");
				oci_bind_by_name($sqlIDSat, ":idartsat", $idArtSatInput);
				oci_bind_by_name($sqlIDSat,":distancefromcenter",$distanceInput);
				oci_bind_by_name($sqlIDArt, ":launchedby", $launchedByInput);
				oci_bind_by_name($sqlIDArt, ":datelaunched", $dateLaunchedInput);
				oci_bind_by_name($sqlIDSat, ":orbits", $orbitsInput);
				oci_bind_by_name($sqlIDArt, ":cost", $costInput);
				oci_bind_by_name($sqlIDArt, ":idartsat", $idArtSatInput);

				if(oci_execute($sqlIDSat)){
					echo "Successfully inserted into SATELLITE ";
				}else{
					echo "ERROR:Unable to insert into SATELLITE";
				}
				if(oci_execute($sqlIDArt)){
					echo "and into ARTIFICIAL";
				}else{
					echo "ERROR: Unable to insert into ARTIFICIAL";
				}
			}else{
				echo "ERROR: must select input existing planet";
			}
		}else{
// TODO: take this away
			echo "ERROR: must input name and planet";
		}

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


		oci_close($conn);

?>
</html>