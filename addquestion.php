<?php
//Princewill Onwubu Backend - Beta 3/6 Adding/Creating questions to the question bank
$conn=mysqli_connect("sql1.njit.edu","pio3","yoAexDSq","pio3");
$catch=file_get_contents('php://input');
$_POST=json_decode($catch,true);
$date=date('m/d/Y');

//Input Data
$questk=mysqli_real_escape_string($conn, $_POST['questionKey']);
$questn=mysqli_real_escape_string($conn, $_POST['questionName']);
$questi=mysqli_real_escape_string($conn, $_POST['questionInput']);
$diff=mysqli_real_escape_string($conn, $_POST['difficulty']);
$f=mysqli_real_escape_string($conn, $_POST['for']);
$w=mysqli_real_escape_string($conn, $_POST['while']);
$p=mysqli_real_escape_string($conn, $_POST['print']);
$c1i=mysqli_real_escape_string($conn, $_POST['testCase1Expected']);
$c1o=mysqli_real_escape_string($conn, $_POST['testCase1Result']);
$c2i=mysqli_real_escape_string($conn, $_POST['testCase2Expected']);
$c2o=mysqli_real_escape_string($conn, $_POST['testCase2Result']);
$c3i=mysqli_real_escape_string($conn, $_POST['testCase3Expected']);
$c3o=mysqli_real_escape_string($conn, $_POST['testCase3Result']);
$c4i=mysqli_real_escape_string($conn, $_POST['testCase4Expected']);
$c4o=mysqli_real_escape_string($conn, $_POST['testCase4Result']);
$c5i=mysqli_real_escape_string($conn, $_POST['testCase5Expected']);
$c5o=mysqli_real_escape_string($conn, $_POST['testCase5Result']);
$c6i=mysqli_real_escape_string($conn, $_POST['testCase6Expected']);
$c6o=mysqli_real_escape_string($conn, $_POST['testCase6Result']);

if($f==1){
	$questi.=" Function must use FOR loop.";
}
if($w==1){
	$questi.=" Function must use WHILE loop.";
}
if($p==1){
	$questi.=" Function must PRINT.";
}

$iquest="INSERT INTO db_questions (questionKey,questionName,questionInput,difficulty,f,w,p,input1,output1,input2,output2,input3,output3,input4,output4,input5,output5,input6,output6)
		VALUES ('$questk','$questn','$questi','$diff','$f','$w','$p','$c1i','$c1o','$c2i','$c2o','$c3i','$c3o','$c4i','$c4o','$c5i','$c5o','$c6i','$c6o')";//Insert a question to the question bank

if(mysqli_query($conn,$iquest)){
	$row=mysqli_fetch_assoc(mysqli_query($conn,"SELECT * from db_maxids"));
	$quests=$row['questions'];
	$quests++;
	$incr="UPDATE db_maxids SET questions='$quests'";
	if(mysqli_query($conn,$incr)){//create cases with same id as question
	echo json_encode(date('m/d/Y')."-$questn was added");
	exit();
	}
	else {
			// echo json_encode("Did not add to data base");
			exit();
	}
}
else{
	echo json_encode("Something went wrong");
	exit();
}
mysqli_close($conn);
?>
