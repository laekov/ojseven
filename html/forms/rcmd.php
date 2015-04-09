<p class='infot'>Run a command</p>
<form action='admin.php?cmd=rcmd_get' method='post' enctype='multipart/form-data'>
<table align='center' width='800px' border='1'>
<tr>
<td>Command</td>
<td><input type='text' id='cmdline' name='cmdline' style='width:500px;'/></td>
</tr>
</table>

<center>
<div style='width:80%;text-align:left;'>
<ul>
<li>Start judge: <br/><pre>oj7-cjudge run</pre></li>
<li>Start judge on time: <br/><pre>oj7-timer 12:30:01 oj7-cjudge run</pre></li>
<li>Compile spj: <br/><pre>g++ ./data/20150319/sort/spj.cpp -o ./data/20150319/sort/spj</pre></li>
<li>Rejudge a person: <br/><pre>oj7-cjudge rejudgeu [uid]</pre></li>
<li>Rejudge a problem: <br/><pre>oj7-cjudge rejudgep [a/b/c]</pre></li>
</ul>
</div>
</center>

<input type='submit' value='Submit'/>

</form>
