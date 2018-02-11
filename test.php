<?php
//Decodes JSON
$jsonobj = $_GET["jsonobj"];
$obj = json_decode($jsonobj, true );

//$type = func_get_arg(1);
//$typeInServer = $type -> {"typeInServer"};
/*
//$typeInSever = $obj["type"]);
foreach ($obj as $type => $value){
	//foreach ($value as $type) {
		$typeInSever = $value -> {"typeInSever"};
	//}

	$typeInSever = $key -> {"typeInSever"};
}
*/
//$name = $obj[1] -> {"name"};
$typeInServer = $obj[1];
//$typeInServer = $typeInS->typeInServer;

//Just to see what type if has gotten out:
//Cases, will be used to determine what to do when called. 
switch ($typeInServer){
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
?>
