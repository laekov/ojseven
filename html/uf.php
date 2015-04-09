<html>
<head>
<link rel='icon' href='src/ic.png' type='image/x-icon'/>
<title>OJ7 - Receive file</title>
<link rel="stylesheet" href="./temp.css" type="text/css">
</head>
<body>
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
?>

<div align='center' width='80%'>
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

if (!$corr && !check_time()) {
	header("Location: error.php?word=Out of submit time");
	return;
}
else if ($corr) {
	$contd=("../data/".$cid."/");
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

	for ($fi=1;$fi<=3;++$fi) {
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
				$cmd = ("unzip -o -q ". $TP. " -d ". "../upload/". $cid. "/". $uid);
				exec($cmd);
			}
		}
	}

	$cmdpf=fopen(".runrequire","a");
	fprintf($cmdpf, "oj7-cjudge cor %s -cid %s\n", $ufid, $cid);

	header("Location: uc.php?cid=".$cid."&cmd=correction");
}
else {
	echo("<div style='width:80%;text-align:left;'>");
	echo("Contest id: ".$cid."<br/>");
	echo("User name: ".$uid."<br/>");
	echo("<hr/></div>");

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

	for ($fi=1;$fi<=3;++$fi) {
		$MSUC = false;
		echo("<div style='text-align:left;width:80%;'>Code". $fi. "</br>");
		$FF = 'f'. $fi;
		if ($FO['error'] || $_FILES[$FF]['size'] == 0) {
			echo("File". $fi. " error!<br/>");
		}
		else if ($_FILES[$FF]['size'] >= 64000000 && !strpos($_FILES[$FF]['name'], "zip")) {
			echo("File size too huge!");
			return;
		}
		else {
			echo("Name:\t". $_FILES[$FF]['name']. "<br/>");
			echo("Size:\t". $_FILES[$FF]['size']. "byte<br/>");
		//	echo("Type:\t". $_FILES[$FF]['type']. "<br/>");
			$TP = '../upload/'. $cid. '/'. $uid. '/'. $_FILES[$FF]['name'];
		//	echo("Path:\t". $TP. "<br/>");
			if (!move_uploaded_file($_FILES[$FF]['tmp_name'], $TP)) {
				echo("Moving error<br/>");
			}
			else {
				$MSUC = true;
			}
			if ($MSUC) {
				if (!strpos($_FILES[$FF]['name'], "zip")) {
					echo("Code preview: <br/><div>");
					showcode($TP);
					echo "</div>";
				}
				else {
					chmod($TP, 0777);
					$cmd = ("unzip -o -q ". $TP. " -d ". "../upload/". $cid. "/". $uid);
					//echo $cmd;
					exec($cmd);
				}
			}
		}
		echo("<hr/></div>");
	}
}
?>
</div>
<?php
include('oj-footer.php');
?>
</body>
</html>
