<?php
//Princewill Onwubu Backend - Beta 3/6 PResenting the questions via Json Array upstream
$res=array();
//questionName,questionInput,difficulty,questionKey
$query=mysqli_query($conn,"SELECT * FROM db_questions");

while($row=mysqli_fetch_assoc($query)){
	$data=array(
		"questionKey"=>$row['questionKey'],
		"questionName"=>$row['questionName'],
		"questionInput"=>$row['questionInput'],
		"difficulty"=>$row['difficulty'],
		"for"=>$row['f'],
		"while"=>$row['w'],
		"print"=>$row['p'],
		"id"=>$row['id']);
	array_push($res,$data);
}
echo json_encode($res);

mysqli_close($conn);
?>
