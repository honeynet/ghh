************
**DELETE THIS FILE WHEN FINISHED
************

Configuration:

Place admin.mdb in your document root

Create the "transparent link" as described in the user manual.

Change the $ConfigFile variable to the path of your config file.

Change the $SafeReferer variable to the page with the transparent link to admin.mdb

Create an .htaccess file with the following line, and place it in the same folder as the honeypot.
addtype application/x-httpd-php .mdb

Delete this README.txt!