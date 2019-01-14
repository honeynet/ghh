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
//GHH Honeypot by Ryan McGeehan for GHDB Signature #833 (filetype:php HAXPLORER "Server Files Browser")
////////////////////////////////////////////////////////
$HoneypotName = "HAXPLORER";

//Trick PHP Shell page
echo "<!-- PHPShell by Macker, Version 2.5.3dev, 15-07-2002  -->\n<HTML>\n <HEAD>\n  <STYLE>\n  <!--\n    A{ text-decoration:none; color:navy; font-size: 12px }\n    body { font-size: 12px; }\n    Table { font-size: 12px; }\n    TR{ font-size: 12px; }\n    TD{ font-size: 12px; BORDER-LEFT: black 0px solid; BORDER-RIGHT: black 0px solid; BORDER-TOP: black 0px solid; BORDER-BOTTOM: black 0px solid; COLOR: black; }\n    .border{       BORDER-LEFT: black 1px solid;\n 		   BORDER-RIGHT: black 1px solid;\n 		   BORDER-TOP: black 1px solid;\n 		   BORDER-BOTTOM: black 1px solid;\n 		 }\n    .none  {       BORDER-LEFT: black 0px solid;\n 		   BORDER-RIGHT: black 0px solid;\n 		   BORDER-TOP: black 0px solid;\n 		   BORDER-BOTTOM: black 0px solid;\n 		 }\n  \n    .top { BORDER-TOP: black 1px solid; }\n    .textin { BORDER-LEFT: silver 1px solid;\n              BORDER-RIGHT: silver 1px solid;\n 	      BORDER-TOP: silver 1px solid;\n              BORDER-BOTTOM: silver 1px solid;\n              width: 99%; font-size: 12px; font-weight: bold; color: navy;\n            }\n    .notop { BORDER-TOP: black 0px solid; }\n    .bottom { BORDER-BOTTOM: black 1px solid; }\n    .nobottom { BORDER-BOTTOM: black 0px solid; }\n    .left { BORDER-LEFT: black 1px solid; }\n    .noleft { BORDER-LEFT: black 0px solid; }\n    .right { BORDER-RIGHT: black 1px solid; }\n    .noright { BORDER-RIGHT: black 0px solid; }\n    .silver{ BACKGROUND: silver; }\n  -->\n  </STYLE>\n  <TITLE>1.php</TITLE>\n </HEAD>\n <body topmargin=\"0\" leftmargin=\"0\">\n <table width=100% NOWRAP border=\"0\">\n\n  <tr NOWRAP>\n   <td width=\"100%\" NOWRAP>\n    <table NOWRAP width=100% border=\"0\" cellpadding=\"0\" cellspacing=\"0\">\n     <tr>\n      <td width=\"100%\" class=\"silver border\">\n       <center>\n	    <strong>\n		 <font size=3>PHPShell by Macker - Version 2.5.3dev - 15-07-2002</font>\n\n            </strong>\n       </center>\n      </td>\n     </tr>\n    </table><br>\n\n	      <form name=\"urlform\" action=\"1.php\"><input type=\"hidden\" name=\"cmd\" value=\"dir\">\n         <table NOWRAP width=\"100%\" border=\"0\" cellpadding=\"0\" cellspacing=\"0\">\n	  <tr>\n\n	   <td width=\"100%\" class=\"silver border\">\n	    <center>&nbsp;HAXPLORER - Server Files Browser...&nbsp;</center>\n	   </td>\n	  </tr>\n	 </table>\n       <br>\n	 <table width=\"100%\" border=\"0\" cellpadding=\"0\" cellspacing=\"0\">\n	  <tr>\n\n           <td class=\"border nobottom noright\">\n            &nbsp;Browsing:&nbsp;\n	  </td>\n          <td width=\"100%\" class=\"border nobottom noleft\">\n   	    <table width=\"100%\" border=\"0\" cellpadding=\"1\" cellspacing=\"0\">\n             <tr>\n              <td NOWRAP width=\"99%\" align=\"center\"><input type=\"text\" name=\"dir\" class=\"none textin\" value=\"/\"></td>\n              <td NOWRAP><center>&nbsp;<a href=\"javascript: urlform.submit();\"><b>GO<b></a>&nbsp;<center></td>\n\n             </tr>\n            </table>\n            \n	  </td>\n	 </tr>\n	</table>\n  <!--    </form>   -->\n        <table NOWRAP width=\"100%\" border=\"0\" cellpadding=\"0\" cellspacing=\"0\" >\n         <tr>\n	  <td width=\"100%\" NOWRAP class=\"silver border\">\n\n	   &nbsp;Filename&nbsp;\n	  </td>\n          <td NOWRAP class=\"silver border noleft\">\n	   &nbsp;Actions&nbsp;(Attempt to perform)&nbsp;\n	  </td>\n          <td NOWRAP class=\"silver border noleft\">\n	   &nbsp;Size&nbsp;\n\n	  </td>\n          <td width=1 NOWRAP class=\"silver border noleft\">\n	   &nbsp;Attributes&nbsp;\n	  </td>\n          <td NOWRAP class=\"silver border noleft\">\n	   &nbsp;Modification Date&nbsp;\n	  </td>\n	 <tr>\n\n<tr><td NOWRAP class=\"top left right\">&nbsp;&nbsp;&nbsp;<a href=\"1.php?cmd=dir&dir=./.\">[.]</a>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</td>\n<td NOWRAP class=\"top right\"><center>&nbsp;&nbsp;\n&nbsp;&nbsp;</center></td>\n<td NOWRAP class=\"top right\">&nbsp;</td>\n<td NOWRAP class=\"top right\">&nbsp;&nbsp;\n<strong>D</strong><strong>R</strong><Strong>X<strong>&nbsp;&nbsp;</td>\n<td NOWRAP class=\"top right\" NOWRAP>\n&nbsp;&nbsp;Thu 0" . rand(1,9) . "-" . rand(1,12) . "-200" . rand(0,5) . rand(0,24). ":1" . rand(0,9) . ":4" . rand(0,9) .  "&nbsp;&nbsp;</td></tr>\n							<tr><td NOWRAP class=\"top left right\">&nbsp;&nbsp;&nbsp;<a href=\"1.php?cmd=dir&dir=./..\">[..]</a>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</td>\n<td NOWRAP class=\"top right\"><center>&nbsp;&nbsp;\n\n&nbsp;&nbsp;</center></td>\n<td NOWRAP class=\"top right\">&nbsp;</td>\n<td NOWRAP class=\"top right\">&nbsp;&nbsp;\n<strong>D</strong><strong>R</strong><Strong>X<strong>&nbsp;&nbsp;</td>\n<td NOWRAP class=\"top right\" NOWRAP>&nbsp;&nbsp;Thu 0" . rand(1,9) . "-" . rand(1,12) . "-200" . rand(0,5). " " . rand(0,24) . ":1" . rand(0,9) . ":4" . rand(0,9) . "&nbsp;&nbsp;</td></tr>\n						</table><table width=100% border=\"0\" cellpadding=\"0\" cellspacing=\"0\"><tr>\n<td NOWRAP width=100% class=\"silver border noright\">\n&nbsp;&nbsp;10&nbsp;Dir(s),&nbsp;106&nbsp;File(s)&nbsp;&nbsp;\n\n</td><td NOWRAP class=\"silver border noleft\">\n&nbsp;&nbsp;Total filesize:&nbsp;801.168 KB&nbsp;&nbsp;<td></tr>\n<tr><td colspan=\"2\" class=\"silver border notop\"><table width=\"100%\" cellspacing=\"0\" cellpadding=\"3\"><tr><td valign=\"top\"><font color=\"red\"><b>Page:</b></font></td><td width=\"100%\"><center><b>| _note - gound |</b>&nbsp;&nbsp;&nbsp;<A HREF=\"?cmd=dir&dir=.&Pidx=1\"><b>| gregb - yours |</b></A></center></td></tr></table></td></tr></table>\n<br><table NOWRAP><tr><td class=\"silver border\">&nbsp;<strong>Server's PHP Version:&nbsp;&nbsp;</strong>&nbsp;</td><td>&nbsp;4.3.10&nbsp;</td></tr>\n<tr><td class=\"silver border\">&nbsp;<strong>Other actions:&nbsp;&nbsp;</strong>&nbsp;</td>\n<td>&nbsp;<b><a href=\"1.php?cmd=newfile&lastcmd=dir&lastdir=.\">| New File |</a>\n&nbsp;&nbsp;&nbsp;<a href=\"1.php?cmd=newdir&lastcmd=dir&lastdir=.\">| New Directory |</a>\n\n&nbsp;&nbsp;&nbsp;<a href=\"1.php?cmd=upload&dir=.&lastcmd=dir&lastdir=.\">| Upload a File |</a></b>\n</td></tr>\n<tr><td class=\"silver border\">&nbsp;<strong>Script Location:&nbsp;&nbsp;</strong>&nbsp;</td><td>&nbsp;/usr/www/1.php</td></tr>\n<tr><td class=\"silver border\">&nbsp;<strong>Your IP:&nbsp;&nbsp;</strong>&nbsp;</td><td>&nbsp;" . $_SERVER["REMOTE_ADDR"] . "&nbsp;</td></tr>\n<tr><td class=\"silver border\">&nbsp;<strong>Browsing Directory:&nbsp;&nbsp;</strong></td><td>&nbsp;/usr/www/</td></tr>\n<tr><td valign=\"top\" class=\"silver border\">&nbsp;<strong>Legend:&nbsp;&nbsp;</strong&nbsp;></td><td>\n<table NOWRAP><tr><td><strong>D:</strong></td><td>&nbsp;&nbsp;Directory.</td></tr>\n\n<tr><td><strong>R:</strong></td><td>&nbsp;&nbsp;Readable.</td></tr>\n<tr><td><strong>W:</strong></td><td>&nbsp;&nbsp;Writeable.</td></tr>\n<tr><td><strong>X:</strong></td><td>&nbsp;&nbsp;Executable.</td></tr>\n<tr><td><strong>U:</strong></td><td>&nbsp;&nbsp;HTTP Uploaded File.</td></tr>\n</table></td></table><br>		<table width=\"100%\" border=\"0\" cellpadding=\"0\" cellspacing=\"0\">\n		 <tr>\n		  <td width=\"100%\" style=\"class=\"silver border>\n\n		   <center><strong>\n		    &nbsp;&nbsp;<a href=\"1.php\"><font color=\"navy\">[&nbsp;Main Menu&nbsp;]</font></a>&nbsp;&nbsp;\n                    &nbsp;&nbsp;<a href=\"1.php?cmd=dir&dir=.\"><font color=\"navy\">[&nbsp;Haxplorer&nbsp;]</font></a>&nbsp;&nbsp;\n 		   </strong></center>\n		  </td>\n		 </tr>\n\n		</table>\n		<br>\n			<table width=100% border=\"0\" cellpadding=\"0\" cellspacing=\"0\">\n	 <tr>\n	  <td width=\"100%\" class=\"silver border\">\n	   <center>&nbsp;PHPShell by Macker - Version 2.5.3dev - 15-07-2002&nbsp;</center>\n	  </td>\n	 </tr>\n\n	</table>\n 	   </td>\n  </tr>\n </table>\n\n";

//Find our PHP shell target in the referer site
if (strstr($Attack['referer'], "haxplorer")){
	 $Signature[] = "Target in URL";
}

//Finds if exact GHDB signature was used
if (strstr ($Attack['referer'], "filetype%3Aphp+HAXPLORER+%22Server+Files+Browser%22")){
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