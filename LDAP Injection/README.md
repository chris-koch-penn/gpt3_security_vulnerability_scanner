## example2.asp
Vulnerabilities Detected:
1. Insecure direct object reference: The userName variable is taken directly from the query string without any validation. This could allow an attacker to access data they should not have access to.
2. Insecure use of LDAP: The LDAP server is hardcoded in the code, which could allow an attacker to gain access to the LDAP server.
3. Insecure use of CStr: The CStr function is used to convert the userName variable to a string, which could allow an attacker to inject malicious code.
4. Insecure use of Response.Write: The Response.Write function is used to output data to the user, which could allow an attacker to inject malicious code.

## LDAP.cs
Vulnerabilities Detected:
1. LDAP Injection: The user input is not sanitized and is directly used in the LDAP query, which can lead to LDAP injection attacks. 
2. Unvalidated Redirects and Forwards: The application does not validate the user input before redirecting or forwarding the user to a different page. This can lead to malicious redirects and forwards.

## example1.php
Vulnerabilities Detected:
1. Unsanitized user input: The $_GET['host'] variable is not being sanitized, which could lead to an injection attack.
2. LDAP injection: The $filter variable is not being sanitized, which could lead to an LDAP injection attack.
3. Information disclosure: The $justthese array is not being sanitized, which could lead to information disclosure.

