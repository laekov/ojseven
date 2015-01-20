#include "acejudge.h"
#include "oj7.h"

int str_read_int(char* a) {
	int s = 0;
	while (*a && !isdigit(*a))
		++ a;
	if (!*a)
		return -1;
	while (s = s * 10 + *a - 48, isdigit(*(++ a)));
	return s;
}

run_res watch(prob_cfg& pcfg, pid_t pid) {
	run_res ret;
	int status;
	struct rusage ru;
	wait4(pid, &status, 0, &ru);

	ret. time = ru. ru_utime. tv_sec * 1000 + ru. ru_utime. tv_usec / 1000;
	ret. mem = ru. ru_maxrss;

	if (ret. mem > pcfg. mem_lmt * 1024)
		ret. res_num = -2;
	else if (ret. time > pcfg. time_lmt)
		ret. res_num = -1;
	else if (status)
		ret. res_num = -3;
	else
		ret. res_num = 0;
	return ret;
}

run_res run_case(prob_cfg& pcfg, int id) {
	char ifn[max_path], ofn[max_path];
	char od[max_path], arglg[max_path], argrp[max_path];

	if (pcfg. ansonly) {
		sprintf(ofn, pcfg. prg_ou, id);
		//puts(pcfg. prg_ou);
		setcolor(36);
		printf("Test case %d	", id);
		if (access(ofn, 0) == -1)
			return mkres(-4, 0, 0);
		else
			return mkres(0, 0, 0);
	}
	else {
		sprintf(ifn, pcfg. ipt_fmt, id);
		sprintf(arglg, "%s/runtime%s%d.log", pcfg. wpath, pcfg. pid, id);
		sprintf(ofn, pcfg. opt_fmt, id);
		sprintf(od, "cp %s %s/%s", ifn, pcfg. wpath, pcfg. prg_in);
		system(od);

		struct rlimit lmtCPU, lmtMem, lmtN;
		char old_dir[max_path];
		getcwd(old_dir, sizeof(old_dir));

		getrlimit(RLIMIT_CPU, &lmtCPU);
		getrlimit(RLIMIT_AS, &lmtMem);
		run_res ret;

		pid_t pid = fork();

		if (!pid) {
			chdir(pcfg. wpath);
			getcwd(argrp, sizeof(argrp));
			strcat(argrp, "/testtmp");
			//printf("I'm at %s\n", argrp);
			freopen(arglg, "w", stderr);
			lmtN. rlim_cur = pcfg. mem_lmt * 1024 * 1280;
			lmtN. rlim_max = pcfg. mem_lmt * 1024 * 1280;
			setrlimit(RLIMIT_AS, &lmtN);
			lmtN. rlim_cur = (pcfg. time_lmt + 100) / 1000 + 1;
			lmtN. rlim_max = (pcfg. time_lmt + 100) / 1000 + 1;
			setrlimit(RLIMIT_CPU, &lmtN);
			freopen(".in", "r", stdin);
			freopen(".ou", "w", stdout);
			execl(argrp, argrp, (char*)0);
		}
		else {
			setcolor(36);
			printf("Test case %d	", id);
			ret = watch(pcfg, pid);
			//printf("ret = %d", ret. res_num);
		}

		setrlimit(RLIMIT_CPU, &lmtCPU);
		setrlimit(RLIMIT_AS, &lmtMem);
		return ret;
	}
}

int judge_case(prob_cfg& pcfg, int id) {
	char stdi[max_path], stdo[max_path], prgo[max_path], od[max_path];

	sprintf(stdi, pcfg. ipt_fmt, id);
	sprintf(stdo, pcfg. opt_fmt, id);
	if (pcfg. ansonly)
		sprintf(prgo, pcfg. prg_ou, id);
	else
		sprintf(prgo, "%s/%s", pcfg. wpath, pcfg. prg_ou);
	if (pcfg. spj) {
		char full_sco_fln[max_path], sco_fln[max_path];
		sprintf(full_sco_fln, "%s/fullsco%s%d", pcfg. wpath, pcfg. pid, id);
		sprintf(sco_fln, "%s/sco%s%d", pcfg. wpath, pcfg. pid, id);
		FILE* pf = fopen(full_sco_fln, "w");
		fprintf(pf, "%d", 100 / (pcfg. end_num - pcfg. beg_num + 1));
		fclose(pf);
		sprintf(od, "%s %s %s %s %s %s %s/diff%s%d.log", 
				pcfg. spj_name, 
				stdi, 
				prgo, 
				stdo, 
				full_sco_fln, 
				sco_fln, 
				pcfg. wpath, pcfg. pid, id);
		system(od);
		pf = fopen(sco_fln, "r");
		if (!pf)
			return 0;
		int dret;
		fscanf(pf, "%d", &dret);
		fclose(pf);
		return dret;
	}
	else {
		sprintf(od, "oj7-diff Normal %s %s >%s/diff%s%d.log", prgo, stdo, pcfg. wpath, pcfg. pid, id);
		int dret = system(od);
		if (dret == 65280)
			return -4;
		else if (!dret)
			return 100 / (pcfg. end_num - pcfg. beg_num + 1);
		else
			return 0;
	}
}

void clean_test(prob_cfg& pcfg, int id) {
	char od[max_path];
	if (id == -1) {
		sprintf(od, "rm %s/testtmp", pcfg. wpath);
		system(od);
		sprintf(od, "rm %s/.in", pcfg. wpath);
		system(od);
		sprintf(od, "%s/.ou", pcfg. wpath);
		if (access(od, 0) == 0) {
			sprintf(od, "rm %s/.ou", pcfg. wpath);
			system(od);
		}
	}
	else {
		if (!pcfg. ansonly) {
			sprintf(od, "rm %s/%s", pcfg. wpath, pcfg. prg_in);
			system(od);
			sprintf(od, "rm %s/%s", pcfg. wpath, pcfg. prg_ou);
			system(od);
		}
		if (pcfg. spj) {
			sprintf(od, "rm %s/fullsco%s%d", pcfg. wpath, pcfg. pid, id);
			system(od);
			sprintf(od, "rm %s/sco%s%d", pcfg. wpath, pcfg. pid, id);
			system(od);
		}
	}
}

void judge(prob_cfg& pcfg, prob_res& cres) {
	int ca = 0, ct = pcfg. end_num - pcfg. beg_num + 1;
	char mfin[max_path];
	sprintf(mfin, "echo 0 >%s/.in", pcfg. wpath);
	system(mfin);
	//printf("Beg: %d End: %d\n", pcfg. beg_num, pcfg. end_num);
	for (int i = pcfg. beg_num; i <= pcfg. end_num; i ++) {
		run_res res = run_case(pcfg, i);
		if (res. res_num < 0) {
			setcolor(33);
			if (res. res_num == -1)
				puts("Time limit exceeded");
			else if (res. res_num == -2)
				puts("Memory limit exceeded");
			else
				puts("Run time error");
			cres. set_res(i, res, -1);
		}
		else {
			int dres = judge_case(pcfg, i);
			if (dres == -4) {
				res. res_num = -4;
				setcolor(31);
				printf("File Error	");
			}
			else if (!dres) {
				setcolor(31);
				printf("Wrong Answer	");
			}
			else {
				setcolor(32);
				printf("Accepted	");
				ca ++;
			}
			cres. set_res(i, res, dres);
			printf("\33[33mtime: \33[35m%d\33[33m MS	memory: \33[35m%d\33[33m KB\n", res. time, res. mem);
		}
		clean_test(pcfg, i);
	}
	clean_test(pcfg, -1);

	setcolor(34);
	printf("Score: ");
	if (ca == ct)
		setcolor(32);
	else
		setcolor(31);
	printf("%d\n", (int)((double)ca/(double)ct * 100));
	setcolor(0);
}

