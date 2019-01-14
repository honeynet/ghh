<?php
/////////////////////////////////////////////////////////
//Google Hack Honeypot v1.1
//Log Viewer - Written by Kevin Benes
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


//Login user & pass
$GHHUser = 'asdf';
$GHHPass = 'fdsa';

//MySQL Configuration
$server = 'localhost';
$user = 'root';       
$pass = '';          

//No need to edit further

  if (!isset($_SERVER['PHP_AUTH_USER'])) {
   header('WWW-Authenticate: Basic realm="My Realm"');
   header('HTTP/1.0 401 Unauthorized');
   exit;
  } else {
if (!($_SERVER['PHP_AUTH_USER'] == $GHHUser && $_SERVER['PHP_AUTH_PW'] == $GHHPass))
die();
}
 
$link = mysql_connect($server, $user, $pass);
if (!$link) {
	die(' Could not connect: ' . mysql_error());
}
mysql_select_db("ghh", $link);
print('</font>');
?><html>
	<head>

<style><!--
.header {
	font-family: Verdana, Arial, Helvetica, sans-serif;
	font-size: 12px;
	font-weight: bold;
}
.data {
	font-family: Verdana, Arial, Helvetica, sans-serif;
	font-size: 12px;

}
.datatable {
	font-family: Verdana, Arial, Helvetica, sans-serif;
	font-size: 12px;
}


//-->
</style>
	</head>


	<title> GHH Beta statistics page </title>
<body>
	<table class="datatable">
		
				<?php
				$order = (isset($_GET['sort'])) ? sanitize($_GET['sort'])  : 'ID';
				$sort = (isset($_GET['order'])) ? sanitize_int($_GET['order']) : '0';
				
				echo '<tr>';
				$sortby = ($sort) ? 'asc' : 'desc';

				$sql = "SELECT * FROM logs order by $order $sortby";
				$result = mysql_query($sql) or die (mysql_error());
				while ($field = mysql_fetch_field($result)){
					echo '<td class="header"><a href="index.php?sort='. $field->name .'">' . $field->name . '</a><a href="index.php?sort='. $field->name . '&order=0">[+</a><a href="index.php?sort='. $field->name . '&order=1">-]</a></td>';
				}
				echo '</tr>';	 
				while ($row = mysql_fetch_row($result)) {
					echo '<tr>';
					for($i = 0; $i < count($row); $i++) {
						echo '<td class="data">'.$row[$i].'</td>';
					}
					
				}
				
?>
	</table>


</body>
		
</html>
<?php
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
function sanitize_int($integer, $min='', $max='')
{
  $int = intval($integer);
  if((($min != '') && ($int < $min)) || (($max != '') && ($int > $max)))
    return FALSE;
  return $int;
}
?>
