#include<stdio.h>
#include<string.h>

int maincost=9999999;
char store[100];
int b[100][100];
int initial=-1;
/* Function to swap values at two pointers */
void swap (char *x, char *y)
{
    char temp;
    temp = *x;
    *x = *y;
    *y = temp;
}

/* Function to print permutations of string
   This function takes three parameters:
   1. String
   2. Starting index of the string
   3. Ending index of the string. */
void permute(char *a, int i, int n)
{
    int j;
    if (i == n)
    {
        int l1,cost=0;
        for(l1=1;l1<n;l1++)
        {
            cost=cost+b[(int)a[l1-1]-65][(int)a[l1]-65];
        }
        if(cost<maincost)
        {
            strcpy(store,a);
        }
    }
    else
    {
        for (j = i; j <= n; j++)
        {
            swap((a+i), (a+j));
            permute(a, i+1, n);
            swap((a+i), (a+j)); //backtrack
        }
    }
}

/* Driver program to test above functions */
int main()
{
    int n,i,j;
    char top;
    scanf("%d",&n);
    char a[n+1];
    for(i=0;i<n;i++)
    {
        a[i]=(char)(65+i);
    }
    a[n]='\0';
    for(i=0;i<n;i++)
    {
        for(j=0;j<n;j++)
        {
            scanf("%d",&b[i][j]);
        }
    }
    int d[n];
    for(i=0;i<n;i++)
    {
        scanf("%d",&d[i]);
    }
    int e[100];
    e[1]=3113;
    e[2]=9741;
    e[3]=61284;
    e[4]=24122;
    e[5]=4370;
    e[6]=601;
    e[7]=2323;
    e[8]=11724;
    e[9]=5308;
    e[10]=6918;
    e[11]=10771;
    //scanf("%d",&initial);
    permute(a, 0, n-1);
    FILE *fp1;
    int l1=0;
    fp1 = fopen("out.php","w");
    fprintf(fp1,"<?php\n");
    fprintf(fp1,"$arr1=array();\n");
    fprintf(fp1,"$arr2=array();\n");
    fprintf(fp1,"$count=%d;\n",n-1);
    for(i=1;i<n;i++)
    {
        fprintf(fp1,"$arr1[%d]=%d; $arr2[%d]=%d;\n",l1,e[d[(int)store[i-1]-65]],l1,e[d[(int)store[i]-65]]);
        l1++;
    }
    fprintf(fp1,"?>\n");
    fclose(fp1);
    return 0;
}
