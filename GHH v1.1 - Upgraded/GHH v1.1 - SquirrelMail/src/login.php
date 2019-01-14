<?php
/////////////////////////////////////////////////////////
//Google Hack Honeypot v1.1
//Template File
//http://ghh.sourceforge.net - many thanks to SourceForge
/////////////////////////////////////////////////////////
//Copyright (C) 2005 GHH Project
//
//This program is free software; you can redistribute it and/or modify 
//it under the terms of the GNU General Public License as published by 
//the Free Software Foundation; either version 2 of the License, or 
//(at your option) any later version.
//
//This program is distributed in the hope that it will be useful, 
//but WITHOUT ANY WARRANTY; without even the implied warranty of MERCHANTABILITY 
//or FITNESS FOR A PARTICULAR PURPOSE. See the GNU General Public License 
//for more details.
//
//You should have received a copy of the GNU General Public License along 
//with this program; if not, write to the 
//Free Software Foundation, Inc., 
//59 Temple Place, Suite 330, 
//Boston, MA 02111-1307 USA
////////////////////////////////////////////////////////

////////////////////////////////////////////////////////
//Begin Configuration Section
////////////////////////////////////////////////////////

//Enter the path to the GHH global configuration file
$ConfigFile = '';
//Enter the URL of the page that links to this honeypot (I.E http://yourdomain.com/forums/index.php, Wherever you put your transparent link to the honeypot.)
$SafeReferer = '';

////////////////////////////////////////////////////////
//End Configuration Section
////////////////////////////////////////////////////////

////////////////////////////////////////////////////////
//Housekeeping Section
//Include config, disable the header protection, init variables, stealth the errors.
////////////////////////////////////////////////////////
error_reporting(0);
$Honeypot = true;
include($ConfigFile);
////////////////////////////////////////////////////////
//End housekeeping section
////////////////////////////////////////////////////////

//Attack Acquisition Section
$Attack = getAttacker();

//Determine Standard Signatures
$Signature = standardSigs($Attack, $SafeReferer);

////////////////////////////////////////////////////////
//Begin Custom Honeypot Section
//GHH Honeypot by Ryan McGeehan for GHDB Signature #1013 ("SquirrelMail version 1.4.4" inurl:src ext:php)
////////////////////////////////////////////////////////
$HoneypotName = "SQMAIL_1.4.4";

//Change this to the name of an organization that owns SquirrelMail.
$MailSystemName = ""; //NEEDS TO BE original. Your "organization" name. Will appear to attacker in title.

//Trick Squirrelmail page
echo "<!DOCTYPE HTML PUBLIC \"-//W3C//DTD HTML 4.01 Transitional//EN\">\n\n<html>\n\n<head>\n\n<title>$MailSystemName - Login</title><script language=\"JavaScript\" type=\"text/javascript\">\n<!--\n  function squirrelmail_loginpage_onload() {\n    document.forms[0].js_autodetect_results.value = '1';\n    var textElements = 0;\n    for (i = 0; i < document.forms[0].elements.length; i++) {\n      if (document.forms[0].elements[i].type == \"text\" || document.forms[0].elements[i].type == \"password\") {\n        textElements++;\n        if (textElements == 1) {\n          document.forms[0].elements[i].focus();\n          break;\n        }\n      }\n    }\n  }\n// -->\n</script>\n\n<style type=\"text/css\">\n<!--\n  /* avoid stupid IE6 bug with frames and scrollbars */\n  body {\n      voice-family: \"\"}\"\";\n      voice-family: inherit;\n      width: expression(document.documentElement.clientWidth - 30);\n  }\n-->\n</style>\n\n</head>\n\n<body text=\"#000000\" bgcolor=\"#FFFFFF\" link=\"#0000CC\" vlink=\"#0000CC\" alink=\"#0000CC\" onload=\"squirrelmail_loginpage_onload();\">\n<form action=\"redirect.php\" method=\"post\">\n\n<table bgcolor=\"#ffffff\" border=\"0\" cellspacing=\"0\" cellpadding=\"0\" width=\"100%\"><tr><td align=\"center\"><center><img src=\"../images/sm_logo.png\" alt=\"$MailSystemName Logo\" width=\"308\" height=\"111\" /><br />\n<small>SquirrelMail version 1.4.4<br />\n  By the SquirrelMail Development Team<br /></small>\n<table bgcolor=\"#ffffff\" border=\"0\" width=\"350\"><tr><td bgcolor=\"#DCDCDC\" align=\"center\"><b>$MailSystemName Login</b>\n</td>\n</tr>\n<tr><td bgcolor=\"#FFFFFF\" align=\"left\">\n<table bgcolor=\"#ffffff\" align=\"center\" border=\"0\" width=\"100%\"><tr><td align=\"right\" width=\"30%\">Name:</td>\n<td align=\"left\" width=\"*\"><input type=\"text\" name=\"login_username\" value=\"\" />\n</td>\n</tr>\n\n<tr><td align=\"right\" width=\"30%\">Password:</td>\n<td align=\"left\" width=\"*\"><input type=\"password\" name=\"secretkey\" />\n<input type=\"hidden\" name=\"js_autodetect_results\" value=\"0\" />\n<input type=\"hidden\" name=\"just_logged_in\" value=\"1\" />\n</td>\n</tr>\n</table>\n</td>\n</tr>\n<tr><td align=\"left\"><center><input type=\"submit\" value=\"Login\" />\n</center></td>\n</tr>\n</table>\n</center></td>\n</tr>\n</table>\n\n</form>\n</body></html>";

//Find our PHP shell target in the referer site
if (strstr($Attack['referer'], "squirrel") || strstr($Attack['referer'], "1.4.4")){
	 $Signature[] = "Target in URL";
}

//Finds if exact GHDB signature was used
if (strstr ($Attack['referer'], "%22SquirrelMail+version+1.4.4%22+inurl%3Asrc+ext%3Aphp")){
	 $Signature[] = "GHDB Signature!";
}

////////////////////////////////////////////////////////
//End Custom Honeypot Section
////////////////////////////////////////////////////////

////////////////////////////////////////////////////////
//Begin Logging Section
////////////////////////////////////////////////////////

writeLog($Owner, $HoneypotName, $DateTime, $Attack, $Signature, $LogType, $Filename, $DBName, $DBUser, $DBPass, $Server);

////////////////////////////////////////////////////////
//End Logging Section
////////////////////////////////////////////////////////
//End of template.php
////////////////////////////////////////////////////////
?>