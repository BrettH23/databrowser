<?php
if(isset($_POST)){
    if(empty($_POST['has_two_stats'])){
        echo 'empty';
    }else{
        echo $_POST['has_two_stats'];
    }
    
    /*
    foreach($_POST as $val){
        echo $val . ' ';
    }
     */
}



?>