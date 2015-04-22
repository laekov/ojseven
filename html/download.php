<?php include("oj-header.php"); ?>
<?php
$cid = $_GET['cid'];
$packid = $_GET['packid'];
$ipfn = ("../data/".$cid."/.contcfg");

if (!$_SESSION['signedin']) {
	header("Location: error.php?word=Please sign in first");
	return;
}
if (!checkaccess($cid, $_SESSION['uid'])) {
	header("Location: error.php?word=Access denied");
	return;
}

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
		$df = MD5($dwfn).$dwsuffix;
		header('Content-Description: File Transfer');    
		header('Content-Type: application/octet-stream');    
		header('Content-Disposition: attachment; filename='.basename($df));    
		header('Content-Transfer-Encoding: binary');    
		header('Expires: 0');    
		header('Cache-Control: must-revalidate, post-check=0, pre-check=0');    
		header('Pragma: public');    
		header('Content-Length: ' . filesize($dwfn));    
		ob_clean(); 
		flush();    
		readfile($dwfn);  
		return;
	}
}
?>
