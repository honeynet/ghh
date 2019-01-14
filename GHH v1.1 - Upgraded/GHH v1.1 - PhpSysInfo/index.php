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
//GHH Honeypot by Ryan McGeehan for GHDB Signature #161 (inurl:phpSysInfo/ "created by phpsysinfo")
////////////////////////////////////////////////////////
$HoneypotName = "PHPSYSINFO";

$OS = ""; //This will change the OS icon, pick the icon prefix from the icons folder. Possible Values:
//Arch, Darwin, Debian, Fedora, FreeBSD, Gentoo, Mandrake, NetBSD, OpenBSD, Redhat, Slackware, Suse, Trustix, free-eos, xp

$OSName = ""; //Full Name of the OS, I.E. Microsoft Windows XP Professional

//Trick PHP Shell page
echo "<!DOCTYPE HTML PUBLIC \"-//W3C//DTD HTML 4.01 Transitional//EN\"><html><!--	Created By: phpSysInfo - 2.3	http://phpsysinfo.sourceforge.net/--><head>    <title>System Information -- localhost --    </title>    <link rel=\"STYLESHEET\" type=\"text/css\" href=\"templates/classic/classic.css\"></head><body dir=ltr><center><h1>System Information: localhost (127.0.0.1)</h1></center><table width=\"100%\" align=\"center\"> <tr>  <td width=\"50%\" valign=\"top\">   <table width=\"100%\"> <tr>  <td>    <table class=\"box\">     <tr class=\"boxheader\">      <td class=\"boxheader\">System Vital</td>     </tr>     <tr class=\"boxbody\">      <td><table border=\"0\" width=\"90%\" align=\"center\"><tr><td valign=\"top\"><font size=\"-1\">Canonical Hostname</font></td><td><font size=\"-1\">localhost</font></td></tr><tr><td valign=\"top\"><font size=\"-1\">Listening IP</font></td><td><font size=\"-1\">127.0.0.1</font></td></tr><tr><td valign=\"top\"><font size=\"-1\">Kernel Version</font></td><td>&nbsp;</td>      </tr><tr><td valign=\"top\"><font size=\"-1\">Distro Name</font></td><td><img width=\"16\" height=\"16\" alt=\"\" src=\"images/$OS.gif\">&nbsp;<font size=\"-1\">$OSName</font></td></tr><tr><td valign=\"top\"><font size=\"-1\">Uptime</font></td><td>&nbsp;</td>      </tr><tr><td valign=\"top\"><font size=\"-1\">Current Users</font></td><td>&nbsp;</td>      </tr><tr><td valign=\"top\"><font size=\"-1\">Load Averages</font></td><td>&nbsp;</td>      </tr></table></td>     </tr>    </table>   </td>  </tr></table>   <br>   <table width=\"100%\"> <tr>  <td>    <table class=\"box\">     <tr class=\"boxheader\">      <td class=\"boxheader\">Network Usage</td>     </tr>     <tr class=\"boxbody\">      <td><table border=\"0\" width=\"90%\" align=\"center\"><tr><td align=\"left\" valign=\"top\"><font size=\"-1\"><b>Device</b></font></td><td align=\"right\" valign=\"top\"><font size=\"-1\"><b>Received</b></font></td><td align=\"right\" valign=\"top\"><font size=\"-1\"><b>Sent</b></font></td><td align=\"right\" valign=\"top\"><font size=\"-1\"><b>Err/Drop</b></font></td>	<tr>		<td align=\"left\" valign=\"top\">&nbsp;</td>		<td align=\"right\" valign=\"top\"><font size=\"-1\">0.00 KB</font></td>		<td align=\"right\" valign=\"top\"><font size=\"-1\">0.00 KB</font></td>		<td align=\"right\" valign=\"top\"><font size=\"-1\">0/0</font></td>	</tr>	<tr>		<td align=\"left\" valign=\"top\">&nbsp;</td>		<td align=\"right\" valign=\"top\"><font size=\"-1\">0.00 KB</font></td>		<td align=\"right\" valign=\"top\"><font size=\"-1\">0.00 KB</font></td>		<td align=\"right\" valign=\"top\"><font size=\"-1\">0/0</font></td>	</tr></table></td>     </tr>    </table>   </td>  </tr></table>  </td>  <td width=\"50%\" valign=\"top\">   <table width=\"100%\"> <tr>  <td>    <table class=\"box\">     <tr class=\"boxheader\">      <td class=\"boxheader\">Hardware Information</td>     </tr>     <tr class=\"boxbody\">      <td><table border=\"0\" width=\"90%\" align=\"center\"><tr><td valign=\"top\"><font size=\"-1\">Model</font></td><td><font size=\"-1\">&nbsp;              </font></td>      </tr><tr><td valign=\"top\"><font size=\"-1\">Chip MHz</font></td><td>&nbsp;</td>      </tr><tr><td valign=\"top\"><font size=\"-1\">PCI Devices</font></td><td><font size=\"-1\"><br>      </font></td></tr><tr><td valign=\"top\"><font size=\"-1\">IDE Devices</font></td><td><font size=\"-1\"><br>      </font></td></tr><tr><td valign=\"top\"><font size=\"-1\">USB Devices</font></td><td><font size=\"-1\"><br>      </font></td></tr></table></td>     </tr>    </table>   </td>  </tr></table>  </td> </tr> <tr>  <td colspan=\"2\">   <table width=\"100%\"> <tr>  <td>    <table class=\"box\">     <tr class=\"boxheader\">      <td class=\"boxheader\">Memory Usage</td>     </tr>     <tr class=\"boxbody\">      <td><table border=\"0\" width=\"90%\" align=\"center\"><tr><td align=\"left\" valign=\"top\"><font size=\"-1\"><b>Type</b></font></td><td align=\"left\" valign=\"top\"><font size=\"-1\"><b>Percent Capacity</b></font></td><td align=\"right\" valign=\"top\"><font size=\"-1\"><b>Free</b></font></td><td align=\"right\" valign=\"top\"><font size=\"-1\"><b>Used</b></font></td><td align=\"right\" valign=\"top\"><font size=\"-1\"><b>Size</b></font></td></tr><tr><td align=\"left\" valign=\"top\"><font size=\"-1\">Physical Memory</font></td><td align=\"left\" valign=\"top\"><font size=\"-1\"><img height=\"10\" src=\"templates/classic/images/bar_left.gif\" alt=\"\"><img src=\"templates/classic/images/bar_middle.gif\" height=\"10\" width=\"116\" alt=\"\"><img height=\"10\" src=\"templates/classic/images/bar_right.gif\" alt=\"\">&nbsp;&nbsp;% </font></td>      <td align=\"right\" valign=\"top\">&nbsp;</td><td align=\"right\" valign=\"top\">&nbsp;</td>      <td align=\"right\" valign=\"top\">&nbsp;</td>      <tr><td align=\"left\" valign=\"top\"><font size=\"-1\">Disk Swap</font></td>      <td align=\"left\" valign=\"top\"><font size=\"-1\"><img height=\"10\" src=\"templates/classic/images/bar_left.gif\" alt=\"\"><img src=\"templates/classic/images/bar_middle.gif\" height=\"10\" width=\"4\" alt=\"\"><img height=\"10\" src=\"templates/classic/images/bar_right.gif\" alt=\"\">&nbsp;&nbsp;% </font></td><td align=\"right\" valign=\"top\">&nbsp;</td>      <td align=\"right\" valign=\"top\">&nbsp;</td>      <td align=\"right\" valign=\"top\">&nbsp;</td>      </table></td>     </tr>    </table>   </td>  </tr></table>  </td> </tr> <tr>  <td colspan=\"2\">   <table width=\"100%\"> <tr>  <td>    <table class=\"box\">     <tr class=\"boxheader\">      <td class=\"boxheader\">Mounted Filesystems</td>     </tr>     <tr class=\"boxbody\">      <td><table border=\"0\" width=\"90%\" align=\"center\"><tr><td align=\"left\" valign=\"top\"><font size=\"-1\"><b>Mount</b></font></td><td align=\"left\" valign=\"top\"><font size=\"-1\"><b>Type</b></font></td><td align=\"left\" valign=\"top\"><font size=\"-1\"><b>Partition</b></font></td><td align=\"left\" valign=\"top\"><font size=\"-1\"><b>Percent Capacity</b></font></td><td align=\"right\" valign=\"top\"><font size=\"-1\"><b>Free</b></font></td><td align=\"right\" valign=\"top\"><font size=\"-1\"><b>Used</b></font></td><td align=\"right\" valign=\"top\"><font size=\"-1\"><b>Size</b></font></td></tr>	<tr>		<td align=\"left\" valign=\"top\">&nbsp;</td>		<td align=\"left\" valign=\"top\"><font size=\"-1\"></font></td>		<td align=\"left\" valign=\"top\"><font size=\"-1\">Removeable Disk (3 1/2 in.)</font></td>		<td align=\"left\" valign=\"top\"><font size=\"-1\"><img height=\"10\" src=\"templates/classic/images/bar_left.gif\" alt=\"\"><img src=\"templates/classic/images/bar_middle.gif\" height=\"10\" width=\"1\" alt=\"\"><img src=\"templates/classic/images/bar_right.gif\" height=\"10\" alt=\"\">&nbsp;</font></td>		<td align=\"right\" valign=\"top\">&nbsp;</td>		<td align=\"right\" valign=\"top\">&nbsp;</td>		<td align=\"right\" valign=\"top\">&nbsp;</td>	</tr>	<tr>		<td align=\"left\" valign=\"top\">&nbsp;</td>		<td align=\"left\" valign=\"top\">&nbsp;</td>		<td align=\"left\" valign=\"top\"><font size=\"-1\">Local Disk</font></td>		<td align=\"left\" valign=\"top\"><font size=\"-1\"><img height=\"10\" src=\"templates/classic/images/redbar_left.gif\" alt=\"\"><img src=\"templates/classic/images/redbar_middle.gif\" height=\"10\" width=\"192\" alt=\"\"><img height=\"10\" src=\"templates/classic/images/redbar_right.gif\" alt=\"\">&nbsp;</font></td>		<td align=\"right\" valign=\"top\">&nbsp;</td>		<td align=\"right\" valign=\"top\">&nbsp;</td>		<td align=\"right\" valign=\"top\">&nbsp;</td>	</tr>	<tr>		<td align=\"left\" valign=\"top\">&nbsp;</td>		<td align=\"left\" valign=\"top\">&nbsp;</td>		<td align=\"left\" valign=\"top\"><font size=\"-1\">Local Disk</font></td>		<td align=\"left\" valign=\"top\"><font size=\"-1\"><img height=\"10\" src=\"templates/classic/images/bar_left.gif\" alt=\"\"><img src=\"templates/classic/images/bar_middle.gif\" height=\"10\" width=\"148\" alt=\"\"><img height=\"10\" src=\"templates/classic/images/bar_right.gif\" alt=\"\">&nbsp;</font></td>		<td align=\"right\" valign=\"top\">&nbsp;</td>		<td align=\"right\" valign=\"top\">&nbsp;</td>		<td align=\"right\" valign=\"top\">&nbsp;</td>	</tr>	<tr>		<td align=\"left\" valign=\"top\">&nbsp;</td>		<td align=\"left\" valign=\"top\"><font size=\"-1\"></font></td>		<td align=\"left\" valign=\"top\"><font size=\"-1\">Compact Disc</font></td>		<td align=\"left\" valign=\"top\"><font size=\"-1\"><img height=\"10\" src=\"templates/classic/images/bar_left.gif\" alt=\"\"><img src=\"templates/classic/images/bar_middle.gif\" height=\"10\" width=\"1\" alt=\"\"><img src=\"templates/classic/images/bar_right.gif\" height=\"10\" alt=\"\">&nbsp;</font></td>		<td align=\"right\" valign=\"top\">&nbsp;</td>		<td align=\"right\" valign=\"top\">&nbsp;</td>		<td align=\"right\" valign=\"top\">&nbsp;</td>	</tr>	<tr>		<td align=\"left\" valign=\"top\">&nbsp;</td>		<td align=\"left\" valign=\"top\">&nbsp;</td>		<td align=\"left\" valign=\"top\"><font size=\"-1\">Compact Disc</font></td>		<td align=\"left\" valign=\"top\"><font size=\"-1\"><img height=\"10\" src=\"templates/classic/images/redbar_left.gif\" alt=\"\"><img src=\"templates/classic/images/redbar_middle.gif\" height=\"10\" width=\"200\" alt=\"\"><img height=\"10\" src=\"templates/classic/images/redbar_right.gif\" alt=\"\">&nbsp;</font></td>		<td align=\"right\" valign=\"top\">&nbsp;</td>		<td align=\"right\" valign=\"top\">&nbsp;</td>		<td align=\"right\" valign=\"top\">&nbsp;</td>	</tr><tr><td colspan=\"3\" align=\"right\" valign=\"top\"><font size=\"-1\"><i>Totals :&nbsp;&nbsp;</i></font></td>		<td align=\"left\" valign=\"top\"><font size=\"-1\"><img height=\"10\" src=\"templates/classic/images/bar_left.gif\" alt=\"\"><img src=\"templates/classic/images/bar_middle.gif\" height=\"10\" width=\"162\" alt=\"\"><img height=\"10\" src=\"templates/classic/images/bar_right.gif\" alt=\"\">&nbsp;</font></td><td align=\"right\" valign=\"top\">&nbsp;</td><td align=\"right\" valign=\"top\">&nbsp;</td><td align=\"right\" valign=\"top\">&nbsp;</td></tr></table></td>     </tr>    </table>   </td>  </tr></table>  </td> </tr></table><table width=\"100%\"> <tr>  <td width=\"67%\" valign=\"top\">      <br>     </td>  <td width=\"33%\" valign=\"top\">     </td> </tr></table><center><form method=\"POST\" action=\"\">	Template:&nbsp;	<select name=\"template\">		<option value=\"aq\">aq</option>		<option value=\"black\">black</option>		<option value=\"blue\">blue</option>		<option value=\"bulix\">bulix</option>		<option value=\"classic\" SELECTED>classic</option>		<option value=\"kde\">kde</option>		<option value=\"metal\">metal</option>		<option value=\"orange\">orange</option>		<option value=\"typo3\">typo3</option>		<option value=\"wintendoxp\">wintendoxp</option>		<option value=\"xml\">XML</option>		<option value=\"random\">random</option>	</select>	&nbsp;Language:&nbsp;	<select name=\"lng\">		<option value=\"ar_utf8\">ar_utf8</option>		<option value=\"bg\">bg</option>		<option value=\"big5\">big5</option>		<option value=\"br\">br</option>		<option value=\"ca\">ca</option		<option value=\"cn\">cn</option>		<option value=\"cs\">cs</option>		<option value=\"ct\">ct</option>		<option value=\"da\">da</option>		<option value=\"de\">de</option>		<option value=\"en\" SELECTED>en</option>		<option value=\"es\">es</option>		<option value=\"et\">et</option>		<option value=\"eu\">eu</option>		<option value=\"fi\">fi</option>		<option value=\"fr\">fr</option>		<option value=\"gr\">gr</option>		<option value=\"he\">he</option>		<option value=\"hu\">hu</option>		<option value=\"id\">id</option>		<option value=\"is\">is</option>		<option value=\"it\">it</option>		<option value=\"ja\">ja</option>		<option value=\"jp\">jp</option>		<option value=\"ko\">ko</option>		<option value=\"lt\">lt</option>		<option value=\"lv\">lv</option>		<option value=\"nl\">nl</option>		<option value=\"no\">no</option>		<option value=\"pl\">pl</option>		<option value=\"pt\">pt</option>		<option value=\"pt-br\">pt-br</option>		<option value=\"ro\">ro</option>		<option value=\"ru\">ru</option>		<option value=\"sk\">sk</option>		<option value=\"sv\">sv</option>		<option value=\"tr\">tr</option>		<option value=\"tw\">tw</option>	</select>	<input type=\"submit\" value=\"Submit\"></form></center><hr>Created by<a href=\"http://phpsysinfo.sourceforge.net\">&nbsp;phpSysInfo-2.3</a> on Feb 11, 2005 at <br></body></html>";

//Find our target in the referer site
if (strstr($Attack['referer'], "phpsysinfo")){
	 $Signature[] = "phpsysinfo found";
}

//Finds if exact GHDB signature was used
if (strstr ($Attack['referer'], "inurl%3AphpSysInfo%2F+%22created+by+phpsysinfo%22")){
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