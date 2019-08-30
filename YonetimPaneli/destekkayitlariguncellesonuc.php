<?php
global $veritabani;
if(isset($_SESSION["Yonetici"])){
    if(isset($_GET["ID"])){
        $GelenID = Guvenlik(SayiliIcerikleriFilitrele($_GET["ID"]));
    }else{
        $GelenID = "";
    }

    if(isset($_POST["SoruBasligi"])){
        $GelenSoruBasligi = Guvenlik($_POST["SoruBasligi"]);
    }else{
        $GelenSoruBasligi = "";
    }

    echo $GelenSoruBasligi;

    if(isset($_POST["BaslikCevabi"])){
        $GelenBaslikCevabi = Guvenlik($_POST["BaslikCevabi"]);
    }else{
        $GelenBaslikCevabi = "";
    }

    if(($GelenID !="") && ($GelenSoruBasligi != "") && ($GelenBaslikCevabi != "")){
        $DestekGuncelleSorgusu = $veritabani->prepare("UPDATE sorular SET soru = ? , cevap = ? WHERE id = ? LIMIT 1");
        $DestekGuncelleSorgusu->execute([$GelenSoruBasligi,$GelenBaslikCevabi,$GelenID]);
        $DestekGuncelleSorgusuSayisi = $DestekGuncelleSorgusu->rowCount();

        if($DestekGuncelleSorgusuSayisi>0){
            yonlendir("index.php?SKD=0&SKI=52");
        }else{
            yonlendir("index.php?SKD=0&SKI=53");
        }
    }else{
        yonlendir("index.php?SKD=0&SKI=53");
    }
}else{
    yonlendir("index.php?SKD=1");
}
?>