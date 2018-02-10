<?php
//Decodes JSON
$jsonobj = $_GET["jsonobj"];
$obj = json_decode($jsonobj, true);
$type = $obj[0] -> {"type"};
$array = array("name" => null, "answer" => null);

//Cases, will be used to determine what to do when called. 
switch ($type){
	case "basic":	
		$name2 = "Henri";
		$answer2 = FALSE;
		$array = array("name" => $name2, "answer" => $answer2);	
		echo json_encode($array);
		break;
	case ("example"):
		$array = array("name" => $name, "answer" => $answer);
		echo json_encode($array);
		break;
}
echo json_encode($array); //Should return with null in the object(right now a player object)
?>
