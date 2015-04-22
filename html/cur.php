<html>
<head>
<link rel='icon' href='src/ic.png' type='image/x-icon'/>
<title>OJ7 - Contest</title>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
</head>
<?php
include('oj-header.php');
?>
<body>

<center>
<div style='width:80%;'>
<?php
$cid=$_GET['cid'];
if (strlen($cid) == 0) {
	$pf = fopen("conf/cont.conf","r");
	list($cid)=fscanf($pf,"%s");
	fclose($pf);
}
if (!$_SESSION['signedin']) {
	header("Location: error.php?word=Please sign in first");
	return;
}
if (!checkaccess($cid, $_SESSION['uid'])) {
	header("Location: error.php?word=Access denied");
	return;
}
?>

<form action='uf.php<?php if ($corr) echo "?cmd=correction&cid=".$cid;?>' method='post' enctype='multipart/form-data'>
<table width='100%' border='0'>
<?php
function gettl() {
	$pf = fopen("conf/time.conf", "r");
	list($hh, $mm) = fscanf($pf, "%d:%d");
	fclose($pf);
	$tl = $hh * 10000 + $mm * 100;
	return $tl;
}

echo("<tr height='30px'>");
echo("<td width='200px'>Contest id</td>\n");
echo "<td>".$cid."</td></tr>";
?>

<?php
if (check_stat($cid) == 1) {
	echo("<tr height='30px'>");
	echo("<td width='200px'>Submit time limit</td>\n");
	$ttl = gettl();
	$wx = 'am';
	if ($ttl >= 120000) {
		$wx = 'pm';
		if ($ttl >= 130000)
			$ttl -= 120000;
	}
	printf("<td>%02d:%02d:00 %s</td></tr>", $ttl / 10000, $ttl % 10000 / 100, $wx);
}
?>
</table>

<p style='text-align:left;'>Problem infomation</p>
<table width='100%' style='text-align:center;<?php if (check_stat($cid) > 2) echo "display:hidden;'" ?>'>
<?php
$cfgs = Array();
$ccfg = readccfg("../data/".$cid."/.contcfg");
$epid = chr(97 + $ccfg['totprob']);
for ($pi = 'a'; $pi < $epid; ++ $pi) {
	$cfgs[$pi] = readcfg("../data/".$cid."/".$pi.".cfg");
}
echo "<tr style='background-color:#3f3fff;color:white;'><td>Problem</td>";
for ($pi = 'a'; $pi < $epid; ++ $pi)
	echo "<td width='20%'>".$cfgs[$pi]['pid']."</td>";
echo "</tr>";
echo "<tr style='background-color:#efffef;color:black;'><td>Code name</td>";
for ($pi = 'a'; $pi < $epid; ++ $pi)
	echo "<td width='20%'>".$cfgs[$pi]['pid']."</td>";
echo "</tr>";
echo "<tr style='background-color:#efefff;color:black;'><td>Input file name</td>";
for ($pi = 'a'; $pi < $epid; ++ $pi)
	echo "<td width='20%'>".$cfgs[$pi]['inf']."</td>";
echo "</tr>";
echo "<tr style='background-color:#efffef;color:black;'><td>Output file name</td>";
for ($pi = 'a'; $pi < $epid; ++ $pi)
	echo "<td width='20%'>".$cfgs[$pi]['ouf']."</td>";
echo "</tr>";
echo "<tr style='background-color:#efefff;color:black;'><td>Time limit</td>";
for ($pi = 'a'; $pi < $epid; ++ $pi)
	echo "<td width='20%'>".$cfgs[$pi]['tl']." ms</td>";
echo "</tr>";
echo "<tr style='background-color:#efffef;color:black;'><td>Memory limit</td>";
for ($pi = 'a'; $pi < $epid; ++ $pi)
	echo "<td width='20%'>".$cfgs[$pi]['ml']." MB</td>";
echo "</tr>";
echo "<tr style='background-color:#efefff;color:black;'><td>Has spj</td>";
for ($pi = 'a'; $pi < $epid; ++ $pi) {
	if ($cfgs[$pi]['spj'])
		echo "<td width='20%'>Yes</td>";
	else
		echo "<td width='20%'>No</td>";
}
echo "</tr>";
echo "<tr style='background-color:#efffef;color:black;'><td>Type</td>";
for ($pi = 'a'; $pi < $epid; ++ $pi)
	if ($cfgs[$pi]['ansonly'])
		echo "<td width='20%'>Answer only</td>";
	else
		echo "<td width='20%'>Traditional</td>";
echo "</tr>";
?>
</table>

<div style='width:100%;text-align:left;'>
<p>Notification</p>
<ul>
<?php
$stat = 0;
$fln = "../data/".$cid."/.contcfg";
if (is_file($fln)) {
	$ipf = fopen($fln, "r");
	while (!feof($ipf)) {
		$text = fgets($ipf);
		list($itid, $val) = sscanf($text,"%s%s");
		if (strlen($itid)<1)
			continue;
		if ($itid == '<self>') {
			echo "<li>". $text. "</li>";
		}
		elseif ($itid=='stat') {
			$stat=$val;
		}
		elseif ($itid=='tag') {
		}
		elseif ($itid=='totprob') {
		}
		else {
			$dwid = "download.php?cid=".$cid."&packid=".$val;
			echo "<li><a href='".$dwid."'>".$itid."</a></li>";
		}
		$hite=1;
	}
	fclose($ipf);
}
else {
	header("Location: error.php?word=No such contest");
}
?>
</ul>
</div>

<div style='width:100%;text-align:left;'>
<p>Link</p>
<ul>
<?php
if ($stat <= '1') {
	echo "<li><a href='./u.php?cid=".$cid."'>Submit</a></li>";
	echo "<li><a href='./uc.php?cid=".$cid."'>Status</a></li>";
}
if ($stat == '2') {
	echo "<li><a href='./uc.php?cid=".$cid."'>Standings</a></li>";
	echo "<li><a href='u.php?cmd=correction&cid=".$cid."'>Submit correction</a></li>";
	echo "<li><a href='uc.php?cmd=correction&cid=".$cid."'>Correction status</a></li>";
}
?>
</ul>
</div>

</div>
</center>

<?php
include('oj-footer.php');
?>
</body>
</html>
