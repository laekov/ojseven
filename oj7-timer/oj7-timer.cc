#include <cstdio>
#include <cstring>
#include <cstdlib>
#include <ctime>
#include <unistd.h>

int main(int argc, char* args[]) {
	if (argc < 3) {
		puts("args error!");
		return 1;
	}
	char cmd[1000];
	strcpy(cmd, args[2]);
	for (int i = 3; i < argc; ++ i) {
		strcat(cmd, " ");
		strcat(cmd, args[i]);
	}

	int ch, cm, cs, tt;
	sscanf(args[1], "%d:%d:%d", &ch, &cm, &cs);
	tt = ch * 10000 + cm * 100 + cs;
	while (1) {
		time_t ctm(time(0));
		struct tm ct(*localtime(&ctm));
		int et(ct. tm_hour * 10000 + ct. tm_min * 100 + ct. tm_sec);
		printf("%d %d\n", et, tt);
		if (et >= tt) {
			system(cmd);
			return 0;
		}
		else {
			sleep(1);
		}
	}
}

