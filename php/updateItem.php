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

if(isset($_POST['requires_unlock'])){
    $item->setRUnlock(true);
}else{
    $item->setRUnlock(false);
}

if(isset($_POST['has_two_stats'])){
    echo 'has 2 stats';
}else{
    echo 'has 1 stat';
}



echo json_encode($item);
//header('Location:../index.html')
?>