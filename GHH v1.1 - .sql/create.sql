<?php
header("Pragma: no-cache");
header("Cache-Control: no-store, no-cache, must-revalidate");
header('Content-Type: text/plain');
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
//GHH Honeypot by GHH project for GHDB Signature #1064 (filetype:sql ("passwd values" | "password values" | "pass values" ))
////////////////////////////////////////////////////////

$HoneypotName = "ADMINSQL"; //This name should be unique if reporting multiple honeypots to one file or database. Helps determine what honeypot made a log.

$Length = rand(5,75); //Length of the file... how many commands are run

$File = array(); // Array full of types of SQL commands...
$Commands = array('INSERT', 'CREATE', 'NEWLINE'); //Types of SQL commands we are going to generate
//Force at least 1 googleable admin line
$File[] = "ADMIN"; //force a ", password) value (****) to be google hackable

//Fill the $File array with SQL commands to fake
for($i=0;$i<$Length;$i++){
$File[] = $Commands[rand(0, sizeof($Commands)-1)];
}

//Depending on command (INSERT, CREATE, ADMIN) fake some SQL commands
shuffle($File);
for($i=0;$i<sizeof($File)-1;$i++){

	switch($File[$i]){
	case 'INSERT':
		CreateInserts();
		break;
	case 'CREATE':
		if(rand(0,1))
			CreateTableUnformatted();
		else CreateTableFormatted();
		break;
	case 'ADMIN':
		CreateAdminInsert();
		break;
	case 'NEWLINE':
		echo "\n";
		break;
	}

}

//Fake the google hackable insert statement
function CreateAdminInsert(){
$i = rand(0, 2);
switch ($i) {
case 0:
   echo "INSERT INTO " . DumpTableName() . " (" . DumpInputFields() . "'pass') VALUES (" . DumpDataPass() . ");\n";
   break;
case 1:
   echo "insert into " . DumpTableName() . " (" . DumpInputFields() . "'password) values (" . DumpDataPass() . ");\n";
   break;
case 2:
   echo "INSERT INTO '" . DumpTableName() . "' (" . DumpInputFields() . "'passwd) VALUES (" . DumpDataPass() . ");\n";
   break;
case 3:
   echo "INSERT INTO " . DumpTableName() . " (" . DumpInputFields() . "'PASS') VALUES (" . DumpDataPass() . ");\n";
   break;
case 4:
   echo "insert into " . DumpTableName() . " (" . DumpInputFields() . "'PASSWORD') values (" . DumpDataPass() . ");\n";
   break;
case 5:
   echo "INSERT INTO '" . DumpTableName() . "' (" . DumpInputFields() . "'PASSWD') VALUES (" . DumpDataPass() . ");\n";
   break;
}
}
//Fake some Insert statements
function CreateInserts(){
$i = rand(0, 3);
switch ($i) {
case 0:
   echo "INSERT INTO " . DumpTableName() . " (" . DumpInputFields() . ") VALUES (" . DumpDataFields() . ");\n";
   break;
case 1:
   echo "insert into " . DumpTableName() . " (" . DumpInputFields() . ") values (" . DumpDataFields() . ");\n";
   break;
case 2:
   echo "INSERT INTO '" . DumpTableName() . "' (" . DumpInputFields() . ") VALUES (" . DumpDataFields() . ");\n";
   break;
case 3:
   echo "insert into '" . DumpTableName() . "' (" . DumpInputFields() . ") values (" . DumpDataFields() . ");\n";
   break;
}

}
//Fake a create statement, without good looking multiline formatting
function CreateTableUnformatted(){
	$Size = rand(2,5);
	$Table = DumpTableName();
	echo "CREATE TABLE '$Table' (";
		if(rand(0,1)){
			for($i = 0;$i<$Size;$i++){
			echo " '". DumpFieldName() . "' ". DumpDataType() . " " . DumpDefault() . ", ";
			}
			echo " '". DumpFieldName() . "' ". DumpDataType() . " " . DumpDefault() . " ";}
		else {
			for($i = 0;$i<$Size;$i++){
				echo "'". DumpFieldName() . "' ". DumpDataType() . " " . DumpDefault() . ", ";
			}
			echo "'". DumpFieldName() . "' ". DumpDataType() . " " . DumpDefault() . "\n";
		}
	echo ")";
		if(rand(0,1))
			echo  " TYPE=" . DumpType() .";\n";
		else echo ";\n";
}

//Fake a create statement, WITH good looking multiline formatting
function CreateTableFormatted(){
	$Size = rand(2,5);
	$Table = DumpTableName();
	echo "CREATE TABLE '$Table' (\n";
		if(rand(0,1)){
			for($i = 0;$i<$Size;$i++){
			echo "  '". DumpFieldName() . "' ". DumpDataType() . " " . DumpDefault() . ",\n";
			}
			echo "  '". DumpFieldName() . "' ". DumpDataType() . " " . DumpDefault() . "\n";}
		else {
			for($i = 0;$i<$Size;$i++){
				echo "'". DumpFieldName() . "' ". DumpDataType() . " " . DumpDefault() . ",\n";
			}
			echo "'". DumpFieldName() . "' ". DumpDataType() . " " . DumpDefault() . "\n";
		}
	echo ")";
		if(rand(0,1))
			echo  " TYPE=" . DumpType() .";\n";
		else echo ";\n";
}
//Randomly dump a password
function DumpPassword(){
	//Type of password - 0 MD5, 1 easy plaintext, 2 ugly plaintext
	//To remove MD5 output, change to $Type = rand(1,2);
	$Type = rand(0,2);

		if ($Type == 0){
	
		$MD5 = array(0,1,2,3,4,5,6,7,8,9,'a','b','c','d','e','f');
		$pass = '';
			for ($i=0;$i<32;$i++){
				$pass .= $MD5[rand(0,15)];
			}
		return $pass;
		}

		//Easy plaintext Passwords!
		if ($Type == 1){
	
			$EZPass = array('admin', 'Admin', 'ADMIN', 'administrator', 'ADMINISTRATOR', 'root', '1234', '11111', 'pass', 'passwd', 'password');
			return $EZPass[rand(0,sizeof($EZPass)-1)];
		}

		//Hard plaintext passwords!
		if ($Type == 2){

			$Length = rand(4,10);
			$pass = '';
			$a = rand(0,5);

				if($a==0){
					for($i=0;$i<$Length;$i++){
					$pass .= chr(rand(48,57));
				}
		}
		
			if($a==1){
				for($i=0;$i<$Length;$i++){
					$pass .= chr(rand(65,90));
				}
			}
	
			if($a==2){
				for($i=0;$i<$Length;$i++){
					$pass .= chr(rand(97,122));
				}
			}
			if($a==3){
				for($i=0;$i<$Length;$i++){
					$pass .= chr(rand(65,122));
				}
			}
			if($a==4){
				for($i=0;$i<$Length;$i++){
					$pass .= chr(rand(48,90));
				}
			}
			if($a==5){
				for($i=0;$i<$Length;$i++){
					$pass .= chr(rand(48,122));
				}
			}
		
	return $pass;
}
}//End Dump Pass Function

//Dump Random Usernames
function DumpUser(){
	//0 for generated, 1 for popular
	$a = rand(0,1);
	$Length = rand(5,9);
	$vowels = array('a','e', 'i', 'o', 'u', 'y');
	$pass = '';
	//Generate name
		if ($a == 0){
				for($i=0;$i<$Length;$i++){
					$pass .= chr(rand(97,122));
					$pass .= $vowels[rand(0,5)];
				}
		return $pass;
		}
	//Typical users
		if ($a == 1){
			$names = array('root', 'admin', 'ROOT', 'ADMIN', 'administrator', 'ADMINISTRATOR');
			return $names[rand(0,sizeof($names)-1)];
		}
}

//Random data type
function DumpDataType(){
	$Types = array('INT', 'BLOB', 'TEXT', 'TINYINT', 'TIMESTAMP', 'VARCHAR', 'SET', 'FLOAT', 'MEDIUMINT', 'BOOL', 'TIME', 'DATE',
 'INT(' . rand(1,15) . ')', 'BLOB(' . rand(1,15) . ')', 'TEXT(' . rand(1,15) . ')', 'TINYINT(' . rand(1,15) . ')', 'VARCHAR(' . rand(1,255) . ')', 'SET', 'FLOAT(' . rand(1,15) . ')', 'MEDIUMINT(' . rand(1,15) . ')', 'BOOL', 'TIME', 'DATE');
	return $Types[rand(0, sizeof($Types)-1)];
}
//Random table name (interesting names ;)
function DumpTableName(){
	$TableNames = array('account', 'accounts', 'payment', 'payments', 'receipts', 'customers', 'transfers', 'users', 'user', 'records', 'passwords', 'passwds', 'hashes', 'admin', 'Administrator', 'ADMIN', 'Owner', 'data', 'email', 'pass', 'ACCOUNTS', 'PAYMENT', 'TRANS', 'USER');
	return $TableNames[rand(0, sizeof($TableNames)-1)];
}
//Random field names
function DumpFieldName(){
	$FieldNames = array('ID', 'id', 'fname', 'firstname', 'lastname', 'fullname', 'lname', 'lastname', 'mname', 'middlename', 'size', 'mdata', 'sig', 'default', 'description', 'DOB' , 'pass');
	return $FieldNames[rand(0, sizeof($FieldNames)-1)];
}
//Some other field data
function DumpDefault(){
	$Default = array("NOT NULL default ''", "default NULL", "default ''");
	return $Default[rand(0, sizeof($Default)-1)];
}
//Type of table
function DumpType(){
	$Type = array("ISAM", "MyISAM", "ISAM", "MyISAM", "InnoDB", "BDB", "MERGE", "HEAP");
	return $Type[rand(0, sizeof($Type)-1)];
}
//makes that field line after an insert statement (ie ('asdf','asdfasdf','asdfasd','asdfasdf') )
function DumpInputFields(){
	$Length = rand(3,6);	
	$Input = "'". DumpFieldName() . "', ";

		for($i=0; $i<$Length; $i++)
			$Input .= "'". DumpFieldName() . "', "; 
	$Input .= "'". DumpFieldName() . "'";
return $Input;
}
//makes that data line after an insert statement (ie ('asdf','asdfasdf','asdfasd','asdfasdf') )
function DumpDataFields(){
	$Length = rand(3,6);	
	$Input = "'". DumpUser() . "', ";

		for($i=0; $i<$Length; $i++)
			$Input .= "'". DumpUser() . "', "; 
	$Input .= "'". DumpPassword() . "'";
return $Input;
}
//dumps a google hackable password line.
function DumpDataPass(){
	$Length = rand(3,6);	
	$Input = "'". DumpPassword() . "', ";

		for($i=0; $i<$Length; $i++)
			$Input .= "'". DumpPassword() . "', "; 
	$Input .= "'". DumpPassword() . "'";
return $Input;
}

//Find our target in the referrer site
if (strstr($Attack['referer'], "admin") || strstr($Attach['referer'], "sql")){
 $Signature[] = "Target in URL";
}

//Finds if exact GHDB signature was used
if (strstr ($Attack['referer'], "filetype%3Asql+%28%22passwd+values%22+%7C+%22password+values%22+%7C+%22pass+values%22+%29")){
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
