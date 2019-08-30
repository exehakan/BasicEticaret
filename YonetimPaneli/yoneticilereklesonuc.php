<?php
global $veritabani;
if(isset($_SESSION["Yonetici"])){
    if((isset($_POST["KullaniciAdi"]))){
        $GelenKullaniciAdi = Guvenlik($_POST["KullaniciAdi"]);
    }else{
        $GelenKullaniciAdi = "";
    }

    if(isset($_POST["Sifre"])){
        $GelenSifre = Guvenlik($_POST["Sifre"]);
    }else{
        $GelenSifre = "";
    }

    if(isset($_POST["isimSoyisim"])){
        $GelenisimSoyisim  = Guvenlik($_POST["isimSoyisim"]);
    }else{
        $GelenisimSoyisim  = "";
    }

    if(isset($_POST["EmailAdresi"])){
        $GelenEmailAdresi  = Guvenlik($_POST["EmailAdresi"]);
    }else{
        $GelenEmailAdresi  = "";
    }

    if(isset($_POST["TelefonNumarasi"])){
        $GelenTelefonNumarasi  = Guvenlik($_POST["TelefonNumarasi"]);
    }else{
        $GelenTelefonNumarasi  = "";
    }

    $GelenSifreyiMD5le = md5($GelenSifre);


    if(($GelenKullaniciAdi != "") && ($GelenSifre != "") && ($GelenisimSoyisim != "") && ($GelenEmailAdresi != "") && ($GelenTelefonNumarasi != "")){

        $YoneticiKontrolSorgusu = $veritabani->prepare("SELECT * FROM yoneticiler WHERE KullaniciAdi = ?  OR EmailAdresi = ? ");
        $YoneticiKontrolSorgusu->execute([$GelenKullaniciAdi,$GelenEmailAdresi]);
        $YoneticiKontrolSorgusuSayisi = $YoneticiKontrolSorgusu->rowCount();

        if($YoneticiKontrolSorgusuSayisi>0){
            yonlendir("index.php?SKD=0&SKI=74");
        }else{
            $YeniYoneticiEkle = $veritabani->prepare("INSERT INTO yoneticiler(KullaniciAdi, Sifre, isimSoyisim, EmailAdresi, TelefonNumrasi) values(?,?,?,?,?)");
            $YeniYoneticiEkle->execute([$GelenKullaniciAdi,$GelenSifreyiMD5le,$GelenisimSoyisim,$GelenEmailAdresi,$GelenTelefonNumarasi]);
            $YeniYoneticiEkleSayisi = $YeniYoneticiEkle->rowCount();
            if($YeniYoneticiEkleSayisi>0){
                yonlendir("index.php?SKD=0&SKI=72");
            }else{
                yonlendir("index.php?SKD=0&SKI=73");
            }
        }



    }else{
        yonlendir("index.php?SKD=0&SKI=73");
    }





}
?>