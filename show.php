<?php
include_once "DatabaseClass.php";
$db = new Database();

function main(){
    global $db;
    $query = "select ID,caption,x,y,sel,swp,max_sel,file_path from problem";
    $result=$db->query($query);

    $result->bind_result($ID,$caption,$x,$y,$sel,$swp,$max_sel,$path);
    while($result->fetch()){
        echo "<tr>";
        echo "<th>".$ID."</th>";
        echo "<th><a href=procon.php?ID=".$ID.">".$caption."</a></th>";
        echo "<th>".$x."x".$y."</th>";
        echo "<th>".$sel."</th>";
        echo "<th>".$swp."</th>";
        echo "<th>".$max_sel."</th>";
        echo "<th><a href=delete.php?ID=".$ID.">削除</a></th>";
        echo "</tr>";
    }
}

?>
