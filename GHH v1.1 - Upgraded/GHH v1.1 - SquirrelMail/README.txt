************
**DELETE THIS FILE WHEN FINISHED
************

GHH Honeypot for GHDB Signature #1013 ("SquirrelMail version 1.4.4" inurl:src ext:php)
by Ryan McGeehan & the GHH team

Configuration:

-Create the "transparent link" as described in the user manual.

-In the configuration section of login.php, change the $ConfigFile variable to the page with the filepath to config.php

-Change the $SafeReferer variable to the page with the transparent link to login.php

-Change $MailSystemName to a "Organization name" or your actual organization name. This will be output to the attacker.

-The file path to this honeypot needs "src" in it. This package has that file structure created already, so drop in the src folder to install.

-In the login.php file, you'll see a "Begin Custom Honeypot" Section, which is where moreconfiguration is done.

