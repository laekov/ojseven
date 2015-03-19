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
for ($ti=0;$ti<$tot;++$ti) {
	$contd=$cidl[$ti];
	echo "<div style='width:80%;text-align:left;'>";
	echo "<span style='font-size:24px'>".$contd." </span>";
	echo "<span style='cursor:pointer; font-size:16px; float: right;' id='cb".$contd."' onclick='chgstate(".$contd.")'>";
	if ($ti > 3)
		echo "Expand";
	else
		echo "Contract";
	echo "</span>";
	echo "<ul id='c".$contd."' ";
	if ($ti > 3)
		echo "style='display:none'";
	echo ">";
	$contd=("./data/".$contd."/");
	$stat=0;
	$ipf=fopen(($contd.".contcfg"),"r");
	$hite=0;
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
	echo "</ul><hr/></div>";
}
?>
</div>

<?php
include('oj-footer.php');
?>
</body>
</html>
