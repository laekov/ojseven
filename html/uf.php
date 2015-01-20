<html>
<head>
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
<table border='1' align='center' width='800px'>
<?php

$uid = $_POST['idp'];

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
else if (!checkID($uid)) {
	header("Location: error.php?word=Invalid user id");
	return;
}
else if ($corr) {
	$ufid=($uid."-".date("Ymdhisa"));

	$tmpstr = ('./upload/'.$cid);
	if (!is_dir($tmpstr))
		mkdir($tmpstr);

	$ulpt=fopen(($tmpstr."/cuid.list"),"a");
	fprintf($ulpt,"%s\n",$ufid);
	fclose($ulpt);

	$tmpstr = ($tmpstr."/".$ufid);
	mkdir($tmpstr);

	for ($fi=1;$fi<=3;++$fi) {
		$MSUC = false;
		$FF = 'f'. $fi;
		if ($_FILES[$FF]['size'] >= 64000000 && !strpos($_FILES[$FF]['name'], "zip")) {
			header("Location: error.php?word=File size too huge!");
			return;
		}
		else if (strlen($_FILES[$FF]['name'])>0) {
			$TP = './upload/'. $cid. '/'. $ufid. '/'. $_FILES[$FF]['name'];
			if (!move_uploaded_file($_FILES[$FF]['tmp_name'], $TP)) {
				header("Location: error.php?word=Moving error!".$TP);
				return;
			}
			else {
				$MSUC = true;
			}
			if ($MSUC && strpos($_FILES[$FF]['name'], "zip")) {
				chmod($TP, 0777);
				$cmd = ("unzip -o -q ". $TP. " -d ". "./upload/". $cid. "/". $uid);
				exec($cmd);
			}
		}
	}

	$cmdpf=fopen(".runrequire","a");
	fprintf($cmdpf, "oj7-cjudge cor %s -cid %s\n", $ufid, $cid);

	header("Location: uc.php?cid=".$cid."&cmd=correction");
}
else {
	echo("<tr>");
	echo("<td width='200px'>Contest id</td>\n");
	echo("<td width='600px'>". $cid. "</td></tr>\n");
	echo("<tr><td>User name</td>\n");
	echo("<td>". $uid. "</td>");
	echo("</tr>");

	$tmp_str = ('./upload/'. $cid);
	if (!mkdir($tmp_str)) {
		echo("mkdir3 failed<br/>");
	}
	$tmp_str = ('./upload/'. $cid);
	$tmp_str = ($tmp_str. '/'. $uid);
	if (!mkdir($tmp_str)) {
		echo("mkdir4 failed<br/>");
	}
	else {
		//		chmod($tmp_str, 0777);
	}

	$l_path = "./upload/". $cid. "/uid.list";
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
		echo("<tr><td>Code". $fi. "</td><td>");
		$FF = 'f'. $fi;
		if ($FO['error'] || $_FILES[$FF]['size'] == 0) {
			echo("File". $fi. " error!<br/>");
		}
		//else if ($_FILES[$FF]['type'] != 'text/x-csrc' && $_FILES[$FF]['type'] != 'text/x-c++src' && $_FILES[$FF]['type'] != 'text/x-pascal') {
		//	echo("Invalid file type!<br/>");
		//	echo("Your filetype is:\t". $_FILES[$FF]['type']);
		//}
		else if ($_FILES[$FF]['size'] >= 64000000 && !strpos($_FILES[$FF]['name'], "zip")) {
			echo("File size too huge!");
		}
		else {
			echo("Name:\t". $_FILES[$FF]['name']. "<br/>");
			echo("Size:\t". $_FILES[$FF]['size']. "byte<br/>");
			echo("Type:\t". $_FILES[$FF]['type']. "<br/>");
			$TP = './upload/'. $cid. '/'. $uid. '/'. $_FILES[$FF]['name'];
			echo("Path:\t". $TP. "<br/>");
			if (!move_uploaded_file($_FILES[$FF]['tmp_name'], $TP)) {
				echo("Moving error<br/>");
			}
			else {
				$MSUC = true;
			}
			if ($MSUC) {
				if (!strpos($_FILES[$FF]['name'], "zip")) {
					echo("Code preview: <br/>");
					echo("<pre class='scode'>");
					$ipf = fopen($TP, "r");
					for ($i = 0; !feof($ipf); ++ $i) {
						$text = htmlspecialchars(fgets($ipf));
						echo("\t". ($i + 1). "\t". $text);
					}
					echo("</pre>");
					fclose(ipf);
					chmod($TP, 0);
				}
				else {
					chmod($TP, 0777);
					$cmd = ("unzip -o -q ". $TP. " -d ". "./upload/". $cid. "/". $uid);
					//echo $cmd;
					exec($cmd);
				}
			}
		}
		echo("</tr></td>");
	}
}
?>
</table>
<?php
include('oj-footer.php');
?>
</body>
</html>
