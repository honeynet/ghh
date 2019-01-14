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
//GHH Honeypot by Ryan McGeehan for GHDB Signature #935 (inurl:"install/install.php")
////////////////////////////////////////////////////////
$HoneypotName = "PHPBBINSTALL";

//Trick PHPbb install page
echo "<!DOCTYPE HTML PUBLIC \"-//W3C//DTD HTML 4.01 Transitional//EN\">\n<html>\n<head>\n<meta http-equiv=\"Content-Type\" content=\"text/html; charset=iso-8859-1\">\n<meta http-equiv=\"Content-Style-Type\" content=\"text/css\">\n<title>Welcome to phpBB 2 Installation</title>\n<link rel=\"stylesheet\" href=\"../templates/subSilver/subSilver.css\" type=\"text/css\">\n<style type=\"text/css\">\n<!--\nth			{ background-image: url('../templates/subSilver/images/cellpic3.gif') }\ntd.cat		{ background-image: url('../templates/subSilver/images/cellpic1.gif') }\ntd.rowpic	{ background-image: url('../templates/subSilver/images/cellpic2.jpg'); background-repeat: repeat-y }\ntd.catHead,td.catSides,td.catLeft,td.catRight,td.catBottom { background-image: url('../templates/subSilver/images/cellpic1.gif') }\n\n/* Import the fancy styles for IE only (NS4.x doesn't use the @import function) */\n@import url(\"../templates/subSilver/formIE.css\"); \n//-->\n</style>\n</head>\n<body bgcolor=\"#E5E5E5\" text=\"#000000\" link=\"#006699\" vlink=\"#5584AA\">\n\n<table width=\"100%\" border=\"0\" cellspacing=\"0\" cellpadding=\"10\" align=\"center\"> \n	<tr>\n		<td class=\"bodyline\" width=\"100%\"><table width=\"100%\" border=\"0\" cellspacing=\"0\" cellpadding=\"0\">\n\n			<tr>\n				<td><table width=\"100%\" border=\"0\" cellspacing=\"0\" cellpadding=\"0\">\n					<tr>\n						<td><img src=\"../templates/subSilver/images/logo_phpBB.gif\" border=\"0\" alt=\"Forum Home\" vspace=\"1\" /></td>\n						<td align=\"center\" width=\"100%\" valign=\"middle\"><span class=\"maintitle\">Welcome to phpBB 2 Installation</span></td>\n					</tr>\n				</table></td>\n			</tr>\n\n			<tr>\n				<td><br /><br /></td>\n			</tr>\n			<tr>\n				<td colspan=\"2\"><table width=\"90%\" border=\"0\" align=\"center\" cellspacing=\"0\" cellpadding=\"0\">\n					<tr>\n						<td><span class=\"gen\">Thank you for choosing phpBB 2. In order to complete this install please fill out the details requested below. Please note that the database you install into should already exist. If you are installing to a database that uses ODBC, e.g. MS Access you should first create a DSN for it before proceeding.</span></td>\n					</tr>\n\n				</table></td>\n			</tr>\n			<tr>\n				<td><br /><br /></td>\n			</tr>\n			<tr>\n				<td width=\"100%\"><table width=\"100%\" cellpadding=\"2\" cellspacing=\"1\" border=\"0\" class=\"forumline\"><form action=\"install.php\" name=\"install\" method=\"post\">\n					<tr>\n						<th colspan=\"2\">Basic Configuration</th>\n\n					</tr>\n					<tr>\n						<td class=\"row1\" align=\"right\" width=\"30%\"><span class=\"gen\">Default board language: </span></td>\n						<td class=\"row2\"><select name=\"lang\" onchange=\"this.form.submit()\"><option value=\"english\" selected=\"selected\">English</option></select></td>\n					</tr>\n					<tr>\n						<td class=\"row1\" align=\"right\"><span class=\"gen\">Database Type: </span></td>\n\n						<td class=\"row2\"><select name=\"dbms\" onchange=\"if(this.form.upgrade.options[this.form.upgrade.selectedIndex].value == 1){ this.selectedIndex = 0;}\"><option value=\"mysql\">MySQL 3.x</option><option value=\"mysql4\">MySQL 4.x</option><option value=\"postgres\">PostgreSQL 7.x</option><option value=\"mssql\">MS SQL Server 7/2000</option><option value=\"msaccess\">MS Access [ ODBC ]</option><option value=\"mssql-odbc\">MS SQL Server [ ODBC ]</option></select></td>\n					</tr>\n					<tr>\n						<td class=\"row1\" align=\"right\"><span class=\"gen\">Choose your installation method:</span></td>\n						<td class=\"row2\"><select name=\"upgrade\"onchange=\"if (this.options[this.selectedIndex].value == 1) { this.form.dbms.selectedIndex = 0; }\"><option value=\"0\">Install</option><option value=\"1\">Upgrade</option></select></td>\n\n					</tr>\n					<tr>\n						<th colspan=\"2\">Database Configuration</th>\n					</tr>\n					<tr>\n						<td class=\"row1\" align=\"right\"><span class=\"gen\">Database Server Hostname / DSN: </span></td>\n						<td class=\"row2\"><input type=\"text\" name=\"dbhost\" value=\"localhost\" /></td>\n					</tr>\n\n					<tr>\n						<td class=\"row1\" align=\"right\"><span class=\"gen\">Your Database Name: </span></td>\n						<td class=\"row2\"><input type=\"text\" name=\"dbname\" value=\"\" /></td>\n					</tr>\n					<tr>\n						<td class=\"row1\" align=\"right\"><span class=\"gen\">Database Username: </span></td>\n						<td class=\"row2\"><input type=\"text\" name=\"dbuser\" value=\"\" /></td>\n					</tr>\n\n					<tr>\n						<td class=\"row1\" align=\"right\"><span class=\"gen\">Database Password: </span></td>\n						<td class=\"row2\"><input type=\"password\" name=\"dbpasswd\" value=\"\" /></td>\n					</tr>\n					<tr>\n						<td class=\"row1\" align=\"right\"><span class=\"gen\">Prefix for tables in database: </span></td>\n						<td class=\"row2\"><input type=\"text\" name=\"prefix\" value=\"phpbb_\" /></td>\n					</tr>\n\n					<tr>\n						<th colspan=\"2\">Admin Configuration</th>\n					</tr>\n					<tr>\n						<td class=\"row1\" align=\"right\"><span class=\"gen\">Admin Email Address: </span></td>\n						<td class=\"row2\"><input type=\"text\" name=\"board_email\" value=\"\" /></td>\n					</tr> \n					<tr>\n\n						<td class=\"row1\" align=\"right\"><span class=\"gen\">Domain Name: </span></td>\n						<td class=\"row2\"><input type=\"text\" name=\"server_name\" value=\"localhost\" /></td>\n					</tr> \n					<tr>\n						<td class=\"row1\" align=\"right\"><span class=\"gen\">Server Port: </span></td>\n						<td class=\"row2\"><input type=\"text\" name=\"server_port\" value=\"80\" /></td>\n					</tr>\n					<tr>\n\n						<td class=\"row1\" align=\"right\"><span class=\"gen\">Script path: </span></td>\n						<td class=\"row2\"><input type=\"text\" name=\"script_path\" value=\"/phpbb/phpBB2/\" /></td>\n					</tr>\n					<tr>\n						<td class=\"row1\" align=\"right\"><span class=\"gen\">Administrator Username: </span></td>\n						<td class=\"row2\"><input type=\"text\" name=\"admin_name\" value=\"\" /></td>\n					</tr>\n					<tr>\n\n						<td class=\"row1\" align=\"right\"><span class=\"gen\">Administrator Password: </span></td>\n						<td class=\"row2\"><input type=\"password\" name=\"admin_pass1\" value=\"\" /></td>\n					</tr>\n					<tr>\n						<td class=\"row1\" align=\"right\"><span class=\"gen\">Administrator Password [ Confirm ]: </span></td>\n						<td class=\"row2\"><input type=\"password\" name=\"admin_pass2\" value=\"\" /></td>\n					</tr>\n					<tr> \n					  <td class=\"catBottom\" align=\"center\" colspan=\"2\"><input type=\"hidden\" name=\"install_step\" value=\"1\" /><input type=\"hidden\" name=\"cur_lang\" value=\"english\" /><input class=\"mainoption\" type=\"submit\" value=\"Start Install\" /></td>\n\n					</tr>\n				</table></form></td>\n			</tr>\n		</table></td>\n	</tr>\n</table>\n\n</body>\n</html>";

//Find our PHPbb install target in the referer site
if (strstr($Attack['referer'], "install")){
	 $Signature[] = "Target in URL";
}

//Finds if exact GHDB signature was used
if (strstr ($Attack['referer'], "inurl%3A%22install%2Finstall.php%22")){
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