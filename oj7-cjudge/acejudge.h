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

void setcolor(int);

void file_wrong();

void show_help();
void show_version();
#endif

