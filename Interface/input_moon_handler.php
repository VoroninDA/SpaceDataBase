<!-- inserts new satellite with classification moon and given name -->
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

		$idMoonInput = $_POST["ID"]; //must be set
		$distanceInput = $_POST["DISTANCE_FROM_CENTER"];
		$orbitsInput = $_POST["ORBITS"]; //must be set and match existing value in DB
		$massInput = $_POST["MASS"];


		if(!empty($idMoonInput) and !empty($orbitsInput)){
			$planetMatch = oci_parse($conn, "SELECT NAME FROM PLANET where UPPER(NAME) LIKE UPPER('" . $orbitsInput . "')");
			oci_execute($planetMatch);
			//checking if planet input matches existing value
			if(oci_fetch($planetMatch)){
			//inserts with classification moon
				$sqlIDSat = oci_parse($conn, "INSERT INTO SATELLITE (ID,ORBITS,DISTANCE_FROM_CENTER,CLASSIFICATION) VALUES (:idmoon,:orbits,:distancefromcenter,'moon')");
				//inserts into artificial
				$sqlIDMoon = oci_parse($conn, "INSERT INTO MOON (ID,MASS) VALUES (:idmoon,:mass)");
				// $sqlIDSat = oci_parse($conn, "INSERT INTO SATELLITE (ID,LAUNCHED_BY,DATE_LAUNCHED) VALUES (:idartsat,:launched_by,to_date(:date_launched))");
				oci_bind_by_name($sqlIDSat, ":idmoon", $idMoonInput);
				oci_bind_by_name($sqlIDSat,":distancefromcenter",$distanceInput);
				oci_bind_by_name($sqlIDSat, ":orbits", $orbitsInput);
				oci_bind_by_name($sqlIDMoon, ":mass", $massInput);
				oci_bind_by_name($sqlIDMoon, ":idmoon", $idMoonInput);

				if(oci_execute($sqlIDSat)){
					echo "inserted into SATELLITE";
				}else{
					echo "ERROR:Unable to insert into SATELLITE";
				}
				if(oci_execute($sqlIDMoon)){
					echo "inserted into MOON";
				}else{
					echo "ERROR: Unable to insert into MOON";
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