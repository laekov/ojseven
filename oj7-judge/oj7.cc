#include "acejudge.h"
#include "oj7.h"

void prob_res :: init(prob_cfg& pcfg) {
	sprintf(res_fln, "%s/%s.rs", pcfg. wpath, pcfg. pid);
	sprintf(cpl_fln, "%s/compile%s.log", pcfg. wpath, pcfg. pid);
	beg_num = pcfg. beg_num;
	end_num = pcfg. end_num;
	tot_sco = 0;
	memset(jur, 0, sizeof(jur));
	asco = !pcfg. spj;
}

void prob_res :: write_ce(char* info) {
	FILE* pf = fopen(res_fln, "w");
	fputs("CE", pf);
	fclose(pf);
	if (info) {
		pf = fopen(cpl_fln, "w");
		fputs(info, pf);
		fclose(pf);
	}
}

void prob_res :: ref() {
	FILE* pf = fopen(res_fln, "w");
	for (int i = beg_num; i <= end_num; ++ i)
		if (!jur[i])
			fputc('-', pf);
		else
			fputc(jur[i], pf);
	fputc(10, pf);
	if (asco) {
		int ct = 0;
		for (int i = beg_num; i <= end_num; ++ i)
			if (jur[i] == 'A')
				++ ct;
		fprintf(pf, "%d\n", ct * 100 / (end_num - beg_num + 1));
	}
	else {
		fprintf(pf, "%d\n", tot_sco);
	}
	for (int i = beg_num; i <= end_num; ++ i) {
		if (!jur[i])
			fprintf(pf, "Pending ");
		else if (jur[i] == 'A')
			fprintf(pf, "Accepted ");
		else if (jur[i] == 'W')
			fprintf(pf, "Wrong_answer ");
		else if (jur[i] == 'T')
			fprintf(pf, "Time_limit_execeeded ");
		else if (jur[i] == 'M')
			fprintf(pf, "Memory_limit_execeeded ");
		else if (jur[i] == 'R')
			fprintf(pf, "Runtime_error ");
		else if (jur[i] == 'F')
			fprintf(pf, "File_error ");
		fprintf(pf, "%d %d %d\n", rur[i]. time, rur[i]. mem, sco[i]);
	}
	fclose(pf);
}

void prob_res :: set_res(int id, run_res rurs, int scos) {
	rur[id] = rurs;
	sco[id] = scos;
	if (scos > 0)
		jur[id] = 'A';
	else if (rurs. res_num == -1)
		jur[id] = 'T';
	else if (rurs. res_num == -2)
		jur[id] = 'M';
	else if (rurs. res_num == -3)
		jur[id] = 'R';
	else if (rurs. res_num == -4)
		jur[id] = 'F';
	else
		jur[id] = 'W';
	tot_sco += max(0, scos);
	ref();
}

