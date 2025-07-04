<?php
require("../connection/connection.php");


$query = "CREATE TABLE categories (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(255) NOT NULL
);
";

$execute = $mysqli->prepare($query);
$execute->execute();
