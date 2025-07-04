<?php 
require("../connection/connection.php");


$query = "ALTER TABLE articles
ADD COLUMN category_id INT,
ADD CONSTRAINT fk_articles_category
    FOREIGN KEY (category_id) REFERENCES categories(id)
    ON DELETE SET NULL;
";

$execute = $mysqli->prepare($query);
$execute->execute();