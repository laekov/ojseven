#include "acejudge.h"

run_res mkres(int res, int time, int mem) {
	run_res r;
	r. res_num = res;
	r. time = time;
	r. mem = mem;
	return r;
}

/*color list:
 * 30 : gray
 * 31 : red
 * 32 : green
 * 33 : yellow
 * 34 : blue
 * 35 : purple
 * 36 : olive
*/
void setcolor(int x) {
	static int now_color = 0, prv_color;
	if (x == -1) {
		swap(now_color, prv_color);
	}
	else {
		prv_color = now_color;
		now_color = x;
	}
	printf("\33[%dm", now_color);
}
bool is_letter(int x) {
	return (x > 64 && x < 92) || (x > 96 && x < 124);
}

void file_wrong() {
	//setcolor(31);
	puts("Wrong file");
}
