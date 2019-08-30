<?php
global $veritabani;
if(isset($_SESSION["Yonetici"])){
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
    if(($GelenMenuAdi != "") && ($GelenUrunTuru != "")){
        $MenuKontrolSorgusu = $veritabani->prepare("SELECT * FROM menuler WHERE MenuAdi = ? LIMIT 1");
        $MenuKontrolSorgusu->execute([$GelenMenuAdi]);
        $MenuKontrolSorgusuSayisi = $MenuKontrolSorgusu->rowCount();
        if($MenuKontrolSorgusuSayisi>0){
           $e->HTMLYazdir("<h3>Üzgünüm bu menü adina dair bir menü daha önce kaydedilmiş.</h3>");
        }else{
            $YeniMenuEklemeSorgusu  = $veritabani->prepare("INSERT INTO menuler(UrunTuru, MenuAdi) values (?,?)");
            $YeniMenuEklemeSorgusu->execute([$GelenUrunTuru,$GelenMenuAdi]);
            $YeniMenuEklemeSorgusuSayisi = $YeniMenuEklemeSorgusu->rowCount();
            if($YeniMenuEklemeSorgusuSayisi>0){
                yonlendir("index.php?SKD=0&SKI=60");
            }else{
                yonlendir("index.php?SKD=0&SKI=61");
            }
        }
    }else{
        yonlendir("index.php?SKD=0&SKI=61");
    }

}
?>