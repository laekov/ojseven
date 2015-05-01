/*
 * oj7-ccfg
 * Source code
 * Code by CDQZ_laekov
 * Version on linux
 * Last change on 05/01 2015
 */

#include <bits/stdc++.h>
using namespace std;

int getcid() {
	FILE* ipf(fopen("html/conf/cont.conf", "r"));
	int x;
	fscanf(ipf, "%d", &x);
	fclose(ipf);
	return x;
}

const int maxn = 1009;

char kx[maxn][maxn], ix[maxn][maxn];

map <string, string> items;

int main(int argc, char* args[]) {
	int cid = getcid();
	int stat = -1;
	for (int i = 1; i < argc; ++ i)
		if (args[i][0] == '-') {
			if (!strcmp(args[i] + 1, "cid")) {
				sscanf(args[i + 1], "%d", &cid);
				++ i;
			}
			else if (!strcmp(args[i] + 1, "stat")) {
				sscanf(args[i + 1], "%d", &stat);
				++ i;
			}
		}
	char cfgfln[maxn];
	sprintf(cfgfln, "./data/%08d/.contcfg", cid);
	FILE* cfgpf(fopen(cfgfln, "r"));
	int tot(0);
	while (fscanf(cfgpf, "%s", kx[tot]) != EOF) {
		fgets(ix[tot], sizeof(ix[tot]), cfgpf);
		if (!strcmp(kx[tot], "stat") && stat > -1)
			sprintf(ix[tot], "%d", stat);
		++ tot;
	}
	fclose(cfgpf);
	cfgpf = fopen(cfgfln, "w");
	for (int i = 0; i < tot; ++ i)
		fprintf(cfgpf, "%s %s\n", kx[i], ix[i]);
	fclose(cfgpf);
}

