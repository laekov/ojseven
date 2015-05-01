<?php
include('oj-header.php');
?>
<?php
$corr=($_GET['cmd']=='correction');
$cid=0;
if ($corr) {
	$cid=$_GET['cid'];
}
else {
	$c_ipf = fopen("conf/cont.conf", "r");
	$cid = fread($c_ipf, 8);
	fclose($c_ipf);
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

<?php

$uid=getuid();
if ($uid=='nouser') {
	header("Location: error.php?word=Please sign in first");
	return;
}

function checkID($x) {
	if (!is_file("users/". $x. ".uinfo"))
		return false;
	else
		return true;
}

function gettl() {
	$pf = fopen("conf/time.conf", "r");
	list($hh, $mm) = fscanf($pf, "%d:%d");
	fclose($pf);
	$tl = $hh * 10000 + $mm * 100;
	return $tl;
}
function check_time() {
	$tc = date("his");
	//echo $tc;
	if (date("a") == "pm" && $tc < 120000)
		$tc += 120000;
	//echo $tc;
	if ($tc <= gettl())
		return true;
	else
		return false;
}

$ccfg = readccfg("../data/".$cid."/.contcfg");
$pcfgs = Array();
for ($i = 0; $i < $ccfg['totprob']; ++ $i) {
	$pcfgs[chr($i + 97)] = readcfg("../data/".$cid."/".chr($i + 97).".cfg");
}

if (!$corr && !check_time()) {
	header("Location: error.php?word=Out of submit time");
	return;
}
else if ($corr) {
	$contd=("../data/".$cid."/");
	$stat=$ccfg['stat'];
	if ($stat<2 && !is_admin($uid)) {
		header("Location: error.php?word=How do you find this page?");
		return;
	}
	
	$ufid=($uid."-".date("Ymdhisa"));

	$tmpstr = ('../upload/'.$cid);
	if (!is_dir($tmpstr)) {
		mkdir($tmpstr);
		chmod(0777, $tmpstr);
	}

	$ulpt=fopen(($tmpstr."/cuid.list"),"a");
	fprintf($ulpt,"%s\n",$ufid);
	fclose($ulpt);

	$tmpstr = ($tmpstr."/".$ufid);
	mkdir($tmpstr);
	chmod(0777,$tmpstr);

	for ($fi=1;$fi<=$ccfg['totprob'];++$fi) {
		$MSUC = false;
		$FF = 'f'. $fi;
		if ($_FILES[$FF]['size'] >= 64000000 && !strpos($_FILES[$FF]['name'], "zip")) {
			header("Location: error.php?word=File size too huge!");
			return;
		}
		else if (strlen($_FILES[$FF]['name'])>0) {
			$TP = '../upload/'. $cid. '/'. $ufid. '/'. $_FILES[$FF]['name'];
			if (!move_uploaded_file($_FILES[$FF]['tmp_name'], $TP)) {
				header("Location: error.php?word=Moving error!".$TP);
				return;
			}
			else {
				$MSUC = true;
			}
			if ($MSUC && strpos($_FILES[$FF]['name'], "zip")) {
				chmod($TP, 0777);
				$cmd = ("unzip -o -q ". $TP. " -d ". "../upload/". $cid. "/". $ufid);
				exec($cmd);
			}
		}
	}

	$cmdpf=fopen(".judgerequire","a");
	fprintf($cmdpf, "oj7-cjudge cor %s -cid %s\n", $ufid, $cid);
	fclose($cmdpf);

	header("Location: uc.php?cid=".$cid."&cmd=correction");
}

else {
	$tmp_str = ('../upload/'. $cid);
	if (!is_dir($tmp_str)) {
		mkdir($tmp_str);
		chmod(0777,$tmp_str);
	}

	$tmp_str = ('../upload/'. $cid);
	$tmp_str = ($tmp_str. '/'. $uid);
	if (!is_dir($tmp_str)) {
		mkdir($tmp_str);
		chmod(0777,$tmp_str);
	}

	$l_path = "../upload/". $cid. "/uid.list";
	if (!is_file($l_path)) {
		$pf = fopen($l_path, "w");
		fclose($pf);
	}
	$nok = 1;
	$l_ipf = fopen($l_path, "r");
	while (1) {
		$gtmp = fscanf($l_ipf, "%s");
		if (feof($l_ipf))
			break;
		list($uu) = $gtmp;
		if ($uu == $uid) {
			$nok = 0;
			break;
		}
	}
	fclose($l_ipf);
	if ($nok) {
		$l_opf = fopen($l_path, "a");
		fputs($l_opf, $uid);
		fputs($l_opf, "\n");
		fclose($l_opf);
	}

	for ($fi=1;$fi<=$ccfg['totprob'];++$fi) {
		$MSUC = false;
		$FF = 'f'. $fi;
		$ufln = $_FILES[$FF]['name'];
		$fpid = -1;
		for ($i = 0; $i < $ccfg['totprob']; ++ $i) {
			$cpid = $pcfgs[chr($i + 97)]['pid'];
			if ($ufln == ($cpid.".pas"))
				$fpid = $i;
			if ($ufln == ($cpid.".cpp"))
				$fpid = $i;
			if ($ufln == ($cpid.".c"))
				$fpid = $i;
			if ($ufln == ($cpid.".zip"))
				$fpid = $i;
		}
		if ($fpid == -1) {
		}
		elseif ($FO['error'] || $_FILES[$FF]['size'] == 0) {
		}
		else if ($_FILES[$FF]['size'] >= 64000000 && !strpos($_FILES[$FF]['name'], "zip")) {
			header("Location: error.php?word=File size too huge!");
			return;
		}
		else {
			if ($ccfg['judgetype'] == 'ioi') {
				$cntfln = ("../upload/".$cid."/".$uid."/".chr($fpid+97).".cnt");
				$ctm = 0;
				if (is_file($cntfln)) {
					$cipf = fopen($cntfln, "r");
					list($ctm) = fscanf($cipf, "%d");
					fclose($cipf);
				}
				if ($ctm >= 30) {
					header("Location: error.php?word=Too many submissions");
					return;
				}
				else {
					$copf = fopen($cntfln, "w");
					fprintf($copf, "%d", $ctm + 1);
					fclose($copf);
				}
			}
			//echo("Name:\t". $_FILES[$FF]['name']. "<br/>");
			//echo("Size:\t". $_FILES[$FF]['size']. "byte<br/>");
		//	echo("Type:\t". $_FILES[$FF]['type']. "<br/>");
			$TP = '../upload/'. $cid. '/'. $uid. '/'. $_FILES[$FF]['name'];
		//	echo("Path:\t". $TP. "<br/>");
			if (!move_uploaded_file($_FILES[$FF]['tmp_name'], $TP)) {
				//echo("Moving error<br/>");
			}
			else {
				$MSUC = true;
			}
			if ($MSUC) {
				if (!strpos($_FILES[$FF]['name'], "zip")) {
					//echo("Code preview: <br/><div>");
					//showcode($TP);
					//echo "</div>";
				}
				else {
					chmod($TP, 0777);
					$cmd = ("unzip -o -q ". $TP. " -d ". "../upload/". $cid. "/". $uid);
					//echo $cmd;
					exec($cmd);
				}
				if ($ccfg['nojudge'] != 'yes') {
					$cmdpf=fopen(".judgerequire","a");
					fprintf($cmdpf, "oj7-cjudge ioijudge %s -cid %s -pid %d\n", $uid, $cid, $fpid);
					fclose($cmdpf);
					$cmdpf=fopen(".runrequire","a");
					fprintf($cmdpf, ("rm upload/".$cid."/".$uid."/.ajtest/".chr($fpid + 97).".rs\n"));
					fclose($cmdpf);
				}
			}
		}
		//echo("<hr/></div>");
	}
	header("Location: uc.php?cid=".$cid);
	return;
}
?>
