<html>
<head>
<title>OJ7 - Orange</title>
</head>
<body>
<?php
include('oj-header.php');
?>
<h1 align='center'>
Project Orange
</h1>
<table align='center' width='800px'><tr><td>
<?php
function matchOrangeKey($cskey) {
	$pf = fopen("conf/orangekey.conf", "r");
	list($key) = fscanf($pf, "%s");
	fclose($pf);
	return $key == $cskey;
}
if (strlen($_GET['cmd']) == 0) {
	echo "<table align='center' width='800px'>\n";
	for ($oid = 1; is_file("orange/". $oid. ".cfg"); ++ $oid) {
		$ipf = fopen(("orange/". $oid. ".cfg"), "r");
		$oname = fgets($ipf);
		$aun = fgets($ipf);
		$fln = fgets($ipf);
		fclose($ipf);
		$fln = "orange/". $fln;
		echo "<tr><td>";
		echo "<font size='5'>". $oid. ". ". $oname. "</font>";
		echo "By ". $aun;
		echo "<br/><a href='orange/". $oid. "' style='text-decoration:none;'>View</a>";
		echo "<hr/>";
		echo "</td></tr>";
	}
	echo "<tr><td>";
	echo "<p align='right'>";
	echo "<a href='orange.php?cmd=new' style='text-decoration:none;'>New</a>";
	echo "</p>";
	echo "<p align='right'>";
	echo "<a href='orange.php?cmd=up' style='text-decoration:none;'>Upload</a>";
	echo "</p>";
	echo "</td></tr>";
	echo "</table>\n";
}
else if ($_GET['cmd'] == 'post') {
	$oid = $_POST['oid'];
	$key = $_POST['key'];
	if (!is_dir("orange/". $oid)) {
		header("Location: error.php?word=Invalid orange id");
	}
	else if (!matchOrangeKey($key)) {
		header("Location: error.php?word=Wrong orange key");
	}
	else {
		if ($_FILES['upf']['size'] == 0) {
			header("Location: error.php?word=No file");
		}
		else {
			$name = $_FILES['upf']['name'];
			$dest = "orange/". $oid. "/". $name;
			if (move_uploaded_file($_FILES['upf']['tmp_name'], $dest)) {
				echo "<p align='center'>Successful</p>"; 
				if (strpos($dest, "zip") != false) {
					chmod($dest, 0777);
					$cmd = "unzip -o -q ./". $dest. " -d ./orange/". $oid;
					echo exec($cmd);
				}
			}
			else {
				echo "<p align='center'>Moving error</p>"; 
			}
		}
	}
}
else if ($_GET['cmd'] == 'new') {
	include("forms/orange_new.php");
}
else if ($_GET['cmd'] == 'newrecv') {
	$gwn = $_POST['oname'];
	$aun = $_POST['aun'];
	$oid = 1;
	while (is_dir("orange/". $oid))
		++ $oid;
	mkdir("orange/". $oid);
	$cfgn = "orange/". $oid.".cfg";
	$pf = fopen($cfgn, "w");
	fputs($pf, $gwn);
	fputs($pf, "\n");
	fputs($pf, $aun);
	fclose($pf);
	echo "<p align='center'>Successful</p>"; 
	echo "<p align='center' style='color:red'>Your id is ". $oid. "<p>";
}
else if ($_GET['cmd'] == 'up') {
	include("forms/orange_uf.php");
}
else if ($_GET['cmd'] == 'new') {
	include("forms/orange_new.php");
}
?>
</td></tr>
<tr><td>
<br/>
<p align='right'><a href='orange' style='text-decoration:none'> Back </a></p>
</td></tr>
</table>
<?php
include("oj-footer.php");
?>
</body>
</html>
