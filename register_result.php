<?php
	$acc = $_POST["account"] ;
	$pw = md5($_POST["password"]) ;
	$cpw = md5($_POST["cpw"]) ;
	
	$db_host = 'localhost' ;
	$db_database = 'pd course' ;
	$db_username = 'root' ;
	$student_dir = '.\\student\\'.$acc;
	if ($acc == NULL or $pw == NULL)
		header ("Location:register.php?empty=1") ;
	elseif ($pw != $cpw)
		header ("Location:register.php?fail=1") ;
	else{
	$connection = mysql_connect($db_host, $db_username, '');
	if (!$connection)
		die ("connection failed".mysql_error()) ;
	$selection = mysql_select_db($db_database) ;
	if (!$selection)
		die ("selection failed".mysql_error()) ;
	$valid = "SELECT * FROM student WHERE account = '$acc';" ;
	$valid2 = mysql_query($valid) ;
	if ($same = mysql_fetch_row($valid2))
		header ("Location:index.php?err=1") ;
  	$uid = "SELECT MAX(s_id) FROM student ;" ;
	$max = mysql_query($uid) ;
	$fetch_max = mysql_fetch_row($max);
	$value = $fetch_max[0]+1 ;
	$query = "INSERT INTO student(s_id, account, password) VALUES ('$value', '$acc', '$pw') " ;
	$result = mysql_query($query) ;
	$check = "SELECT * FROM student WHERE account = '$acc' AND password = '$pw' " ;
	$success = mysql_query($check) ; 
	
	//創建使用者資料夾
	$return = 0;
	$command = "MD ".$student_dir;
	system($command, $return);
	
	if ($result_rowc = mysql_fetch_row($success) and file_exists($student_dir))
		header("Location:index.php?success=1") ;
	}
?>