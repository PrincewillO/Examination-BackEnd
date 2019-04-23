<?php
//Princewill Onwubu Backend - Beta 3/30 Presenting the exams via Json Array upstream
$catch=file_get_contents('php://input');
$_POST=json_decode($catch,true);
$res=array();

$q1=mysqli_query($conn,"SELECT * FROM db_exams");
$username=$_POST['username'];

while($r1=mysqli_fetch_assoc($q1)){
	$exam=$r1['examname'];
	$q2=mysqli_query($conn,"SELECT * FROM `$exam` WHERE username like '$username'");
	if($r2=mysqli_fetch_assoc($q2)){
		$data=array(
			"professor"=>$r1['professor'],
			"examname"=>$r1['examname'],
			"grade"=>$r2['grade'],
			"total"=>$r2['total'],
			"status"=>$r2['status'],
			"date"=>$r2['date'],
			"id"=>$r1['id']
			);
		array_push($res,$data);
	}else{
		$data=array(
			"professor"=>$r1['professor'],
			"examname"=>$r1['examname'],
			"id"=>$r1['id']
			);
		array_push($res,$data);
	}
}
echo json_encode($res);

mysqli_close($conn);
?>
