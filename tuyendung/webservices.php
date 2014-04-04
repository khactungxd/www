<?
require('../wp-db-connect.php');
require('../helper/mysql.helper.php');

$query=$_POST['q'];
	if (!$query) $query=$_GET['q']; // TEST
$ip=$_POST['ip'];
	if (!$ip) $ip=$_GET['ip'];

if ($query=="start_english_test"){
	// CHECK IF VALID REQUEST (first time)
	/*
	if (mysql_get_first_record("SELECT * FROM tb_online_test_result WHERE xIP='{$ip}';")){
		// Error - This IP Address has used the test before
		echo('{"error":1, "errorText":"Bạn chỉ được thực hiện bài test này 01 lần !"}');
		exit();
	}
	
	
	// WRITE TO DATABASE (IP ADDRESS, TIMESTAMP)
	$now=date("Y-m-d H:i:s");
	if (!mysql_query("INSERT INTO tb_online_test_result(xIP, xTestName, xPersonalName, xStartTime, xEndTime, xScore, xMaxScore) 
					VALUES ('{$ip}', 'English Test For Programmer', '{$_POST['name']}', '{$now}','', 0, 10);") ){
		echo('{"error":1, "errorText":"Có lỗi với cơ sở dữ liệu. Vui lòng liên hệ Ms. Duyên (0989.466.991) !"}');
		exit();
	}
	*/
	
	// RETURN TEST CONTENT
	$arrEnglishTest=array();
	$arrEnglishTest[]=array(1, "Where did you have dinner last night?", "Where have you had dinner last night?","Where do you have dinner last night?");
	$arrEnglishTest[]=array(1, "I should stop smoking", "I should to stop smoking","I must to stop smoking");
	$arrEnglishTest[]=array(2, "I really should to talk to her", "I really need to talk to her","I really must to talk to her");
	$arrEnglishTest[]=array(3, "Are you going party on Friday?", "Are you going partying on Friday?","Are you going to the party on Friday?");
	$arrEnglishTest[]=array(1, "When are you going to go out?", "When going out are we?","When do we go out?");
	$arrEnglishTest[]=array(3, "I work tomorrow", "I don't working tomorrow","I'm working tomorrow");
	$arrEnglishTest[]=array(3, "I am usually having some coffee and toast for my breakfast", "I am used to have some coffee and toast for my breakfast","I usually have some coffee and toast for my breakfast");
	$arrEnglishTest[]=array(3, "I'm trying to eat a more healthy diet", "I try to eat a more healthy diet","I'm trying to eat a healthier diet");
	$arrEnglishTest[]=array(1, "He's never been to New York", "He's never gone to New York","He's gone often to New York");
	$arrEnglishTest[]=array(1, "At this rate, they will never be here on time", "At this rate, they are never here on time","At this rate, they are never going here on time");
	$arrEnglishTest[]=array(3, "Are you studied Chinese before?", "Are you studying Chinese before?","Have you studied Chinese before?");
	$arrEnglishTest[]=array(2, "You haven't to do that, you know", "You didn't have to do that, you know","You didn't must do that, you know");
	$arrEnglishTest[]=array(2, "How long is it from Hong Kong to Shanghai?", "How far is it from Hong Kong to Shanghai?","How much is it from Hong Kong to Shanghai?");
	$arrEnglishTest[]=array(1, "When we finish the painting, we'll have a cup of tea", "When we've finished the painting, we'll have a cup of tea","When the painting finishes, we'll have a cup of tea");
	$arrEnglishTest[]=array(3, "She asked the shop asistent to have a refund", "She asked the shop asistent to give a refund","She asked the shop asistent for a refund");
	echo json_encode($arrEnglishTest);
}

?>