<?php
//Decodes JSON
$jsonobj = $_GET["jsonobj"];
$obj = json_decode($jsonobj);
foreach ($obj->type as $type) {
	$typeInSever = $type -> {"typeInSever"};
	# code...
}

//$typeInSever = $type -> {"typeInSever"};
	# code...
/*
foreach ($data as $name => $value) {
	foreach ($value as $entry) {
        //echo '  ' . $entry->firstName;
		$typeInSever = $entry->typeInSever;
		//$name = $entry -> name;
}
}
*/
//$name = $obj[1] -> {"name"};
//$typeInSever = $obj->type->typeInSever;

$array = array("name" => $name, "answer" => null, "typeInSever" => $typeInSever);

//Cases, will be used to determine what to do when called. 
switch ($typeInSever){
	case "basic":	
		$name2 = "Henri";
		$answer2 = FALSE;
		$array = array("name" => $name2, "answer" => $answer2);	
		echo json_encode($array);
		break;
	case "example":
		$array = array("name" => $name, "answer" => $answer);
		echo json_encode($array);
		break;
}
echo json_encode($array); //Should return with null in the object(right now a player object)

?>
