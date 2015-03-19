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
<a href='uc.php?cid=<?php echo $cid; if (!$corr) echo "&cmd=correction"; ?>' style='color:blue;padding:40px;'><?php if ($corr) echo "Standings"; else echo "Correction status" ?></a>
</td>
</tr>
</table>

<hr/>
</td></tr>

<tr><td>
<div id='chartplace'></div>
<script>
<?php
echo "var nonu=";
if ($corr)
	echo "1;";
else
	echo "0;";
echo "var cid='".$cid."';\n";
echo "var pname=new Array();\n";
$cnt=0;
$pid=array();
for ($i='a';$i<='c';++$i) {
	$fln=("./data/".$cid."/".$i.".cfg");
	if (!is_file($fln))
		header("Location: error.php?word=Wrong contest");
	$ipf=fopen($fln, "r");
	list($pid[$cnt])=fscanf($ipf,"%s");
	fclose($ipf);
	echo "pname[".($cnt)."]='".$pid[$cnt]."';\n";
	++$cnt;
}
$fln=("./upload/".$cid."/uid.list");
if ($corr)
	$fln=("./upload/".$cid."/cuid.list");
if (!is_file($fln)) {
	header("Location: error.php?word=No submissions");
	return;
}
$uidpf=fopen($fln,"r");
$cu=0;
echo "var ul=new Array();\n";
while (true) {
	list($uid)=fscanf($uidpf,"%s");
	if (feof($uidpf))
		break;
	if (strlen($uid)<2)
		continue;
	$pn=0;
	$tots=0;
	echo "ul[".$cu."]={};\n";
	echo "ul[".$cu."].uid='".$uid."';\n";
	echo "ul[".$cu."].a=new Array();\n";
	for ($i='a';$i<='c';++$i) {
		echo "ul[".$cu."].a[".$pn."]={};\n";
		$pprf=('./upload/'.$cid."/".$uid."/".$pid[$pn]);
		if (!is_file($pprf.".cpp")&&!is_file($pprf.".c")&&!is_file($pprf.".pas")&&!is_file($pprf.".zip")) {
			echo "ul[".$cu."].a[".$pn."].wd='No file';\n";
			echo "ul[".$cu."].a[".$pn."].sco=-1;\n";
		}
		else {
			$pprf=('./upload/'.$cid."/".$uid."/.ajtest/".$i.".rs");
			if (!is_file($pprf)) {
				echo "ul[".$cu."].a[".$pn."].wd='Pending';\n";
				echo "ul[".$cu."].a[".$pn."].sco=-1;\n";
			}
			else {
				$ripf=fopen($pprf,"r");
				list($pwd)=fscanf($ripf,"%s");
				list($psc)=fscanf($ripf,"%s");
				fclose($ripf);
				echo "ul[".$cu."].a[".$pn."].wd='".$pwd."';\n";
	//echo "alert('".$cu."');";
				if ($pwd=='CE')
					$psc=-1;
				echo "ul[".$cu."].a[".$pn."].sco=".$psc.";\n";
				if ($psc>-1)
					$tots+=$psc;
			}
		}
		++$pn;
	}
	echo "ul[".$cu."].tot_sco=".$tots.";\n";
	++$cu;
}
fclose($uidpf);
echo "var tot_u=".$cu.";\n";
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
if (is_file(".cjudgerunning"))
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
