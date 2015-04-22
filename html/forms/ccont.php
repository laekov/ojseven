<p class='infot'>Config current contest</p>
<form action='admin.php?cmd=ccont_get' method='post' enctype='multipart/form-data'>
<table align='center' width='800px' border='1'>
<tr>
<td width='200px'><label for='cid'> Contest id </td>
<td><input type='text' id='cid' name='cid' value='<?php echo read_file("./conf/cont.conf"); ?>' onchange='clrpname();'/></td>
</tr>

<tr>
<td><label for='etime'> End time(hh:mm) </td>
<td><input type='text' id='etime' name='etime' value='<?php echo read_file("./conf/time.conf") ?>'/></td>
</tr>

<?php
if ($cid == -1)
	$cid = read_fline("./conf/cont.conf");
$ccfg = readccfg("../data/".$cid."/.contcfg");
$eid = chr(97 + $ccfg['totprob']);
for ($i = 'a'; $i < $eid; ++ $i) {
	echo "<tr>\n";
	echo "<td><label for='". $i. "'> Problem ". $i. "</td>\n";
	if (strlen($cid) > 0)
		echo "<td><input type='text' id='pid". $i. "' name='". $i. "'". " value='". read_fline("../data/". $cid. "/". $i. ".cfg"). "'/></td>";
	else
		echo "<td><input type='text' id='". $i. "' name='". $i. "'/></td>";
	echo "</tr>";
}
?>
</table>

<input type='submit' value='Submit'/>
</tr>
</form>

<script>
function clrpname() {
	document.getElementById('pida').value="";
	document.getElementById('pidb').value="";
	document.getElementById('pidc').value="";
	document.getElementById('pidd').value="";
}
</script>
