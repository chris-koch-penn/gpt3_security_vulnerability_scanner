# Experimenting with GPT-3 for Detecting Security Vulnerabilities in Code
**Summary**: GPT-3 found 213 security vulnerabilities in this [git repository](https://github.com/chris-koch-penn/gpt3_security_vulnerability_scanner). In comparison, one of the better commercial tools on the market (from a reputable cybersecurity company) only found 99 issues, although their tool provides context in a more structured format. After manually reviewing a random sample of 60 / 213 of the vulnerabilities detected by GPT-3, only 4 were false positives. Both tools had many false negatives.
The full text of this README is available as a Medium article [here](https://betterprogramming.pub/i-used-gpt-3-to-find-213-security-vulnerabilities-in-a-single-codebase-cc3870ba9411).

## Introduction
In recent years, the field of artificial intelligence and machine learning has seen tremendous growth and has opened up a new realm of possibilities. One such field that has been gaining attention is AI-based code analysis, specifically the use of AI models to detect security vulnerabilities in code. In this experiment, we used OpenAI's GPT-3 to find security vulnerabilities in a [code repository](https://github.com/chris-koch-penn/gpt3_security_vulnerability_scanner) containing 129 vulnerable files.

## How it Works
The variant of GPT-3 I used (text-davinci-003) has a context window of 4000 tokens, which is roughly 3000 english words. This means it can process at most a few hundred lines of code per request. Unfortunately, GPT-3’s current architecture can’t handle a whole repo at once.

To get around this, I had to scan all of the files with GPT-3 separately. This means GPT-3 might have trouble finding security vulnerabilities that are the result of multiple files of code interacting, unless the import/exports are clear enough to make a guess as to what those functions do without needing to specifically see the code. This ended up often being the case, particularly when the source code was using common libraries like express.js, Flask, the Python standard library, the C standard library, etc. It’s likely that GPT-3 has many of the most common libraries either partially memorized, fully memorized, or encoded in some other way. In the case of the code analyzed in this article, GPT-3 had enough prior knowledge about the imported libraries that it was able to accurately detect security vulnerabilities without needing to inspect any of the imported library code.

To be fair to GPT-3, I suspect that many of the existing commercial vulnerability scanners don’t actually inspect imported library code when doing static analysis — so this is not that different from how some of the tools on the market already work.

### The code that was analyzed
Each folder in the repository is named after a type of security vulnerability and contains files with example code containing one or more vulnerabilities. Some of these files contain trivial code, but many are fairly realistic code snippets you might come across in a production code base (note: they are still snippets though, and therefore lack the context of a larger codebase). The README.md file in each folder of the repository contains GPT-3’s analysis of the security vulnerabilities for all of the files in that folder.

Let’s take a look at some examples to see how GPT-3 did!

### Example 1 (trivial)
Here is a [simple C program](https://github.com/chris-koch-penn/gpt3_security_vulnerability_scanner/blob/main/Format%20String%20Attacks/FormatString.c) that is vulnerable to a Format String Attack:

```c
#include <stdio.h>
 
int main(int argc, char **argv) {
    printf(argv[1]);
 
    return 0;
}
```

And here is GPT-3's analyis (which is correct):
```md
Vulnerabilities Detected:
1. Unvalidated user input: The program does not check the length of the user input, which could lead to a buffer overflow attack.
2. Format string vulnerability: The program does not check the format of the user input, which could lead to a format string attack.
```

### Example 2 (less trivial)
Let's try this with a less trivial program in a higher level language, like this [C# program](https://github.com/chris-koch-penn/gpt3_security_vulnerability_scanner/blob/main/Log%20Forging/logf.cs) containing a Log Forging vulnerability. I've personally seen similar (although less trivial) code in open-source projects and production code bases:

```csharp
using Microsoft.AspNetCore.Http;
using Microsoft.AspNetCore.Mvc;
using Microsoft.Extensions.Logging;
using System;
using System.Collections.Generic;
using System.Linq;
using System.Threading.Tasks;

namespace WebFox.Controllers
{
    [Route("api/[controller]")]
    [ApiController]
    public class LogInjection : ControllerBase
    {
        private readonly ILogger<LogInjection> _logger;


        public LogInjection(ILogger<LogInjection> logger)
        {
            _logger = logger;
        }

        [HttpGet("{userInfo}")]
        public void injectLog(string userInfo)
        {
            _logger.LogError("error!! " + userInfo);
        }
    }
}
```

GPT-3's output:
```md
Vulnerabilities Detected:
1. Log injection vulnerability: The code is vulnerable to log injection attacks as user input is being directly logged without any sanitization.
```
GPT-3's evaluation is correct - there is a log injection vulnerability in this code.

### Example 3 (non-trivial)
The following [C program](https://github.com/chris-koch-penn/gpt3_security_vulnerability_scanner/blob/main/Out%20of%20Bounds/vuln.c) reads and manipulates an image. It contains numerous security vulnerabilities, including Out Of Bounds reads and writes:

```c
#include<stdio.h>
#include<stdlib.h>
#include<string.h>

struct Image
{
    char header[4];
    int width;
    int height;
    char data[10];
};

int ProcessImage(char* filename){

    FILE *fp;
    char ch;
    struct Image img;

    fp = fopen(filename,"r"); 

    if(fp == NULL)
    {
        printf("\nCan't open file or file doesn't exist.");
        exit(0);
    }

    printf("\n\tHeader\twidth\theight\tdata\t\r\n");

    while(fread(&img,sizeof(img),1,fp)>0){
        printf("\n\t%s\t%d\t%d\t%s\r\n",img.header,img.width,img.height,img.data);
    
        int size1 = img.width + img.height;
        char* buff1=(char*)malloc(size1);

        memcpy(buff1,img.data,sizeof(img.data));
        free(buff1);
    
        if (size1/2==0){
            free(buff1);
        }
        else{
            if(size1 == 123456){
                buff1[0]='a';
            }
        }

        int size2 = img.width - img.height+100;
        //printf("Size1:%d",size1);
        char* buff2=(char*)malloc(size2);

        memcpy(buff2,img.data,sizeof(img.data));

        int size3= img.width/img.height;
        //printf("Size2:%d",size3);

        char buff3[10];
        char* buff4 =(char*)malloc(size3);
        memcpy(buff4,img.data,sizeof(img.data));

        char OOBR_stack = buff3[size3+100];
        char OOBR_heap = buff4[100];

        buff3[size3+100]='c';
        buff4[100]='c';

        if(size3>10){
                buff4=0;
        }
        else{
            free(buff4);
        }

        free(buff2);
    }
    fclose(fp);
}

int main(int argc,char **argv)
{
    ProcessImage(argv[1]);
}
```

GPT-3's output:
```md
Vulnerabilities Detected:
1. Unchecked return value: The return value of the fopen() function is not checked, which could lead to a null pointer dereference.
2. Out-of-bounds read: The memcpy() function is used to copy data from img.data to buff1 and buff2 without checking the size of the destination buffer, which could lead to an out-of-bounds read.
3. Out-of-bounds write: The buff3 and buff4 arrays are written to without checking the size of the source buffer, which could lead to an out-of-bounds write.
4. Uninitialized memory access: The OOBR_stack and OOBR_heap variables are accessed without being initialized, which could lead to undefined behavior.
5. Memory leak: The buff4 array is not freed if the size3 variable is greater than 10, which could lead to a memory leak.
```
GPT-3 is correct for 4 out of 5 of these. Vulnerability 1 is a false positive as the value of fopen() is checked in the line if(fp == NULL). Also, vulnerability 4 is worded in a way that is misleading - it is correct that there are two uninitialized memory access bugs on the lines of code that it is referencing, but it mentions the wrong variable names.

### Example 4
This last [Java example](https://github.com/chris-koch-penn/gpt3_security_vulnerability_scanner/blob/main/Unsafe%20Deserialization/SerializeToFile.java) is my favorite because, unfortunately, I didn't see anything wrong with this code when I first read it. To me, it looked completely innocuous and *familiar* - I've seen similar code in the wild but never had any second thoughts.

```java
class Utils
{
    // Function to serialize an object and write it to a file
    public static void SerializeToFile(Object obj, String filename)
    {
        try
        {
            FileOutputStream file = new FileOutputStream(filename);
            ObjectOutputStream out = new ObjectOutputStream(file);

            // Serialization of the object to file
            System.out.println("Serializing " + obj.toString() + " to " + filename);
            out.writeObject(obj);

            out.close();
            file.close();
        }
        catch(Exception e)
        {
            System.out.println("Exception: " + e.toString());
        }
    }

    // Function to deserialize an object from a file
    public static Object DeserializeFromFile(String filename)
    {
        Object obj = new Object();

        try
        {
            FileInputStream file = new FileInputStream(filename);
            ObjectInputStream in = new ObjectInputStream(file);

            // Deserialization of the object to file
            System.out.println("Deserializing from " + filename);
            obj = in.readObject();

            in.close();
            file.close();
        }
        catch(Exception e)
        {
            System.out.println("Exception: " + e.toString());
        }

        return obj;
    }
}
```

GPT-3's output:
```md
Vulnerabilities Detected:
1. Insecure Deserialization: Deserializing untrusted data can lead to remote code execution.
2. Insecure File Permissions: The file being written to or read from may have insecure permissions, allowing unauthorized access.
```

GPT-3 is correct again.

### The Ultimate "Shift-left" in Cybersecurity
Shifting-left is the process of applying security practices earlier in the development process - like testing for security bugs before deploying your code to production.

AI code-analysis could represent the ultimate shift-left in cybersecurity by applying best security practices and educating developers on cybersecurity as they are *writing and committing code*. This could truly foster a culture of strong cybersecurity inside an organization and even prevent the next big hack, but... 

Admittedly, the technology is not perfect yet and there are several things it missed that an experienced cybersecurity professional doing an audit would not have missed. Still, it's shockingly good for being a general-purpose large language model and it's far cheaper than the alternatives.

GPT-4 doesn't currently have a release date, but I'm sure these large language models will continue to march forward as they gain more and more capabilities. 

### The False Positive
After manually reviewing around 60 out of 213 of the vulnerabilities detected by GPT-3, one of the false positives I found that was notable was on line 13 of this [Javascript program](https://github.com/chris-koch-penn/gpt3_security_vulnerability_scanner/blob/main/Unsafe%20Deserialization/unsafe.js):
```js
var express = require('express');
var cookieParser = require('cookie-parser');
var escape = require('escape-html');
var serialize = require('node-serialize');
var app = express();
app.use(cookieParser())
 
app.get('/', function(req, res) {
 if (req.cookies.profile) {
   var str = new Buffer(req.cookies.profile, 'base64').toString();
   var obj = serialize.unserialize(str);
   if (obj.username) {
     res.send("Hello " + escape(obj.username)); // <--- GPT-3 makes a mistake here
   }
 } else {
     res.cookie('profile', "eyJ1c2VybmFtZSI6ImFqaW4iLCJjb3VudHJ5IjoiaW5kaWEiLCJjaXR5IjoiYmFuZ2Fsb3JlIn0=", {
       maxAge: 900000,
       httpOnly: true
     });
 }
 res.send("Hello World");
});
app.listen(3000);
```
GPT-3's output:
```md
Vulnerabilities Detected:
- Insecure cookie settings (no secure flag set)
- Unvalidated deserialization of user input (cookie)
- Potential XSS vulnerability due to lack of escaping of user input (username)
```
GPT-3 is correct about the first two vulnerabilities, but the third vulnerability is a false positive - `obj.username` is escaped, but GPT-3 is saying that it is not.

## Results
The results of the experiment showed that GPT-3 was able to detect security vulnerabilities in 85 out of 129 files scanned. This is quite impressive!

The script [`summarize_results.py`](summarize_results.py) generates a summary of GPT-3's results:
```
Vulnerabilities detected in 86 / 129 files.
Detected 213 vulnerabilities in total.

Frequency of introductory sentences used in GPT-3's responses (1 response / file scanned):
{'vulnerabilities detected': 73, 'no vulnerabilities detected.': 43, 'vulnerability detected': 6, 'answer': 2, 'potential vulnerabilities detected': 2, 'analysis': 1, 'security vulnerabilities detected': 1, 'no response given': 1} 

Distribution of file types scanned: 
129 files of code in total (excluding markdown and flatfiles)
{'.php': 50, '.js': 20, '.cs': 16, '.c': 14, '.java': 9, '.py': 8, '.rb': 5, '.asp': 3, '.ts': 2, '.go': 1, '.html': 1}
```

### Comparison to Commercial Offerings
To round out this experiment, I compared the results of GPT-3 with a commercially available code vulnerability scanner, [Snyk Code](https://snyk.io/product/snyk-code/), which is made by Snyk - a company which I think makes excellent security products. After running this repo through Snyk Code, it found 99 security vulnerabilities compared to the 213 found by GPT-3. 

![Snyk's results](https://github.com/chris-koch-penn/gpt3_security_vulnerability_scanner/blob/main/snyk-results.png)

One contributing factor is that Snyk Code only supports certain programming languages, and was only able to scan around 103 files compared to the 129 files scanned by GPT-3.

### Final Notes
If you're interested in seeing this experiment become a full product, express interest through this super short [Google Form](https://forms.gle/mXy8NVZb5fshqCAt6).

The vulnerable code snippets in this repo were taken from [snoopysecurity/Vulnerable-Code-Snippets](https://github.com/snoopysecurity/Vulnerable-Code-Snippets), which is a fantastic resource. I tried to remove any comments embedded in the code snippets that hinted at what security vulnerabilities were contained in that snippet. This required me to remove comments containing links to blog posts and articles that these example snippets were gathered from. Any attributions present in the original repo can be found in the [attributions.md](https://github.com/chris-koch-penn/gpt3_security_vulnerability_scanner/blob/main/attributions.md) file.
