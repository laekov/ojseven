#include<iostream>
#include<cstdio>
#include<cstring>
#include<algorithm>
#include<fstream>
#include<cmath>
using namespace std;
FILE *Log;
bool ignore_space=true;
int StrScanf(FILE *Data,FILE *Text,char *str1,char *str2,int &Row,int &Rownow)
{
	int res1=0,res2=0,res0;
	int t1=0,t2=0;
	char ch1,ch2;
	while (ch1=(char)fgetc(Data),(ch1==' ' || ch1=='\r' || ch1=='\n') && ch1!=-1)t1=(ch1=='\n')?0:t1+1;
	while (ch2=(char)fgetc(Text),(ch2==' ' || ch2=='\r' || ch2=='\n') && ch2!=-1)t2=(ch2=='\n')?0:t2+1;
	if (ch1==-1)
	{
		if (ch2==-1)return -1;
		while (ch2=(char)fgetc(Text),(ch2==' ' || ch2=='\r' || ch2=='\n') && ch2!=-1)res2+=ch2=='\n';
		if (ch2==-1)return -1;
	}else if (ch2==-1)
	{
		if (ch1==-1)return -1;
		while (ch1=(char)fgetc(Data),(ch1==' ' || ch1=='\r' || ch1=='\n') && ch1!=-1)res1+=ch1=='\n';
		if (ch1==-1)return -1;
		fprintf(Log,"Presentation Error! At Line %d.\n",Row);
		return -2;
	}
	if (t1!=t2)
	{
		fprintf(Log,"Differences found! At Line %d.\n",Row);
		return -2;
	}
	*(str1++)=ch1;
	*(str2++)=ch2;
	Rownow=Row;
	while (*(str1++)=(char)fgetc(Data),*(str1-1)!=' ' && ch1!='\r' && *(str1-1)!='\n');
	res1+=*(str1-1)=='\n';
	while (*(str2++)=(char)fgetc(Text),*(str2-1)!=' ' && ch2!='\r' && *(str2-1)!='\n');
	res2+=*(str2-1)=='\n';

	res0=*(str2-1)=='\n';
	Row+=res1;
	while (*(str1-1)=='\n' || *(str1-1)=='\r' || *(str1-1)==' ')*(--str1)='\0';
	while (*(str2-1)=='\n' || *(str2-1)=='\r' || *(str2-1)==' ')*(--str2)='\0';
	while (res1<res2)
	{
		ch1=(char)fgetc(Data);
		if (ch1=='\n')res1++;
		if (ch1==-1 || (ch1!='\n' && ch1!=' ' && ch1!='\r'))
		{
			char tmp[10];
			fgets(tmp,sizeof(tmp),Data);
			fprintf(Log,"Line %d: Read <eoln> ,but expect %c%s\n",Row,ch1,tmp);
			return -2;
		}
	}
	while (res1>res2)
	{
		ch2=(char)fgetc(Text);
		if (ch2=='\n')res2++;
		if (ch2==-1 || (ch2!='\n' && ch2!=' ' && ch2!='\r'))
		{
			fprintf(Log,"Presentation Error!\n");
			return -2;
		}
	}
	if (res1!=res2)
	{
		fprintf(Log,"Presentation Error!\n");
		return -2;
	}
	return res0;
}
int main(int argc,const char *argv[])
{
	int i;
	FILE *Data,*Text;
	//Log=fopen("/home/toby/Program/log.txt","w");
	Log=fopen("log.txt","w");
	fprintf(Log,"Load %d parameters\n",argc);
	if (argc<2)
	{
		fprintf(Log,"The parameters are not enough.\n");
		fclose(Log);
		return 1;
	}
	fprintf(Log,"LoadFile:%s..\n",argv[1]);
	if ((Data=fopen(argv[1],"r"))==NULL)
	{
		fprintf(Log,"Cannot find file:%s\n",argv[1]);
		cout<<"File<"<<argv[1]<<"> could not found.\n";
		fclose(Log);
		return 1;
	}
	fprintf(Log,"LoadFile:%s..\n",argv[2]);
	if ((Text=fopen(argv[2],"r"))==NULL)
	{
		fprintf(Log,"Cannot find file:%s\n",argv[2]);
		cout<<"File<"<<argv[2]<<"> could not found.\n";
		fclose(Log);
		fclose(Data);
		return -1;
	}
	for (i=2;i<argc;i++)
	{
		if (!strcmp(argv[i],"-space"))
		{
			ignore_space=true;
		}else if (!strcmp(argv[i],"-full"))
		{
			ignore_space=false;
		}
	}
	char str1[10000],str2[10000];
	if (argc>3 && strstr(argv[3],"-real"))
	{
		int Rowid=1,Rownow;
		fprintf(Log,"Real Number Mode..\n");
		long double eps;
		sscanf(argv[3],"-real-%Lf",&eps);
		unsigned int l1,l2;
		int t;
		while (true)
		{
			t=StrScanf(Data,Text,str1,str2,Rowid,Rownow);
			if (t==-1)
			{
				fprintf(Log,"Okay,No difference found.\n");
				fclose(Log);
				fclose(Data);
				fclose(Text);
				return 0;
			}else if (t==-2)
			{
				fclose(Log);
				fclose(Data);
				fclose(Text);
				return 1;
			}
			l1=(unsigned)strlen(str1);
			l2=(unsigned)strlen(str2);
			bool isReal=true;
			for (unsigned i=0;i<l1;i++)
				if (str1[i]!='.' && (str1[i]<'0' || str1[i]>'9'))
					isReal=false;
			for (unsigned i=0;i<l2;i++)
				if (str2[i]!='.' && (str2[i]<'0' || str2[i]>'9'))
					isReal=false;
			bool sameFlag=true;
			if (!isReal)
			{
				if (l1!=l2)sameFlag=false;
				if (sameFlag)
				{
					for (unsigned i=0;i<l1;i++)
						if (str1[i]!=str2[i])
							sameFlag=false;
				}
				if (!sameFlag)
				{
					fprintf(Log,"Line #%d, Read %s ,but expect %s",Rowid,str1,str2);
					cout<<"Line #"<<Rowid-t<<", Read "<<str1<<", but expect "<<str2<<endl;
					fclose(Log);
					fclose(Data);
					fclose(Text);

					return 1;
				}
			}else
			{
				long double a,b;
				sscanf(str1,"%Lf",&a);
				sscanf(str2,"%Lf",&b);
				if (abs(a-b)>eps)
				{
					fprintf(Log,"Line #%d: Read %s ,but expect %s",Rowid,str1,str2);
					cout<<"Line #"<<Rownow<<", Read "<<str1<<", but expect "<<str2<<endl;
					fclose(Log);
					fclose(Data);
					fclose(Text);
					return 1;
				}
			}
		}
	}else if (argc>3 && !strcmp(argv[3],"-full"))
	{
		fprintf(Log,"Line by Line Mode..\n");
		int Rowid=0;
		while (fgets(str1,sizeof(str1),Data))
		{
			Rowid++;
			fgets(str2,sizeof(str2),Data);
			if (strcmp(str1,str2))
			{
				fprintf(Log,"Line #%d: Read %s, but expect %s\n",Rowid,str1,str2);
				printf("Line #%d: Read %s, but expect %s\n",Rowid,str1,str2);
				fclose(Log);
				fclose(Data);
				fclose(Text);
				return 1;
			}
		}
		fprintf(Log,"Okay,No difference found.\n");
		fclose(Log);
		fclose(Data);
		fclose(Text);
		return 0;

	}else
	{
		fprintf(Log,"Normal Mode..\n");
		int Rowid=0;
		while (fgets(str1,sizeof(str1),Data))
		{
			Rowid++;
			if (!fgets(str2,sizeof(str2),Text))
			{
				do
				{
					unsigned l1=(unsigned)strlen(str1);
					while (l1 && (str1[l1-1]==' ' || str1[l1-1]=='\n' || str1[l1-1]=='\r'))str1[--l1]='\0';
					if (l1)
					{
						strcpy(str2,"<empty line>");
						fprintf(Log,"Line #%d: Read %s, but expect %s\n",Rowid,str2,str1);
						printf("Line #%d: Read %s, but expect %s\n",Rowid,str2,str1);
						fclose(Log);
						fclose(Data);
						fclose(Text);
						return 1;

					}
				}while (~fscanf(Data,"%s",str1));
				fprintf(Log,"Okay,No difference found.\n");
				printf("Okay,No difference found.\n");
				fclose(Log);
				fclose(Data);
				fclose(Text);
				return 0;
			}
			unsigned l1=(unsigned)strlen(str1);
			unsigned l2=(unsigned)strlen(str2);
			while (l1 && (str1[l1-1]==' ' || str1[l1-1]=='\n'|| str1[l1-1]=='\r'))str1[--l1]='\0';
			while (l2 && (str2[l2-1]==' ' || str2[l2-1]=='\n'|| str2[l2-1]=='\r'))str2[--l2]='\0';
			if (strcmp(str1,str2))
			{
				if (!l1)strcpy(str1,"<empty line>");
				if (!l2)strcpy(str2,"<empty line>");
				fprintf(Log,"Line #%d: Read %s, but expect %s\n",Rowid,str2,str1);
				printf("Line #%d: Read %s, but expect %s\n",Rowid,str2,str1);
				fclose(Log);
				fclose(Data);
				fclose(Text);
				return 1;
			}
		}
		while (fgets(str2,sizeof(str2),Text))
		{
			unsigned l2=(unsigned)strlen(str2);
			while (l2 && (str2[l2-1]==' ' || str2[l2-1]=='\n' || str2[l2-1]=='\r'))str2[--l2];
			if (l2)
			{
				strcpy(str1,"<empty line>");
				fprintf(Log,"Line #%d: Read %s\n, but expect %s\n",Rowid,str2,str1);
				printf("Line #%d: Read %s\n, but expect %s\n",Rowid,str2,str1);
				fclose(Log);
				fclose(Data);
				fclose(Text);
				return 1;

			}
		}
		fprintf(Log,"Okay,No difference found.\n");
		fclose(Log);
		fclose(Data);
		fclose(Text);
		return 0;
	}
}
