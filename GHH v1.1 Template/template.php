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
//GHH Template by Ryan McGeehan
//
//This Template is currently emulating PHP Shell. 
////////////////////////////////////////////////////////
$HoneypotName = "PHPSHELL"; //This name should be unique if reporting multiple honeypots to one file or database. Helps determine what honeypot made a log.

//Trick PHP Shell page
echo "<html>\n<head>\n<title>PHP Shell 1.7</title>\n</head>\n<body>\n<h1>PHP Shell 1.7</h1>\n\n\n<form name=\"myform\" action=\"/mysidia/main/mid/uploaded/p-s.mid.php\" method=\"post\">\n<p>Current working directory: <b>\n<a href=\"/mysidia/main/mid/uploaded/p-s.mid.php?work_dir=/\">Root</a>/</b></p>\n\n<p>Choose new working directory:\n<select name=\"work_dir\" onChange=\"this.form.submit()\">\n<br />\n<br /><html>\n<head>\n<title>PHP Shell 1.7</title>\n</head>\n<body>\n<h1>PHP Shell 1.7</h1>\n\n\n<form name=\"myform\" action=\"/mysidia/main/mid/uploaded/p-s.mid.php\" method=\"post\">\n<p>Current working directory: <b>\n<a href=\"/mysidia/main/mid/uploaded/p-s.mid.php?work_dir=/\">Root</a>/</b></p>\n\n<p>Choose new working directory:\n<select name=\"work_dir\" onChange=\"this.form.submit()\">\n<br />\n<br />\n<br />\n<br />\n\n</select></p>\n\n<p>Command: <input type=\"text\" name=\"command\" size=\"60\">\n<input name=\"submit_btn\" type=\"submit\" value=\"Execute Command\"></p>\n\n<p>Enable <code>stderr</code>-trapping? <input type=\"checkbox\" name=\"stderr\"></p>\n<textarea cols=\"80\" rows=\"20\" readonly>\n\n\n</textarea>\n</form>\n\n<script language=\"JavaScript\" type=\"text/javascript\">\ndocument.forms[0].command.focus();\n</script>\n\n<hr>\n<i>Copyright &copy; 2000&ndash;2002, <a\nhref=\"mailto:gimpster@gimpster.com\">Martin Geisler</a>. Get the latest\nversion at <a href=\"http://www.gimpster.com\">www.gimpster.com</a>.</i>\n</body>\n</html>\n";

//Find our PHP shell target in the referer site
if (strstr($Attack['referer'], "Shell")){
 $Signature[] = "Target in URL";
}

//Finds if exact GHDB signature was used
if (strstr ($Attack['referer'], "intitle%3A%22PHP+Shell+*%22+%22Enable+stderr%22+filetype%3Aphp")){
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
