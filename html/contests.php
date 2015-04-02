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
$tot=0;
while (($contd=readdir($dir))!=false)
	if (is_file("./data/".$contd."/.contcfg")) {
		$cidl[$tot]=$contd;
		++$tot;
	}
closedir($dir);
rsort($cidl);
echo "<table style='width:80%;align:center;text-align:center;'><tr height='42px'>";
for ($ti=0;$ti<$tot;++$ti) {
	$contd=$cidl[$ti];
	echo "<td><a href='cur.php?cid=".$contd."'>".$contd."</a> </td>";
	if ($ti % 4 == 3)
		echo "</tr><tr height='42px'>";
}
?>
</div>

<?php
include('oj-footer.php');
?>
</body>
</html>
