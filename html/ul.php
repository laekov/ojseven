<html>
<head>
<title>OJ7 - Status</title>
</head>
<body>
<?php
include('oj-header.php');
?>
<table align='center' width='800px'>
<tr><td>
<?php
$c_ipf = fopen("conf/cont.conf", "r");
$cid = fread($c_ipf, 8);
fclose($c_ipf);
echo("Contest id: ");
echo($cid);
echo("<br/>");
?>
</tr></td>
<table align='center' border='1' width='800px'>
<tr>
<td>User</td><td>Uploaded code</td>
</tr>
<?php
$c_dir = opendir('./upload/'. $cid);
$tot_p = 0;
$tot_c = 0;
while (($u_dir = readdir($c_dir)) != false) {
	$sub_dir = opendir('./upload/'. $cid. '/'. $u_dir); 
	if ($u_dir == '.' || $u_dir == '..')
		continue;
	else {
		echo("<tr>");
		echo("<td>". $u_dir. "</td>");
		echo("<td>");
		//if (!is_dir($sub_dir))
		//	echo("not a dir<br/>");
		$nof = true;
		while (($c_file = readdir($sub_dir)) != false) {
			if ($c_file == '.' || $c_file == '..')
				continue;
			chmod($c_dir. '/'. $u_dir. '/'. $c_file, 0777);
			echo($c_file. "\tUnlocked<br/>");
			++ $tot_c;
			$nof = false;
		}
		if ($nof) {
			echo("EMPTY!!!");
		}
		if (!$nof)
			++ $tot_p;
		echo("</td>");
		echo("</tr>\n");
	}
	closedir($sub_dir);
}
closedir($c_dir);
?>
</table>
<br/>
<br/>
<br/>
<br/>
<br/>
<br/>
<table align='center' border='1' width='800px'>
<?php
echo("<tr><td width='400px'>Total user</td><td>");
echo("\t". $tot_p. "<br/></td>");
echo("<tr><td>Total code</td><td>");
echo("\t". $tot_c. "<br/></td>");
?>
</table>
<?php
include('oj-footer.php');
?>
</body>
</html>
