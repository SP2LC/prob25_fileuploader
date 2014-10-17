<?php
include_once "DatabaseClass.php";

$db = new Database();
extract($_GET);

del_prob($ID);

function del_prob($ID){
    global $db;
    $up_dir="problems";
    $query = "select path from problem wehre ID=?";
    $result=$db->query($query);

    $result->bind_result($filename);
    $result->fetch();
    unlink("$up_dir/$filename")

    $query = "delete from problem where ID=?";
    $db->prepare($query);
    $db->bind_param('i',$ID);
    $result=$db->execute();
    if(!$result) die("問題の削除に失敗しました");
    echo $filename."を削除しました<br>";
}

?>
