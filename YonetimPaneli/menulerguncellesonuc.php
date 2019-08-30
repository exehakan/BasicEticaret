<?php
global $veritabani;
if(isset($_SESSION["Yonetici"])){
    if(isset($_GET["ID"])){
        $GelenID = Guvenlik(SayiliIcerikleriFilitrele($_GET["ID"]));
    }else{
        $GelenID = "";
    }

    if(isset($_POST["UrunTuru"])){
        $GelenUrunTuru = Guvenlik($_POST["UrunTuru"]);
    }else{
        $GelenUrunTuru = "";
    }

    if(isset($_POST["MenuAdi"])){
        $GelenMenuAdi = Guvenlik($_POST["MenuAdi"]);
    }else{
        $GelenMenuAdi = "";
    }


    if(($GelenUrunTuru != "") && ($GelenMenuAdi != "") && ($GelenID != "")){
        $MenuGuncellemeSorgusu = $veritabani->prepare("UPDATE menuler SET MenuAdi = ? WHERE id = ? LIMIT 1");
        $MenuGuncellemeSorgusu->execute([$GelenMenuAdi,$GelenID]);
        $MenuGuncellemeSorgusuSayisi = $MenuGuncellemeSorgusu->rowCount();
        if($MenuGuncellemeSorgusuSayisi>0){
            yonlendir("index.php?SKD=0&SKI=64");
        }else{
            yonlendir("index.php?SKD=0&SKI=65");
        }
    }else{
        yonlendir("index.php?SKD=0&SKI=65");
    }


}else{
    yonlendir("index.php?SKD=1");
}
?>