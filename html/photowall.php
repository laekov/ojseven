<html>
<head>
<title>OJ7 - Photo wall</title>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
</head>
<body>
<?php
include('oj-header.php');
?>
<div align='center' text-align='center' width='800px'>
<?php
$dir=opendir("./photo");
while (($it=readdir($dir))!=false)
	if (!is_dir($it)) {
		echo "<img width='800px' src='./photo/".$it."'/>";
	}
closedir($dir);
?>
</div>
<?php
include('oj-footer.php');
?>
</body>
</html>
