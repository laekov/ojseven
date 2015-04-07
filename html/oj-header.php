<?php
session_start();
include("oj-functions.php");
?>
<link rel="stylesheet" href="./temp.css" type="text/css">

<div id='hbar' class='hbar'>
<table align='center' width='98%' border='0'>
<tr>
<td align='center' width='14%' bgcolor='red' style='color:white; cursor: pointer; font-size: 200%; font-family: Monospace;' onclick=location.href='index.php' class='hitem'> 
OJ7 </td>
<td align='center' width='14%' bgcolor='orange' style='color:darkblue; cursor: pointer;' onclick=location.href='cur.php' class='hitem'> 
Current </td>
<td align='center' width='14%' bgcolor='yellow' style='color:blue; cursor: pointer;' onclick=location.href='uc.php' class='hitem'> 
Status </td>
<td align='center' width='14%' bgcolor='green' style='color:white; cursor: pointer;' onclick=location.href='contests.php' class='hitem'> 
Contests </td>
<td align='center' width='14%' bgcolor='blue' style='color:white; cursor: pointer;' onclick=location.href='cnt.php' class='hitem'> 
Ranklist </td>
<td align='center' width='14%' bgcolor='purple' style='color:white; cursor: pointer;' onclick=location.href='bbs.php' class='hitem'> 
Web Board </td>
<td align='right'  width='16%' bgcolor='black'>
<?php
if ($_SESSION['signedin']) {
	echo "<a  style='text-decoration:none; color:#00ff00; cursor: pointer;' href='mu.php' class='litem'>".$_SESSION['uid']."</a><br/>";
	echo "<a  style='text-decoration:none; color:white; cursor: pointer;' href='si.php?cmd=leave' class='litem'>Sign out</a>";
}
else {
	echo "<a  style='text-decoration:none; color:red; cursor: pointer;' href='su.php' class='litem'>Sign up</a><br/>";
	echo "<a  style='text-decoration:none; color:white; cursor: pointer;' href='si.php' class='litem'>Sign in</a>";
}
?>
</td>
</tr>
</table>
</div>

<script src='scripts/codehilighter.js'></script>

<div style='height:48px'></div>
