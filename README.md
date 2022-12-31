Convert to JUnit XML
===========================

The Convert to JUnit XML is a command line tool that enables you to convert
various input formats to JUnit XML.

Installation
------------

    composer require koenvanmeijeren/convert-to-junit-xml
    php convert-to-junit-xml help

Usage
------
This is an example of how you can use this command.
``` shell
cat <your_file> | php convert-to-junit-xml <converter>
```

Save output
-----------
This is an example of how you can use this command and save the output.
``` shell
cat <your_file> | php convert-to-junit-xml <converter> > <your_file_name>.xml
```
