<p class='infot'>Config problems (<a href='faq.php'>protocol</a>)</p>
<form action='admin.php?cmd=cprob_get' method='post' enctype='multipart/form-data'>
<table align='center' width='800px' border='1'>
<?php
$cid = read_fline("./conf/cont.conf");
if (strlen($cid) < 8)
	header("Location: error.php?word=No contest");
for ($i = 'a'; $i <= 'c'; ++ $i) {
	$cfln = ("./data/". $cid. "/". $i. ".cfg");
	echo "<tr>\n";
	echo "<td width='24%'><label for='". $i. "'>". $i. ".cfg</td>\n";
	echo "<td><textarea id='". $i. "' name='". $i. "' cols='50' rows='8'>";
	echo read_file($cfln);
	echo "</textarea></td>";
	echo "</tr>";
}
?>

<tr>
<td>Admin key</td>
<td><input type='password' id='key' name='key' /></td>
</tr>
</table>

<input type='submit' value='Submit'/>

</form>
