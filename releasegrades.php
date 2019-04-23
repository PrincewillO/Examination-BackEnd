<?php
//Princewill Onwubu Backend - Beta 4/14 Professor Release grades
$conn=mysqli_connect("sql1.njit.edu","pio3","yoAexDSq","pio3");
$catch=file_get_contents('php://input');
$_POST=json_decode($catch,true);
$date=date('m/d/Y');

$id=mysqli_real_escape_string($conn,$_POST['examid']);
$r1=mysqli_fetch_assoc(mysqli_query($conn,"SELECT * FROM db_exams WHERE id like '$id'"));

$e="UPDATE `$r1[examname]` SET `status`='Graded' WHERE `status` like 'Pending'";
if(mysqli_query($conn,$e)){
	echo json_encode($date."-$r1[examname] grades have been realeased\n");
} else { echo "Exam's couldn't be graded";}
mysqli_close($conn);
?>