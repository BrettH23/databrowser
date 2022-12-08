<?php
include 'config.php';

$conn = new mysqli($servername, $username, $password, $dbname);
// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}    
$result = $conn->query('SELECT pkey,`name`,rarity FROM items');

$arr;
while($row = $result->fetch_assoc()){
    $arr[$row['pkey']] = ['name' =>$row['name'] , 'rarity'=> $row['rarity']];
}
echo json_encode($arr);

?>