<?

if ($_POST['name']){ 		
	require_once("../wp-db-connect.php");
		
	$education_info=mysql_real_escape_string( $_POST['studyField']." - ".$_POST['school'] );	
	
	$sql="INSERT INTO tb_employee (position, name, isMale, isSingle, age, 					birth_place, address, email, tel, education, education_info, other_certs, 																																														english, english_test, 																							programming_languages, programming_tools, 																					soft_skills, last_job, old_projects, experience, expected_salary, others)
					VALUES ('HCVP','{$_POST['name']}', 0, 1, {$_POST['age']}, '".mysql_real_escape_string($_POST['birthPlace'])."', '".mysql_real_escape_string($_POST['address'])."', '".mysql_real_escape_string($_POST['email'])."', '".mysql_real_escape_string($_POST['tel'])."', {$_POST['education']}, '{$education_info}', '".mysql_real_escape_string($_POST['otherCertificates'])."', '".mysql_real_escape_string($_POST['english'])."', '', '', '', '".mysql_real_escape_string($_POST['softSkills'])."', '".mysql_real_escape_string($_POST['lastJob'])."', '', '', '".mysql_real_escape_string($_POST['expectedSalary'])."', '".mysql_real_escape_string($_POST['others'])."'  );";
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
		
		$mailSubject="New Oxseed VN application: HCVP !";
		$mailContent=$_POST['name']." [{$newEmployeeId}] - http://vn.oxseed.com/tuyendung/nimda.php";
		mail("thinhnp@gmail.com", $mailSubject, $mailContent);
	}	
	
} else {
	?>
	<? // ================================= CSS =========================================== ?>
	<style>
		.formSection {font-weight:bold; font-size:20px; background: #d8f2f1;text-align:center;}
		textarea {width:350px; height:80px;}
	</style>
	
	<? // ================================= JS =========================================== ?>
	<script src='jquery-1.9.1.min.js'></script>
	<script>
	function empty(s){
		if ($.trim(s)=="") return true; else return false;
	}
	function strrpos (haystack, needle, offset) {
	  var i = -1;
	  if (offset) {
		i = (haystack + '').slice(offset).lastIndexOf(needle); // strrpos' offset indicates starting point of range till end,
		// while lastIndexOf's optional 2nd argument indicates ending point of range from the beginning
		if (i !== -1) {
		  i += offset;
		}
	  } else {
		i = (haystack + '').lastIndexOf(needle);
	  }
	  return i >= 0 ? i : false;
	}
	function invalidImage(imageName){
		if (imageName=="") return true;		
		var fileExtension=imageName.substring( strrpos(imageName, '.') + 1 ).toLowerCase();	
		if ( (fileExtension!="jpg") && (fileExtension!="png") && (fileExtension!="gif") ) return true;
		else return false;	}

	$(function(){
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
			
			if (errText){
				alert( errText );
				event.preventDefault();
			}
		});	
	});
	</script>

	
	<? // ================================= HTML =========================================== ?>
	<form id='xForm' method="POST" enctype="multipart/form-data">
	<table width='100%'>
		<tr><td colspan=2 class='formSection' >Thông tin cá nhân</td></tr>
		<tr>
			<td>Ảnh (jpg/png) <span style='color:red'>(*)</span></td>
			<input type="hidden" name="MAX_FILE_SIZE" value="10000000" /> 
			<td><input type='file' name="profilePicture"/></td>
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
		
		<tr><td colspan=2 class='formSection' >Trình độ học vấn</td></tr>
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
			<td>Trình độ tiếng Anh</span></td>
			<td><input name="english"/></td>
		</tr>				
		<tr>
			<td>Kỹ năng mềm</td>
			<td><textarea name="softSkills"></textarea></td>
		</tr>
		
		<tr><td colspan=2 class='formSection' >Kinh nghiệm làm việc (nếu có)</td></tr>
		<tr>
			<td>Công việc gần nhất bạn làm<br>(Tên công ty. Thời gian, hình thức, nội dung công việc. Mức lương. Lí do nghỉ việc)</td>
			<td><textarea name="lastJob"></textarea></td>
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
		
		<tr><td colspan=2><center><input type="submit"  value="Gửi"/></center></td></tr>
	</table>
	</form>
<? 
} ?>