<?php
$jsonobj = $_GET["jsonobj"];
$obj = json_decode($jsonobj);
$name = $obj -> {"name"};
$answer = $obj -> {"answer"};

$name2 = "Henri";
$answer2 = FALSE;
$array = array("name" => $name, "answer" => $answer);
echo json_encode($array);
?>
