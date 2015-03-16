<html>
<head>
<title>OJ7 - Contributors</title>
</head>
<body>
<?php
include('oj-header.php');
?>
<table align='center' border='0' width='80%'>
<tr>
<td style='color: blue; font-size: 30px;' align='center'>
Contributors
</td>
</tr>
<?php
$l_ipf = fopen("conf/contri.list", "r");
while (!feof($l_ipf)) {
	echo("<tr style='color: red; font-size: 80px;' align='center'><td>". fgets($l_ipf). "</td></tr>\n");
}
fclose($l_ipf);
?>
</table>
<?php
include("oj-footer.php");
?>
</body>
</html>
