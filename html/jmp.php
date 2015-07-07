<?php
if ($_SERVER['REQUEST_URI'] == '/ranklist')
	include("cnt.php");
elseif ($_SERVER['REQUEST_URI'] == '/contestlist')
	include("contests.php");
elseif ($_SERVER['REQUEST_URI'] == '/status')
	include("uc.php");
elseif ($_SERVER['REQUEST_URI'] == '/cur')
	include("cur.php");
elseif ($_SERVER['REQUEST_URI'] == '/bbs')
	include("bbs.php");
else {
	$_GET['word'] = 'ovo';
	include("error.php");
}
?>
