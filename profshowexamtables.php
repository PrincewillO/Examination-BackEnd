<?php
//Princewill Onwubu Backend - Beta 3/30 Presenting the exams via Json Array upstream
$catch=file_get_contents('php://input');
$_POST=json_decode($catch,true);
$res=array();

$username=mysqli_real_escape_string($conn,$_POST['username']);
//$username="mdh27";
$r1=mysqli_fetch_assoc(mysqli_query($conn,"SELECT * FROM db_users WHERE username like '$username'"));
$q1=mysqli_query($conn,"SELECT * FROM db_exams WHERE professor like '$r1[fName]'");

while($r2=mysqli_fetch_assoc($q1)){
	$data=array(
		"professor"=>$r2['professor'],
		"examname"=>$r2['examname'],
		"id"=>$r2['id']
		);
	array_push($res,$data);
}
echo json_encode($res);
mysqli_close($conn);
?>
