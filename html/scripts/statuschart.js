od=new Array();
for (var i=0;i<tot_u;++i) 
	od[i]=i;

var col=new Array();
col[0]='#eeffee';
col[1]='#eeeeff';
var show_res=1;

function show_chart() {
	var text="";
	text+="<table width='800px' style='text-align:center'>";
	text+="<tr style='background-color:#3f3fff; color:white;'>";
	text+="<td width='50px'>Rank</td>";
	text+="<td>User</td>";
	for (var i=0;i<3;++i)
		text+="<td style='cursor:pointer;' onclick='resortprob("+i+")'>"+pname[i]+"</td>";
	text+="<td width='100px' style='cursor:pointer' onclick='resortprob(-1);'>Total</td>";
	text+="</tr>";
	for (var ti=0;ti<tot_u;++ti) {
		var i=od[ti];
		text+="<tr style='background-color:"+col[ti%2]+";'>";
		text+="<td>"+(i+1)+"</td>";
		text+="<td><a href='cnt.php?uid="+ul[i].uid+"'>"+ul[i].uid+"</a></td>";
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
					text+="</a><font style='color:blue'>"+ul[i].a[j].wd+"</font><a>";
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
		for (var i=0;i<tot_u;++i)
			for (var j=i+1;j<tot_u;++j)
				if (ul[od[i]].tot_sco<ul[od[j]].tot_sco||(ul[od[i]].tot_sco<ul[od[j]].tot_sco&&ul[od[i]].uid<ul[od[j]].uid)) {
					var h=od[i];
					od[i]=od[j];
					od[j]=h;
				}
	}
	else {
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
		document.getElementById("showstyletext").innerHTML='Show test cases';
	}
	else {
		show_res=1;
		document.getElementById("showstyletext").innerHTML='Show score';
	}
	show_chart();
}
