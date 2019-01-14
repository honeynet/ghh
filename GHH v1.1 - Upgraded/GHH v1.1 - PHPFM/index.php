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
//GHH Honeypot by Ryan McGeehan for GHDB Signature #361 ("Powered by PHPFM" filetype:php -username)
////////////////////////////////////////////////////////
$HoneypotName = "PHPFM";

//Trick PHP Shell page
echo "<!DOCTYPE HTML PUBLIC \"-//W3C//DTD HTML 4.01 Transitional//EN\"><html><head><title>PHPFM 0.2.3 - a file manager written in PHP</title><link rel='stylesheet' href='incl/phpfm.css' type='text/css'></head><body link='#0000FF' alink='#0000FF' vlink='#0000FF' bgcolor='#FFFFFF'><center><table class='top' cellpadding=0 cellspacing=0><tr><td align='center'><font class='headline'>PHPFM 0.2.3</font></td></tr></table><br /><table class='menu' cellpadding=2 cellspacing=0><tr><td align='center' valign='bottom'><a href='?&amp;&amp;path=&amp;action=create&amp;type=directory'><img src='icon/newfolder.gif' width=20 height=22 alt='Create new folder' border=0>&nbsp;Create new folder</a></td><td align='center' valign='bottom'><a href='?&amp;&amp;path=&amp;action=create&amp;type=file'><img src='icon/newfile.gif' width=20 height=22 alt='Create new file' border=0>&nbsp;Create new file</a></td><td align='center' valign='bottom'><a href='?&amp;&amp;path=&amp;action=upload'><img src='icon/upload.gif' width=20 height=22 alt='Upload files' border=0>&nbsp;Upload files</a></td><td align='center' valign='bottom'><a href='?&amp;&amp;action=logout'><img src='icon/logout.gif' width=20 height=22 alt='Log out' border=0>&nbsp;Log out</a></td></tr></table><br /><table class='index' cellpadding=0 cellspacing=0><tr><td class='iheadline' colspan=4 align='center' height=21><font class='iheadline'>Index of&nbsp;<a href='?&amp;'>.</a> / </font></td></tr><tr><td>&nbsp;</td><td class='fbborder' valign='top'><table class='directories' width=300 cellpadding=1 cellspacing=0><tr><td class='bold' width=20>&nbsp;</td><td class='bold'>&nbsp;Name</td><td class='bold' width=20 align='center'>Rn</td><td class='bold' width=20 align='center'>Rm</td></tr><tr><td width=20><a href='?&amp;&amp;path='><img src='icon/folder.gif' width=20 height=22 alt='Open folder' border=0></a></td><td>&nbsp;<a href='?&amp;'>.</a></td><td width=20>&nbsp;</td><td width=20>&nbsp;</td></tr><tr><td width=20><a href='?&amp;&amp;path=/'><img src='icon/folder.gif' width=20 height=22 alt='Open folder' border=0></a></td><td>&nbsp;<a href='?&amp;&amp;path=/'>..</a></td><td width=20>&nbsp;</td><td width=20>&nbsp;</td></tr><tr><td width=20><a href='?&amp;&amp;path=conf/'><img src='icon/folder.gif' width=20 height=22 alt='Open folder' border=0></a></td><td>&nbsp;<a href='?&amp;&amp;path=conf/'>conf</a></td><td width=20><a href='?&amp;&amp;path=&amp;directory_name=conf/&amp;action=rename'><img src='icon/rename.gif' width=20 height=22 alt='Rename folder' border=0></a></td><td width=20><a href='?&amp;&amp;path=&amp;directory_name=conf/&amp;action=delete'><img src='icon/delete.gif' width=20 height=22 alt='Delete folder' border=0></a></td></tr><tr><td width=20><a href='?&amp;&amp;path=docs/'><img src='icon/folder.gif' width=20 height=22 alt='Open folder' border=0></a></td><td>&nbsp;<a href='?&amp;&amp;path=docs/'>docs</a></td><td width=20><a href='?&amp;&amp;path=&amp;directory_name=docs/&amp;action=rename'><img src='icon/rename.gif' width=20 height=22 alt='Rename folder' border=0></a></td><td width=20><a href='?&amp;&amp;path=&amp;directory_name=docs/&amp;action=delete'><img src='icon/delete.gif' width=20 height=22 alt='Delete folder' border=0></a></td></tr><tr><td width=20><a href='?&amp;&amp;path=icon/'><img src='icon/folder.gif' width=20 height=22 alt='Open folder' border=0></a></td><td>&nbsp;<a href='?&amp;&amp;path=icon/'>icon</a></td><td width=20><a href='?&amp;&amp;path=&amp;directory_name=icon/&amp;action=rename'><img src='icon/rename.gif' width=20 height=22 alt='Rename folder' border=0></a></td><td width=20><a href='?&amp;&amp;path=&amp;directory_name=icon/&amp;action=delete'><img src='icon/delete.gif' width=20 height=22 alt='Delete folder' border=0></a></td></tr><tr><td width=20><a href='?&amp;&amp;path=incl/'><img src='icon/folder.gif' width=20 height=22 alt='Open folder' border=0></a></td><td>&nbsp;<a href='?&amp;&amp;path=incl/'>incl</a></td><td width=20><a href='?&amp;&amp;path=&amp;directory_name=incl/&amp;action=rename'><img src='icon/rename.gif' width=20 height=22 alt='Rename folder' border=0></a></td><td width=20><a href='?&amp;&amp;path=&amp;directory_name=incl/&amp;action=delete'><img src='icon/delete.gif' width=20 height=22 alt='Delete folder' border=0></a></td></tr><tr><td width=20><a href='?&amp;&amp;path=lang/'><img src='icon/folder.gif' width=20 height=22 alt='Open folder' border=0></a></td><td>&nbsp;<a href='?&amp;&amp;path=lang/'>lang</a></td><td width=20><a href='?&amp;&amp;path=&amp;directory_name=lang/&amp;action=rename'><img src='icon/rename.gif' width=20 height=22 alt='Rename folder' border=0></a></td><td width=20><a href='?&amp;&amp;path=&amp;directory_name=lang/&amp;action=delete'><img src='icon/delete.gif' width=20 height=22 alt='Delete folder' border=0></a></td></tr><tr><td colspan=4>&nbsp;</td></tr></table></td><td>&nbsp;</td><td valign='top'><table class='files' width=500 cellpadding=1 cellspacing=0><tr><td class='bold' width=20>&nbsp;</td><td class='bold'>&nbsp;<a href='?&amp;&amp;path=&amp;sortby=filename&amp;order=desc'>Name</a></td><td class='bold' width=60 align='center'><a href='?&amp;&amp;path=&amp;sortby=filesize&amp;order=asc'>Size</a></td><td class='bold' width=35 align='center'><a href='?&amp;&amp;path=&amp;sortby=permissions&amp;order=asc'>Perm</a></td><td class='bold' width=110 align='center'><a href='?&amp;&amp;path=&amp;sortby=modified&amp;order=asc'>Modified</a></td><td class='bold' width=20 align='center'>Vw</td><td class='bold' width=20 align='center'>Ed</td><td class='bold' width=20 align='center'>Rn</td><td class='bold' width=20 align='center'>Dl</td><td class='bold' width=20 align='center'>Rm</td></tr><tr><td width=20><img src='icon/script.gif' width=20 height=22 border=0 alt='File'></td><td>&nbsp;index.php</td><td width=60 align='right'>2,81&nbsp;KB</td><td width=35 align='center'>666</td><td width=110 align='right'>20:36 06-19-2003</td><td width=20>&nbsp;</td><td width=20><a href='?&amp;&amp;path=&amp;filename=index.php&amp;action=edit'><img src='icon/edit.gif' width=20 height=22 alt='Edit file' border=0></a></td><td width=20><a href='?&amp;&amp;path=&amp;filename=index.php&amp;action=rename'><img src='icon/rename.gif' width=20 height=22 alt='Rename file' border=0></a></td><td width=20><a href='?&amp;&amp;path=&amp;filename=index.php&amp;action=download'><img src='icon/download.gif' width=20 height=22 alt='Download file' border=0></a></td><td width=20><a href='?&amp;&amp;path=&amp;filename=index.php&amp;action=delete'><img src='icon/delete.gif' width=20 height=22 alt='Delete file' border=0></a></td></tr><tr><td width=20><img src='icon/text.gif' width=20 height=22 border=0 alt='File'></td><td>&nbsp;readme.txt</td><td width=60 align='right'>2,13&nbsp;KB</td><td width=35 align='center'>666</td><td width=110 align='right'>22:26 06-19-2003</td><td width=20>&nbsp;</td><td width=20><a href='?&amp;&amp;path=&amp;filename=readme.txt&amp;action=edit'><img src='icon/edit.gif' width=20 height=22 alt='Edit file' border=0></a></td><td width=20><a href='?&amp;&amp;path=&amp;filename=readme.txt&amp;action=rename'><img src='icon/rename.gif' width=20 height=22 alt='Rename file' border=0></a></td><td width=20><a href='?&amp;&amp;path=&amp;filename=readme.txt&amp;action=download'><img src='icon/download.gif' width=20 height=22 alt='Download file' border=0></a></td><td width=20><a href='?&amp;&amp;path=&amp;filename=readme.txt&amp;action=delete'><img src='icon/delete.gif' width=20 height=22 alt='Delete file' border=0></a></td></tr><tr><td colspan=9>&nbsp;</td></tr></table></td></tr></table><br /><br /><table class='bottom' cellpadding=0 cellspacing=0><tr><td align='center'>Powered by <a href='http://phpfm.zalon.dk/' target='_new' class='bottom'>PHPFM</a> 0.2.3</td></tr><tr><td align='center'>Copyright © 2002 Morten Bojsen-Hansen</td></tr><tr><td>&nbsp;</td></tr><tr><td align='center'><a href='http://validator.w3.org/check/referer'><img border='0' src='icon/valid-html401.jpg' alt='Valid HTML 4.01!' height='31' width='88'></a><a href='http://jigsaw.w3.org/css-validator/'><img style='border:0;width:88px;height:31px' src='icon/valid-css.jpg' alt='Valid CSS!'></a></td></tr><tr><td>&nbsp;</td></tr><tr><td align='center'>This page was produced in 0.0" . rand(0,999) . " seconds.</td></tr></table><br /><br /></center></body></html>";

//Find our PHP shell target in the referer site
if (strstr($Attack['referer'], "phpfm")){
	 $Signature[] = "Target in URL";
}

//Finds if exact GHDB signature was used
if (strstr ($Attack['referer'], "%22Powered+by+PHPFM%22+filetype%3Aphp+-username")){
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