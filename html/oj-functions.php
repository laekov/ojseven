<?php
function check_passwd($uid,$passwd) {
	$pfln=("./users/".$uid);
	if (!is_file($pfln.".uinfo")) {
		return 1;
	}
	if (!is_file($pfln.".upasswd")) {
		return 0;
	}
	$ipf=fopen(($pfln.".upasswd"),"r");
	list($std)=fscanf($ipf,"%s");
	fclose($ipf);
	if (MD5($passwd)==$std)
		return 0;
	else
		return 2;
}

function getuid() {
	if (!$_SESSION['signedin'])
		return "nouser";
	else
		return $_SESSION['uid'];
}

function getUname($uid) {
	$fln=("./users/".$uid.".uinfo");
	$ipf=fopen($fln,"r");
	list($id)=fscanf($ipf,"%s");
	fclose($ipf);
	return $id;
}

function getUgrade($uid) {
	$fln=("./users/".$uid.".uinfo");
	$ipf=fopen($fln,"r");
	list($id)=fscanf($ipf,"%s");
	list($id)=fscanf($ipf,"%s");
	fclose($ipf);
	return $id;
}

function is_admin($uid) {
	if (!$_SESSION['signedin'])
		return 0;
	$pf=fopen("./conf/admin.list","r");
	while (!feof($pf)) {
		list($ad)=fscanf($pf,"%s");
		if ($ad==getuid()) {
			fclose($pf);
			return 1;
		}
	}
	fclose($pf);
	return 0;
}

function check_stat($cid) {
	$fln=("./data/".$cid."/.contcfg");
	if (!is_file($fln))
		return 0;
	$ipf=fopen($fln,"r");
	$stat=0;
	while (!feof($ipf)) {
		list($key,$val)=fscanf($ipf,"%s%s");
		if ($key=='stat')
			$stat=$val;
	}
	return $stat;
}

function showcode($fln) {
	$lcnt=0;
	chmod($fln,0444);
	$ipf=fopen($fln,"r");
	echo "<table algin='center' width='100%'><tr>";
	echo "<td width='5%'><pre class='linear'>";
	while (!feof($ipf)) {
		fgets($ipf);
		++$lcnt;
		echo "<span>";
		printf("%3d",$lcnt);
		echo "</span>\n";
	}
	fseek($ipf, 0);
    $codeid = md5_file($fln);
	echo "</pre></td><td width='95%'><pre class='scode' id='".$codeid."'>";
	for ($i = 0; $i < $lcnt; ++ $i) {
		$txt = htmlspecialchars(fgets($ipf));
		echo $txt;
	}
	echo " ";
	fclose($ipf);
    echo "</pre>";
    echo "<script>sethlById('".$codeid."');</script>";
    echo "</td>";
	echo "</tr></table>";
	chmod($fln,0000);
}

function showcodenl($fln) {
	$lcnt=0;
	chmod($fln,0444);
	$ipf=fopen($fln,"r");
	while (!feof($ipf)) {
		++$lcnt;
		echo "<span>".htmlspecialchars(fgets($ipf))."</span>";
	}
	fclose($ipf);
	chmod($fln,0000);
}

function printcode($cid,$uid,$pid) {
	$fln="./upload/".$cid."/".$uid."/".$pid;
	if (is_file($fln.".cpp"))
		$fln=$fln.".cpp";
	else if (is_file($fln.".c"))
		$fln=$fln.".c";
	else if (is_file($fln.".pas"))
		$fln=$fln.".pas";
	else {
		echo "No code";
		return;
	}
	showcode($fln);
}
?>
