<html>
<head>
<title>OJ7 - F.A.Q.</title>
</head>
<body>
<?php
include('oj-header.php');
?>
<table width="800px" align='center'>

<tr><td><pre>
<font color='red'>What is OJ7?
<font color='blue'>OJ7 is an online judge system by OIers from Grade 2015, 2016 and 2017.
</pre></td></tr>

<tr><td><pre>
<font color='red'>How does OJ7 work?
<font color='blue'>This is an online version of ojseven.
</pre></td></tr>

<tr><td><pre>
<font color='red'>What is the judging environment?
<font color='blue'>I don't know
</pre></td></tr>

<tr><td><pre>
<font color='red'>Compile command:
<font color='blue'>for c++: g++ %s.cpp
for c: gcc %s.c
for pascal: fpc %s.pas
</pre></td></tr>

<tr><td><pre>
<font color='red'>Config file format of OJ7
<font color='blue'>a/b/c.cfg
[problem name]
[user input file name]
[user output file name]
[std input file format(%d stands for test case id)]
[std output file format(%d stands for test case id)]
[first test case id] [last test case id]
[time limit(ms)] [memory limit(MB)]
(spj [spj cmd])
(ansonly)
</pre></td></tr>

<tr><td><pre>
<font color='red'>Special judge format of OJ7
<font color='blue'>Command: spj arg1 arg2 .. arg6
arg1: Standrad input
arg2: Player output
arg3: Standrad output
arg4: Full score
arg5: (Necessary) Player score
arg6: (Not necessary) Extra info
(This is the same as the one of Lemon)
</pre></td></tr>

</table>
<?php
include('oj-footer.php');
?>
</body>
</html>
