<?php
//Decodes JSON
$jsonobj = $_GET["jsonobj"];
$obj = json_decode($jsonobj, true);
//$typeInSever = $obj["type"]);
foreach ($obj as $key => $value) {
	foreach ($value as $key => $value) {
		$typeInSever = $value -> {"typeInSever"};

	}
}

//$name = $obj[1] -> {"name"};
//$typeInSever = $obj->type->typeInSever;

//Just to see what type if has gotten out:
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
		$name = "Ex";
		$answer = FALSE;
		$array = array("name" => $name, "answer" => $answer);
		echo json_encode($array);
		break;
}
echo json_encode($array); //Should return with null in the object(right now a player object)
?>
