<?php
global $veritabani;
if(isset($_SESSION["Yonetici"])){
    if(isset($_GET["ID"])){
        $GelenID = Guvenlik(SayiliIcerikleriFilitrele($_GET["ID"]));
    }else{
        $GelenID = "";
    }

    if($GelenID != ""){
        $KayitSil = $veritabani->prepare("DELETE FROM sorular WHERE id = ? LIMIT 1");
        $KayitSil->execute([$GelenID]);
        $KayitSilSayisi = $KayitSil->rowCount();
        if($KayitSilSayisi>0){
            yonlendir("index.php?SKD=0&SKI=55");
        }else{
            yonlendir("index.php?SKD=0&SKI=56");
        }
    }else{
        yonlendir("index.php?SKD=0&SKI=56");
    }
}else{
    yonlendir("index.php?SKD=1");
}
?>