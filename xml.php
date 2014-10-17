<?php
include_once "DatabaseClass.php";
$db = new Database();
extract($_POST);

add_problem($caption,$_FILES);

function add_problem($caption,$file){
    global $db;

    $sxml = simplexml_load_file($file);
    var_dump($sxml);

}

?>
