<?php
//Decodes JSON
$jsonobj = $_GET["jsonobj"];
$obj = json_decode($jsonobj,true);

/*
//$typeInSever = $obj["type"]);
foreach ($obj as $value){
	foreach
	$typeInSever = $obj["typeInSever"];
}
*/
//$name = $obj[1] -> {"name"};
$typeInServer = $obj[1] -> {"typeInServer"};

//Just to see what type if has gotten out:
$array = array("name" => $name, "answer" => null, "typeInServer" => $typeInServer);
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
//echo $jsonobj
echo json_encode($array); //Should return with null in the object(right now a player object)
?>
