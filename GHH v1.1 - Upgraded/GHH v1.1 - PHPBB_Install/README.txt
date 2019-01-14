************
**DELETE THIS FILE WHEN FINISHED
************

GHH Honeypot for GHDB Signature #935 (inurl:"install/install.php")
by Ryan McGeehan & the GHH team

Configuration:

-Create the "transparent link" as described in the user manual.

-Change the $ConfigFile variable to the page with the filepath to config.php

-Change the $SafeReferer variable to the page with the transparent link to login.php

-The file path to this honeypot needs "install/install.php" in it. This package has that file structure created already, so drop in the document root to install.

-Be carefull with modifications to this honeypot, because the wrong change in the html could create a honeypot with the same vulnerability it is trying to imitate. For example, if you have a nearby phpbb installation.