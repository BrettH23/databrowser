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
//echo $total;
echo true;
echo isset($_POST['position']);
echo $_POST['position']<=$total;
echo $_POST['position']>0;
if(isset($_POST['position']) && $_POST['position']<=$total && $_POST['position']>0){
    $sql = 'DELETE FROM items WHERE pkey=' . $_POST['position'];
    $conn->query($sql);
}else{
    echo 'Failure, unset postion';
}


?>