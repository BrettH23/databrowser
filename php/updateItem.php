<?php
include 'item.php';
include 'uploadfile.php';

$accept = true;
$item = new Item();

if(isset($_POST['name'])){
   $item->setName($_POST['name']);
}else{
    echo 'Failure, bad name';
    $accept=false;
}

if(isset($_POST['rarity'])){
    $item->setRarity($_POST['rarity']);
}else{
    echo 'Failure, bad rarity';
    $accept=false;
}

if(isset($_POST['category'])){
    $item->setCategory($_POST['category']);
}else{
    echo 'Failure, bad category';
    $accept=false;
}

$imageok = true;
if($uploadOk == 1){
    $item->setImage('images/'.basename($_FILES["fileup"]["name"]));
}else if($_POST['mode']=='edit'){
    $imageok=false;
}
else{
    $accept=false;
}


if(isset($_POST['requires_unlock'])){
    $item->setRUnlock(true);
}else{
    $item->setRUnlock(false);
}

if(isset($_POST['stat1'])){
    $item->setStat($_POST['stat1'],0);
}else{
    echo 'Failure, bad stat1';
    $accept=false;
}
if(isset($_POST['base1'])){
    $item->setBase($_POST['base1'],0);
}else{
    echo 'Failure, bad base1';
    $accept=false;
}
if(isset($_POST['unit1'])){
    $item->setUnit($_POST['unit1'],0);
}else{
    echo 'Failure, bad unit1';
    $accept=false;
}
if(isset($_POST['stack_type1'])){
    $item->setStackType($_POST['stack_type1'],0);
}else{
    echo 'Failure, bad stack_type1';
    $accept=false;
}
if(isset($_POST['stack_rate1'])){
    $item->setStackRate($_POST['stack_rate1'],0);
}else{
    echo 'Failure, bad stack_rate1';
    $accept=false;
}



if(isset($_POST['has_two_stats'])){
    $item->set2Stats(true);
    
    if(isset($_POST['stat2'])){
        $item->setStat($_POST['stat2'],1);
    }else{
        echo 'Failure, bad stat2';
        $accept=false;
    }
    if(isset($_POST['base2'])){
        $item->setBase($_POST['base2'],1);
    }else{
        echo 'Failure, bad base2';
        $accept=false;
    }
    if(isset($_POST['unit2'])){
        $item->setUnit($_POST['unit2'],1);
    }else{
        echo 'Failure, bad unit2';
        $accept=false;
    }
    if(isset($_POST['stack_type2'])){
        $item->setStackType($_POST['stack_type2'],1);
    }else{
        echo 'Failure, bad stack_type2';
        $accept=false;
    }
    if(isset($_POST['stack_rate2'])){
        $item->setStackRate($_POST['stack_rate2'],1);
    }else{
        echo 'Failure, bad stack_rate2';
        $accept=false;
    }


        

}else{
    $item->set2Stats(false);
}


//echo $accept;
//echo json_encode($item);
if($accept){     
    
    include_once 'config.php';


    $conn = new mysqli($servername, $username, $password, $dbname);
    $stmt;
    $itemToInsert = json_decode(json_encode($item), true);
    if($_POST['mode']=='new'){
        $stmt = $conn->prepare("INSERT INTO items(name, rarity, category, 
        image, requires_unlock, has_two_stats, stat1, base1, unit1, 
        stack_type1, stack_rate1, stat2, base2, unit2, stack_type2, stack_rate2) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)");
        
        $stmt->bind_param("ssssiisdssdsdssd", $name, $rarity, $category, 
        $image, $requires_unlock, $has_two_stats, $stat1, $base1, $unit1, 
        $stack_type1, $stack_rate1, $stat2, $base2, $unit2, $stack_type2, $stack_rate2);

        
        $name=$itemToInsert['name'];
        $rarity=$itemToInsert['rarity'];
        $category=$itemToInsert['category'];
        
        $image=$itemToInsert['image'];
        
        
        $requires_unlock=$itemToInsert['requires_unlock'];
        $has_two_stats=$itemToInsert['has_two_stats'];

        $stat1=$itemToInsert['stats'][0]['stat'];
        $base1=$itemToInsert['stats'][0]['base'];
        $unit1=$itemToInsert['stats'][0]['unit'];
        $stack_type1=$itemToInsert['stats'][0]['stack_type'];
        $stack_rate1=$itemToInsert['stats'][0]['stack_rate'];
        if($itemToInsert['has_two_stats']){
            $stat2=$itemToInsert['stats'][1]['stat'];
            $base2=$itemToInsert['stats'][1]['base'];
            $unit2=$itemToInsert['stats'][1]['unit'];
            $stack_type2=$itemToInsert['stats'][1]['stack_type'];
            $stack_rate2=$itemToInsert['stats'][1]['stack_rate'];
        }else{
            $stat2='';
            $base2=0;
            $unit2='';
            $stack_type2='';
            $stack_rate2=0; 
        }
    
        if ($stmt==FALSE) {
            echo "There is a problem with prepare <br>";
            echo $conn->error; // Need to connect/reconnect before the prepare call otherwise it doesnt work
        }
        $stmt->execute();
    }else if($_POST['mode']=='edit'){
        if(isset($_POST['position']) && is_numeric($_POST['position'])){
            $sql="UPDATE items SET ";
            $sql.="name='".$itemToInsert["name"] ."', ";
            $sql.="rarity='".$itemToInsert["rarity"]."', ";
            $sql.="category='".$itemToInsert["category"]."', ";
            
            
            if($imageok){
                $sql.="image='".$itemToInsert["image"]."', ";
            }
            
            
            if($itemToInsert["requires_unlock"]){
                $sql.="requires_unlock=1, ";
            }else{
                $sql.="requires_unlock=0, ";
            }

            if($itemToInsert["has_two_stats"]){
                $sql.="has_two_stats=1, ";
            }else{
                $sql.="has_two_stats=0, ";
            }
            

            $sql.="stat1='".$itemToInsert["stats"][0]["stat"]."', ";
            $sql.="base1=".$itemToInsert["stats"][0]["base"].", ";
            $sql.="unit1='".$itemToInsert["stats"][0]["unit"]."', ";
            $sql.="stack_type1='".$itemToInsert["stats"][0]["stack_type"]."', ";
            $sql.="stack_rate1=".$itemToInsert["stats"][0]["stack_rate"].", ";
            if($itemToInsert["has_two_stats"]){
                $sql.="stat2='".$itemToInsert["stats"][1]["stat"]."', ";
                $sql.="base2=".$itemToInsert["stats"][1]["base"].", ";
                $sql.="unit2='".$itemToInsert["stats"][1]["unit"]."', ";
                $sql.="stack_type2='".$itemToInsert["stats"][1]["stack_type"]."', ";
                $sql.="stack_rate2=".$itemToInsert["stats"][1]["stack_rate"];
            }else{
                $sql.="stat2=". '0' .", ";
                $sql.="base2=". 0 .", ";
                $sql.="unit2=". '0' .", ";
                $sql.="stack_type2=". '0' .", ";
                $sql.="stack_rate2=". 0;
            }

            $sql.=' WHERE pkey='.$_POST['position'];
            echo $sql;
            
            
            if ($conn->query($sql) === TRUE) {
                echo "item edited successfully<br>";
            } else {
                echo "Error editing item: " . $conn->error ."<br>";
            }
            
            
            /* 
            $stmt = $conn->prepare("UPDATE items SET name=?, rarity=?, category=?, 
            image=?, requires_unlock=?, has_two_stats=?, stat1=?, base1=?, unit1=?, 
            stack_type1=?, stack_rate1=?, stat2=?, base2=?, unit2=?, stack_type2=?, stack_rate2=? WHERE pkey=".$_POST['position']);
            if ($stmt==FALSE) {
                echo "There is a problem with prepare <br>";
                echo $conn->error; // Need to connect/reconnect before the prepare call otherwise it doesnt work
            }*/
        }else{
            echo "There is a problem with the request <br>";
            echo $conn->error; // Need to connect/reconnect before the prepare call otherwise it doesnt work
        }
        
        
    }


    
    $conn->close();
    
    //echo json_encode($value);


}else{
    echo 'Rejected. Not uploaded to database.';
}
//echo $_POST['mode'];
//echo $_POST['position'];
include_once 'sort.php';

if($accept){
    
    $conn = new mysqli($servername, $username, $password, $dbname);
    $itemToInsert = json_decode(json_encode($item), true);
    $name=$itemToInsert['name'];
    $sql = "SELECT pkey FROM items WHERE `name`= '" . $name . "' LIMIT 1";

    $result = $conn->query($sql);
    
    $row = $result->fetch_assoc();
    //echo $row['pkey'];
    header("location: ../browser.html?pos=" . $row['pkey']);
}



//echo json_encode($item);
//header('Location:../index.html')
?>