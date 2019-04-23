<?php
//Princewill Onwubu Backend - Beta 4/3 Student View Grades
$conn=mysqli_connect("sql1.njit.edu","pio3","yoAexDSq","pio3");
$catch=file_get_contents('php://input');
$_POST=json_decode($catch,true);
$date=date('m/d/Y');
$res=array();

$username=mysqli_real_escape_string($conn, $_POST['username']);
$id=mysqli_real_escape_string($conn, $_POST['id']);

$r1=mysqli_fetch_assoc(mysqli_query($conn,"SELECT * FROM `db_exams` WHERE id like '$id'"));
$r4=mysqli_fetch_assoc(mysqli_query($conn,"SELECT * FROM `db_users` WHERE username like '$username'"));

$stu['examname']=$r1['examname'];//Exam Name
$stu['examid']=$_POST['id'];//Exam ID
$stu['professor']=$r1['professor'];//Professor Name
$stu['student']=$_POST['username'];//Student username
$stu['studentName']=$r4['fName'];//Student First name

$i=1;
$q='q'.$i;
$qw=$q.'w';
$qa=$q.'a';
$qc=$q.'c';
$qpc=$q.'pc';
$qf=$q.'f';
$qfs=$q.'fs';
$qaw=$q.'aw';
$qsyn=$q.'syn';
$qfor=$q.'for';
$qwhile=$q.'while';
$qprint=$q.'print';

$r2=mysqli_fetch_assoc(mysqli_query($conn,"SELECT * FROM `$stu[examname]` WHERE username like '$username'"));
$stu['total']=$r2['total'];
$stu['grade']=$r2['grade'];
while(isset($r2[$q])!=false){
		$stu[$q]=$r1[$q];//Exam Question
		$stu[$qw]=$r1[$qw];//Exam Question Weight
		$stu[$qa]=$r2[$q];//Student Answer
		$stu[$qaw]=$r2[$qw];//Student Answer Score
		$stu[$qf]=$r2[$qf];//Student Function name
		$stu[$qfs]=$r2[$qfs];//Student Function name score
		$stu[$qsyn]=$r2[$qsyn];//Student Syntax score
		$stu[$qfor]=$r2[$qfor];//Did student use FOR
		$stu[$qwhile]=$r2[$qwhile];//Did student use WHILE
		$stu[$qprint]=$r2[$qprint];//DId student PRINT
		$stu[$qpc]=$r2[$qpc];//Professor's Comments
		$stu[$qc]=$r2[$qc];//Auto Grader's Comments
		
		$i++;
		$q='q'.$i;
		$qa=$q.'a';
		$qw=$q.'w';
		$qc=$q.'c';
		$qpc=$q.'pc';
		$qf=$q.'f';
		$qfs=$q.'fs';
		$qaw=$q.'aw';
		$qsyn=$q.'syn';
		$qfor=$q.'for';
		$qwhile=$q.'while';
		$qprint=$q.'print';
}
array_push($res,$stu);

$i=1;
$q='q'.$i;
$qid=$q.'id';

$r2=mysqli_fetch_assoc(mysqli_query($conn,"SELECT * FROM `$stu[examname]` WHERE username like '$username'"));
$r1=mysqli_fetch_assoc(mysqli_query($conn,"SELECT * FROM `db_exams` WHERE id like '$id'"));
$question=$r1[$qid];

$o=1;
$qn=$q.'o'.$i;
$qi='input'.$i;
$qo='output'.$o;
$qe='student'.$qo;
$qf=$q.'f';
$qw=$q.'w';
$qp=$q.'p';
$qs=$q.'s'.$o;

$r3=mysqli_fetch_assoc(mysqli_query($conn,"SELECT * FROM db_questions WHERE id like '$r1[$qid]'"));
while(isset($r2[$q])!=false){
	$pro["questionName"]=$r3['questionName'];
	$pro["for"]=$r3['f'];
	$pro["while"]=$r3['w'];
	$pro["print"]=$r3['p'];
	while($o!=7){
		if(empty($r3[$qi])!=true){
			$pro[$qi]=$r3[$qi];//Test case input
			$pro[$qe]=$r2[$qn];//Student Output
			$pro[$qo]=$r3[$qo];//DB Test case output
			$pro[$qs]=$r2[$qs];//Test Case Score
		}
		$o++;
		$qn=$q.'o'.$o;
		$qs=$q.'s'.$o;
		$qi='input'.$o;
		$qo='output'.$o;
		$qe='student'.$qo;
	}
	$i++;
	$q='q'.$i;
	$qid=$q.'id';
	$qf=$q.'f';
	$qw=$q.'w';
	$qp=$q.'p';
	$o=1;
	$qn=$q.'o'.$o;
	$qs=$q.'s'.$o;
	$qi='input'.$o;
	$qo='output'.$o;
	$qe='student'.$qo;
	array_push($res,$pro);
	$r3=mysqli_fetch_assoc(mysqli_query($conn,"SELECT * FROM db_questions WHERE id like '$r1[$qid]'"));
	$pro=array();
}

echo json_encode($res);
mysqli_close($conn);
?>