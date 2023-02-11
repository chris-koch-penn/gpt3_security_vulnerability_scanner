## vuln.c
Vulnerabilities Detected:
1. Unchecked return value: The return value of the fopen() function is not checked, which could lead to a null pointer dereference.
2. Out-of-bounds read: The memcpy() function is used to copy data from img.data to buff1 and buff2 without checking the size of the destination buffer, which could lead to an out-of-bounds read.
3. Out-of-bounds write: The buff3 and buff4 arrays are written to without checking the size of the source buffer, which could lead to an out-of-bounds write.
4. Uninitialized memory access: The OOBR_stack and OOBR_heap variables are accessed without being initialized, which could lead to undefined behavior.
5. Memory leak: The buff4 array is not freed if the size3 variable is greater than 10, which could lead to a memory leak.

