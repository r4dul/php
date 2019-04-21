<!DOCTYPE html>
<html>
<head>
	<title>Extrageri loto 1998-01-04  -> 2018-10-28</title>
	<meta name="viewport" content="width=device-width, initial-scale=1">
<!-- <script type='text/javascript' src="//cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/3.3.6/js/bootstrap.min.js"></script> -->
		<link rel="stylesheet" type="text/css" href="loto.css">
<!-- 		<link href="//cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/3.3.6/css/bootstrap.min.css" media="screen" rel="stylesheet" type="text/css"/>
<link href="//cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/3.3.6/css/bootstrap-theme.min.css" media="screen" rel="stylesheet" type="text/css"/> -->
</head>
<body>
<?php
	$count = 1;
	$txt_file = file_get_contents('loto.txt');
	$rows = explode("\n", $txt_file);
	echo '<table class="table table-striped table-bordered with-responsive-wrapper">';
	echo "<thead><tr role='row'>";
	echo "<th style='background-color:white'>1998-01-11</th>";
	while ($count <= 49) {
     	echo "<th>" . $count . "</th>";
     	$count++;
	}
    echo "</tr></thead>";
	$count = 0;
	$nr = 0;
	$i = 0;
	$nr49 = 1;
	echo "<tbody>";
	$numbers = array(); 
	foreach($rows as $data) {
		if ($count == 0 || ($count % 7  == 0)) {
			echo "<tr>";
			echo "<td id='date'>" . $data . " </td>";
		} else {
			//array_push($numbers, trim($data));
			$numbers[] = trim($data);
			//echo trim($data);
				//echo "<td id=a".trim($data). " colspan=".trim($data).">" . $data ."</td>";
			}
		$nr++;
		if ($nr == 7) {
			sort($numbers);
            while ($nr49 <= 49)
            {
            	if (in_array($nr49, $numbers)) {
            		//echo "<td id=a" . $numbers[$i] . ">" . $numbers[$i] . "</td>";
            		echo "<td style='background-color:red'" . $numbers[$i] . ">" . $numbers[$i] . "</td>";
                    $i++;
            	} else {
            		echo "<td></td>";
            	}
            	$nr49++;
            }
            $nr49 = 1;
            $i = 0;
            unset($numbers);
			echo "</tr>";
			$nr = 0;
		}
		$count++;
	}
	echo "</tbody>";
	echo "</table>";
?>
</body>
</html>
