<?php
//Princewill Onwubu Backend - Beta 4/3 Student submits answer to the exam
$conn=mysqli_connect("sql1.njit.edu","pio3","yoAexDSq","pio3");
$catch=file_get_contents('php://input');
$_POST=json_decode($catch,true);
$date=date('m/d/Y');

$count=count($_POST[0])-1;
$stu=$_POST[0][$count];//$test is an array of arrays fix

$id=mysqli_real_escape_string($conn, $stu['id']);
$username=mysqli_real_escape_string($conn, $stu['username']);

$r1=mysqli_fetch_assoc(mysqli_query($conn,"SELECT * FROM `db_exams` WHERE id like '$id'"));
$r2=mysqli_fetch_assoc(mysqli_query($conn,"SELECT * FROM `db_users` WHERE username like '$username'"));
$fName=$r2['fName'];
$exam=$r1['examname'];

$aquest="UPDATE `$exam` SET ";
$end=" WHERE username like '$username'";

$y=0;
$total=0.00;
while($y!=16){
	$total+=$r1[$qw];
	$y++;
	$qw='q'.$y.'w';
}
$p=0;
$o=1;
$q='q'.($p+1);
$qo=$q.'o'.$o;
$qos=$q.'s'.$o;
$qw=$q.'w';
$qc=$q.'c';
$qf=$q.'f';
$qfs=$q.'fs';
$qsyn=$q.'syn';
$qfor=$q.'for';
$qwhile=$q.'while';
$qprint=$q.'print';
$comments="";
$y=0;

while($p<$r1['questionCount']){
	//echo $p." ";
	$test=mysqli_real_escape_string($conn,$_POST[1][$p]);
	$for=$test['Constraints'][0];
	$while=$test['Constraints'][2];
	$print=$test['Constraints'][1];
	$qscore+=$test['PointsLost'];
	$qsw=$stu[$qw]-$test['PointsLost'];

	while(isset($test['Comments'][$y])==true){
		$comments.=$test['Comments'][$y]."\n";
		$y++;
	}

	$aquest.="$q='$stu[$q]',$qw='$qsw',$qc='$comments',$qf='$test[fname]',`$qsyn`='$test[Syntax]',$qfs='$test[fnamePoints]',$qfor='$for',$qwhile='$while',$qprint='$print'";
	while($o<7){
		$output=$test['StudOutput'][$o-1];
		$outputscore=$test['TestCases'][$o-1];
		$aquest.=",$qo='$output',$qos='$outputscore'";
		$o++;
		$qo=$q.'o'.$o;
		$qos=$q.'s'.$o;
	}

	$p++;
	$q='q'.($p+1);
	$qw=$q.'w';
	$qsyn=$q.'syn';
	$qc=$q.'c';
	$qf=$q.'f';
	$qfs=$q.'fs';
	$qfor=$q.'for';
	$qwhile=$q.'while';
	$qprint=$q.'print';
	$o=1;
	$y=0;
	$qo=$q.'o'.$o;
	$qos=$q.'s'.$o;
	$aquest.=$end;
	mysqli_query($conn,$aquest);
	$aquest="UPDATE `$exam` SET ";
	$comments="";
}
$grade=$total-$qscore;
if($grade<0){
	$grade=0;
}

$aquest="UPDATE `$exam` SET `fName`='$fName',`date`='$date',`status`='Completed',`grade`='$grade',`total`='$total'".$end;
if(mysqli_query($conn,$aquest)){
	echo json_encode(date('m/d/Y')."-'$exam' was submitted");
	exit();
}
else {
	echo "\nError: " . $sql . "<br>" . mysqli_error($conn);
	exit();
}
mysqli_close($conn);
?>
