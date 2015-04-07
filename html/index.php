<html>
<head>
<title>OJ7</title>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<link rel='icon' href='src/ic.png' type='image/x-icon'/>
</head>
<?php
include('oj-header.php');
?>
<body>
<h1 style='color: blue' align='center'>OJ7 beta 3</h1>

<center>
<div style='align:center;width:80%;text-align:left;'>

<div style='float:left;width:60%'>
<div>
<h2 align='center'>Notice</h2>
<?php include("conf/notice.list"); ?>
</div>

<div>
<h2 align='center'>Updates</h2>
<?php 
$ipf = fopen("conf/upd.list", "r"); 
for ($i = 0; $i < 8 && !feof($ipf); ++ $i)
	echo fgets($ipf)."<br/>";
fclose($ipf);
?>
</div>

</div>

<div style='float:left;width:5%'>
<p></p>
</div>

<div style='float:left;width:35%'>
<div>
<h2 align='center'> <a href='dw.php' style='text-decoration:none; color:blue'>Source packages</a></h2>
Recent:<br/>
<?php
$upd_f = fopen("conf/download.list", "r");
$cnt = 0;
while (!feof($upd_f) && $cnt <= 10) {
	++ $cnt;
	$tx = fgets($upd_f);
	echo("<a href='". $tx. "'/>");
	echo($tx);
	echo("</a><br/>");
}
fclose($upd_f);
?>
</div>

<div>
<h2 align='center'>Common software</a></h2>
<?php
$upd_f = fopen("conf/soft.list", "r");
$cnt = 0;
while (!feof($upd_f) && $cnt <= 10) {
	++ $cnt;
	$tx = fgets($upd_f);
	echo("<a href='". $tx. "'/>");
	echo($tx);
	echo("</a><br/>");
}
fclose($upd_f);
?>
</div>
</div>
<div style='clear:both'></div>
</div>
</center>
<?php
include('oj-footer.php');
?>
</body>
</html>
