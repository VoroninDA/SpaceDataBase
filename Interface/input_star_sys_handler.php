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

		$solarSystemInput = $_POST["SOLAR_SYSTEM"];	//must be set
		$heatInput = $_POST["HEAT"];
		$dateDiscoveredInput = $_POST["DATE_DISCOVERED"];
		$distanceFromEarthInput = $_POST["DISTANCE_FROM_EARTH"];
		$classificationInput = $_POST["CLASSIFICATION"];	//must be set

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
				echo "sql executed";
			}else{
				echo "ERROR:Unable to execute SQL statement";
			}
		}else{
// TODO: take this away
			echo "ERROR: must input solar system AND classification";
		}

		oci_close($conn);

?>