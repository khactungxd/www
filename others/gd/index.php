<?
if ($_GET['code']){
	header("Location: http://192.168.10.236:3400/oauth2callback?code=".$_GET['code']);
}

?>