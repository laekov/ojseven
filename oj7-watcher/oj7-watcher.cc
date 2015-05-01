#include <cstdio>
#include <cstdlib>
#include <cstring>
#include <ctime>
#include <unistd.h>
#include <sys/time.h>
#include <sys/resource.h>
#include <sys/wait.h>
#include <sys/stat.h>

char gcmd[1024];

int main(int argc, char* args[]) {
	int pid = fork();
	if (pid)
		return 0;
	if (argc > 1)
		chdir(args[1]);
	else
		chdir("/var/www");
	while (1) {
		if (access("html/.runrequire", 0) > -1) {
			FILE* ipf = fopen("html/.runrequire", "r");
			while (!feof(ipf)) {
				fgets(gcmd, sizeof(gcmd), ipf);
				if (feof(ipf))
					break;
				printf("Received require %s\n", gcmd);
				pid_t pid = fork();
				if (!pid) {
					system(gcmd);
					return 0;
				}
			}
			fclose(ipf);
			system("rm html/.runrequire");
		}
		if (access("html/.judgerequire", 0) > -1) {
			FILE* ipf = fopen("html/.judgerequire", "r");
			while (!feof(ipf)) {
				fgets(gcmd, sizeof(gcmd), ipf);
				if (feof(ipf))
					break;
				printf("Received judge %s\n", gcmd);
				pid_t pid = fork();
				if (!pid) {
					system(gcmd);
					return 0;
				}
				/*else {
					int status;
					struct rusage ru;
					wait4(pid, &status, 0, &ru);
				}*/
			}
			fclose(ipf);
			system("rm html/.judgerequire");
		}

		sleep(1);
	}
}
