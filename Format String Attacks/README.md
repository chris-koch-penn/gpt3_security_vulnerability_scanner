## vuln.c
Vulnerabilities Detected:
1. Unchecked return value of fopen() - The return value of fopen() is not checked, which could lead to a segmentation fault if the file is not found.
2. Unchecked return value of system() - The return value of system() is not checked, which could lead to unexpected behavior if the command fails.
3. Unbounded read of user input - The user input is read into a fixed-size buffer, which could lead to a buffer overflow if the user input is too long.
4. Unchecked return value of malloc() - The return value of malloc() is not checked, which could lead to unexpected behavior if the memory allocation fails.
5. Unchecked return value of scanf() - The return value of scanf() is not checked, which could lead to unexpected behavior if the user input is invalid.

## FormatString.c
Vulnerabilities Detected:
1. Unvalidated user input: The program does not check the length of the user input, which could lead to a buffer overflow attack.
2. Format string vulnerability: The program does not check the format of the user input, which could lead to a format string attack.

