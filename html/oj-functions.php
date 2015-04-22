<?php
function check_passwd($uid,$passwd) {
	$pfln=("../users/".$uid);
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
	$fln=("../users/".$uid.".uinfo");
	$ipf=fopen($fln,"r");
	list($id)=fscanf($ipf,"%s");
	fclose($ipf);
	return $id;
}

function getUgrade($uid) {
	$fln=("../users/".$uid.".uinfo");
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
	$fln=("../data/".$cid."/.contcfg");
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
		//$txt = (fgets($ipf));
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
	$fln="../upload/".$cid."/".$uid."/".$pid;
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

function readcfg($fln) {
	$ret = Array();
	if (is_file($fln)) {
		$ipf = fopen($fln, "r");
		list($pid) = fscanf($ipf, "%s");
		list($inf) = fscanf($ipf, "%s");
		list($ouf) = fscanf($ipf, "%s");
		list($inff) = fscanf($ipf, "%s");
		list($ouff) = fscanf($ipf, "%s");
		list($beg_n, $end_n) = fscanf($ipf, "%d %d");
		list($tl, $ml) = fscanf($ipf, "%d %d");
		$ret['pid'] = $pid;
		$ret['inf'] = $inf;
		$ret['ouf'] = $ouf;
		$ret['ccase'] = $end_n - $beg_n + 1;
		$ret['tl'] = $tl;
		$ret['ml'] = $ml;
		while (!feof($ipf)) {
			list($str) = fscanf($ipf, "%s");
			$ret[$str] = 'yes';
		}
		fclose($ipf);
	}
	return $ret;
}

function readccfg($fln) {
	$ret = Array();
	if (is_file($fln)) {
		$ipf = fopen($fln, "r");
		while (!feof($ipf)) {
			$line = fgets($ipf);
			list($id, $item) = sscanf($line, "%s %s");
			if ($id == "<self>")
				continue;
			$ret[$id] = $item;
		}
		fclose($ipf);
	}
	if ($ret['totprob'] == null)
		$ret['totprob'] = 3;
	return $ret;
}

function cntline($fln) {
	$ret = 0;
	if (is_file($fln)) {
		$ipf = fopen($fln, "r");
		while (!feof($ipf)) {
			$ln = fgets($ipf);
			++ $ret;
		}
		fclose($ipf);
		-- $ret;
	}
	return $ret;
}

function checkaccess($cid, $pid) {
	$fln = ("../data/".$cid."/access.list");
	if (is_admin($pid))
		return true;
	elseif (!is_file($fln)) {
		return true;
	}
	else {
		$ipf = fopen($fln, "r");
		while (!feof($ipf)) {
			list($gid) = fscanf($ipf, "%s");
			if (strstr($gid, "group@") != false) {
				$grid = substr($gid, 6);
				$fln = ("../users/".$grid.".group");
				if (!is_file($fln)) {
					continue;
				}
				$ig = false;
				$gipf = fopen($fln, "r");
				while (!feof($gipf)) {
					list($xid) = fscanf($gipf, "%s");
					if ($pid == $xid)
						$ig = true;
				}
				fclose($gipf);
				if ($ig == true) {
					fclose($ipf);
					return true;
				}
			}
			elseif ($gid == $pid) {
				fclose($ipf);
				return true;
			}
		}
		fclose($ipf);
		return false;
	}
}
?>
