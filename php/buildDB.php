<?php

include 'config.php';


// Create connection
$conn = new mysqli($servername, $username, $password);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error ."<br>");
} 
echo "Connected successfully <br>";

// Creation of the database
$sql = "CREATE DATABASE IF NOT EXISTS ". $dbname;
if ($conn->query($sql) === TRUE) {
    echo "Database ". $dbname ." created successfully<br>";
} else {
    echo "Error creating database: " . $conn->error ."<br>";
}

// close the connection
$conn->close();
// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);
// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
} 

// $lvar=get_object_vars($a0[0]);
// print_r ($lvar);

$sql = "CREATE TABLE IF NOT EXISTS items (
pkey INT(6) UNSIGNED AUTO_INCREMENT PRIMARY KEY,

name VARCHAR(30) NOT NULL,
rarity VARCHAR(10) NOT NULL,
category VARCHAR(10) NOT NULL,
image VARCHAR(100) NOT NULL,
requires_unlock TINYINT(1) NOT NULL,
has_two_stats TINYINT(1) NOT NULL,

stat1 VARCHAR(30) NOT NULL,
base1 FLOAT(10) NOT NULL,
unit1 VARCHAR(10) NOT NULL,
stack_type1 VARCHAR(20) NOT NULL,
stack_rate1 FLOAT(10) NOT NULL,

stat2 VARCHAR(30) NOT NULL,
base2 FLOAT(10) NOT NULL,
unit2 VARCHAR(10) NOT NULL,
stack_type2 VARCHAR(20) NOT NULL,
stack_rate2 FLOAT(10) NOT NULL
)";


if ($conn->query($sql) === TRUE) {
    echo "Table created successfully<br>";
} else {
    echo "Error creating table: " . $conn->error ."<br>";
}

$conn->close();
// Create connection

if(true){//populateDB

$conn = new mysqli($servername, $username, $password, $dbname);

$dataJson = file_get_contents('../data/data.json');

$dataArr = json_decode($dataJson,true);



$stmt = $conn->prepare("INSERT INTO items(name, rarity, category, 
image, requires_unlock, has_two_stats, stat1, base1, unit1, 
stack_type1, stack_rate1, stat2, base2, unit2, stack_type2, stack_rate2) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)");
if ($stmt==FALSE) {
	echo "There is a problem with prepare <br>";
	echo $conn->error; // Need to connect/reconnect before the prepare call otherwise it doesnt work
}
$stmt->bind_param("ssssiisdssdsdssd", $name, $rarity, $category, 
$image, $requires_unlock, $has_two_stats, $stat1, $base1, $unit1, 
$stack_type1, $stack_rate1, $stat2, $base2, $unit2, $stack_type2, $stack_rate2);

foreach($dataArr as $value){
    $name=$value['name'];
    $rarity=$value['rarity'];
    $category=$value['category'];
    $image=$value['image'];
    $requires_unlock=$value['requires_unlock'];
    $has_two_stats=$value['has_two_stats'];

    $stat1=$value['stats'][0]['stat'];
    $base1=$value['stats'][0]['base'];
    $unit1=$value['stats'][0]['unit'];
    $stack_type1=$value['stats'][0]['stack_type'];
    $stack_rate1=$value['stats'][0]['stack_rate'];
    if($value['has_two_stats']){
        $stat2=$value['stats'][1]['stat'];
        $base2=$value['stats'][1]['base'];
        $unit2=$value['stats'][1]['unit'];
        $stack_type2=$value['stats'][1]['stack_type'];
        $stack_rate2=$value['stats'][1]['stack_rate'];
    }else{
        $stat2='';
        $base2=0;
        $unit2='';
        $stack_type2='';
        $stack_rate2=0; 
    }
    

    $stmt->execute();
    //echo json_encode($value);
}

echo "New record created successfully<br>";

$stmt->close();

// close the connection
$conn->close();

}



include_once 'sort.php';
?>