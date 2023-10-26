<!-- script to connect to sneakerhive database -->
<?php
@$dbcnx = new mysqli('localhost','root','','sneakerhive');
// @ to ignore error message display //
if ($dbcnx->connect_error){
	echo "Database is not online"; 
	exit;
	// above 2 statments same as die() //
	}
/*	else
	echo "Congratulations...  MySql is working..";
*/
if (!$dbcnx->select_db ("sneakerhive"))
	exit("<p>Unable to locate the sneakerhive database</p>");
?>	