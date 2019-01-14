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
//GHH Honeypot by GHH project for GHDB Signature #937 (filetype:blt "buddylist")
////////////////////////////////////////////////////////
$HoneypotName = "AIMBUDDYLIST"; //This name should be unique if reporting multiple honeypots to one file or database. Helps determine what honeypot made a log.

print <<<END
Config {
 version 1 
}
User {
 screenName 
END;

echo GenerateUsername();

print <<<END

 profile {
  mimeType "text/aolrtf; charset=\"us-ascii\"" 
END;

//echo GenerateProfile();

print <<<END

 }
}
Login {
 authorizer {
  hostName login.oscar.aol.com 
  port 5190 
 }
 useProxy 
END;
echo rand(0,1) ? "true" : "false";
GenerateProxy();

GenerateLoginNetwork();

print <<<END

Buddy {
 list {

END;
echo GenerateBuddies();

print <<<END
 }
}
END;

//Begin Functions
function GenerateProxy(){
switch(rand(0,3))  {
case 0:
print <<<END
 proxy {
  protocol SOCKS4 
  hostName localhost 
  port 1080 
  dnsLookUp true 
}

END;
   break;
case 1:
print <<<END
 proxy {
  protocol SOCKS4 
  hostName  
  port 1080 
  dnsLookUp false 
 }

END;
   break;
case 2:
print <<<END
 proxy {
  protocol SOCKS4 
  hostName  
  port 1080 
  dnsLookUp false 
 }

END;
   break;
}

}

function GenerateLoginNetwork(){
	$a = " keepAlive ";
	$a .= (rand(0,1) ? "true\n" : "false\n");
	$b = " reconnect ";
	$b .= (rand(0,1) ? "true\n" : "false\n"); 
	$c = " displayReconnect ";
	$c .= (rand(0,1) ? "true\n" : "false\n");
	$d = " autoLogin ";
	$d .= (rand(0,1) ? "true" : "false\n");
	echo $a.$b.$c.$d;
}

function GenerateBuddies(){
$size = rand(0,200);
$BuddyList = '';
	for($i=0; $i<$size;$i++){
		if (rand(0,1))
			$Buddy = "   " . chr(rand(65,90));
		else $Buddy = "   " . chr(rand(97,122));
	
		$BuddyLength = rand(5,16);
		for ($j=0; $j<$BuddyLength; $j++){
			switch (rand(0,2)){
				case 0: $Buddy .= chr(rand(65,90));
				break;
				case 1: $Buddy .= chr(rand(97,122));
				break;
				case 2: $Buddy .= chr(rand(48,57));
				break;
			}
		
		}
	$BuddyList .= $Buddy . "\n";
	}
return $BuddyList;
}

function GenerateUsername(){

if (rand(0,1))
			$Buddy = chr(rand(65,90));
		else $Buddy = chr(rand(97,122));
	
		$BuddyLength = rand(5,16);
		for ($j=0; $j<$BuddyLength; $j++){
			switch (rand(0,2)){
				case 0: $Buddy .= chr(rand(65,90));
				break;
				case 1: $Buddy .= chr(rand(97,122));
				break;
				case 2: $Buddy .= chr(rand(48,57));
				break;
			}
			
		}
		return $Buddy;
}
//Find our target in the referrer site
if (strstr($Attack['referer'], "buddylist") || strstr($Attach['referer'], "blt"){
 $Signature[] = "Target in URL";
}

//Finds if exact GHDB signature was used
if (strstr ($Attack['referer'], "filetype%3Ablt+%22buddylist%22")){
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
