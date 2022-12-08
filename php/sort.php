<?php
include 'config.php';

$conn = new mysqli($servername, $username, $password, $dbname);
// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}


//$sql= 'SELECT * FROM `items` ORDER BY items.rarity ASC;';
$sql = 'ALTER TABLE items DROP pkey;';

$conn->query($sql);

$sql="ALTER TABLE items ADD COLUMN pkey INT NOT NULL;
SET @x = 0;
UPDATE items SET pkey = (@x:=@x+1) ORDER BY FIELD(rarity, 'Void','Lunar','Boss','Legendary','Uncommon','Common') DESC,`name`;
ALTER TABLE items ADD PRIMARY KEY pkey (pkey);
ALTER TABLE items CHANGE pkey pkey INT NOT NULL AUTO_INCREMENT;";
$conn->multi_query($sql);

//$conn->query('ALTER TABLE items DROP PRIMARY KEY, ADD PRIMARY KEY(name);');
//$sql= 'ALTER TABLE items  ADD id INT NOT NULL AUTO_INCREMENT FIRST ORDER BY items.rarity, AUTO_INCREMENT=1 ';
//$sql = 'ALTER TABLE items ORDER BY rarity';
/*
if($conn->multi_query($sql) === TRUE){
    echo 'seems fine';
}
*/


//$conn->query('ALTER TABLE items DROP pkey');
//$conn->query('ALTER TABLE items ADD pkey INT NOT NULL AUTO_INCREMENT FIRST, ADD PRIMARY KEY (pkey), AUTO_INCREMENT=1');



?>