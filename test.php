<?php
$jsonobj = $_GET["jsonobj"];
$obj = json_decode($jsonobj);
$name = $obj -> {"name"};
$answer = $obj -> {"answer"};
if ($answer == "dinmamma") {
$price = 1;
} else if ($answer == "dinpappa") {
$price = 1;
} else {
$price = 0;
}
if ($price == 0) {
$status = "not-accepted";
} else {
$status = "accepted";
}
$array = array("name" => $name, "answer" => $answer, "price" => $price, "status" => $status);
echo json_encode($array);

?>
