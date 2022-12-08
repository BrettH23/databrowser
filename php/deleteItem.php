<?php
include 'config.php';

$conn = new mysqli($servername, $username, $password, $dbname);
// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
$result = $conn->query('SELECT COUNT(*) as total from items');
$result2 = $result->fetch_assoc();
$total = $result2['total'];
$result3 = $conn->query('SELECT `image` from items WHERE pkey=' . $_POST['position']);
$result4 = $result3->fetch_assoc();
$imgfile = $result4['image'];
//echo $total;

if(isset($_POST['position']) && $_POST['position']<=$total && $_POST['position']>0){
    $sql = 'DELETE FROM items WHERE pkey=' . $_POST['position'];
    $conn->query($sql);
    //echo $imgfile;
    unlink('../'.$imgfile);
}else{
    echo 'Failure, unset postion';
}
include_once 'sort.php';
$conn->close();
?>