#include "acejudge.h"

const int ban_word_count = 5;
const char ban_word[ban_word_count][21] = {"system", "fork", "exec", "upasswd", "attribute"};

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
		for (int i = 0; i < ban_word_count; ++ i)
			if (strstr(tmp, ban_word[i])) {
				fclose(ipf);
				return 1;
			}
		//if (strstr(tmp, "#include") && strstr(tmp, "\""))
			//return 1;
	}
	fclose(ipf);
	return 0;
}

int compile_gcc(prob_cfg& pcfg) {
	char od[max_path];
	if (pcfg.co2)
		sprintf(od, "gcc %s -o %s/testtmp%s 2>%s/compile%s.log -O2", pcfg. prg_name, pcfg. wpath, pcfg. prob_name, pcfg. wpath, pcfg. pid);
	else
		sprintf(od, "gcc %s -o %s/testtmp%s 2>%s/compile%s.log", pcfg. prg_name, pcfg. wpath, pcfg. prob_name, pcfg. wpath, pcfg. pid);
	int rres = system(od);
	if (rres)
		return 2;
	else
		return 0;
}

int compile_gpp(prob_cfg& pcfg) {
	char od[max_path], tmpstr[max_path];
	sprintf(od, "g++ %s -o %s/testtmp%s 2>%s/compile%s.log", pcfg. prg_name, pcfg. wpath, pcfg. prob_name, pcfg. wpath, pcfg. pid);
	if (pcfg.co2) {
		strcat(od, " -O2");
	}
	if (pcfg.intact) {
		strcat(od, " -I ");
		strcat(od, pcfg.libpath);
	}
	else

	puts(od);
	int rres = system(od);
	if (rres)
		return 2;
	else
		return 0;
}

int compile_pas(prob_cfg& pcfg) {
	char od[max_path];
	if (pcfg.co2)
		sprintf(od, "fpc %s -o%s/testtmp%s >%s/compile%s.log -O2", pcfg. prg_name, pcfg. wpath, pcfg. prob_name, pcfg. wpath, pcfg. pid);
	else
		sprintf(od, "fpc %s -o%s/testtmp%s >%s/compile%s.log", pcfg. prg_name, pcfg. wpath, pcfg. prob_name, pcfg. wpath, pcfg. pid);
	int rres = system(od);
	if (rres)
		return 2;
	else
		return 0;
}

int compile(prob_cfg& pcfg) {
	if (pcfg. prg_lang == -1)
		return 1;
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

