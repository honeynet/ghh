<?php
/////////////////////////////////////////////////////////
//Google Hack Honeypot v1.1
//XML-rpc server
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
$RegisterGlobals = false;

////////////////////////////////////////////////////////
//Logging (CSV or MySQL?)
////////////////////////////////////////////////////////
//CSV or MySQL?
$LogType = ''; //Enter 'CSV' or 'MySQL', then complete the relevant configuration section below

	//CSV Config
	$Filename = ''; //yourORIGINALfilename.txt (this better be original!!!!!) This is where logs are being written to.

	//MySQL Config ownder is from Ident
	$Server = ''; //MySQL Server (IP, IP:port, IP:port/path/to/socket)
	$DBUser = ''; //MySQL Username
	$DBPass = ''; //DB Password
	$DBName = ''; //Default ghh (name of the database)
	
	//TODO: if we are using mysql store the ident's and magics in a table
	$XMLsec['ident'] = "magic"; //keep a array of the idents.
	$XMLsec['second ident'] = "second magic";//you give thease to people on your honeynet
	
////////////////////////////////////////////////////////
//End Global Configuration Section
////////////////////////////////////////////////////////

////////////////////////////////////////////////////////
//Begin Housekeeping Section
////////////////////////////////////////////////////////

$DateTime = date("m-d-Y h:i:s A");

////////////////////////////////////////////////////////
//End Housekeeping Section
////////////////////////////////////////////////////////

////////////////////////////////////////////////////////
//Begin xmlrpc server
////////////////////////////////////////////////////////
include("xmlrpc.inc");
include("xmlrpcs.inc");

$server = new xmlrpc_server(array(
		"ghh.log" => array(
			"function" => "ghhlog",
			"signature" => $ghhlog_sig,
			"docstring" => $ghhlog_doc
		)
));
$ghhlog_sig = array(array($xmlrpcArray, $xmlrpcArray));
$ghhlog_doc = 'Sends what\'s pased to to writeLog after every thing is verefied and put through sanitize';


////////////////////////////////////////////////////////
//End xmlrpc server
////////////////////////////////////////////////////////

////////////////////////////////////////////////////////
//Begin Functions Section
//Contains core functions of GHH which are shared by all honeypot files.
//Function list: sanitize(), writelog()
////////////////////////////////////////////////////////

//look at $ghhlog_doc
function ghhlog($params)
{
	xmlrpc_debugmsg("Entering 'loging'");
	$Attack_dirty = php_xmlrpc_decode($params->getParam(0));
	$err="";
	$output = new xmlrpcval();
	if (isset($Attack_dirty)) {
		xmlrpc_debugmsg("Ident is {$Attack_dirty['Ident']} and magic is {$Attack_dirty['Magic']}");
		if (checkIdent($Attack_dirty['Ident'], $Attack_dirty['Magic']))
		{
			xmlrpc_debugmsg("we got an array and the ident matches");
			$Attacker = makeAttacker($Attack_dirty);//I only clean and copy over what I use
			writeLog($Attacker);
			xmlrpc_debugmsg("if all went well we just wrote to our log :-D");
		}
		else
		{
			xmlrpc_debugmsg("we got an array but the ident does not match");
		}
	} else {
		xmlrpc_debugmsg("we either didn't get a param or it was not an array");
		$err="Must be one parameter, an array of structs";
	}
	return new xmlrpcresp(new xmlrpcval("true", $GLOBALS['xmlrpcBoolean']));
}

function makeAttacker($Attack_dirty)
{
	$Attacker = array();
	$Attacker['IP'] = isset($Attack_dirty['IP']) ? sanitize($Attack_dirty['IP']) : null;
	$Attacker['request'] = isset($Attack_dirty['request']) ? sanitize($Attack_dirty['request']) : null;
	$Attacker['referer'] = isset($Attack_dirty['referer']) ? sanitize($Attack_dirty['referer']) : null;
	$Attacker['agent'] = isset($Attack_dirty['agent']) ? sanitize($Attack_dirty['agent']) : null;
	$Attacker['accept'] = isset($Attack_dirty['accept']) ? sanitize($Attack_dirty['accept']) : null;
	$Attacker['charset'] = isset($Attack_dirty['charset']) ? sanitize($Attack_dirty['charset']) : null;
	$Attacker['encoding'] = isset($Attack_dirty['encoding']) ? sanitize($Attack_dirty['encoding']) : null;
	$Attacker['language'] = isset($Attack_dirty['language']) ? sanitize($Attack_dirty['language']) : null;
	$Attacker['connection'] = isset($Attack_dirty['connection']) ? sanitize($Attack_dirty['connection']) : null;
	$Attacker['keep_alive'] = isset($Attack_dirty['keep_alive']) ? sanitize($Attack_dirty['keep_alive']) : null;
	$Attacker['SigLog']  = isset($Attack_dirty['SigLog']) ? sanitize($Attack_dirty['SigLog']) : null;
	$Attacker['Name'] = isset($Attack_dirty['Name']) ? sanitize($Attack_dirty['Name']) : null;
	$Attacker['Ident'] = isset($Attack_dirty['Ident']) ? sanitize($Attack_dirty['Ident']) : null;
	return $Attacker;
}

//checkIdent() returns true if the ident matches the cookie
function checkIdent($ident, $magic)
{
	
	// TODO: add mysql code
	$sec = $GLOBALS['XMLsec'];
	if ($sec[$ident]== '')
		return false;
	if ($sec[$ident] == $magic)
	{
		xmlrpc_debugmsg("ident and magic match");
		return true;
	} else {
		xmlrpc_debugmsg("ident and magic dont match");
		return false;
	}
}

//sanitize() returns $string stripped of any illegal chars that may corrupt the log when parsed into HTML.  500 character limit per field.
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
	$replacement[0] = '&amp;';
	$replacement[1] = '&lt;';
	$replacement[2] = '&gt;';
	$replacement[3] = '';
	$replacement[4] = '&quot;';
	$replacement[5] = '&#39;';
	$replacement[6] = '&#37;';
	$replacement[7] = '&#40;';
	$replacement[8] = '&#41;';
	$replacement[9] = '&#43;';
	$replacement[10] = '&ndash;';
	$replacement[11] = '&sbquo;';
	
	return substr(preg_replace($pattern, $replacement, $string),0,500);
}
// TODO: add a return so xmlrpc can throw a error
function writeLog($Attack) {
	$SigLog = '';
	if(strtolower($GLOBALS['LogType']) == "mysql") {
		//make the db connection
		$link = mysql_connect($GLOBALS['Server'], $GLOBALS['DBUser'], $GLOBALS['DBPass']);
		//open the db
		$db = mysql_select_db($GLOBALS['DBName']);
		$query = "INSERT INTO logs ( Owner, Tripped, TimeOfAttack, Host, RequestURI, Referrer, Accepts, AcceptsCharset, AcceptLanguage, Connection, keepalive, UserAgent, Signatures)
VALUES ('" . $Attack['Ident'] . "', '" . $Attack['Name'] . "', NOW( ), '" . $Attack['IP'] . "', '" . $Attack['request'] . "' , '" . $Attack['referer'] . "', '" . $Attack['accept'] . "', '" . $Attack['charset'] . "', '" . $Attack['language'] . "', '" . $Attack['connection'] . "', '" . $Attack['keep_alive'] . "', '" . $Attack['agent'] . "', '" . $Attack['SigLog'] . "');";

		$result = mysql_query($query, $link);

		mysql_close($link);

	} else { //Type is CSV
		$Log = "";
		$Log = $Attack['Name'] . "," . $GLOBALS['DateTime'] . "," . $Attack['IP'] . "," . $Attack['request'] . "," . $Attack['referer'] . "," . $Attack['accept'] . "," . $Attack['charset'] . "," . $Attack['encoding'] . "," . $Attack['language'] . "," . $Attack['connection'] . "," . $Attack['keep_alive'] . "," . $Attack['agent'] . ",";
 
 		//add the sig
		$Log .= $Attack['SigLog'];
		//New line
		$Log .= "\n";

		if (is_writable($GLOBALS['Filename'])) {

			//Checks to see if $Filename exists, if not attempts to create file.
			if (!$handle = fopen($GLOBALS['Filename'], 'a')) {
				return false;
			}
			if (fwrite($handle, $Log) === FALSE) {
				return false;
			}
			fclose($handle);
		} 
		else {
			return false;
		}
	}
}
////////////////////////////////////////////////////////
//End Functions Section
////////////////////////////////////////////////////////
?>
