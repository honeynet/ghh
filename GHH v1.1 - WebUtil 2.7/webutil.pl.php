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
//GHH Honeypot by GHH project for GHDB Signature #769 (inurl:webutil.pl)
////////////////////////////////////////////////////////
$HoneypotName = "WEBUTIL"; //This name should be unique if reporting multiple honeypots to one file or database. Helps determine what honeypot made a log.

//WebUtil 2.7 GHH Honeypot

print <<<END
<html><head><title>WebUtil</title></head>
<body><center><h1>WebUtil Version: 2.7</h1>
<h6>By The Puppet Master</h6>
<h3>Make Your Choice Below</h3></center>
<hr><center>
<table border=0 width=600>
<tr><td align=center>
Note: Depending on present net traffic and the speed of your link,
<br>Some of these commands may take a long time.  Patience is
a virtue.
</td></tr></table>
<table border=0 width=150>
<tr><td>
<ul>

END;
echo "<li><a href=\"http://" . $_SERVER['HTTP_HOST'] . "/cgi-bin/webutil.pl?ping\">ping</a></li>";
echo "<li><a href=\"http://" . $_SERVER['HTTP_HOST'] . "/cgi-bin/webutil.pl?traceroute\">traceroute</a></li>";
echo "<li><a href=\"http://" . $_SERVER['HTTP_HOST'] . "/cgi-bin/webutil.pl?whois\">whois</a></li>";
echo "<li><a href=\"http://" . $_SERVER['HTTP_HOST'] . "/cgi-bin/webutil.pl?finger\">finger</a></li>";
echo "<li><a href=\"http://" . $_SERVER['HTTP_HOST'] . "/cgi-bin/webutil.pl?nslookup\">nslookup</a></li>";
echo "<li><a href=\"http://" . $_SERVER['HTTP_HOST'] . "/cgi-bin/webutil.pl?host\">host</a></li>";
echo "<li><a href=\"http://" . $_SERVER['HTTP_HOST'] . "/cgi-bin/webutil.pl?dnsquery\">dnsquery</a></li>";
echo "<li><a href=\"http://" . $_SERVER['HTTP_HOST'] . "/cgi-bin/webutil.pl?dig\">dig</a></li>";
echo "<li><a href=\"http://" . $_SERVER['HTTP_HOST'] . "/cgi-bin/webutil.pl?calendar\">calendar</a></li>\n\n";

echo "<li><a href=\"http://" . $_SERVER['HTTP_HOST'] . "/cgi-bin/webutil.pl?uptime\">uptime</a></li>";
print <<<END
</ul>
</td></tr></table>
<p>
<font size="-1">WebUtil &copy; Copyright 1998-2001 <a href="http://www.ravensclaw.com/~pmaster/perl/">The Puppet Master</a><br>
Parsform.pl Is &copy; Copyright <a href="http://www.cgi-perl.com">The CGI/Perl Cookbook</a><br>by Matt Wright &amp; Craig Patchett

</font></center>
</body></html>
END;

//Find our target in the referrer site
if (strstr($Attack['referer'], "webutil.pl")){
 $Signature[] = "Target in URL";
}

//Finds if exact GHDB signature was used
if (strstr ($Attack['referer'], "inurl%3Awebutil.pl")){
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
