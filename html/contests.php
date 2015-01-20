<html>
<head>
<title>OJ7 - Contests</title>
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

<div align='center'>
<table width='800px'>
<?php
$dir=opendir("./data");
$cidl=Array();
$tot=0;
while (($contd=readdir($dir))!=false)
	if (is_file("./data/".$contd."/.contcfg")) {
		$cidl[$tot]=$contd;
		++$tot;
	}
closedir($dir);
rsort($cidl);
for ($ti=0;$ti<$tot;++$ti) {
	$contd=$cidl[$ti];
	echo "<tr><td>";
	echo "<h2>".$contd."</h2><ul>";
	$contd=("./data/".$contd."/");
	$stat=0;
	$ipf=fopen(($contd.".contcfg"),"r");
	$hite=0;
	while (!feof($ipf)) {
		list($itid,$val)=fscanf($ipf,"%s %s");
		if (strlen($itid)<1)
			continue;
		if ($itid=='stat') {
			$stat=$val;
		}
		else {
			echo "<li><a href='".$contd.$val."'>".$itid."</a></li>";
		}
		$hite=1;
	}
	fclose($ipf);

	if ($stat <= '1') {
		echo "<li><a href='./uc.php?cid=".$cidl[$ti]."'>Status</a></li>";
	}
	if ($stat == '2') {
		echo "<li><a href='./uc.php?cid=".$cidl[$ti]."'>Standings</a></li>";
		echo "<li><a href='u.php?cmd=correction&cid=".$cidl[$ti]."'>Submit correction</a></li>";
		echo "<li><a href='uc.php?cmd=correction&cid=".$cidl[$ti]."'>Correction status</a></li>";
	}
	echo "</ul><hr/></tr></td>";
}
?>
</table>
</div>

<?php
include('oj-footer.php');
?>
</body>
</html>
