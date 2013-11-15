#include<stdio.h>

#define cbt 1
#define bm 2
#define c 3
#define g 4
#define nzp 5
#define sjm 6
#define hs 7
#define kt 8
#define gvk 9
#define im 10
#define rfc 11

int main()
{
    int n,i,j,initial;
    FILE *fp1;
    fp1=fopen("input_algo.txt","r");
    FILE *fp;
    fp = fopen("actualdata.txt","r");
    int b[12][12];
    for(i=1;i<12;i++)
    {
        for(j=1;j<12;j++)
        {
            fscanf(fp,"%d",&b[i][j]);
        }
    }
    fclose(fp);


    int l,count=1;
    int a[15];
    while(scanf("%d",&l)!=EOF)
    {
        a[count]=l;
        count++;
    }
    fclose(fp1);
    //FILE *fp1;
    fp1=fopen("output.txt","w");
    n=count-1;
    fprintf(fp1,"%d\n",n);
    for(i=1;i<=n;i++)
    {
        for(j=1;j<=n;j++)
        {
            if(j!=n)
            {
                fprintf(fp1,"%d ",b[a[i]][a[j]]);
            }
            else
            {
                fprintf(fp1,"%d\n",b[a[i]][a[j]]);
            }
        }
    }
    for(i=1;i<=n;i++)
    {
        if(i!=n)
        {
            fprintf(fp1,"%d ",a[i]);
        }
        else
        {
            fprintf(fp1,"%d\n",a[i]);
        }
    }
    fclose(fp1);
    return 0;
}
