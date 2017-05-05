<!-- inserts new satellite with classification artitficial and given name -->
<?php
	// Create connection to Oracle
		$conn = oci_connect('yeaplebetamn', 'V00672813', 'localhost:20037/xe'); // this is localhost, i.e., jasmine.cs.vcu.edu
		if (!$conn) {
		$m = oci_error();
		echo $m['Oracle connection lost'], "\n";
		exit;
		}
		else {
			print "</p>Connected to Oracle!</p>";
		}

		$idArtSatInput = $_POST["ID"]; //must be set
		$distanceInput = $_POST["DISTANCE_FROM_CENTER"];
		$launchedByInput = $_POST["LAUNCHED_BY"];
		$dateLaunchedInput = $_POST["DATE_LAUNCHED"];
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
					echo "inserted into SATELLITE";
				}else{
					echo "ERROR:Unable to insert into SATELLITE";
				}
				if(oci_execute($sqlIDArt)){
					echo "inserted into ARTIFICIAL";
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

		oci_close($conn);

?>