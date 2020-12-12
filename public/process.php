<?php
include_once ('migrate.php');
include_once ('Node.php');

$nodeObj = new Node();
if(isset($_GET['add_node'])){
    $parentNode = intval($_GET['add_node']);
    if($parentNode == 0){   //this is root
        $lastParent = $nodeObj->getLatestParent();
        if(!$lastParent){
            $parentId = $nodeObj->addNode(0,'root');
            $nodeObj->addNode(0, 'node');
        } else {
            $nodeObj->addNode(0, 'node');
        }
    } else {
        $nodeObj->addNode($parentNode, 'node');
    }
}

if(isset($_GET['delete_node'])){
    $parentNode = intval($_GET['delete_node']);
    $nodeObj->deleteNode($parentNode);
}

$nodes = $nodeObj->getNodes();
$children = $nodeObj->getTree($nodes, 0);
