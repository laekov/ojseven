/*
 * Ace Judge for OJ7
 * Source code
 * Code by CDQZ_laekov
 * Version on linux
 * Last change on 01/11 2015
 */

#include "acejudge.h"
#include "oj7.h"
#include "judge.h"

int main(int argc, char* args[]) {
	//puts("RUNNING");
	bool flag = 1, fastrun = 0;
	freopen(".ajruntime", "w", stderr);
	prob_cfg ccfg;
	prob_res cres;
	for (int i = 1; i < argc; ++ i)
		if (args[i][0] == '-') {
			if (!strcmp(args[i] + 1, "help")) {
				show_help();
				return 0;
			}
			else if (!strcmp(args[i] + 1, "version")) {
				show_version();
				return 0;
			}
		}
	if (argc != 4) {
		puts("Wrong arguments");
		return 1;
	}
	ccfg. load(args[1], args[2], args[3]);
	cres. init(ccfg);

	int cpres(0);

	setcolor(0);
	setcolor(35);
	puts(ccfg. prg_name);
	setcolor(0);

	if (ccfg. ansonly) {
		cpres = 0;
	}
	else if (ccfg. prg_lang == -1) {
		cres. write_ce((char*)"No code");
		cpres = 1;
	}
	else {
		cpres = compile(ccfg);
		if (cpres == 1)
			cres. write_ce((char*)"Dangerous word!");
	}
	printf("Ret %d\n", cpres);
	if (!cpres) {
		setcolor(32);
		puts("Compile ok");
		judge(ccfg, cres);
	}
	else {
		setcolor(41);
		puts("Compile error!");
		cres. write_ce(0);
	}
	setcolor(0);
}

