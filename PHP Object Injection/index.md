## chall2.php
Vulnerabilities Detected:
1. Unserialize call on user input without proper validation.
2. Potential remote code execution vulnerability due to __wakeup() method.

## tarlogic1.php
Vulnerabilities Detected:
1. Unserialize vulnerability: The code is vulnerable to PHP Object Injection attacks due to the use of the unserialize() function.
2. Command Injection vulnerability: The code is vulnerable to command injection attacks due to the use of the system() function.

## chall1.php
Vulnerabilities Detected:
1. Unvalidated user input: The user data is being unserialized without any validation, which could lead to remote code execution.
2. Insecure file operations: The file is being deleted without any validation, which could lead to arbitrary file deletion.

## tarlogic-ex2.php
Vulnerabilities Detected:
1. Unserialize vulnerability: The code is vulnerable to PHP Object Injection attacks due to the use of the unserialize() function.
2. File Inclusion vulnerability: The code is vulnerable to remote file inclusion attacks due to the use of the fopen() function.
3. Access Control vulnerability: The code is vulnerable to access control bypass due to the lack of proper authentication checks.

## tarlogic-ex1.php
Vulnerabilities Detected:
1. Unserialize vulnerability: The code is vulnerable to PHP Object Injection attacks due to the use of the unserialize() function.
2. Insufficient Authorization: The code does not properly check for authorization before granting access to the flag.txt file.

