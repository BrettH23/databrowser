<?php

include "item.php";

if(isset($_POST["position"])){
    $index = json_decode($_POST["position"]);
}else{
    $index = 1;
}
//echo $index;

$servername = "localhost"; // default server name
$username = "admin02"; // user name that you created
$password = "x2g)OUQiY7uu!x3-"; // password that you created
$dbname = "ROR2_Items";

$conn = new mysqli($servername, $username, $password, $dbname);
// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$result = $conn->query('SELECT COUNT(*) as total from items');
$result2 = $result->fetch_assoc();
$total = $result2['total'];
//echo $total;
if($index>$total){
    $index = 1;
}elseif($index<1){
    $index = $total;
}

$sql = 'SELECT name, rarity, category, 
image, requires_unlock, has_two_stats, stat1, base1, unit1, 
stack_type1, stack_rate1, stat2, base2, unit2, stack_type2, stack_rate2 FROM items where pkey=' . $index;

$result = $conn->query($sql);

if ($result->num_rows > 0) {
    // output data of each row
    $row = $result->fetch_assoc(); // Fetch a result row as an associative array
    
    $selected_item=new Item();
    
    $selected_item->setName($row['name']);
    $selected_item->setRarity($row['rarity']);
    $selected_item->setCategory($row['category']);
    $selected_item->setImage($row['image']);
    
    if($row['requires_unlock'] == 0){
        $selected_item->setRUnlock(false);
    }else{
        $selected_item->setRUnlock(true);
    }

    if($row['has_two_stats'] == 0){
        $selected_item->set2Stats(false);
    }else{
        $selected_item->set2Stats(true);
    }
    
    $selected_item->setStat(0, $row['stat1']);
    $selected_item->setBase(0, $row['base1']);
    $selected_item->setUnit(0, $row['unit1']);
    $selected_item->setStackType(0, $row['stack_type1']);
    $selected_item->setStackRate(0, $row['stack_rate1']);

    $selected_item->setStat(1, $row['stat2']);
    $selected_item->setBase(1, $row['base2']);
    $selected_item->setUnit(1, $row['unit2']);
    $selected_item->setStackType(1, $row['stack_type2']);
    $selected_item->setStackRate(1, $row['stack_rate2']);

    $response = ['pos'=>$index,'item'=>$selected_item];



    echo json_encode($response);
} else {
    $bad1=[ 'bad' => 1];
    echo json_encode($bad1);	
	}


?>