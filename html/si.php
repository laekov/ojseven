<html>
<head>
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
	header("Location: ".$_COOKIE['HTTP_REFERER']);
}
else {
	setcookie("lurl",$_SERVER['HTTP_REFERER']);
	include("forms/signin.php");
}
?>

<?php
include('oj-footer.php');
?>
</body>
</html>
