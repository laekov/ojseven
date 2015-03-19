<html>
<head>
<link rel='icon' href='src/ic.png' type='image/x-icon'/>
<title>OJ7 - Admin</title>
</head>
<body>
<?php
include('oj-header.php');
?>

<?php
if (!is_admin()) {
	header("Location: error.php?word=Permission denined");
	return;
}
?>

<div id='ufd' class='idiv'>
<form action='adminfl.php<?php if ($_GET['cmd'] == 'udata') echo "?cmd=udata"; ?>' method='post' enctype='multipart/form-data'>
<table align='center' width='800px' border='1'>

<tr>
<td><label for='file'> <?php if ($_GET['cmd']=='udata') echo "Data"; else echo "<span style='color:red'>File</span>";?> </td>
<td><input type='file' id='file' name='file'></td>
</tr>

<tr>
<td><label for='dest'> Destination </label></td>
<td><input type='text' id='dest' name='dest' /></td>
</tr>

</table>
<input type='submit' value='Submit'/>
</tr>
</table>
</form>

<?php
function check_key($key) {
	$pf = fopen("conf/admin_key.conf", "r");
	list($k0) = fscanf($pf, "%s");
	fclose($pf);
	return $k0 == $key;
}
function getcid() {
	$pf = fopen("conf/cont.conf", "r");
	list($cid) = fscanf($pf, "%s");
	fclose(pf);
	return $cid;
}

if ($_FILES['file']['size'] > 0) {
	$dest = ("./packs/". $_FILES['file']['name']);
	if ($_GET['cmd'] == 'udata') {
		$cid = getcid();
		$dest = "./data/". $cid. "/". $_FILES['file']['name'];
		if (strstr($dest, "admin.conf") != false) {
			header("Location: error.php?word=Dangerous operation");
			return;
		}
		if (strlen($_POST['dest']) > 0)
			$dest = "./data/". $cid. "/". $_POST['dest'];
	}
	else if (strlen($_POST['dest']) > 0)
		$dest = $_POST['dest'];
	if (strstr($dest, "admin.conf") != false) {
		header("Location: error.php?word=Dangerous operation");
		return;
	}
	if (!move_uploaded_file($_FILES['file']['tmp_name'], $dest))
		echo "File moving error<br/>";
	else
		echo "File uploading successful<br/>";
	if ($_GET['cmd'] == 'udata') {
		if (strpos($dest, "zip") != false) {
			chmod($dest, 0777);
			$cmd = "unzip -o -q ./". $dest. " -d ./data/". $cid;
			echo exec($cmd);
		}
	}
}
?>

</div>
<?php
include("oj-footer.php");
?>
</body>
</html>
