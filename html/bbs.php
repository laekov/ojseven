<html>
<head>
<link rel='icon' href='src/ic.png' type='image/x-icon'/>
<title>OJ7 - bbs</title>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<script type="text/javascript" src="http://cdn.mathjax.org/mathjax/latest/MathJax.js?config=default"></script>
</head>
<body bgcolor='white'>
<?php
include('oj-header.php');
?>
<table width="80%" align='center'>

<?php
$c = 1;
for ($c = 1; is_file("./bbs/text". $c. ".html"); ++ $c);
$top = $c - 1;

if (strlen($_GET['top']) > 0)
	$top = $_GET['top'];
$bot = max(1, $top - 16);
if ($_GET['single'] == 'yes')
	$bot = $top;
echo "<tr><td width='80%' align='right'>";
if ($top < $c - 1) {
	if ($_GET['single'] == 'yes')
		$outmp = "<a href='bbs.php?top=". ($top + 1). "&single=yes' style='text-decoration:none;'>Later Page</a>";
	else
		$outmp = "<a href='bbs.php?top=". min($c - 1, $top + 16). "' style='text-decoration:none;'>Later Page</a>";
	echo '['. $outmp. ']';
}
if ($top > 0) {
	if ($_GET['single'] == 'yes')
		$outmp = "<a href='bbs.php?top=". max(0, $top - 1). "&single=yes' style='text-decoration:none;'>Older Page</a>";
	else
		$outmp = "<a href='bbs.php?top=". max(16, $top - 16). "' style='text-decoration:none;'>Older Page</a>";
	echo '['. $outmp. ']';
}
echo "</td></tr>";
for ($i = $top; $i >= $bot; -- $i) {
	echo "<tr><td width='80%' style='word-break:break-all; word-wrap:break-word;'>";
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
	if ($_GET['single'] != 'yes')
		echo "<p><a href='bbs.php?top=".$i."&single=yes'>View single</a></span>";
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
	if (!$_SESSION['signedin']) {
		header("Location: error.php?word=Please sign in first");
		return;
	}
	$uid = getuid();
	$cip = getIP();
	$j = 1;
	for ($j = 1; is_file("bbs/text". $j. ".html"); ++ $j);
	$isc = $_POST['iscode'];
	$pf = fopen(("bbs/text". $j. ".html"), "w");
	fprintf($pf, "%s From: %s(ip: ". $cip. ")<br/>\n", date("Y-m-d h:i:sa"), $uid);
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

<?php 

if ($_GET['single'] != 'yes')
	echo "<tr><td><form action='bbs.php' method='post'><label for='word'>Say something here: <br/>(html and javascript are supported. Please do not submit malicious code)</label><textarea id='word' name='word' cols='90' rows='10'></textarea><br/><input type='checkbox' name='iscode' id='iscode'/><label for='iscode'>This is a code</label><br/><input type='submit' name='submit' value='Say'/></form></td></tr>";
?>

</table>
<?php
include('oj-footer.php');
?>

<script src='scripts/codehilighter.js'></script>
<script> //sethls_special(); </script>
</body>
</html>
