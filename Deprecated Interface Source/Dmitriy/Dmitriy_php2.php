<html>


	<head>
		<title> Information Gathered</title>	
	</head>

	<body>

		<?php 
	
	 "<p>Data processed</>
<p/>" ; 
	date_default_timezone_set('UTC');
	echo date('h:i:s:u a, l F jS Y e');
	
	
	 /* Echos the date

                h : 12 hr format

             H : 24 hr format

                i : Minutes

                s : Seconds

              u : Microseconds

                a : Lowercase am or pm

                l : Full text for the day

                F : Full text for the month

                j : Day of the month

                S : Suffix for the day st, nd, rd, etc.
                Y : 4 digit year

	*/
	
	//$variablename
	//['what is being pulled']
	//$_POST Pulls from html vars
	
	//$_POST['VARNAME'];
	
	$usersName = $_POST['username'];
	$street =$_POST['address'];
	$city = $_POST['city'];
	
	// DOT ( . ) is string concatination
	
	echo $usersName . "</br>";
	echo $street . "</br>";
	echo $city . "</br>";
	
	
	
	?>
	
	

	</body>

</html>