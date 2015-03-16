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
		return "#009900";
	else if (word[0] == '#')
		return '#777777';
	else if (word.match('\&lt;') != null && word.match('\&gt;') != null)
		return '#777777';
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
        if (line[sepp[i]] == '"') {
            inquote = 1 - inquote;
        }
        if (inquote == 1) {
            word = '"' + word + '"';
            text += "<span style='color:yellow;'>" + word + "</span>";
        }
        else {
            text += "<span style='color:" + getwordcolor(word) + "'>" + word + "</span>";
        }
        if (line[sepp[i + 1]] != '"')
            text += "<span style='color:pink'>" + line[sepp[i + 1]] + "</span>";
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

function sethls() {
	var tas = document.getElementsByTagName("pre");
	//document.write(tas.length);
	for (var i = 0; i < tas.length; ++ i)
		sethl(tas[i]);
}

function sethlById(id) {
    sethl(document.getElementById(id));
}


