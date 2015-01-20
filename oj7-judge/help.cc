#include "acejudge.h"

const char help_text[] = "\
oj7-judge <player code dir> <data file dir> <problem id>[-help] [-version] \n\
";

void show_help() {
	setcolor(0);
	puts(help_text);
}

const char version_text[] = "\
\33[30m\33[42mAce Judge for oj7\33[0m \33[0mV3.0 Beta1 \33[35m(Released 01/11 2015) \n\
			\33[34mby CDQZ_\33[31ml\33[32ma\33[33me\33[34mk\33[35mo\33[36mv\33[0m \
";

void show_version() {
	setcolor(0);
	puts(version_text);
}
