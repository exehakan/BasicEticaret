<?php
require_once "Config/ayar.php";
require_once "Config/fonksiyonlar.php";


if(isset($_GET["AktivasyonKodu"])){
    $GelenAktivasyonKoduDegeri = Guvenlik($_GET["AktivasyonKodu"]);
}else{
    $GelenAktivasyonKoduDegeri = "";
}

if(isset($_GET["Email"])){
    $GelenEmailAdresi = Guvenlik($_GET["Email"]);
}else{
    $GelenEmailAdresi = "";
}

if(($GelenAktivasyonKoduDegeri != "") and ($GelenEmailAdresi != "")){
    $AktivasyonSorgulari = $veritabani->prepare("SELECT * FROM uyeler WHERE AktivasyonKodu = ? AND EmailAdresi = ? AND Durumu = 0");
    $AktivasyonSorgulari->execute([$GelenAktivasyonKoduDegeri,$GelenEmailAdresi]);
    $AktivasyonEtkilenenKayitSayisi = $AktivasyonSorgulari->rowCount();
    if($AktivasyonEtkilenenKayitSayisi > 0){
        $AktivasyonKayitlariniGuncelle = $veritabani->prepare("UPDATE uyeler SET Durumu = 1");
        $AktivasyonKayitlariniGuncelle->execute();
        $AktivasyonKayitlariniGuncelleSayi = $AktivasyonKayitlariniGuncelle->rowCount();
        if($AktivasyonKayitlariniGuncelleSayi>0){
            //Güncelleme başarili ise
            yonlendir("index.php?SK=30");
        }else{
            //Güncelleme başarisiz  ise
            yonlendir($SiteLinki);
        }
    }else{
        yonlendir($SiteLinki);
    }
}else{
    yonlendir($SiteLinki);
}