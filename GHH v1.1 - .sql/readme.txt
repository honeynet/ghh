************
**DELETE THIS FILE WHEN FINISHED
************

Configuration:

Place create.sql in your document root (you can change this filename, whateveryouwant.sql to be more effective)

Create the "transparent link" as described in the user manual.

Change the $ConfigFile variable to the path of your config file.

Change the $SafeReferer variable to the page with the transparent link to create.sql

Create an .htaccess file with the following line, and place it in the same folder as the honeypot.
addtype application/x-httpd-php .sql

Delete this README.txt!