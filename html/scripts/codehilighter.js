function findArray(arr, item) {
	for (var i = 0; arr[i] != undefined; ++ i) {
		if (arr[i] == item)
			return true;
	}
	return false;
}

var typewords = Array("int", "void", "long", "fload", "double", "register", "static", "size_t", "char", "bool");
var specialwords = Array("using", "namespace", "struct", "class", "public", "private", "for", "while", "if", "do", "return", "new", "delete", "const", "break", "continue", "else", "switch", "default", "sizeof", "inline", "typedef", "operator");
var separatorwords = Array("(", ")", " ", "[", "]", "{", "}", "\t", "\,", "\r", '"', "+", "-", "*", "/", "~", "!");

function isSeparator(x) {
	for (var i = 0; separatorwords[i] != undefined; ++ i)
		if (x == separatorwords[i])
			return true;
	return false;
}

function getwordcolor(word) {
	if (findArray(typewords, word))
		return "#aaaaff";
	else if (findArray(specialwords, word))
		return "#00ff00";
	else if (word[0] == '#')
		return '#aaaaaa';
	else if (word.match('\&lt;') != null && word.match('\&gt;') != null)
		return '#999999';
	else if (word[0] == '"' && word[word.length-1]=='"')
		return "orange";
	else
		return "#ffffff";
}

function dealLine(line) {
	var text = "";
    var sepp = Array();
    var totsep = 0;
    line = " " + line + " ";
    for (var i = 0; i < line.length; ++ i)
        if (isSeparator(line[i])) {
            sepp[totsep] = i;
            totsep ++;
        }
    var inquote = 0;
	for (var i = 0; i < totsep - 1; ++ i) {
        var word = "";
        for (var j = sepp[i] + 1; j < sepp[i + 1]; ++ j)
            word += line[j];
		var afq = 0;
        if (line[sepp[i]] == '"') {
			if (inquote == 0)
				text += "<span style='color:yellow'>" + line[sepp[i]] + "</span>";
			else
				afq = 1;
            inquote = 1 - inquote;
        }
        if (inquote == 1) {
			if (word.length > 0) {
				text += "<span style='color:yellow;'>" + word + "</span>";
			}
			text += "<span style='color:yellow'>" + line[sepp[i + 1]] + "</span>";
        }
        else {
			text += "<span style='color:" + getwordcolor(word) + "'>" + word + "</span>";
			if (line[sepp[i + 1]] != '"')
				text += "<span style='color:pink'>" + line[sepp[i + 1]] + "</span>";
        }
	}
	return text;
}

function sethl(cp) {
	var lines = cp.innerHTML.split('\n');
	var tot = 0;
	while (lines[tot] != undefined)
		++ tot;
	var text = "";
	for (var i = 0; i < tot; ++ i) {
		text += dealLine(lines[i]);
		text += "\n";
	}
	cp.innerHTML = text;
}

function sethl_special(cp) {
	var lines = cp.innerHTML.split('\n');
	var tot = 0;
	while (lines[tot] != undefined)
		++ tot;
	var text = "";
	for (var i = 0; i < tot; ++ i) {
		var line = lines[i];
	//	text += "<span>" + i + "\t</span>";
		text += dealLine(lines[i]);
		text += "\n";
	}
	cp.innerHTML = text;
}

function sethls() {
	var tas = document.getElementsByTagName("pre");
	//document.write(tas.length);
	for (var i = 0; i < tas.length; ++ i)
		sethl(tas[i]);
}

function sethls_special() {
	var tas = document.getElementsByTagName("pre");
	//document.write(tas.length);
	for (var i = 0; i < tas.length; ++ i)
		sethl_special(tas[i]);
}

function sethlById(id) {
    sethl(document.getElementById(id));
}


