<?php
include 'item.php';
include 'config.php';
include "fetchItem.php";

$conn = new mysqli($servername, $username, $password, $dbname);
// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}    
$result = $conn->query('SELECT COUNT(*) as total from items');
$result2 = $result->fetch_assoc();
$total = $result2['total'];
$conn->close();
$arr;
for($i = 0;$i<$total;$i++){
    $fetched = fetchItem($i);
    $arr[$i] =$fetched['item'];
}
//echo json_encode($arr);
$file = fopen("../data/data.json", "w") or die("Unable to open file!");
fwrite($file, json_encode($arr));
echo 'Database Saved.';
?>