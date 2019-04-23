<?php
//Princewill Onwubu Backend - Beta 3/30 Presenting the exams via Json Array upstream
$catch=file_get_contents('php://input');
$_POST=json_decode($catch,true);
$res=array();

$id=mysqli_real_escape_string($conn,$_POST['id']);

$q1=mysqli_query($conn,"SELECT * FROM db_exams WHERE id like '$id'");

if($r1=mysqli_fetch_assoc($q1)){
	$q2=mysqli_query($conn,"SELECT * FROM `$r1[examname]`");
	while($r2=mysqli_fetch_assoc($q2)){
		$data=array(
			"username"=>$r2['username'],
			"fName"=>$r2['fName'],
			"date"=>$r2['date'],
			"status"=>$r2['status'],
			"grade"=>$r2['grade'],
			"total"=>$r2['total']
			);
			array_push($res,$data);
	}
}
echo json_encode($res);
mysqli_close($conn);
?>
