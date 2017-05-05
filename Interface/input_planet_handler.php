<!-- Inserts new planet -->
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
					echo "sql executed";
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

		oci_close($conn);

?>