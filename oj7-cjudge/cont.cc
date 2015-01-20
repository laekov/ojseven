#include "acejudge.h"
#include "cont.h"

user :: user() {
	for (int i = 0; i < 3; ++ i)
		sco[i] = 0;
	tot_sco = 0;
}

bool cmpUser(const user& a, const user& b) {
	return a. tot_sco > b. tot_sco;
}

int getcid() {
	FILE* pf = fopen("conf/cont.conf", "r");
	if (!pf)
		return 0;
	int x;
	fscanf(pf, "%d", &x);
	fclose(pf);
	return x;
}
