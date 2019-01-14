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
//GHH Honeypot by Ryan McGeehan for GHDB Signature #733 ("Enter ip" inurl:"php-ping.php")
////////////////////////////////////////////////////////
$HoneypotName = "PHPPING";

//Trick PHP Shell page
echo "<!DOCTYPE html PUBLIC \"-//IETF//DTD HTML 2.0//EN\">\n<html>\n<head>\n<title>The WorldsEnd.NET - Free Ping Script, written in PHP</title></head><body bgcolor=\"#FFFFFF\" text=\"#000000\"></body><p><font size=\"2\">Your IP is: " . $_SERVER['REMOTE_ADDR'] . "</font></p><form methode=\"post\" action=\"/GHH - phpping/asdf.php\">   Enter IP or Host <input type=\"text\" name=\"host\" value=\"127.0.0.1\"></input>   Enter Count <input type=\"text\" name=\"count\" size=\"2\" value=\"4\"></input>   <input type=\"submit\" name=\"submit\" value=\"Ping!\"></input></form><br><b></b></body></html>";

//Find our target in the referer site
if (strstr($Attack['referer'], "Shell")){
	 $Signature[] = "php-ping found";
}

//Finds if exact GHDB signature was used
if (strstr ($Attack['referer'], "%22Enter+ip%22+inurl%3A%22php-ping.php%22")){
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