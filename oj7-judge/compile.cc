#include "acejudge.h"

const char ban_word[3][10] = {"system", "fork", "exec"};

bool check_code(char* fln) {
	FILE* ipf = fopen(fln, "r");
	char tmp[max_line];
	if (!ipf)
		return 1;
	while (!feof(ipf)) {
		fgets(tmp, sizeof(tmp), ipf);
		if (feof(ipf))
			break;
		char* x(strstr(tmp, "//"));
		if (x)
			*x = 0;
		for (int i = 0; i < 3; ++ i)
			if (strstr(tmp, ban_word[i])) {
				fclose(ipf);
				return 1;
			}
	}
	fclose(ipf);
	return 0;
}

int compile_gcc(prob_cfg& pcfg) {
	char od[max_path];
	sprintf(od, "gcc %s -o %s/testtmp 2>%s/compile%s.log", pcfg. prg_name, pcfg. wpath, pcfg. wpath, pcfg. pid);
	int rres = system(od);
	if (rres)
		return 2;
	else
		return 0;
}

int compile_gpp(prob_cfg& pcfg) {
	char od[max_path];
	sprintf(od, "g++ %s -o %s/testtmp 2>%s/compile%s.log", pcfg. prg_name, pcfg. wpath, pcfg. wpath, pcfg. pid);
	int rres = system(od);
	if (rres)
		return 2;
	else
		return 0;
}

int compile_pas(prob_cfg& pcfg) {
	char od[max_path];
	sprintf(od, "fpc %s -o%s/testtmp >%s/compile%s.log", pcfg. prg_name, pcfg. wpath, pcfg. wpath, pcfg. pid);
	int rres = system(od);
	if (rres)
		return 2;
	else
		return 0;
}

int compile(prob_cfg& pcfg) {
	if (check_code(pcfg. prg_name))
		return 1;
	if (pcfg. prg_lang == 0)
		return compile_gcc(pcfg);
	else if (pcfg. prg_lang == 1 || pcfg. prg_lang == 3)
		return compile_gpp(pcfg);
	else if (pcfg. prg_lang == 2)
		return compile_pas(pcfg);
	return 0;
}

