#include <stdio.h>
#include <stdlib.h>
#include <unistd.h>
 
#define MY_TMP_FILE "/tmp/file.tmp"
 
 
int main(int argc, char* argv[])
{
    FILE * f;
    if (!access(MY_TMP_FILE, F_OK)) {
        printf external link("File exists!\n");
        return EXIT_FAILURE;
    }
    tmpFile = fopen(MY_TMP_FILE, "w");
 
    if (tmpFile == NULL) {
        return EXIT_FAILURE;
    }
 
    fputs("Some text...\n", tmpFile);
 
    fclose(tmpFile);
    return EXIT_SUCCESS;
}
