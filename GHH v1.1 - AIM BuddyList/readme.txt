************
**DELETE THIS FILE WHEN FINISHED
************

Configuration:

Place BuddyList in your document root (Change the filename to something you choose, with the .blt extension)

Create the "transparent link" as described in the user manual.

Change the $ConfigFile variable to the path of your config file.

Change the $SafeReferer variable to the page with the transparent link to BuddyList.blt

Create an .htaccess file with the following line, and place it in the same folder as the honeypot.
addtype application/x-httpd-php .blt

Delete this README.txt!