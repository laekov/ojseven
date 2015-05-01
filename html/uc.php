<html>
<head>
<link rel='icon' href='src/ic.png' type='image/x-icon'/>
<title>OJ7 - Status</title>
</head>
<body>
<?php
include('oj-header.php');
?>
<table align='center' width='80%'>
<tr><td>
<?php
$cid = $_GET['cid'];
if (strlen($cid) < 1) {
	$c_ipf = fopen("conf/cont.conf", "r");
	$cid = fread($c_ipf, 8);
	fclose($c_ipf);
}
$corr=($_GET['cmd']=='correction');

if (!$_SESSION['signedin']) {
	header("Location: error.php?word=Please sign in first");
	return;
}
if (!checkaccess($cid, $_SESSION['uid'])) {
	header("Location: error.php?word=Access denied");
	return;
}
$ccfg = readccfg("../data/".$cid."/.contcfg");
?>
<script>
var corr=0;
<?php
if ($corr)
	echo "corr=1;";
?>
</script>

<table width='100%'>
<tr>
<td>
<form action='uc.php' method='get'>
<label for='cid'>Contest id:</label>
<input type='text' size='10px' name='cid' id='cid' value='<?php echo $cid;?>'/>
<input type='submit' name='submit' value='Go'>
<input type='button' id='showstyletext' onclick='chgshowstyle();' value='Show score'/>
</form>
</td>

<td style='text-align:right'>
<?php
if ($ccfg['stat'] == 2 || is_admin($_SESSION['uid'])) {
	echo "<a href='uc.php?cid=";
	echo $cid; 
	if (!$corr) 
		echo "&cmd=correction";
	echo "'>";
	if ($corr) 
		echo "Standings"; 
	else 
		echo "Correction status";
	echo "</a>";
}
?>
</td>

<td style='text-align:right'>
<a href='cur.php?cid=<?php echo $cid; ?>'>Back</a>
</td>
</tr>
</tr>
</table>

<hr/>
</td></tr>

<tr><td>
<div id='chartplace'></div>
<script>
<?php
echo "var totprob = ". $ccfg['totprob']. ";";
echo "var nonu=";
if ($corr)
	echo "1;";
else
	echo "0;";
echo "var cid='".$cid."';\n";
echo "var pname=new Array();\n";
$cnt=0;
$pid=array();
if (!is_file("../data/".$cid."/.contcfg")) {
	header("Location: error.php?word=Wrong contest");
	return;
}
$epid = chr(97 + $ccfg['totprob']);
for ($i='a';$i<$epid;++$i) {
	$fln=("../data/".$cid."/".$i.".cfg");
	$ipf=fopen($fln, "r");
	list($pid[$cnt])=fscanf($ipf,"%s");
	fclose($ipf);
	echo "pname[".($cnt)."]='".$pid[$cnt]."';\n";
	++$cnt;
}
$fln=("../upload/".$cid."/uid.list");
if ($corr)
	$fln=("../upload/".$cid."/cuid.list");
$totu = 0;
$uidarr = Array();
if (is_file($fln)) {
	$uidpf=fopen($fln,"r");
	echo "var ul=new Array();\n";
	while (true) {
		list($uid)=fscanf($uidpf,"%s");
		if (feof($uidpf))
			break;
		if (strlen($uid)<2)
			continue;
		$uidarr[$totu] = $uid;
		++ $totu;
	}
	fclose($uidpf);
}
if ($ccfg['judgetype'] != 'noiacm' && $ccfg['stat'] == 1 && !is_admin($_SESSION['uid'])) {
	$totu = 1;
	$uidarr[0] = $_SESSION['uid'];
}
if ($ccfg['judgetype'] != "noi") {
	echo "var printtime=1;";
}
else {
	echo "var printtime=0;";
}
for ($ui = 0; $ui < $totu; ++ $ui) {
	$uid = $uidarr[$ui];
	//echo "alert('".$uid."');";
	$pn=0;
	$tots=0;
	echo "ul[".$ui."]={};\n";
	echo "ul[".$ui."].uid='".$uid."';\n";
	echo "ul[".$ui."].a=new Array();\n";
	for ($i='a';$i<=$epid;++$i) {
		echo "ul[".$ui."].a[".$pn."]={};\n";
		$pprf=('../upload/'.$cid."/".$uid."/".$pid[$pn]);
		if (!$corr) {
			$tfln = ("../upload/".$cid."/".$uid."/".$i.".cnt");
			$tt = 0;
			if (is_file($tfln)) {
				$tipf = fopen($tfln, "r");
				list($tt) = fscanf($tipf, "%d");
				fclose($tt);
			}
			echo "ul[".$ui."].a[".$pn."].ctime=".$tt.";\n";
		}
		if (!is_file($pprf.".cpp")&&!is_file($pprf.".c")&&!is_file($pprf.".pas")&&!is_file($pprf.".zip")) {
			echo "ul[".$ui."].a[".$pn."].wd='No file';\n";
			echo "ul[".$ui."].a[".$pn."].sco=-1;\n";
		}
		elseif (!is_admin($_SESSION['uid']) && $ccfg['stat'] == 1 && $ccfg['judgetype'] == 'noi') {
			$pprf=('../upload/'.$cid."/".$uid."/.ajtest/".$i.".rs");
			echo "ul[".$ui."].a[".$pn."].wd='Pending';\n";
			echo "ul[".$ui."].a[".$pn."].sco=-1;\n";
		}
		else {
			$pprf=('../upload/'.$cid."/".$uid."/.ajtest/".$i.".rs");
			if (!is_file($pprf)) {
				echo "ul[".$ui."].a[".$pn."].wd='Pending';\n";
				echo "ul[".$ui."].a[".$pn."].sco=-1;\n";
			}
			else {
				$ripf=fopen($pprf,"r");
				list($pwd)=fscanf($ripf,"%s");
				list($psc)=fscanf($ripf,"%s");
				fclose($ripf);
				echo "ul[".$ui."].a[".$pn."].wd='".$pwd."';\n";
				if ($pwd=='CE')
					$psc=-1;
				echo "ul[".$ui."].a[".$pn."].sco=".$psc.";\n";
				if ($psc>-1)
					$tots+=$psc;
			}
		}
		++$pn;
	}
	echo "ul[".$ui."].tot_sco=".$tots.";\n";
}
echo "var tot_u=".$totu.";\n";
?>
</script>
<script src='scripts/statuschart.js'></script>
<script>
<?php
if ($corr)
	echo "rev_arrange();\n";
?>
show_chart();
</script>

<script>
<?php
if (is_file("../.cjudgerunning"))
	echo 'setTimeout("window.location.reload()",1000);';
?>
</script>

</td></tr>

</table>
<?php
include('oj-footer.php');
?>
</body>
</html>
