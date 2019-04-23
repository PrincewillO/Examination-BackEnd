<?php
//Princewill Onwubu Backend - Beta 3/5 Login
$catch=file_get_contents('php://input');
$_POST=json_decode($catch,true);
$date=date('m/d/Y');
/*$username='pio3';
$password='secret';*/

$username=mysqli_real_escape_string($conn, $_POST['username']);
$password=mysqli_real_escape_string($conn, $_POST['password']);

$query=mysqli_query($conn,"SELECT * FROM db_users WHERE username like '$username'");

if($row=mysqli_fetch_assoc($query)){
	if(MD5($password)==$row['password']){
		$data=array(
		"permission"=>$row['permission'],
		"fName"=>$row['fName'],
		"id"=>$row['id']);
		echo json_encode($data,true);
		exit();
	}
	else{
		echo json_encode("Incorrect Credentials");
		exit();
	}
}
else{
	echo json_encode("Error Logging In");
	exit();
}
mysqli_close($conn);
?>
