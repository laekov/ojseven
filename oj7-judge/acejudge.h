/*
 * acejudge.h
 * universal header file for acejudge source files
 * containing:
 *		headers
 *		typedefs
 *		consts
 *		global functions
 */

#ifndef ACEJUDGE_H

#define ACEJUDGE_H_VERSION OJ7_3_0

#define ACEJUDGE_H

#include <cstdio>
#include <cstring>
#include <cstdlib>
#include <ctime>
#include <cctype>

#include <algorithm>

#include <termios.h>
#include <unistd.h>
#include <sys/time.h>
#include <sys/resource.h>
#include <sys/wait.h>
#include <sys/stat.h>

using namespace std;

typedef long long qw;
typedef unsigned int uint;
typedef struct {
	int res_num, time, mem;
	//res_num: 0-ok -1-tle -2-mle -3-re -4-fe
} run_res;
run_res mkres(int, int, int);

const int max_path = 256;
const int max_line = 1024;
const int max_case = 1024;
const char lang_suf[4][4] = {"c", "cpp", "pas", "cc"};

struct prob_cfg {
	char pid[max_path], wpath[max_path], prob_name[max_path];

	char prg_in[max_path], prg_ou[max_path];
	char ipt_fmt[max_path], opt_fmt[max_path];

	char prg_name[max_path];
	int prg_lang;

	char spj_name[max_path];
	bool spj;
	bool ansonly;

	int beg_num, end_num;
	int time_lmt, mem_lmt;

	bool co2;

	prob_cfg();
	void load(char*, char*, char*);
};

void setcolor(int);

void file_wrong();

int compile(prob_cfg&);

void show_help();
void show_version();
#endif

