<?php
include_once "DatabaseClass.php";
$db = new Database();
extract($_POST);

if($proposal==="prob25") add_prob25_problem($_FILES);
else if($proposal==="ppm") add_ppm_problem($_FILES);

function add_prob25_problem($file){
    global $db;
    $up_dir="problems";
    if($file["prob"]["error"]==UPLOAD_ERR_OK){
        $moto_name=$file["prob"]["name"];
        $tmp_name=$file["prob"]["tmp_name"];
        move_uploaded_file($tmp_name,"$up_dir/$moto_name");
    }

    $dom = new DOMDocument('1.0','UTF-8');
    $dom->preserveWhiteSpace = false;
    $dom->formatOutput = true;
    $dom->load("$up_dir/$moto_name");

    $x = -1;
    $y = -1;

    $swp = $dom->getElementsByTagName("SwapCost")->item(0)->nodeValue;
    $sel = $dom->getElementsByTagName("SelectCost")->item(0)->nodeValue;
    $max_sel = $dom->getElementsByTagName("MaxSelections")->item(0)->nodeValue;

    foreach($dom->getElementsByTagName("X") as $kore){
       $temp = $kore->nodeValue;
       if($temp>=$x) $x=$temp;
    }
    $x = $x + 1;

    foreach($dom->getElementsByTagName("Y") as $kore){
       $temp = $kore->nodeValue;
       if($temp>=$y) $y=$temp;
    }
    $y = $y + 1;

    $query = "insert into problem (caption,x,y,sel,swp,max_sel,path) values (?,?,?,?,?,?,?)";
    $db->prepare($query);
    $db->bind_param('siiiiis',$moto_name,$x,$y,$sel,$swp,$max_sel,$moto_name);
    $result=$db->execute();
    if(!$result) die("問題の追加に失敗しました");
    
    echo "<html><body>問題の追加に成功しました。<br><a href=index.php>トップに戻る</a></body></html>";
}

function add_ppm_problem($file){
    global $db;
    $up_dir="problems";
    if($file["prob"]["error"]==UPLOAD_ERR_OK){
        $moto_name=$file["prob"]["name"];
        $tmp_name=$file["prob"]["tmp_name"];
        move_uploaded_file($tmp_name,"$up_dir/$moto_name");
    }
    
    $fp = fopen("$up_dir/$moto_name",'r');
    
    fgets($fp);
    fscanf($fp,"#\t%d\t%d",$x,$y);
    fscanf($fp,"#\t%d",$max_sel);
    fscanf($fp,"#\t%d\t%d",$sel,$swp);
    fclose($fp);

    $query = "insert into problem (caption,x,y,sel,swp,max_sel,path) values (?,?,?,?,?,?,?)";
    $db->prepare($query);
    $db->bind_param('siiiiis',$moto_name,$x,$y,$sel,$swp,$max_sel,$moto_name);
    $result=$db->execute();
    if(!$result) die("問題の追加に失敗しました");
    
    echo "<html><body>問題の追加に成功しました。<br><a href=index.php>トップに戻る</a></body></html>";
}

?>
