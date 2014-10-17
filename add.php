<?php
include_once "DatabaseClass.php";
$db = new Database();
extract($_POST);

add_problem($caption,$_FILES);

function add_problem($caption,$file){
    global $db;
    $up_dir="problems";
    if($file["prob"]["error"]==UPLOAD_ERR_OK){
        $moto_name=$file["prob"]["name"][$key];
        $tmp_name=$file["prob"]["tmp_name"][$key];
        move_uploaded_file($tmp_name,"$up_dir/$moto_name");
    }

    $sxml = simplexml_load_file("$up_dir/$moto_name");
    $sel = $sxml->ProblemInfo->SelectCost;
    $swp = $xml->ProblemInfo->SwapCost;
    $max_sel = $xml->ProblemInfo->MaxSelections;

    $query = "insert into problem (caption,x,y,sel,swa,max_sel,path) values (?,?,?,?,?,?)";
    $db->prepare($query);
    $db->bind_param('siiiiis',$caption,$x,$y,$sel,$swa,$max_sel,$moto_name);
    $result=$db->execute();
    if(!$result) die("問題の追加に失敗しました");
    
    echo "<html><body>問題の追加に成功しました。<br><a href=index.php>トップに戻る</a></body></html>";
}

?>
