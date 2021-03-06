<html>
<head>
<link rel='icon' href='src/ic.png' type='image/x-icon'/>
<title>OJ7 - F.A.Q.</title>
</head>
<body>
<?php
include('oj-header.php');
?>
<table width="80%" align='center'>

<tr><td><pre>
<font color='red'>What is OJ7?
<font color='blue'>OJ7 is an online judge system by OIers from Grade 2015, 2016 and 2017.
</pre></td></tr>

<tr><td><pre>
<font color='red'>How does OJ7 work?
<font color='blue'>The server of OJ7 locates in Room 404. OIers maintain it essentially.
</pre></td></tr>

<tr><td><pre>
<font color='red'>What is the judging environment?
<font color='blue'>Intel(R) Xeon(R) CPU X3440  2.53GHz
4GB RAM
Xubuntu 14.04 LTS
gcc 4.8.2
fpc 2.6.2
</pre></td></tr>

<tr><td><pre>
<font color='red'>Normal compile command:(There may be -O2 if it is required by the problem setter)
<font color='blue'>for c++: g++ %s.cpp
for c: gcc %s.c
for pascal: fpc %s.pas
</td></tr>

<tr><td><pre>
<font color='red'>How to submit answer-only problems on OJ7?
<font color='blue'>Assume that the answers are xxx1.out ... xxx10.out
You should submit a zip file named xxx.zip.
You may use the following command to make such a zip file:
<span style='color:black'>zip xxx.zip xxx1.out xxx2.out ... xxx10.out</span>
or
<span style='color:black'>zip xxx.zip xxx*.out</span>
That means if you double-click this zip file under GUI, you can see xxx?.out immediately.
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
