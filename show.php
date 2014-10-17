<?php
include_once "DatabaseClass.php";
$db = new Database();

function main(){
    global $db;
    $query = "select ID,caption,x,y,sel,swa,max_sel,path from problem";
    $result=$db->query($query);

    $result->bind_result($ID,$caption,$x,$y,$sel,$swa,$max_sel,$path);
    while($result->fetch()){
        echo "<tr>";
        echo "<th>".$caption."</th>";
        echo "<th>".$x."x".$y."</th>";
        echo "<th>".$sel."</th>";
        echo "<th>".$swa."</th>";
        echo "<th>".$max_sel."</th>";
        echo "<th><a href=delete.php?ID=".$ID.">削除</a></th>"
        echo "</tr>";
    }
}

?>
