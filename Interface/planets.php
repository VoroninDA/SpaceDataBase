<html><head>
		<title>Planets</title>
		<meta charset="utf-8">
		<meta name="viewport" content="width=device-width, initial-scale=1">
		<link rel="stylesheet" href="assets/css/main.css">
	<style type="text/css">
:root .ad.super,
:root #header + #content > #left > #rlblock_left,
:root #content > #right > .dose > .dosesingle,
:root #content > #center > .dose > .dosesingle
{ display: none !important; }</style></head>
	<body class="subpage">

		<!-- Header -->
			<header id="header">
				<div class="inner">
					<a href="index.php" class="logo">Yeaple-Betancourt &amp; Voronin</a>
					<nav id="nav">
						<a href="index.php">Home</a>
                        <a href="planets.php">Planets</a>
                        <a href="stars.php">Stars</a>
                        <a href="satellites.php">Satellite</a>
                        <a href="login.php">Login</a>
					</nav>
					<a href="#navPanel" class="navPanelToggle"><span class="fa fa-bars"></span></a>
				</div>
			</header>
			

		<!-- Banner -->
			<section id="banner">
				<h1>These are the Planets</h1>
							</section>
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

		$stid = oci_parse($conn, "SELECT column_name
				FROM USER_TAB_COLUMNS
				WHERE table_name = 'PLANET'");
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
			print "<table>\n";
			print "<thead>\n";

			print "<tr>\n";
			while (($row = oci_fetch_array($stid, OCI_ASSOC)) != false) {
			
			    foreach ($row as $item) {
			        print "    <th>" . ($item !== null ? htmlentities($item, ENT_QUOTES) : "&nbsp;") . "</th>\n";
			    }
			   
			}
 			print "</tr>\n";
			print "</thead>\n";
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
			print "<tbody>\n";
			while ($row = oci_fetch_assoc($stid)) {
			    print "<tr>\n";
			    foreach ($row as $item) {
			        print "    <td>" . ($item !== null ? htmlentities($item, ENT_QUOTES) : "&nbsp;") . "</td>\n";
			    }
			    print "</tr>\n";
			}
			print "</tbody>\n";
			print "</table>\n";

				?>
		<!-- Scripts -->
			<script src="assets/js/jquery.min.js"></script>
			<script src="assets/js/skel.min.js"></script>
			<script src="assets/js/util.js"></script>
			<script src="assets/js/main.js"></script>

	
<div id="navPanel">
						<a href="index.html" style="-webkit-tap-highlight-color: rgba(0, 0, 0, 0);">Home</a>
						<a href="generic.html" style="-webkit-tap-highlight-color: rgba(0, 0, 0, 0);">Generic</a>
						<a href="elements.html" style="-webkit-tap-highlight-color: rgba(0, 0, 0, 0);">Elements</a>
					<a href="#navPanel" class="close" style="-webkit-tap-highlight-color: rgba(0, 0, 0, 0);"></a></div><img id="hzDownscaled" style="position: absolute; top: -10000px;"><img id="hzDownscaled" style="position: absolute; top: -10000px;"></body></html>