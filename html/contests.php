<html>
<head>
<link rel='icon' href='src/ic.png' type='image/x-icon'/>
<title>OJ7 - Contests</title>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
</head>
<body>
<?php
include('oj-header.php');
?>

<?php
$cid = $_GET['cid'];
if (strlen($cid) < 1) {
	$c_ipf = fopen("conf/cont.conf", "r");
	$cid = fread($c_ipf, 8);
	fclose($c_ipf);
}
?>

<script>
function chgstate(id) {
	var bar = document.getElementById("cb" + id);
	var item = document.getElementById("c" + id);
	if (bar.innerHTML == 'Contract') {
		item.style.display = 'none';
		bar.innerHTML = 'Expand';
	}
	else {
		item.style.display = '';
		bar.innerHTML = 'Contract';
	}
}
</script>

<div align='center'>
<?php
$dir=opendir("./data");
$cidl=Array();
$ccfg = Array();
$tot=0;
while (($contd=readdir($dir))!=false)
	if (is_file("./data/".$contd."/.contcfg")) {
		$cidl[$tot]=$contd;
		$fln = "./data/".$contd."/.contcfg";
		++$tot;
	}
closedir($dir);
rsort($cidl);
echo "<table style='width:80%;align:center;text-align:center;'><tr>";
echo "<tr style='background-color:#3f3fff;color:white;'><td>Contest</td><td>Status</td><td>Participate</td></tr>";
for ($ti=0;$ti<$tot;++$ti) {
	if ($ti % 2 == 0)
		echo "<tr style='background-color:#efffef;color:black;'>";
	else
		echo "<tr style='background-color:#efefff;color:black;'>";
	$contd=$cidl[$ti];
	$cfgfln = "./data/".$contd."/.contcfg";
	$curcfg = readccfg($cfgfln);
	echo "<td><a href='cur.php?cid=".$contd."'>".$contd."</a> </td>";
	if ($curcfg['stat'] == '1') {
		echo "<td><span style='color:red'>Running</span></td>";
	}
	elseif ($curcfg['stat'] == '2') {
		echo "<td><span style='color:green'>Finished</span></td>";
	}
	else {
		echo "<td><span style='color:black'Unknown</span></td>";
	}
	$csu = cntline("./upload/".$contd."/uid.list");
	$cco = cntline("./upload/".$contd."/cuid.list");
	echo "<td><a href='uc.php?cid=".$contd."'>";
	echo "x".$csu;
	echo "</a></td>";
	echo "</tr>";
}
?>
</div>

<?php
include('oj-footer.php');
?>
</body>
</html>
