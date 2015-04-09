<?php
$cid = $_GET['cid'];
$packid = $_GET['packid'];
$ipfn = ("../data/".$cid."/.contcfg");
if (!is_file($ipfn)) {
	header("Location: error.php?word=No such resource");
	return;
}
else {
	$ipf = fopen($ipfn, "r");
	$fd = 0;	
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
			if ($val == $packid)
				$fd = 1;
		}
		$hite=1;
	}
	fclose($ipf);
	if ($fd == 0) {
		header("Location: error.php?word=No such resource");
		return;
	}
	else {
		$dwfn = ("../data/".$cid."/".$packid);
		$dwsuffix = strrchr($dwfn, '.');
		$df = "./downloads/".MD5($dwfn).$dwsuffix;
		if (!is_file($df)) {
			copy($dwfn, $df);
		}
		header("Location: ".$df);
		return;
	}
}
?>
