#ifndef CONT_H
#define CONT_H

struct user {
	char *uid;
	int sco[6], tot_sco;

	user();
};

bool cmpUser(const user& a, const user& b);

int getcid();

#endif

