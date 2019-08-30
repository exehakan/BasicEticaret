<?php
if(isset($_SESSION["Kullanici"])){
    if(isset($_GET["ID"])){
        $GelenID = Guvenlik($_GET["ID"]);
    }else{
        $GelenID = "";
    }

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

    if(($GelenID != "") && ($GelenisimSoyisim != "") && ($GelenAdres != "") && ($GelenIlce != "") && ($GelenSehir != "") && ($GelenTelefonNumarasi != "")){
        $GelenlerinKontrolu = $veritabani->prepare("SELECT * FROM adresler WHERE id = ? AND UyeId =? LIMIT 1");
        $GelenlerinKontrolu->execute([$GelenID,$KullaniciID]);
        $KontrolSayisi = $GelenlerinKontrolu->rowCount();
        $KontrolDegerleri = $GelenlerinKontrolu->fetch(PDO::FETCH_ASSOC);
        if($KontrolSayisi>0){
            $KontrolAdiSoyadi           = $KontrolDegerleri["AdiSoyadi"];
            $KontrolAdres               = $KontrolDegerleri["Adres"];
            $KontrolSehir               = $KontrolDegerleri["Sehir"];
            $KontrolIlce                = $KontrolDegerleri["Ilce"];
            $KontrolTelefonNumarasi     = $KontrolDegerleri["TelefonNumarasi"];
            if((($KontrolAdiSoyadi != $GelenisimSoyisim) or ($KontrolAdres != $GelenAdres)) or (($KontrolIlce != $GelenIlce) or ($KontrolSehir != $GelenSehir) or ($KontrolTelefonNumarasi != $GelenTelefonNumarasi))){
                $AdresGuncelleSorgusu = $veritabani->prepare("UPDATE adresler SET AdiSoyadi = ?,Adres = ?,Ilce = ?, Sehir = ?, TelefonNumarasi = ? WHERE id=? AND UyeId = ? LIMIT 1");
                $AdresGuncelleSorgusu->execute([$GelenisimSoyisim,$GelenAdres,$GelenIlce,$GelenSehir,$GelenTelefonNumarasi,$GelenID,$KullaniciID]);
                $EtkilenenAdresSorgusu = $AdresGuncelleSorgusu->rowCount();
                if($EtkilenenAdresSorgusu > 0){
                    yonlendir("index.php?SK=64");
                }else{
                    yonlendir("index.php?SK=65");
                }
            }else{
                yonlendir("index.php?SK=66");
            }
        }else{
            yonlendir("index.php?SK=66");
        }
    }else{
        yonlendir("index.php?SK=66");

    }
}else{
    yonlendir("index.php");
}