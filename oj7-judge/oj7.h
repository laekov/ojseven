#ifndef OJ7_H
#define OJ7_H

#include "acejudge.h"

struct prob_res {
	int beg_num, end_num;
	run_res rur[max_case];
	char jur[max_case];
	int sco[max_case], tot_sco;
	char cpl_fln[max_path], res_fln[max_path];
	bool asco;

	void init(prob_cfg& cfg); 

	void write_ce(char*);
	void ref();
	void set_res(int, run_res, int);
};

#endif
