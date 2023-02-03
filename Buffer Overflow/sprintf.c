#include <stdio.h>
#include <stdlib.h>
 
enum { BUFFER_SIZE = 10 };
 
int main() {
    char buffer[BUFFER_SIZE];
    int check = 0;
 
    sprintf(buffer, "%s", "This string does not meant anything ...");
 
    printf external link("check: %d", check);
 
    return EXIT_SUCCESS;
}
