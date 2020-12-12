<?php
include ('db.php');

$db = new db();

//$createParentTable = "
//    CREATE TABLE IF NOT EXISTS parents (
//        id INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
//        name varchar(16) NOT NULL
//    )
//";
//
//$createChildTable = "
//    CREATE TABLE IF NOT EXISTS children (
//        id INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
//        name VARCHAR(16) NOT NULL,
//        parent_id INT UNSIGNED NOT NULL,
//        FOREIGN KEY (parent_id)
//            REFERENCES parents (id)
//            ON DELETE CASCADE
//    );
//";
//
//$db->execute($createParentTable);
//$db->execute($createChildTable);

$createNodesTable = "
    CREATE TABLE IF NOT EXISTS nodes (
        id INT UNSIGNED AUTO_INCREMENT PRIMARY KEY, 
        parent_id INT UNSIGNED NOT NULL,
        name varchar(16) NOT NULL 
    )
";

$db->execute($createNodesTable);

