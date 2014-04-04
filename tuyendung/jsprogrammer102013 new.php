<?
if ($_POST['name']){ 		
	require_once("../wp-db-connect.php");
	if ($_POST['gender']=="male") $isMale=1; else $isMale=0;
	if ($_POST['maritalStatus']=="single") $isSingle=1; else $isSingle=0;
	$education_info=mysql_real_escape_string( $_POST['studyField']." - ".$_POST['school'] );
	$experience=mysql_real_escape_string( $_POST['oldProjects']. " <br> ". $_POST['jsExperience']);
	
	$sql="INSERT INTO tb_employee (position, name, isMale, isSingle, age, 					birth_place, address, email, tel, education, education_info, other_certs, 																																														english, english_test, 																							programming_languages, programming_tools, 																					soft_skills, last_job, old_projects, experience, expected_salary, others)
					VALUES ('JsProgrammer','{$_POST['name']}', {$isMale}, {$isSingle}, {$_POST['age']}, '".mysql_real_escape_string($_POST['birthPlace'])."', '".mysql_real_escape_string($_POST['address'])."', '".mysql_real_escape_string($_POST['email'])."', '".mysql_real_escape_string($_POST['tel'])."', {$_POST['education']}, '{$education_info}', '".mysql_real_escape_string($_POST['otherCertificates'])."', '".mysql_real_escape_string($_POST['english'])."', '".mysql_real_escape_string($_POST['englishWriting'])."', '".mysql_real_escape_string($_POST['programmingLanguages'])."', '".mysql_real_escape_string($_POST['programmingTools'])."', '".mysql_real_escape_string($_POST['softSkills'])."', '".mysql_real_escape_string($_POST['lastJob'])."', '".mysql_real_escape_string($_POST['oldProjects'])."', '{$experience}', '".mysql_real_escape_string($_POST['expectedSalary'])."', '".mysql_real_escape_string($_POST['others'])."'  );";
	if (!mysql_query($sql)){
		// FAILED !!!
		echo "<br>Có lỗi xảy ra: ". mysql_error()." ! <br><b>Vui lòng thực hiện lại hoặc gửi CV tới thinhnp@gmail.com </b> !"; 
	} else {	
		// SUCCESSFUL !!!
		$newEmployeeId=mysql_insert_id();		
		$target_path = "/var/www/tuyendung/employee_images/".$newEmployeeId.".jpg";
		if(!move_uploaded_file($_FILES['profilePicture']['tmp_name'], $target_path)) {
			echo "<br>Upload ảnh thât bại ! <br><b>Vui lòng thực hiện lại hoặc gửi CV tới thinhnp@gmail.com </b> !"; 
		} else {		
			echo "<br><center>Bạn đã gửi hồ sơ thành công !</center><br>"; 
		}
		
		$mailSubject="New Oxseed VN application: JS Programmer !";
		$mailContent=$_POST['name']." [{$newEmployeeId}] - http://vn.oxseed.com/tuyendung/nimda.php";
		mail("thinhnp@gmail.com", $mailSubject, $mailContent);
	}		
} else {
	error_reporting(E_WARNING | E_ERROR);
	require_once("../helper/php.helper.php");	
	$ip=get_client_ip();	
	?>
	
<html lang="en">
<head>
	<meta charset="UTF-8">

	<link rel='stylesheet' id='admin-bar-css'  href='http://vn.oxseed.com/jquery-ui/jquery-ui.css' type='text/css' media='all' />
	<style>
		h1,h2{text-align:center;}
		.formSection {font-weight:bold; font-size:20px; background: #d8f2f1;text-align:center;}
		textarea {width:680px; height:80px;}
		input {width:300px}		
		.leftColumn{width:300px}
		.rightColumn{width:680px !important}
		.divQuestion{text-align:left;min-height:28px;}
		.grey{background: #ccc}
		
		#cloud-grey{position:fixed; top:0px; left:0px; width:100%; height:100%; z-index:10; background-color:black; opacity:0.7;display:none;}
		#cloud-english-test{position:fixed;width:80%; height:480px; top:30px; left:10%; margin:0px auto; z-index:12; background-color:white;display:none;padding:20px;}				
		#cloud-it-test{position:fixed;width:80%; height:450px; top:30px; left:10%; margin:0px auto; z-index:12; background-color:white;display:none;padding:20px;}				
		#englishTest-content, #itTest-content {overflow-y: scroll}
		.btSubmitTest{position: absolute; top:10px; right:10px; width:100px;}
		.lbTimeLeft{position:absolute; top:10px; right:115px;}
	</style>
	
	<script src="jquery-1.9.1.min.js"></script>	
	<script src="../js/helper.js"></script>	
	<?//<script src="http://vn.oxseed.com/jquery-ui/jquery-ui.js"></script>	?>
	
	<script>
		$(function(){					
			var testTimer;			
			var currentTest;
			
			$('#btEnglishTest').click(function(){
				currentTest="english";
				testTimer=15*15+10; // 15 questions, 15 seconds for each, 10 seconds for checking and submiting
				
				// Check if 'Name' field has been filled
				if ( empty($('input[name=name]').val()) ){
					alert("Bạn chưa điền thông tin : Họ và tên !");
					return;
				}
				
				$.post("webservices.php","q=start_english_test&ip=<?=$ip?>&name="+$('input[name=name]').val(),function(data){
					console.log(data);
					var json=JSON.parse(data);
					if (json.error==1){
						alert(json.errorText);
						return;
					} else {
						$('#cloud-grey').css('display','block');
						$('#cloud-english-test').css('display','block');					
						$('#englishTest-content').css('text-align','left');
						var testContent="";
						for (var i=0; i<json.length; i++){
							var questionNumber=i+1;
							if (questionNumber%2)
								testContent+="<div class='divQuestion'>Q"+questionNumber+". ";
							else 
								testContent+="<div class='divQuestion grey'>Q"+questionNumber+". ";
							var q=json[i];
							for (var j=0; j<q.length; j++){								
								if (j==0){
									testContent+="<input type='hidden' name='englishTestResult"+questionNumber+"' value='"+q[j]+"'/>";
								} else {
									var choiceNumber=j;
									testContent+="<input type='radio' style='width:20px !important; margin-left:15px;' name='englishTest"+questionNumber+"' value="+choiceNumber+">"+q[j]+"</input>";
								}
							}
							testContent+="</div>";
						}
						$('#englishTest-content').html(testContent);
						setInterval(decreaseTimer, 1000);
					}
				});				
			});
			function decreaseTimer(){				
				testTimer--;		
				var e; // html element
				if (currentTest=="english") e=$('#lbTimeLeftEnglish');
					
				if (testTimer==0) submitTestResult();
				else {
					e.html('(Còn '+testTimer+' giây)');
				}
					
			}
			function submitTestResult(){
				
			}
			
			$('#xForm').submit(function(event){		
				var errText="";		
				
				if ( empty($('input[name=profilePicture]').val()) ) errText="Thiếu thông tin : Ảnh !";		
				else if ( invalidImage($('input[name=profilePicture]').val()) ) errText="Chỉ hỗ trợ các dạng file ảnh: JPG, PNG, GIF";		
				
				else if ( empty($('input[name=name]').val()) ) errText="Thiếu thông tin : Họ và tên !";
				else if ( empty($('input[name=age]').val()) ) errText="Thiếu thông tin : Tuổi !";
				else if ( isNaN($('input[name=age]').val()) ) errText="Sai thông tin : Tuổi !";
				else if ( empty($('input[name=email]').val()) ) errText="Thiếu thông tin : Email !";
				else if ( empty($('input[name=tel]').val()) ) errText="Thiếu thông tin : Điện thoại !";
				else if ( empty($('input[name=studyField]').val()) ) errText="Thiếu thông tin : Ngành học !";
				else if ( empty($('input[name=english]').val()) ) errText="Thiếu thông tin : Trình độ tiếng Anh !";		
				else if ( empty($('textarea[name=englishWriting]').val()) ) errText="Thiếu thông tin : Viết về bản thân, quá trình học tập / công tác trước đây bằng tiếng Anh !";
				else if ( empty($('textarea[name=programmingLanguages]').val()) ) errText="Thiếu thông tin : Sử dụng các ngôn ngữ lập trình !";
				else if ( empty($('textarea[name=oldProjects]').val()) ) errText="Thiếu thông tin : Một (vài) dự án bạn đã thực hiện !";
				else if ( empty($('textarea[name=jsExperience]').val()) ) errText="Thiếu thông tin : Kinh nghiệm làm việc với Javascript !";						
				
			 
				if (errText){
					alert( errText );
					event.preventDefault();
				}
			});	
		});
	</script>
</head>


	
<body style='width:980px; margin:0px auto;'>
	<h2>Nộp hồ sơ ứng tuyển <a href="http://vn.oxseed.com/?p=48">vị trí lập trình viên Javascript</a></h1>
	<h2>Công ty Oxseed Việt Nam</h2>

	<div id="cloud-grey"></div>	
	<div id="cloud-english-test">
		<input type='button' id='btSubmitEnglishTest' class='btSubmitTest' value="Hoàn thành" />
		<div style='text-align:center; font-weight:bold;'>English Test - Choose the correct option:</div>
		<div id='lbTimeLeftEnglish' class='lbTimeLeft'></div>
		<hr>
		<div id='englishTest-content'></div>			
	</div>
	<div id="cloud-it-test">
		<b>Logic & IT Test:</b>
		<div id='itTest-content' style='text-align:center'><img src="../images/ajax-loader.gif"/></div>	
	</div>

	<? // ================================= HTML =========================================== ?>
	<form id='xForm' method="POST" enctype="multipart/form-data">
	<table width='100%'>
		
		<tr><td colspan=2 class='formSection' >Thông tin cá nhân</td></tr>
		<tr>
			<td class='leftColumn'>Ảnh (jpg/png) <span style='color:red'>(*)</span></td>
			<input type="hidden" name="MAX_FILE_SIZE" value="10000000" /> 
			<td class='rightColumn'><input type='file' name="profilePicture"/></td>
		</tr>
		<tr>
			<td>Họ và tên <span style='color:red'>(*)</span></td>
			<td><input name="name"/></td>
		</tr>
		<tr>
			<td>Tuổi <span style='color:red'>(*)</span></td>
			<td><input name="age"/></td>
		</tr>
		<tr>
			<td>Giới tính</td>
			<td><select name="gender"><option value="male">Nam</option><option value="female">Nữ</option></td>
		</tr>
		<tr>
			<td>Nơi sinh</td>
			<td><input name="birthPlace"/></td>
		</tr>
		<tr>
			<td>Địa chỉ hiện tại</td>
			<td><input name="address"/></td>
		</tr>
		<tr>
			<td>Email <span style='color:red'>(*)</span></td>
			<td><input name="email"/></td>
		</tr>
		<tr>
			<td>Điện thoại <span style='color:red'>(*)</span></td>
			<td><input name="tel"/></td>
		</tr>
		<tr>
			<td>Tình trạng hôn nhân</td>
			<td><select name="maritalStatus"><option value="single">Độc thân</option><option value="married">Đã kết hôn</option></td>
		</tr>
		
		<tr><td colspan=2 class='formSection' >Trình độ học vấn & Kỹ năng làm việc</td></tr>
		<tr>
			<td>Trình độ học vấn</td>
			<td><select name="education"><option value="1">Trung học</option><option value="2">Trung cấp</option><option value="3">Cao đẳng</option><option value="4">Đại học</option><option value="5">Trên Đại học</option></td>
		</tr>
		<tr>
			<td>Ngành học <span style='color:red'>(*)</span></td>
			<td><input name="studyField"/></td>
		</tr>
		<tr>
			<td>Tốt nghiệp tại trường</td>
			<td><input name="school"/></td>
		</tr>	
		<tr>
			<td>Các bằng cấp/chứng chỉ khác</td>
			<td><textarea name="otherCertificates"></textarea></td>
		</tr>
		<tr>
			<td>Trình độ tiếng Anh <span style='color:red'>(*)</span></td>
			<td><input name="english"/></td>
		</tr>
		<tr>
			<td>Viết về bản thân, quá trình học tập hay công tác trước đây <b>bằng tiếng Anh</b> (80-200 từ)<span style='color:red'>(*)</span><br>Lưu ý: Trước khi nhận việc sẽ có bài kiểm tra tiếng Anh trên giấy nên hãy tự viết phần này !</td>
			<td><textarea name="englishWriting"></textarea></td>
		</tr>
		<tr>
			<td>Sử dụng các ngôn ngữ lập trình <span style='color:red'>(*)</span><br>(Nêu rõ mức độ thành thạo từng ngôn ngữ)</td>
			<td><textarea name="programmingLanguages"></textarea></td>
		</tr>
		<tr>
			<td>Sử dụng các công cụ lập trình</td>
			<td><textarea name="programmingTools"></textarea></td>
		</tr>
		<tr>
			<td>Kỹ năng mềm</td>
			<td><textarea name="softSkills"></textarea></td>
		</tr>
		
		<tr><td colspan=2 class='formSection' >Kinh nghiệm làm việc</td></tr>
		<tr>
			<td>Công việc gần nhất bạn làm (nếu có)<br>(Tên công ty. Thời gian, hình thức, nội dung công việc. Mức lương. Lí do nghỉ việc)</td>
			<td><textarea name="lastJob"></textarea></td>
		</tr>
		<tr>
			<td>Một (vài) dự án bạn đã thực hiện <span style='color:red'>(*)</span><br>- Lưu ý: Bạn làm cá nhân hoặc là nhóm trưởng<br>- Tài liệu chi tiết và/hoặc source code<br>- Upload lên host khác và chèn link</td>
			<td><textarea name="oldProjects"></textarea></td>
		</tr>
		<tr>
			<td>Kinh nghiệm làm việc với Javascript <span style='color:red'>(*)</span></td>
			<td><textarea name="jsExperience"></textarea></td>
		</tr>		
		
		<tr><td colspan=2 class='formSection' >Khác</td></tr>
		<tr>
			<td>Mức lương mong muốn</td>
			<td><input name="expectedSalary"/></td>
		</tr>
		<tr>
			<td>Yêu cầu, thắc mắc khác</td>
			<td><textarea name="others"></textarea></td>
		</tr>
		
		<tr><td colspan=2 class='formSection' >Kiểm tra kỹ năng trực tuyến</td></tr>
		<tr><td colspan="2"><b>Lưu ý chung:</b>
			<br>+ Trước khi nhận việc sẽ có bài kiểm tra trên giấy nên hãy tự làm phần này !
			<br>+ Bạn chỉ được thực hiện 01 lần mỗi bài test.
			<br>+ Các thông tin về IP address, cookie, thời gian ... sẽ được hệ thống lưu lại !
			<br>+ Nếu có lỗi trong quá trình thực hiện bài test, liên hệ Ms. Duyên (0989.466.991) để được giải đáp !<hr>
		</td></tr>
		
		<tr>
			<td>Trắc nghiệm Tiếng Anh <span style='color:red'>(*)</span><br>(15 câu trắc nghiệm trong 225 giây)</td>
			<td><input type='button' id='btEnglishTest' value='Thực hiện'/><br><input disabled name="englishTestScore" value="Điểm: --"/></td>			
		</tr>
		<tr><td colspan="2"><hr></td></tr>
		<tr>
			<td>Trắc nghiệm logic và lập trình cơ bản <span style='color:red'>(*)</span><br>(15 câu trắc nghiệm trong 225 giây)</td>
			<td><input type='button' id='btItTest' value='Thực hiện'/><br><input disabled name="itTestScore" value="Điểm: --"/></td>
		</tr>
		
		<tr><td colspan=2><center><input type="submit" style='width:80px !important;' value="Gửi hồ sơ"/></center></td></tr>
	</table>
	</form>
<? 
} ?>
</body>