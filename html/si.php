<html>
<head>
<link rel='icon' href='src/ic.png' type='image/x-icon'/>
<title>OJ7 - Sign in</title>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
</head>
<body>
<?php
include('oj-header.php');
?>

<div align='center' width='800px'>

<?php
if ($_GET['cmd']=='check') {
	$checkres=check_passwd($_POST['uid'],$_POST['passwd']);
	if ($checkres == 1) {
		header("Location: error.php?word=No such user");
		return;
	}
	else if ($checkres == 2) {
		header("Location: error.php?word=Wrong password");
		return;
	}
	$_SESSION['signedin']=1;
	$_SESSION['uid']=$_POST['uid'];
	header("Location: ".$_COOKIE['lurl']);
}
if ($_GET['cmd']=='leave') {
	$_SESSION['signedin']=0;
	unset($_SESSION['uid']);
	//header("Location: ".$_COOKIE['lurl']);
	header("Location: ".$_SERVER['HTTP_REFERER']);
}
else {
	$lref = $_SERVER['HTTP_REFERER'];
	if (strstr($lref, "error") == false && strstr($lref, "si") == false)
		setcookie("lurl",$lref);
	//else
		//setcookie("lurl","/index.php");
	include("forms/signin.php");
}
?>

<?php
include('oj-footer.php');
?>
</body>
</html>
