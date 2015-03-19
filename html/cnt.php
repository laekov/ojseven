<html>
<head>
<link rel='icon' href='src/ic.png' type='image/x-icon'/>
<title>OJ7 - Ranklist</title>
</head>
<body>
<?php
include('oj-header.php');
?>
<?php
exec("oj7-ref");
?>
<script src='rescnt/data.js'></script>
<script>
<?php 
if (getuid()!='nouser')
	echo "cur_uid='".getuid()."';";
else
	echo "cur_uid='nouser';";
?>
</script>
<table align='center' width='80%'><tr><td>
Begin contest id <input id='fliterbeg' type='text' onchange='fliterchg()' value='<?php if (strlen($_GET['fbeg'])>0) echo $_GET['fbeg']; else echo "00000000";?>' style='width:100px'/>
&emsp;
End contest id <input id='fliterend' type='text' onchange='fliterchg()'  value='<?php if (strlen($_GET['fend'])>0) echo $_GET['fend']; else echo "99999999";?>' style='width:100px'/>
&emsp;
<input value='Fliter' type='submit' onclick='fliterchg()'/>
&emsp;
<input value='' type='submit' id='sgo' onclick='chgsgs();'/> 
<script>
var showgs=1;
function chgsgs() {
	showgs=!showgs;
	if (showgs) {
		sgo.value='Hide guests';
	}
	else {
		sgo.value='Show guests';
	}
	listall();
}
chgsgs();
<?php
if (strlen($_GET['uid'])>0)
	echo "sgo.style.visibility='hidden';";
?>
</script>
<br/>
<span style='display:<?php if (strlen($_GET['uid'])==0) echo ";"; else echo "none;"; ?>'>
<label for='specify'>Specify</label>
<input type='text' id='specify' value='' size='80px' onchange='listall()'></input>
</span>

<hr/>
</tr></td></table>
<center><div style='width:80%'>
<div id='showplace' align='center'></div>
<p>
<?php
if (strlen($_GET['uid'])==0) {
	echo "<script src='scripts/listall.js'></script>";
}
else {
	echo "<script>var vuid='".$_GET['uid']."';</script>";
	//echo "<script>alert('"+$_GET['uid']+"');</script>";
	include("./forms/sgltable.php");
	echo "<script src='scripts/listsgl.js'></script>";
}
?>
</p>
</center></div>
<?php
include('oj-footer.php');
?>
</body>
</html>
