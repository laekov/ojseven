<html>
<head>
<link rel='icon' href='src/ic.png' type='image/x-icon'/>
<title>OJ7 - Modify user</title>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
</head>
<body>
<?php
include('oj-header.php');
?>

<div align='center' width='800px'>
<?php
if (!$_SESSION['signedin']) {
	header("Location: error.php?word=Please sign in first");
	return;
}
else if ($_GET['cmd'] == 'recv') {
	$uid = getuid();
	$uname = $_POST['uname'];
	$grade = $_POST['grade'];
	$passwdold=$_POST['passwdold'];
	if (check_passwd($uid,$passwdold)) {
		header("Location: error.php?word=Wrong password");
		return;
	}
	$passwd=$_POST['passwd'];
	if ($passwd != $_POST['reppasswd']) {
		header("Location: error.php?word=Password not match!");
		return;
	}
	$fln = "../users/". $uid. ".uinfo";
	$opf = fopen($fln, "w");
	fprintf($opf, "%s\n%s\n", $uname, $grade);
	fclose($opf);
	if (strlen($passwd)>0) {
		$fln = "../users/". $uid. ".upasswd";
		$opf=fopen($fln,"w");
		fprintf($opf,"%s",MD5($passwd));
		fclose($opf);
	}
	echo "<font style='font-size: 24px'>";
	echo "User info successfully changed<br/>";
	echo "User id: ". $uid. "<br/>";
	echo "Name: ". $uname. "<br/>";
	echo "Graudate year: ". $grade. "<br/>";
	echo "</font>";
}
else {
	include("forms/modifyuser.php");
}
?>
</div>

<?php
include('oj-footer.php');
?>
</body>
</html>

