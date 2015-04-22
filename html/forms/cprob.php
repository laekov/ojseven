<p class='infot'>Config problems (<a href='faq.php'>protocol</a>)</p>
<form action='admin.php?cmd=cprob_get' method='post' enctype='multipart/form-data'>
<table align='center' width='800px' border='1'>
<?php
if ($cid == -1)
	$cid = read_fline("./conf/cont.conf");
if (strlen($cid) < 8)
	header("Location: error.php?word=No contest");
$ccfg = readccfg("../data/".$cid."/.contcfg");
$eid = chr(97 + $ccfg['totprob']);
for ($i = 'a'; $i < $eid; ++ $i) {
	$cfln = ("../data/". $cid. "/". $i. ".cfg");
	echo "<tr>\n";
	echo "<td width='24%'><label for='". $i. "'>". $i. ".cfg</td>\n";
	echo "<td><textarea id='". $i. "' name='". $i. "' cols='50' rows='8'>";
	echo read_file($cfln);
	echo "</textarea></td>";
	echo "</tr>";
}
?>
</table>

<input type='submit' value='Submit'/>

</form>
