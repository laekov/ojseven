<center>
<div style='width:80%;text-align:left;'>
<form action='admin.php?cmd=ls' method='post'>
<label>Path</label>
<input type='text' name='path' value='<?php echo $pth;?>'/>
<input type='submit' value='Submit'/>
</form>
<ul>
<?php
$dir = opendir($pth);
while (($ite = readdir($dir))!= false) {
	echo "<li>";
	echo $ite;
	if (is_dir($pth."/".$ite))
		echo "/";
	echo "</li>";
}
closedir($pth);
?>
</ul>
</div>
</center>
