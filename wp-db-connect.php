<?
require_once("wp-config.php");// DB CONNECT	
mysql_connect(DB_HOST, DB_USER, DB_PASSWORD) or die('Could not connect: ' . mysql_error());
mysql_select_db(DB_NAME) or die('Could not select database');
mysql_query('SET NAMES "utf8"'); 	
?>