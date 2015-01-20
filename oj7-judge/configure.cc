#include "acejudge.h"

prob_cfg :: prob_cfg() {
}

void prob_cfg :: load(char *arg1, char* arg2, char* arg3) {
	char tmpstr[max_path];
	sprintf(tmpstr, "%s/%s.cfg", arg2, arg3);
	FILE* ipf = fopen(tmpstr, "r");
	if (!ipf) {
		return file_wrong();
	}
	else {
		fscanf(ipf, "%s", prob_name);
		fscanf(ipf, "%s%s", prg_in, prg_ou);
		fscanf(ipf, "%s%s", ipt_fmt, opt_fmt);
		fscanf(ipf, "%d%d%d%d", &beg_num, &end_num, &time_lmt, &mem_lmt);
		spj = 0;
		ansonly = 0;
		while (fscanf(ipf, "%s", tmpstr) != EOF)
			if (!strcmp(tmpstr, "spj")) {
				spj = 1;
				fscanf(ipf, "%s", spj_name);
			}
			else if (!strcmp(tmpstr, "ansonly")) {
				ansonly = 1;
			}
		fclose(ipf);
	}
	if (ansonly) {
		sprintf(tmpstr, "%s/%s", arg1, prg_ou);
		strcpy(prg_ou, tmpstr);
	}
	if (spj) {
		sprintf(tmpstr, "./%s/%s", arg2, spj_name);
		strcpy(spj_name, tmpstr);
	}

	strcpy(pid, arg3);
	sprintf(wpath, "%s/.ajtest", arg1);
	if (access(wpath, 0) == -1) {
		mkdir(wpath, 0755);
	}
	sprintf(tmpstr, "%s/%s", arg2, ipt_fmt);
	strcpy(ipt_fmt, tmpstr);
	sprintf(tmpstr, "%s/%s", arg2, opt_fmt);
	strcpy(opt_fmt, tmpstr);

	prg_lang = -1;
	for (int i = 0; i < 3; ++ i) {
		sprintf(prg_name, "%s/%s.%s", arg1, prob_name, lang_suf[i]);
		if (access(prg_name, 0) == 0) {
			prg_lang = i;
			break;
		}
	}
}

