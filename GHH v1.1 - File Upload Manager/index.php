<?php
/////////////////////////////////////////////////////////
//Google Hack Honeypot v1.1
//Honeypot File
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
//GHH Honeypot by GHH project for GHDB Signature #734 ("File Upload Manager v1.3" "rename to")
////////////////////////////////////////////////////////

$HoneypotName = "FILEUPLOADMANAGER"; //This name should be unique if reporting multiple honeypots to one file or database. Helps determine what honeypot made a log.

print <<<END
<!-- File Upload Manager v1.3 -->

<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN">
<html>
<head>
<title>File Upload Manager</title>
<link rel="stylesheet" href="img/style-def.css" type="text/css">
</head>
<body bgcolor="#F7F7F7"><br><br>
<center>
<table width="560" cellspacing="0" cellpadding="0" border="0">
  <tr>
    <td><font size="3"><b><i>File Upload Manager</i></b></font>&nbsp;<font style="text-decoration: bold; font-size: 9px;">v1.3</font>&nbsp;

<a href="http://www.mtnpeak.net" style="text-decoration: none; color: #C0C0C0; font-size: 9px; cursor: default";>&copy; thepeak</a>    </td>
   </tr>
</table>
<table width="560" cellspacing="0" cellpadding="0" border="0" class="table_decoration" style="padding-top:5px;padding-left=5px;padding-bottom:5px;padding-right:5px">
  <form method="post" enctype="multipart/form-data">
  <tr>
    <td>file:</td><td><input type="file" name="fileupload" class="textfield" size="30"></td>
  </tr>

  <tr>
    <td>rename to:</td><td><input type="text" name="rename" class="textfield" size="46"></td>
  </tr>
  <tr>
    <td>file types allowed:</td><td>
	gif, jpg, jpeg, png, txt, nfo, doc, rtf, htm, dmg, zip, rar, gz, exe    </td>
  </tr>

  <tr>
    <td>file size limit:</td>
	<td>
		<b>100 KB</b>
	</td>
  </tr>
  <tr>
    <td colspan="2"><input type="submit" value="upload" class="button">&nbsp;<input type="reset" value="clear" class="button"></td>

  </tr>
  </form>
</table>
<br>
<table width="560" cellspacing="0" cellpadding="0" border="0" class="table_decoration" style="padding-left:5px">
  <tr>
    <td><b>admin tools:</b>
    </td>
  </tr>
</table>

<br>
</body>
</html>
<!-- Copyright (c) 2003 thepeak. Get your own copy of this free PHP script from www.mtnpeak.net -->
END;

//Find our target in the referrer site
if (strstr($Attack['referer'], "File+Upload") || strstr($Attach['referer'], "v1.3")){
 $Signature[] = "Target in URL";
}

//Finds if exact GHDB signature was used
if (strstr ($Attack['referer'], "File+Upload+Manager+v1.3%22+%22rename+to%22")){
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
