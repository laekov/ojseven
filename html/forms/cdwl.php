<p class='infot'>Edit a file</p>
<form action='admin.php?cmd=cdwl_get' method='post' enctype='multipart/form-data'>
<table align='center' width='800px' border='1'>
<tr>

<?php
$fln="";
if (strlen($_POST['filename'])>0)
	$fln=$_POST['filename'];
else if (strlen($_GET['filename'])>0)
	$fln=$_GET['filename'];
?>

<tr>
<td>File name</td>
<td><input type='input' size='50px' name='filename' value='<?php echo $fln; ?>' onchange='clritem("dwl");'/></td>
</tr>

<tr>
<td>File</td>
<td><textarea id='dwl' name='dwl' cols='72' rows='24'>
<?php if (is_file($fln)) echo read_file($fln); ?></textarea></td>
</tr>
</table>

<input type='submit' value='Submit'/>

</form>
