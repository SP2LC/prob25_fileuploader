<?php
include_once "DatabaseClass.php";

$db = new Database();
extract($_GET);

get_prob($probID);

function get_prob($ID){
    global $db;
    $up_dir="problems";
    $query = "select file_path from problem where ID=?";
    $db->prepare($query);
    $db->bind_param('i',$ID);
    $result=$db->execute();

    $result->bind_result($filename);
    $result->fetch();
    header('Content-Type: application/octet-stream');
    header('Content-Disposition: attachment; filename=' . $filename);
    header('Content-Transfer-Encoding: binary');
    header('Content-Length: ' . filesize("$up_dir/$filename"));
    readfile("$up_dir/$filename");
}

?>
