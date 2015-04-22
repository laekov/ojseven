<?php
if ($cid == -1)
	$cid = read_fline("./conf/cont.conf");
?>
<p class='infot'> Admin menu </p>
<table align='center'>
<tr><td><a href='admin.php?cmd=ccont' class='infot'>Config contest</a></td></tr>
<tr><td><a href='admin.php?cmd=cdwl_get&filename=../data/<?php echo $cid; ?>/.contcfg' class='infot'>Config contest status</a></td></tr>
<tr><td><a href='admin.php?cmd=cprob' class='infot'>Config problems</a></td></tr>
<tr><td><a href='admin.php?cmd=cdwl_get&filename=../data/<?php echo $cid; ?>/access.list' class='infot'>Config contest accessibility</a></td></tr>
<tr><td><a href='admin.php?cmd=cdwl_get&filename=../users/.group' class='infot'>Accessibility groups</a></td></tr>
<tr><td><a href='admin.php?cmd=rcmd' class='infot'>Run a command</a></td></tr>
<tr><td><a href='adminfl.php?cmd=udata' class='infot'>Upload data</a></td></tr>
<tr><td><a href='adminfl.php' class='infot' style='color:black'>Upload file</a></td></tr>
<tr><td><a href='admin.php?cmd=cdwl' class='infot' style='color:black'>Edit a file</a></td></tr>
<tr><td><a href='admin.php?cmd=ls' class='infot'>List data</a></td></tr>
</table>
