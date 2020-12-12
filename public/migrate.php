<?php
include ('db.php');

$db = new db();

$createNodesTable = "
    CREATE TABLE IF NOT EXISTS nodes (
        id INT UNSIGNED AUTO_INCREMENT PRIMARY KEY, 
        parent_id INT UNSIGNED NOT NULL,
        name varchar(16) NOT NULL 
    )
";

$db->execute($createNodesTable);

