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
<table width="80%" align='center'>
<tr><td>
<h1 style='color: blue' align='center'>OJ7 beta 3</h1>
<hr/>
</td></tr>

<tr><td>
<h2 align='center'>Notice</h2>
<pre class='bcode'><?php include("conf/notice.list"); ?></pre>
<hr/>
</td></tr>


<tr><td>
<h2 align='center'>Updates</h2>
<pre class='bcode'><?php include("conf/upd.list"); ?></pre>
<hr/>
</td></tr>

<tr><td>
<h2 align='center'> <a href='dw.php' style='text-decoration:none; color:blue'>Source packages</a></h2>
Recent:
<pre class='bcode'>
<?php
$upd_f = fopen("conf/download.list", "r");
$cnt = 0;
while (!feof($upd_f) && $cnt <= 10) {
	++ $cnt;
	$tx = fgets($upd_f);
	echo("<a href='". $tx. "'/>");
	echo($tx);
	echo("</a>");
}
fclose($upd_f);
?>
</pre>
<hr/>
</td></tr>

<tr><td>
<h2 align='center'>Common software</a></h2>
<pre class='bcode'>
<?php
$upd_f = fopen("conf/soft.list", "r");
$cnt = 0;
while (!feof($upd_f) && $cnt <= 10) {
	++ $cnt;
	$tx = fgets($upd_f);
	echo("<a href='". $tx. "'/>");
	echo($tx);
	echo("</a>");
}
fclose($upd_f);
?>
</pre>
</td></tr>
</table>
<?php
include('oj-footer.php');
?>
</body>
</html>
