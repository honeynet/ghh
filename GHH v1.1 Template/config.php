<?php
/////////////////////////////////////////////////////////
//Google Hack Honeypot v1.1
//Configuration File
//http://ghh.sourceforge.net - many thanks to SourceForge
/////////////////////////////////////////////////////////

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
//Begin Global Configuration Section 
////////////////////////////////////////////////////////
//In php.ini, if register_globals is on it can cause a honeypot security bypass opportunity. If you need register_globals on, set this to false.
$RegisterGlobals = true;

////////////////////////////////////////////////////////
//Logging (CSV or MySQL?)
////////////////////////////////////////////////////////
//CSV or MySQL?
$LogType = 'CSV'; //Enter 'CSV' or 'MySQL', then complete the relevant configuration section below

	//CSV Config
	$Filename = ''; //yourORIGINALfilename.txt (this better be original!!!!!) This is where logs are being written to.

	//MySQL Config
	$Owner = ''; //There may be many people logging in the remote database, so who are you? This will determine which logs are yours.
	$Server = ''; //MySQL Server (IP, IP:port, IP:port/path/to/socket)
	$DBUser = ''; //MySQL Username
	$DBPass = ''; // $DB Password
	$DBName = 'ghh'; //Default ghh (name of the database)

////////////////////////////////////////////////////////
//End Global Configuration Section
////////////////////////////////////////////////////////

////////////////////////////////////////////////////////
//Begin Housekeeping Section
////////////////////////////////////////////////////////
$Signature = array();
$DateTime = date("m-d-Y h:i:s A");
$Attack = "";
$HoneypotName = "";
$Log = "";
error_reporting(0);
////////////////////////////////////////////////////////
//End Housekeeping Section
////////////////////////////////////////////////////////

////////////////////////////////////////////////////////
//Begin Basic Security Section (This makes the configuration file a honeypot itself to prevent fingerprinting, no transparent links to this file please.)
////////////////////////////////////////////////////////
//Checks for $RegisterGlobals so $Honeypot cannot be bypassed
if($RegisterGlobals){
	if(ini_get("register_globals")==1)
		die();
}

if(!isset($Honeypot)){
	//Set Config honeypot's name
	$HoneypotName = "CONFIG.PHP";
	//Attack Acquisition Section
	$Attack = getAttacker();
	//Determine Standard Signatures
	$Signature = standardSigs($Attack, "none");
	//Build Log
	writeLog($Owner, $HoneypotName, $DateTime, $Attack, $Signature, $LogType, $Filename, $DBName, $DBUser, $DBPass, $Server);
	exit;
}
////////////////////////////////////////////////////////
//End Basic Security Section
////////////////////////////////////////////////////////


////////////////////////////////////////////////////////
//Begin Functions Section
//Contains core functions of GHH which are shared by all honeypot files.
//Function list: getAttacker(),standardSigs(),sanitize(), writelog(), buildLog()
////////////////////////////////////////////////////////

//getAttacker() returns attacker profile
function getAttacker() {
	$Attacker = array();
	$Attacker['IP'] = isset($_SERVER['REMOTE_ADDR']) ? sanitize($_SERVER['REMOTE_ADDR'] . getProxy()) : null;
	$Attacker['request'] = isset($_SERVER['REQUEST_URI']) ? sanitize($_SERVER['REQUEST_URI']) : null;
	$Attacker['referer'] = isset($_SERVER['HTTP_REFERER']) ? sanitize($_SERVER['HTTP_REFERER']) : null;
	$Attacker['agent'] = isset($_SERVER['HTTP_USER_AGENT']) ? sanitize($_SERVER['HTTP_USER_AGENT']) : null;
	$Attacker['accept'] = isset($_SERVER['HTTP_ACCEPT']) ? sanitize($_SERVER['HTTP_ACCEPT']) : null;
	$Attacker['charset'] = isset($_SERVER['HTTP_ACCEPT_CHARSET']) ? sanitize($_SERVER['HTTP_ACCEPT_CHARSET']) : null;
	$Attacker['encoding'] = isset($_SERVER['HTTP_ACCEPT_ENCODING']) ? sanitize($_SERVER['HTTP_ACCEPT_ENCODING']) : null;
	$Attacker['language'] = isset($_SERVER['HTTP_ACCEPT_LANGUAGE']) ? sanitize($_SERVER['HTTP_ACCEPT_LANGUAGE']) : null;
	$Attacker['connection'] = isset($_SERVER['HTTP_CONNECTION']) ? sanitize($_SERVER['HTTP_CONNECTION']) : null;
	$Attacker['keep_alive'] = isset($_SERVER['HTTP_KEEP_ALIVE']) ? sanitize($_SERVER['HTTP_KEEP_ALIVE']) : null;
	return $Attacker;
}


//getProxy() Detects a proxy. If the real IP is available, it's logged.
function getProxy() {
	$proxy = array();
	
	if(isset($_SERVER['HTTP_CLIENT_IP']))
		$proxy = array_merge($proxy, explode(',', $_SERVER['HTTP_CLIENT_IP']));
	
	if(isset($_SERVER['HTTP_X_FORWARDED_FOR']))
		$proxy = array_merge($proxy, explode(',', $_SERVER['HTTP_X_FORWARDED_FOR']));
	
	if (!count($proxy) > 0) {
		if (isset($_SERVER["HTTP_PROXY_CONNECTION"]) || isset($_SERVER["HTTP_VIA"])) {
			return "::Proxy Detected";
		}
		return "";
	}
	$proxy = implode('::', $proxy);
	return '::' . $proxy;
}

//standardSigs() returns default signatures, if any are found.
function standardSigs($Attacker, $SafeReferer) {
	$results = array();

	//Was the site crawled?
	if($Attacker['referer'] == $SafeReferer) {
		$results[] = "Spider Detected"; 
	}
	//No referer found. The "only way" to reach the page is with a referer. Referers help us determine how we were attacked.
	if($Attacker['referer'] == "") {
		$results[] = "No Referer";
	}

	//Determine if an KNOWN engine was used
	$Engines = array ('lycos.com', 'google.com', 'yahoo.com', 'altavista.com', '209.202.248.202', '216.239.37.99', '216.109.112.135', '66.218.71.198');
	foreach ($Engines as $string) {
		if (strstr ($Attacker['referer'], $string)) {
			$results[] = "Known Search Engine: " . $string;
			break;
		}
	}
	return $results;
}

//sanitize() returns $_SERVER['REQUEST_URI'] stripped of any illegal chars that may corrupt the log when parsed into HTML.  500 character limit per field.
function sanitize($string) {
	$pattern[0] = '/\&/';
	$pattern[1] = '/</';
	$pattern[2] = "/>/";
	$pattern[3] = '/\n/';
	$pattern[4] = '/"/';
	$pattern[5] = "/'/";
	$pattern[6] = "/%/";
	$pattern[7] = '/\(/';
	$pattern[8] = '/\)/';
	$pattern[9] = '/\+/';
	$pattern[10] = '/-/';
	$pattern[11] = '/,/';
	$replacement[0] = '';
	$replacement[1] = '&lt;';
	$replacement[2] = '&gt;';
	$replacement[3] = '';
	$replacement[4] = '&quot;';
	$replacement[5] = '&#39;';
	$replacement[6] = '&#37;';
	$replacement[7] = '&#40;';
	$replacement[8] = '&#41;';
	$replacement[9] = '&#43;';
	$replacement[10] = ' ';
	$replacement[11] = ' ';
	
	return substr(preg_replace($pattern, $replacement, $string),0,500);
}

//writeLog() returns nothing.  Writes results of captured honeypot attack to disk or database
function writeLog($Owner, $HoneypotName, $DateTime, $Attack, $Signature, $LogType, $Filename, $DBName, $DBUser, $DBPass, $Server) {
$SigLog = '';

	if($LogType == "MySQL") {
		//Loop out discovered signatures, separated by ";" to maintain CSV array sizes
		foreach ($Signature as $string)
			$SigLog .= $string . ';';
		//Host, username, password is pulled from configuration file.
		$link = mysql_connect($Server, $DBUser, $DBPass);
		//Database name is pulled from configuration file.
		$db = mysql_select_db($DBName);
		$query = "INSERT INTO logs ( Owner, Tripped, TimeOfAttack, Host, RequestURI, Referrer, Accepts, AcceptsCharset, AcceptLanguage, Connection, keepalive, UserAgent, Signatures)
VALUES ('" . $Owner . "', '" . $HoneypotName . "', NOW( ), '" . $Attack['IP'] . "', '" . $Attack['request'] . "' , '" . $Attack['referer'] . "', '" . $Attack['accept'] . "', '" . $Attack['charset'] . "', '" . $Attack['language'] . "', '" . $Attack['connection'] . "', '" . $Attack['keep_alive'] . "', '" . $Attack['agent'] . "', '" . $SigLog . "');";

		$result = mysql_query($query, $link);

		mysql_close($link);

	}
	else { //Type is CSV
		$Log = "";
		$Log = $HoneypotName . "," . $DateTime . "," . $Attack['IP'] . "," . $Attack['request'] . "," . $Attack['referer'] . "," . $Attack['accept'] . "," . $Attack['charset'] . "," . $Attack['encoding'] . "," . $Attack['language'] . "," . $Attack['connection'] . "," . $Attack['keep_alive'] . "," . $Attack['agent'] . ",";
 
		//Loop out discovered signatures, separated by ";" to maintain CSV array sizes
		foreach ($Signature as $string)
			$Log .= $string . ';';
		//New line
		$Log .= "\n";

		if (is_writable($Filename)) {

			//Checks to see if $Filename exists, if not attempts to create file.
			if (!$handle = fopen($Filename, 'a')) {
				exit;
			}
			if (fwrite($handle, $Log) === FALSE) {
				exit;
			}
			fclose($handle);
		} 
		else {
			exit;
		}
	}
}
////////////////////////////////////////////////////////
//End Functions Section
////////////////////////////////////////////////////////
////////////////////////////////////////////////////////
//End of config.php
////////////////////////////////////////////////////////
?>