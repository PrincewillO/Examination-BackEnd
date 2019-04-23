<?php
//Princewill Onwubu Backend - Beta 3/12 Creating exam
$conn=mysqli_connect("sql1.njit.edu","pio3","yoAexDSq","pio3");
$catch=file_get_contents('php://input');
$_POST=json_decode($catch,true);
$date=date('m/d/Y');

$prof=mysqli_real_escape_string($conn, $_POST['professor']);
$examname=mysqli_real_escape_string($conn, $_POST['examname']);

if($_POST['examname']==""){
	$row=mysqli_fetch_assoc(mysqli_query($conn,"SELECT * FROM db_maxids"));
	$i=mysqli_real_escape_string($conn,$row['exams']);
	$i++;
	$examname="Exam ".$i;
}
if($r1=mysqli_fetch_assoc(mysqli_query($conn,"SELECT * FROM db_users WHERE username like '$prof'"))){
	$professor=mysqli_real_escape_string($conn,$r1['fName']);
}

$iexam="INSERT INTO db_exams (professor,examname,date";
$iqn=") VALUES ('$professor','$examname','$date'";
$texam="CREATE TABLE `$examname` (username VARCHAR(10) NOT NULL UNIQUE,fName VARCHAR(20) NOT NULL, date VARCHAR(10) NOT NULL,status VARCHAR(25) NOT NULL DEFAULT 'Incomplete',grade DOUBLE NOT NULL,total INT(100) NOT NULL";

$c=0;
$qi=array();//Exam Question (STRING)
$qp=array();//Exam Question Weight
$total=0;

for($i=1;$i<=15;$i++){
	$q='q'.$i;
	$qd=$q.'id';
	$qw=$q.'w';
	$qc=$q.'c';
	$qpc=$q.'pc';
	$qf=$q.'f';
	$qfor=$q.'for';
	$qsyn=$q.'syn';
	$qwhile=$q.'while';
	$qprint=$q.'print';
	$qfs=$q.'fs';
	$o=1;
	$qo=$q.'o'.$o;
	$qs=$q.'s'.$o;
	
	
	$qi[$i]=mysqli_real_escape_string($conn, $_POST[$q]);
	$qp[$i]=mysqli_real_escape_string($conn, $_POST[$qw]);
	$qid[$i]=mysqli_real_escape_string($conn, $_POST[$q]);
	if(empty($_POST[$q])!=true){
		$iq=mysqli_query($conn,"SELECT * FROM db_questions WHERE id like '$qi[$i]'");
		if($row=mysqli_fetch_assoc($iq)){
		$qi[$i]=mysqli_real_escape_string($conn,$row['questionInput']);
		}
		$iexam.=",$q,$qw,$qd";
		$total+=$qw;
		$iqn.=",'$qi[$i]','$qp[$i]','$qid[$i]'";
		$tqn.=",$q MEDIUMTEXT NOT NULL";
		$tqn.=",$qw DOUBLE NOT NULL DEFAULT '0'";
		$tqn.=",$qc MEDIUMTEXT NOT NULL";
		$tqn.=",$qpc MEDIUMTEXT NOT NULL";
		$tqn.=",$qf MEDIUMTEXT NOT NULL";
		$tqn.=",$qfs DOUBLE NOT NULL";
		$tqn.=",$qsyn DOUBLE NOT NULL";
		$tqn.=",$qfor DOUBLE NOT NULL";
		$tqn.=",$qwhile DOUBLE NOT NULL";
		$tqn.=",$qprint DOUBLE NOT NULL";
		while($o!=7){
			$tqn.=",$qo VARCHAR(15),$qs DOUBLE";
			$o++;
			$qo=$q.'o'.$o;
			$qs=$q.'s'.$o;
		}
		$c++;
	} else {
		$iexam.=",$q,$qw";
		$iqn.=",NULL,NULL";
		if($c<3){
			echo $date."\nA minimum of 3 questions is required to make an exam.\n";
			exit();
		}
	}
}

$iexam.=",questionCount".$iqn.",'$c')";
$texam.=$tqn.")";
$row=mysqli_fetch_assoc(mysqli_query($conn,"SELECT * from db_maxids"));
$exams=$row['exams'];
$exams++;
$incr="UPDATE db_maxids SET exams='$exams'";

$query=mysqli_query($conn,"SELECT * FROM db_users WHERE permission like 'student' ");

if((mysqli_query($conn,$iexam))&&(mysqli_query($conn,$texam))){
	$yes=$date."\n$examname has been created";
		if(mysqli_query($conn,$incr)){
				while($row=mysqli_fetch_assoc($query)){
					$username=mysqli_real_escape_string($conn,$row['username']);
					$fName=mysqli_real_escape_string($conn,$row['fName']);
					$aexam="INSERT INTO `$examname` (username,fName,total) VALUES ('$username','$fName','$total')";
					mysqli_query($conn,$aexam);
				}
				echo $yes;
				exit();
		}else{
			$no="\n$examname was not created\n";
			echo $yes.$no;
				exit();
		}
}else{
	//echo "Could not make table\n".$iexam."\n".$texam;
	echo "Error: " . $sql . "<br>" . mysqli_error($conn);
	exit();
}

mysqli_close($conn);
?>