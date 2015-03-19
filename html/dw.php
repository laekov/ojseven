<html>
<head>
<link rel='icon' href='src/ic.png' type='image/x-icon'/>
<title>OJ7 - Downloads</title>
</head>
<body>
<?php
include('oj-header.php');
?>
<table width="800px" align='center'>
<tr>
<td><h2 align='center'>Downloads</h2></td>
</tr>
<?php
$upd_f = fopen("conf/download.list", "r");
while (!feof($upd_f)) {
		$tx = fgets($upd_f);
		echo("<tr><td>");
		echo("<a style='text-decoration:none' href='". $tx. "'/>");
		echo($tx);
		echo("</a>");
		echo("</td></tr>");
}
fclose($upd_f);
?>
<tr><td></td></tr>
</table>
<?php
include('oj-footer.php');
?>
</body>
</html>
