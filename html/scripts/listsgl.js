function drawGraph(x) {
	var cvs=document.getElementById("graphplace");
	var ctx=cvs.getContext("2d");
	var csv=ctx.createLinearGradient(0,0,0,cvs.height-1);
	var spcd=32;
	var t=0;
	for (;x[t]!=undefined;++t);

	csv.addColorStop(0,'#deffcc');
	csv.addColorStop(1,'#eedcff');
	ctx.fillStyle=csv;
	ctx.fillRect(0,0,cvs.width,cvs.height);
	ctx.strokeStyle='#acacac';
	ctx.lineWidth=0.5;
	for (var i=0;i<6;++i) {
		ctx.moveTo(spcd,Math.round((cvs.height-spcd*2)/5*i)+spcd);
		ctx.lineTo(cvs.width-spcd,(Math.round((cvs.height-spcd*2)/5*i)+spcd));
		ctx.stroke();
	}

	ctx.stroke();
	ctx.strokeStyle='#000000';
	for (var i=0;i<6;++i)
		ctx.strokeText(String(i*20)+"%",1,Math.round((cvs.height-spcd*2)/5*i)+spcd);
	ctx.stroke();

	var stp=0,edp=t-1;
	for (; stp<t&&x[stp]<0;++stp);
	for (; edp > stp && x[edp] < 0; -- edp);
	var gwid;
	if (edp == stp)
		gwid = (cvs.width-spcd*2)/2;
	else
		gwid = (cvs.width-spcd*2)/(edp-stp);

	ctx.lineWidth=0.5;
	ctx.strokeStyle='#000000';
	for (var i=stp;i<=edp;++i)
		if (stp<edp)
			ctx.strokeText(String("#")+(i+1),spcd+gwid*(i-stp),cvs.height-spcd/2);
		else
			ctx.strokeText(String("#")+(i+1),spcd+gwid,cvs.height-spcd/2);
	ctx.stroke();

	var csl=ctx.createLinearGradient(0,0,0,cvs.height-1);
	csl.addColorStop(0,'#fc0000');
	csl.addColorStop(1,'#0000fc');
	ctx.beginPath();
	ctx.strokeStyle=csl;
	ctx.lineWidth=2;
	ctx.moveTo(spcd , x[stp]*(cvs.height-spcd*2)+spcd);
	if (t>1) {
		for (var i=stp+1;i<=edp;++i) 
			if (x[i]>=0)
				ctx.lineTo(spcd+Math.round(gwid*(i-stp)),x[i]*(cvs.height-spcd*2)+spcd);
	}
	ctx.stroke();

	var prd=3,pa=4;
	for (var i=stp;i<=edp;++i) 
		if (x[i]>=0) {
			ctx.fillStyle='#'+Math.round((1-x[i])*89+10)+"00"+Math.round(x[i]*89+10);
			ctx.beginPath();
			if (stp < edp) {
				var xo = spcd+gwid*(i-stp);
				var yo = x[i]*(cvs.height-spcd*2)+spcd;
			//	ctx.moveTo(spcd+Math.round(gwid*(i-stp)),x[i]*(cvs.height-spcd*2)+spcd);
			//	ctx.rect(spcd+gwid*(i-stp)-prd,x[i]*(cvs.height-spcd*2)+spcd-prd,prd*2,prd*2);
			//	ctx.fill();
				ctx.strokeStyle="#000";
				ctx.lineWidth=1.0;
				ctx.arc(xo, yo, prd, 0, 2 * Math.PI);
			//	ctx.strokeRect(spcd+gwid*(i-stp)-pa,x[i]*(cvs.height-spcd*2)+spcd-pa,pa*2,pa*2);
				ctx.stroke();
				ctx.fill();
			}
			else {
				ctx.moveTo(spcd+gwid,x[i]*(cvs.height-spcd*2)+spcd);
				ctx.rect(spcd+gwid-prd,x[i]*(cvs.height-spcd*2)+spcd-prd,prd*2,prd*2);
				ctx.fill();
				ctx.strokeStyle="#3f3fff";
				ctx.lineWidth=1.0;
				ctx.strokeRect(spcd+gwid-pa,x[i]*(cvs.height-spcd*2)+spcd-pa,pa*2,pa*2);
				ctx.stroke();
			}
		}
}

function listsgl() {
	var fbeg=fliterbeg.value;
	var fend=fliterend.value;
	var text="<table width='800px'>";
	var col=new Array();
	col[0]='#eeffee';
	col[1]='#eeeeff';

	text=text+"<tr><td>";
	var uid=-1;
	for (var i=0;i<tot_u;++i)
		if (vuid==ul[i].uid) {
			uid=i;
			break;
		}
	if (uid==-1) {
		text=text+"<h1 style='color:red'>No such user</h1>";
		text=text+"</tr></td>";
		text=text+"</table>";
		document.getElementById("showplace").innerHTML=text;
		return;
	}
	text=text+"<p style='text-align:left'>Username: "+ul[uid].uid+"</p>";
	text=text+"<p style='text-align:left'>Real name: "+ul[uid].uname+"</p>";
	text=text+"<p style='text-align:left'>Grade: "+ul[uid].grade+"</p>";
	text=text+"<p style='text-align:left'>Total rounds: "+ul[uid].tot_c+"</p>";
	text=text+"<p style='text-align:left'>Rating: "+ul[uid].rating+"</p>";
	text=text+"<hr/></td></tr>";
	text=text+"<tr><td><p style='text-align:left'>Rank graph: </p>";
	text=text+"<canvas height='200' width='800' id='graphplace'>Java script not supported </canvas>";
	text=text+"<hr/></td></tr>";
	text=text+"<tr><td>";
	text=text+"<table width='800px'><tr style='text-align:center;background-color:#3f3fff;color:white;'><td width='50px'>Num</td><td>Contest</td><td>Score</td><td>Rank</td></tr>";
	var x=new Array();
	var t=0,c=0;
	for (var i=0;i<tot_c;++i) {
		if (cid[i]<fbeg||cid[i]>fend)
			continue;
		x[t]=ul[uid].crk[i];
		if (ctot[i]>1&&x[t]>-1) {
			x[t]=(x[t]-1)/(ctot[i]-1);
			text=text+"<tr style='text-align:center;background-color:"+col[c%2]+"'><td>#"+(t+1)+"</td><td><a href='uc.php?cid="+cid[i]+"'>"+cid[i]+"</a></td><td>"+ul[uid].csco[i]+"</td><td>"+ul[uid].crk[i]+" / "+ctot[i]+"</td></tr>";
			++c;
		}
		++t;
	}
	text=text+"</td></tr></table></table>";
	document.getElementById("showplace").innerHTML=text;
	drawGraph(x);
}

function fliterchg() {
	var fbeg=fliterbeg.value;
	var fend=fliterend.value;
	var text="cnt.php?uid="+vuid+"&fbeg="+fbeg+"&fend="+fend;
	window.location.href=text;
	listsgl();
}

listsgl();
