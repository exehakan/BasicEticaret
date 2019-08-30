<?php
if(isset($_SESSION["Kullanici"])){
    if(isset($_POST["isimSoyisim"])){
        $GelenisimSoyisim = Guvenlik($_POST["isimSoyisim"]);
    }else{
        $GelenisimSoyisim = "";
    }

    if(isset($_POST["Adres"])){
        $GelenAdres = Guvenlik($_POST["Adres"]);
    }else{
        $GelenAdres = "";
    }

    if(isset($_POST["Ilce"])){
        $GelenIlce = Guvenlik($_POST["Ilce"]);
    }else{
        $GelenIlce = "";
    }

    if(isset($_POST["Sehir"])){
        $GelenSehir = Guvenlik($_POST["Sehir"]);
    }else{
        $GelenSehir = "";
    }

    if(isset($_POST["TelefonNumarasi"])){
        $GelenTelefonNumarasi = Guvenlik($_POST["TelefonNumarasi"]);
    }else{
        $GelenTelefonNumarasi = "";
    }


    if(($GelenisimSoyisim != "") &&($GelenAdres != "") &&($GelenIlce != "") &&($GelenSehir != "") &&($GelenTelefonNumarasi != "") ){

        $AdresEkleSorgu = $veritabani->prepare("INSERT INTO adresler(UyeId, AdiSoyadi, Adres, Sehir, Ilce, TelefonNumarasi) values (?,?,?,?,?,?)");
        $AdresEkleSorgu->execute([$KullaniciID,$GelenisimSoyisim,$GelenAdres,$GelenSehir,$GelenIlce,$GelenTelefonNumarasi]);
        $EtkilenenSorgu = $AdresEkleSorgu->rowCount();
        if($EtkilenenSorgu>0){
            yonlendir("index.php?SK=72");
        }else{
            yonlendir("index.php?SK=73");
        }



    }else{
        yonlendir("index.php?SK=74");
    }





}else{
    yonlendir("index.php");
}


