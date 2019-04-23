<?php
//Princewill Onwubu Backend - Beta 3/31 Presenting the selected Exam to student via Json Array upstream
$catch=file_get_contents('php://input');
$_POST=json_decode($catch,true);

$id=mysqli_real_escape_string($conn, $_POST['id']);
$query=mysqli_query($conn,"SELECT * FROM db_exams WHERE id like '$id'");
$res=array();

if($r1=mysqli_fetch_assoc($query)){
	$exam=array(
		"professor"=>$r1['professor'],
		"examname"=>$r1['examname']);
	$i=1;
	$q='q'.$i;
	$qw=$q.'w';
	while(($r1[$q])!=NULL){
		$exam[$q]=$r1[$q];
		$exam[$qw]=$r1[$qw];
		$i++;$q='q'.$i;$qw=$q.'w';
	}
	//echo json_encode($exam);
	array_push($res,$exam);
}

$query=mysqli_query($conn,"SELECT * FROM db_exams WHERE id like '$id'");
if($r1=mysqli_fetch_assoc($query)){
	$i=1;
	$q='q'.$i;
	$qid=$q.'id';


	$r2=mysqli_fetch_assoc(mysqli_query($conn,"SELECT * FROM db_questions WHERE id like '$r1[$qid]'"));

	while(($r1[$q])!=NULL){
		$quests=array();
		if(empty($r2['questionName']!=true)){
			$quests['questionName']=$r2['questionName'];
			$quests['questionInput']=$r2['questionInput'];
			$quests['questionKey']=$r2['questionKey'];
			$quests['for']=$r2['f'];
			$quests['while']=$r2['w'];
			$quests['print']=$r2['p'];
			$o=1;
			$qi='input'.$o;
			$qo='output'.$o;
			while(empty($r2[$qi])!=true){
				$quests[$qi]=$r2[$qi];
				$quests[$qo]=str_replace('"','',$r2[$qo]);
				$o++;
				$qi='input'.$o;
				$qo='output'.$o;
			}

		}
		$i++;
		$q='q'.$i;
		$qid=$q.'id';

		array_push($res,$quests);

		$r2=mysqli_fetch_assoc(mysqli_query($conn,"SELECT * FROM db_questions WHERE id like '$r1[$qid]'"));
	}
	//echo json_encode($quests);

}
echo json_encode($res);
mysqli_close($conn);
exit();
?>
