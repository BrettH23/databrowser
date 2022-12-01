<?php

include "item.php";
include "fetchItem.php";

if(isset($_POST["position"])){
    $itemIndex = json_decode($_POST["position"]);
}else{
    $itemIndex = 1;
}
//echo $index;

echo json_encode(fetchItem($itemIndex));


?>