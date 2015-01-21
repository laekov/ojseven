<form action='mu.php?cmd=recv' method='post' enctype='multipart/form-data'>
<table align='center' width='800px' border='0'>
<tr>
<td><label>Real name <br/>(Pinyin in lowercase letter)</label></td>
<td><input type='text' name='uname' id='uname' size='50px' value='<?php echo getUname(getuid()); ?>'/></td>
</tr>

<tr>
<td><label>Old password</label></td>
<td><input type='password' name='passwdold'/></td>
</tr>

<tr>
<td><label>New password</label></td>
<td><input type='password' name='passwd'/></td>
</tr>

<tr>
<td><label>Repeat password</label></td>
<td><input type='password' name='reppasswd'/></td>
</tr>

<tr>
<td><label>Graduate year <br/></label></td>
<td><input type='text' name='grade' id='grade' size='50px' value='<?php echo getUgrade(getuid()); ?>'/></td>
</tr>
</table>
<input type='submit' value='Submit'/>
</form>
