<?php


class Node
{
    protected $db;
    protected $data;
    protected $finalData;
    protected $parentIdPointer;
    protected $treeHtml = '';
    protected $indent = 50;

    public function __construct()
    {
        $this->db = new db();
        $this->data = [];
        $this->finalData = [];
        $this->parentIdPointer = null;
    }

    public function getParent($id){
        $sql = "SELECT * FROM nodes WHERE parent_id = {$id}";
        $result = $this->db->execute($sql);
        if($result->num_rows > 0){
            while($node = $result->fetch_assoc()) {
                return $node;
            }
        }
        return false;
    }

    public function getLatestParent(){
        $sql = "SELECT * FROM nodes ORDER BY parent_id DESC limit 1";
        $result = $this->db->execute($sql);
        if($result->num_rows > 0){
            while($node = $result->fetch_assoc()) {
                return (object) $node;
            }
        }
        return false;
    }

    public function hasChildren($parentId){
        $sql = "SELECT * FROM nodes WHERE parent_id = '{$parentId}'";
        $result = $this->db->execute($sql);
        return ($result->num_rows > 0);
    }

    public function addNode($parentId, $name){
        $sql = "INSERT INTO nodes (parent_id, name) VALUES ('{$parentId}', '{$name}')";
        return $this->db->executeWithId($sql);
    }

    public function deleteNode($id){
        $sql = "DELETE FROM nodes WHERE id = '{$id}'";
        var_dump($sql);
        return $this->db->executeWithId($sql);
    }

    public function getTree(array $nodes, $parentId = 0) {
        $branch = array();
        foreach ($nodes as $node) {
            if ($node['parent_id'] == $parentId) {
                $children = $this->getTree($nodes, $node['id']);
                if ($children) {
                    $node['children'] = $children;
                }
                $branch[] = $node;
            }
        }
        return $branch;
    }

    public function getTreeHtml() {
        return $this->treeHtml;
    }

    public function getHtmlTree(array $nodes, $parentId = 0){

        foreach ($nodes as $node) {

            if ($node['parent_id'] == $parentId) {

                if($parentId > 0){
                    $this->indent += 50;
                } else {
                    $this->indent = 50;
                }

                $this->treeHtml .= "<div style='text-indent: {$this->indent}px'>";
                $this->treeHtml .= "<span>{$node['name']}</span>";
                $nodeId = $node['id'];
                $this->treeHtml .= "<a href='/?add_node={$nodeId}'>&nbsp;+</a>";
                $this->treeHtml .= "<a href='/?delete_node={$nodeId}'>&nbsp;-</a>";
                $this->treeHtml .= "</div>";

                $this->getHtmlTree($nodes, $node['id']);
            }
        }
        return $this->treeHtml;
    }
    public function getNodes(){
        $sql = "SELECT * FROM nodes where name != 'root' ORDER BY parent_id ASC";
        $result = $this->db->execute($sql);
        $nodes = [];
        if($result->num_rows > 0){
            while($node = $result->fetch_assoc()) {
                $nodes[] = $node;
            }
            return $nodes;
        }
        return [];
    }
}