<?php
function fetchItem($index)
{
include 'config.php';

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
        
        $selected_item->setStat($row['stat1'],0);
        $selected_item->setBase($row['base1'],0);
        $selected_item->setUnit($row['unit1'],0);
        $selected_item->setStackType($row['stack_type1'],0);
        $selected_item->setStackRate($row['stack_rate1'],0);

        $selected_item->setStat($row['stat2'],1);
        $selected_item->setBase($row['base2'],1);
        $selected_item->setUnit($row['unit2'],1);
        $selected_item->setStackType($row['stack_type2'],1);
        $selected_item->setStackRate($row['stack_rate2'],1);

        $response = ['pos'=>$index,'item'=>$selected_item, 'total'=>$total];



        return($response);
    } else {
        $bad1=[ 'bad' => 1];
        return($bad1);	
    }
}
?>