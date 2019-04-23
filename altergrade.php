<?php
//Princewill Onwubu Backend - Beta 4/3 Professor submit a student's corrected grade
$catch=file_get_contents('php://input');
$_POST=json_decode($catch,true);
$date=date('m/d/Y');

$id=mysqli_real_escape_string($conn, $_POST['examid']);
$username=mysqli_real_escape_string($conn, $_POST['student']);

$r1=mysqli_fetch_assoc(mysqli_query($conn,"SELECT * FROM `db_exams` WHERE id like '$id'"));
$r2=mysqli_fetch_assoc(mysqli_query($conn,"SELECT * FROM `db_users` WHERE username like '$username'"));
$fName=$r2['fName'];
$exam=$r1['examname'];

$aquest="UPDATE `$exam` SET `status`='Pending'";
$end=" WHERE username like '$username'";

$i=1;
$o=1;
$q='q'.$i;
$qpc=$q.'pc';
$qw=$q.'w';
$qaw=$q.'aw';
$qsyn=$q.'syn';
$qfs=$q.'fs';
$qs=$q.'s'.$o;
$grade=$_POST['grade'];
while(isset($_POST[$qw])!=false){
	$aquest.=",$qpc='$_POST[$qpc]'";
	$aquest.=",$qsyn='$_POST[$qsyn]'";
	$aquest.=",$qw='$_POST[$qaw]'";
	$aquest.=",$qfs='$_POST[$qfs]'";
	while(isset($_POST[$qs])!=false){
		$aquest.=",$qs='$_POST[$qs]'";
		$o++;
		$qs=$q.'s'.$o;
	}

	$i++;
	$o=1;
	$q='q'.$i;
	$qpc=$q.'pc';
	$qw=$q.'w';
	$qaw=$q.'aw';
	$qsyn=$q.'syn';
	$qfs=$q.'fs';
	$qs=$q.'s'.$o;
}

$aquest.=",`grade`='$grade'";
$aquest.=$end;

if(mysqli_query($conn,$aquest)){
	echo json_encode($date."-$fName's exam was Graded");
}
else {
	echo json_encode("Error: " . $sql . "<br>" . mysqli_error($conn));
}
mysqli_close($conn);
?>
