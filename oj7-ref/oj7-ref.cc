#include "oj7-ref.h"

user ul[maxu];
contest cl[maxc];

int tu, tc;

user :: user() {
	memset(crk, -1, sizeof(crk));
	memset(csco, -1, sizeof(csco));
	exp = 0.7;
	tot_c = 0;
}

inline bool cmpCid(const contest& a, const contest& b) {
	return a. cid < b. cid;
}

inline bool cmpExp(const user& a, const user& b) {
	return (a. exp < b. exp) || (a. exp == b. exp && a. uid < b. uid);
}

void loadUsers() {
	DIR *drp = opendir("./users");
	struct dirent *dri;
	char tmpstr[max_str];
	tu = 0;
	while ((dri = readdir(drp)))
		if (strstr(dri-> d_name, ".uinfo")) {
			strcpy(tmpstr, dri-> d_name);
			*strstr(tmpstr, ".uinfo") = 0;
			ul[tu]. uid = string(tmpstr);
			FILE* ipf = fopen(("./users/" + string(dri-> d_name)). c_str(), "r");
			fscanf(ipf, "%s", tmpstr);
			ul[tu]. uname = string(tmpstr);
			fscanf(ipf, "%s", tmpstr);
			ul[tu]. grade = string(tmpstr);
			fclose(ipf);
			++ tu;
		}
	closedir(drp);
}

void loadContests() {
	char tmpstr[max_str];
	tc = 0;
	DIR *drp;
	struct dirent *dri;
	drp = opendir("./results");
	tc = 0;
	while ((dri = readdir(drp))) 
		if (strstr(dri-> d_name, ".rl")) {
			FILE* ipf = fopen(("./results/" + string(dri-> d_name)). c_str(), "r");
			if (!ipf)
				continue;
			int n;
			fscanf(ipf, "%s%d", tmpstr, &n);
			cl[tc]. cid = string(tmpstr);
			cl[tc]. tot = n;
			++ tc;
			fclose(ipf);
		}
	sort(cl, cl + tc, cmpCid);
	for (int ci = 0; ci < tc; ++ ci) {
		FILE* ipf = fopen(("./results/" + cl[ci]. cid + ".rl"). c_str(), "r");
		int n;
		fscanf(ipf, "%*s%d", &n);
		for (int i = 0; i < n; ++ i) {
			int a, b;
			fscanf(ipf, "%s%d%d", tmpstr, &a, &b);
			string uid(tmpstr);
			int j = 0;
			for (; j < tu && ul[j]. uid != uid; ++ j);
			if (j == tu) {
				ul[tu]. uid = uid;
				ul[tu]. uname = "no_name";
				ul[tu]. grade = "unknown";
				++ tu;
			}
			ul[j]. csco[ci] = a;
			ul[j]. crk[ci] = b;
			double r0 = (double)((ul[j]. csco[ci] == 0) ? (n - 1) : (ul[j]. crk[ci] - 1)) / (double)((n > 1) ? (n - 1) : 1);
			ul[j]. exp += (r0 - ul[j]. exp) * 0.142857142857;
			++ ul[j]. tot_c;
		}
		fclose(ipf);
	}
	sort(ul, ul + tu, cmpExp);
	closedir(drp);
}

void showUsers() {
	for (int i = 0; i < tu; ++ i)
		printf("%s: %.2lf (%d)\n", ul[i]. uid. c_str(), ul[i]. exp, ul[i]. tot_c);
	printf("Total: %d\n", tu);
}

void writeJS() {
	FILE* opf = fopen("./rescnt/data.js", "w");
	fprintf(opf, "var tot_c=%d;\n", tc);
	fprintf(opf, "var cid=new Array();\n");
	fprintf(opf, "var ctot=new Array();\n");
	for (int i = 0; i < tc; ++ i) {
		fprintf(opf, "cid[%d]='%s';\n", i, cl[i]. cid. c_str());
		fprintf(opf, "ctot[%d]=%d;\n", i, cl[i]. tot);
	}
	fprintf(opf, "var tot_u=%d;\n", tu);
	fprintf(opf, "var ul=new Array();\n");
	for (int i = 0; i < tu; ++ i) {
		fprintf(opf, "ul[%d]={};\n", i);
		fprintf(opf, "ul[%d].uid='%s';\n", i, ul[i]. uid. c_str());
		fprintf(opf, "ul[%d].uname='%s';\n", i, ul[i]. uname. c_str());
		fprintf(opf, "ul[%d].grade='%s';\n", i, ul[i]. grade. c_str());
		fprintf(opf, "ul[%d].tot_c=%d;\n", i, ul[i]. tot_c);
		fprintf(opf, "ul[%d].csco=new Array();\n", i);
		fprintf(opf, "ul[%d].crk=new Array();\n", i);
		fprintf(opf, "ul[%d].rating=%d;\n", i, (int)(778 / ul[i]. exp));
		for (int j = 0; j < tc; ++ j) {
			fprintf(opf, "ul[%d].csco[%d]=%d;\n", i, j, ul[i]. csco[j]);
			fprintf(opf, "ul[%d].crk[%d]=%d;\n", i, j, ul[i]. crk[j]);
		}
	}
	fclose(opf);
}

int main(int argc, char* args[]) {
	//if (argc > 1)
	//	chdir(args[1]);
	chdir("/var/www/html");
	loadUsers();
	loadContests();
	showUsers();
	writeJS();
}

