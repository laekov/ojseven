<html>
<head>
<title>OJ7 - bbs</title>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<script type="text/javascript" src="http://cdn.mathjax.org/mathjax/latest/MathJax.js?config=default"></script>
</head>
<body bgcolor='white'>
<?php
include('oj-header.php');
?>
<table width="800px" align='center'>

<?php
$c = 1;
for ($c = 1; is_file("./bbs/text". $c. ".html"); ++ $c);
$top = $c - 1;
if (strlen($_GET['top']) > 0)
	$top = $_GET['top'];
echo "<tr><td width='800px' align='right'>";
if ($top < $c - 1) {
	$outmp = "<a href='bbs.php?top=". min($c - 1, $top + 16). "' style='text-decoration:none;'>Later Page</a>";
	echo '['. $outmp. ']';
}
if ($top > 0) {
	$outmp = "<a href='bbs.php?top=". max(16, $top - 16). "' style='text-decoration:none;'>Older Page</a>";
	echo '['. $outmp. ']';
}
echo "</td></tr>";
for ($i = $top; is_file("bbs/text". $i. ".html") && $i >= $top - 16; -- $i) {
	echo "<tr><td width='800px' style='word-break:break-all; word-wrap:break-word;'>";
	echo "<div class='item'>";
	$pf = fopen(("bbs/text". $i. ".html"), "r");
	while (!feof($pf)) {
		++ $tot;
		$word = fread($pf, filesize("bbs/text". $i. ".html"));
		/*if (strpos($word, "script")) {
			$word = "<font color='red'>river crab</font>";
			//continue;
		}
else */if (strpos($word, "/html")) {
			$word = "<font color='red'>river crab</font>";
			//$word = "river crab";
			//continue;
		}
		//else if (strpos($word, "\"#\"")) {
		//	$word = "<font color='red'>river crab</font>";
		//}
		//$word = htmlspecialchars($word);
		//str_ireplace($word, "\n", "<br/>");
		echo $word;
		//echo "<br/>";
	}
	fclose($pf);
	echo "<hr/></div></td></tr>";
}
?>
<?php
function GetIP(){
	if(!empty($_SERVER["HTTP_CLIENT_IP"])){
		$cip = $_SERVER["HTTP_CLIENT_IP"];
	}
	elseif(!empty($_SERVER["HTTP_X_FORWARDED_FOR"])){
		$cip = $_SERVER["HTTP_X_FORWARDED_FOR"];
	}
	elseif(!empty($_SERVER["REMOTE_ADDR"])){
		$cip = $_SERVER["REMOTE_ADDR"];
	}
	else{
		$cip = "NOIP";
	}
	return $cip;
}
if (strlen($_POST['word']) > 0) {
	if (strlen($_POST['uid']) <= 1) {
		header("Location: error.php?word=Please input your user id");
	}
	else if (!is_file("users/". $_POST['uid']. ".uinfo")) {
		header("Location: error.php?word=No such user");
	}
	$cip = getIP();
	$j = 1;
	for ($j = 1; is_file("bbs/text". $j. ".html"); ++ $j);
	$isc = $_POST['iscode'];
	$pf = fopen(("bbs/text". $j. ".html"), "w");
	fprintf($pf, "%s From: %s(ip: ". $cip. ")<br/>\n", date("Y-m-d h:i:sa"), $_POST['uid']);
	if ($isc) {
		fputs($pf, "<pre class='scode'>\n");
		$word = htmlspecialchars($_POST['word']);
		//$word = str_ireplace("\r\n", "</p><p>", $word);
		//echo $word[0];
		fputs($pf, $word);
		fputs($pf, "</p></pre>");
	}
	else {
		fputs($pf, $_POST['word']);
	}
	fclose($pf);
	echo "<script language=JavaScript> location.replace(location.href);</script>";
}
?>
</tr></td>

<tr><td>
<form action='bbs.php' method='post'>
<label for='word'>Say something here: <br/>
(html and javascript are supported. Please do not submit malicious code)</label>
<textarea id='word' name='word' cols='90' rows='10'></textarea>
<br/>
<label for='uid'>Username:</label>
<input type='text' name='uid' id='uid'>
</br>
<input type='checkbox' name="iscode" id='iscode'/>
<label for='iscode'>This is a code</label><br/>
<input type='submit' name='submit' value='Say'/>
</form>
</td></tr>

</table>
<?php
include('oj-footer.php');
?>
</body>
</html>
