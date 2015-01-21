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
?>
