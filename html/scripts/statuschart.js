od=new Array();
for (var i=0;i<tot_u;++i) 
	od[i]=i;

var col=new Array();
col[0]='#eeffee';
col[1]='#eeeeff';
var show_res=1;

var cck = document.cookie.split(';');
for (var i = 0; i < cck. length; ++ i) {
	var g = cck[i]. split('=');
	if (g[0].match("show_res")!= false) {
		//alert(g[0]);
		show_res = parseInt(g[1]);
	}
}
if (show_res == 0)
	document.getElementById("showstyletext").value='Show test cases';

function show_chart() {
	var text="";
	text+="<table width='100%' style='text-align:center'>";
	text+="<tr style='background-color:#3f3fff; color:white;'>";
	if (nonu)
		text+="<td width='50px'>Index</td>";
	else
		text+="<td width='50px'>Rank</td>";
	text+="<td>User</td>";
	for (var i=0;i<3;++i)
		text+="<td style='cursor:pointer;' onclick='resortprob("+i+")'>"+pname[i]+"</td>";
	text+="<td width='100px' style='cursor:pointer' onclick='resortprob(-1);'>Total</td>";
	text+="</tr>";
	for (var ti=0, trk=0;ti<tot_u;++ti) {
		var i=od[ti];
		text+="<tr style='background-color:"+col[ti%2]+";'>";
		if (nonu == 1)
			trk = ti;
		else if (ti > 0 && ul[ti].tot_sco != ul[od[ti - 1]]. tot_sco)
			trk = ti;
		text+="<td>"+(trk+1)+"</td>";
		text+="<td><a href='cnt.php?uid="+(ul[i].uid.split('-')[0])+"'>"+ul[i].uid+"</a></td>";
		for (var j=0;j<3;++j) {
			var k;
			if (j==0)
				k='a';
			else if (j==1)
				k='b';
			else 
				k='c';
			text+="<td><a style='font-family:Monospace;' class='wcode' href='vs.php?uid="+ul[i].uid+"&cid="+cid+"&pid="+k+"'>";
			if (show_res) {
				if (ul[i].a[j].wd=='No file')
					text+="</a><font style='color:hotpink'>"+ul[i].a[j].wd+"</font><a>";
				else if (ul[i].a[j].wd=='CE')
					text+="<font style='color:black'>Compile error</font>";
				else if (ul[i].a[j].wd=='Pending')
					text+="<font style='color:blue'>"+ul[i].a[j].wd+"</font>";
				else {
					for (var l=0;l<ul[i].a[j].wd.length;++l) {
						if (ul[i].a[j].wd[l]=='A')
							text+="<font style='background-color:green;color:white;'>";
						else if (ul[i].a[j].wd[l]=='W')
							text+="<font style='background-color:red;color:white;'>";
						else if (ul[i].a[j].wd[l]=='M')
							text+="<font style='background-color:darkorange;color:white;'>";
						else if (ul[i].a[j].wd[l]=='T')
							text+="<font style='background-color:darkorange;color:white;'>";
						else if (ul[i].a[j].wd[l]=='R')
							text+="<font style='background-color:purple;color:white;'>";
						else if (ul[i].a[j].wd[l]=='F')
							text+="<font style='background-color:black;color:white;'>";
						else 
							text+="<font style='color:black;'>";
						text+=ul[i].a[j].wd[l]+"</font>";
						if (l % 25 == 24)
							text += "<br/>";
					}
				}
			}
			else {
				text+="<font style='color:black;'>";
				if (ul[i].a[j].sco>-1)
					text+=ul[i].a[j].sco;
				else if (ul[i].a[j].wd=='Pending')
					text+="?";
				else
					text+="0";
				text+="</font>";
			}
			text+="</a></td>";
		}
		text+="<td>"+ul[i].tot_sco+"</td>";
		text+="</tr>";
	}
	text+="</table>";
	document.getElementById("chartplace").innerHTML=text;
}

function rev_arrange() {
	for (var i=0;i<tot_u;++i)
		od[i]=tot_u-i-1;
}

function resortprob(p) {
	if (p==-1) {
		nonu = 0;
		for (var i=0;i<tot_u;++i)
			for (var j=i+1;j<tot_u;++j)
				if (ul[od[i]].tot_sco<ul[od[j]].tot_sco||(ul[od[i]].tot_sco<ul[od[j]].tot_sco&&ul[od[i]].uid<ul[od[j]].uid)) {
					var h=od[i];
					od[i]=od[j];
					od[j]=h;
				}
	}
	else {
		nonu = 1;
		for (var i=0;i<tot_u;++i)
			for (var j=i+1;j<tot_u;++j)
				if (ul[od[i]].a[p].sco<ul[od[j]].a[p].sco||(ul[od[i]].a[p].sco<ul[od[j]].a[p].sco&&ul[od[i]].uid<ul[od[j]].uid)) {
					var h=od[i];
					od[i]=od[j];
					od[j]=h;
				}
	}
	show_chart();
}

function chgshowstyle() {
	if (show_res) {
		show_res=0;
		document.getElementById("showstyletext").value='Show test cases';
		document.cookie="show_res=0;";
	}
	else {
		show_res=1;
		document.getElementById("showstyletext").value='Show score';
		document.cookie="show_res=1;";
	}
	show_chart();
}
