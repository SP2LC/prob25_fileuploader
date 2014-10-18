<?php
include_once "DatabaseClass.php";
$db = new Database();
extract($_POST);

if($proposal==="prob25") add_prob25_problem($_FILES);
else if($proposal==="ppm") add_ppm_problem($_FILES);

function add_prob25_problem($file){
    global $db;
    $up_dir="problems";
    if($file["prob25"]["error"]==UPLOAD_ERR_OK){
        $moto_name=$file["prob25"]["name"];
        $tmp_name=$file["prob25"]["tmp_name"];
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
    $lum = $dom->getElementsByTagName("Maxval")->item(0)->nodeValue;
    $contents = $dom->getElementsByTagName("Image")->item(0)->nodeValue;
    $width = $dom->getElementsByTagName("Width")->item(0)->nodeValue;
    $height = $dom->getElementsByTagName("Height")->item(0)->nodeValue;

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

    $query = "insert into problem (caption,x,y,sel,swp,max_sel,file_path) values (?,?,?,?,?,?,?)";
    $db->prepare($query);
    $db->bind_param('siiiiis',$moto_name,$x,$y,$sel,$swp,$max_sel,$moto_name);
    $result=$db->execute();
    if(!$result) die("問題の追加に失敗しました");
    generatePPM($contents,$width,$height,$x,$y,$sel,$swp,$max_sel,$lum,$moto_name){
    }
    echo "<html><body>問題の追加に成功しました。<br><a href=index.php>トップに戻る</a></body></html>";
}

function add_ppm_problem($file){
    global $db;
    $up_dir="problems";
    if($file["ppm"]["error"]==UPLOAD_ERR_OK){
        $moto_name=$file["ppm"]["name"];
        $tmp_name=$file["ppm"]["tmp_name"];
        move_uploaded_file($tmp_name,"$up_dir/$moto_name");
    }
    
    $fp = fopen("$up_dir/$moto_name",'r');
    
    fgets($fp);
    fscanf($fp,"#\t%d\t%d",$x,$y);
    fscanf($fp,"#\t%d",$max_sel);
    fscanf($fp,"#\t%d\t%d",$sel,$swp);
    fclose($fp);

    $query = "insert into problem (caption,x,y,sel,swp,max_sel,file_path) values (?,?,?,?,?,?,?)";
    $db->prepare($query);
    $db->bind_param('siiiiis',$moto_name,$x,$y,$sel,$swp,$max_sel,$moto_name);
    $result=$db->execute();
    if(!$result) die("問題の追加に失敗しました");
    
    echo "<html><body>問題の追加に成功しました。<br><a href=index.php>トップに戻る</a></body></html>";
}

function generatePPM($contents,$width,$height,$x,$y,$sel,$swp,$max_sel,$lum,$moto_name){
    $ppm_name=removeExt($moto_name).".ppm";
    $fp = fopen("hoge/".$ppm_name,'r');
    fprintf($fp,"P6\r\n");
    fprintf($fp,"#\t%d\t%d\r\n",$x,$y);
    fprintf($fp,"#\t%d\r\n",$max_sel);
    fprintf($fp,"#\t%d\t%d\r\n",$sel,$swp);
    fprintf($fp,"%d\t%d\r\n",$width,$height);
    fprintf($fp,"%d\r\n",$lum);
    fwrite($fp,$contents);
    fclose($fp);
}

function removeExt($filename){
    $reg="/(.*)(?:\.([^.]+$))/";
    preg_match($reg,$filename,$retArr);
    return $retArr[1];
}
?>
