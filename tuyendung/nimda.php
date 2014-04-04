<?
require_once("../helper/mysql.helper.php");
require_once("../wp-db-connect.php");

if ($_GET['action']=="delete"){
	mysql_query("INSERT INTO tb_employee_deleted SELECT * FROM tb_employee WHERE id={$_GET['id']};");
	mysql_query("DELETE FROM tb_employee WHERE id={$_GET['id']};");
}

if ($_GET['position']){
	$employees=mysql_get_records("SELECT * FROM tb_employee WHERE position='{$_GET['position']}' ORDER BY id DESC");
} else {
	$employees=mysql_get_records("SELECT * FROM tb_employee ORDER BY id DESC");
}

?>
<meta charset="utf-8" /> 

<? // ====================================== JS ================================= ?>
<script src='jquery-1.9.1.min.js'></script>
<script src='http://vn.oxseed.com/jquery-ui/jquery-ui.js'></script>
<script>
	$(function(){
		$('.english_test_button').click(function(){
			var index=$(this).attr('index');
			$('.english_test[index='+index+']').dialog( {width:700, title:'English Test [id: '+index+']'} );
		});
		$('.old_projects_button').click(function(){
			var index=$(this).attr('index');
			$('.old_projects[index='+index+']').dialog( {width:700, title:'Old Projects [id: '+index+']'} );
		});
		$('.btDelete').click(function(){
			if (confirm("Do you really want to delete ID="+$(this).attr('index')+" ?")){
				location.href='?position=<?=$_GET['position']?>&action=delete&id='+$(this).attr('index');
			}
		});
	});
</script>

<? // ====================================== CSS ================================= ?>
<link rel="stylesheet" type="text/css" href="http://vn.oxseed.com/jquery-ui/jquery-ui.css" media="screen" />
<style>
	td, th {border:1px solid black;}
	*{font-size:12px;}
</style>

<? // ====================================== HTML ================================= ?>
<table cellspacing="1" cellpadding="1">
	<tr>
		<th>Vị trí</th><th>Ảnh</th><th>Tên</th><th>Nam ?</th><th>FA ?</th><th>Tuổi</th><th>Nơi sinh</th><th>Địa chỉ</th><th>Email</th><th>Điện thoại</th><th>Trình độ</th><th>Bằng cấp khác</th><th>English</th><th>Programming</th><th>Soft Skills</th><th>Last job</th><th>Old project</th><th>Experience</th><th>Expected Salary</th><th>Other questions/requests</th><th></th>
	</tr>
<?
foreach ($employees as $e){
	?>
	<tr>
		<td><?=$e->position?></td>
		<td><img width="100px" src='http://vn.oxseed.com/tuyendung/employee_images/<?=$e->id?>.jpg'/></td>
		<td>[<?=$e->id?>] <?=$e->name?></td>
		<td><?=$e->isMale?></td>
		<td><?=$e->isSingle?></td>
		<td><?=$e->age?></td>
		<td><?=$e->birth_place?></td>
		<td><?=$e->address?></td>
		<td><?=$e->email?></td>
		<td><?=$e->tel?></td>
		<td><? 
			switch ($e->education){
				case 1: echo "Trung học"; break;
				case 2: echo "Trung cấp"; break;
				case 3: echo "Cao đẳng"; break;
				case 4: echo "Đại học"; break;
				case 5: echo "Trên đại học"; break;
			}
			echo "<br>".$e->education_info;			
			?>	
		</td>
		<td><?=$e->other_certs?></td>
		<td>
			<?=$e->english?> <div class='english_test' index='<?=$e->id?>' id='english_test_<?=$e->id?>' style='display:none'><?=$e->english_test?></div><button class='english_test_button' index='<?=$e->id?>'>Show</button>
		</td>
		<td><?=$e->programming_languages?><br><?=$e->programming_tools?></td>
		<td><?=$e->soft_skills?></td>
		<td><?=$e->last_job?></td>
		<td>
			<div class='old_projects' index='<?=$e->id?>' id='old_projects_<?=$e->id?>' style='display:none'><?=$e->old_projects?></div><button class='old_projects_button' index='<?=$e->id?>'>Show</button>
		</td>
		<td><?=$e->experience?></td>
		<td><?=$e->expected_salary?></td>
		<td><?=$e->others?></td>
		<td><button class='btDelete' index='<?=$e->id?>'>X</button>
	</tr>
	
	<?	
}

?>
</table>