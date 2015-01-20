#ifndef OJ7_REF_H

#define OJ7_REF_H

#include <cstdio>
#include <cstring>
#include <cstdlib>
#include <string>
#include <algorithm>
#include <dirent.h>
#include <unistd.h>

using namespace std;

const int maxu = 1009;
const int maxc = 127;
const int max_str = 256;

struct user {
	string uid, uname, grade;
	int csco[maxc], crk[maxc], tot_c;
	double exp;
	user();
};
struct contest {
	string cid;
	int tot;
};

#endif
