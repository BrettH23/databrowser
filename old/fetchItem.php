<?php

$dataJson = file_get_contents('../data/data2.json');
if(isset($_POST["position"])){
    $pos = json_decode($_POST["position"]);

}else{
    $pos = 0;
}

$dataArr = json_decode($dataJson);
if($pos>=count($dataArr)){
    $pos = 0;
}elseif($pos<0){
    $pos = count($dataArr)-1;
}
$response = ['pos'=>$pos,'item'=>$dataArr[$pos]];
echo(json_encode($response));



?>