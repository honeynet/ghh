************
**DELETE THIS FILE WHEN FINISHED
************

Configuration:

Place passwd.txt in your document root

Create the "transparent link" as described in the user manual to passwd.txt.

Change the $ConfigFile variable to the path of your config file.

Change the $SafeReferer variable to the page with the transparent link to passwd.txt

Create an .htaccess file with the following line, and place it in the same folder as the honeypot.
addtype application/x-httpd-php .txt

Delete this README.txt!