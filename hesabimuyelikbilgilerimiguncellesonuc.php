<?php
if($_SESSION["Kullanici"]){
    if(isset($_POST["EmailAdresi"])){
        $GelenEmailAdresi = Guvenlik($_POST["EmailAdresi"]);
    }else{
        $GelenEmailAdresi = "";
    }

    if(isset($_POST["isimSoyisim"])){
        $GelenisimSoyisim = Guvenlik($_POST["isimSoyisim"]);
    }else{
        $GelenisimSoyisim = "";
    }

    if(isset($_POST["Sifre"])){
        $GelenSifre = Guvenlik($_POST["Sifre"]);
    }else{
        $GelenSifre = "";
    }

    if(isset($_POST["SifreTekrar"])){
        $GelenSifreTekrar = Guvenlik($_POST["SifreTekrar"]);
    }else{
        $GelenSifreTekrar = "";
    }

    if(isset($_POST["TelefonNumarasi"])){
        $GelenTelefonNumarasi = Guvenlik($_POST["TelefonNumarasi"]);
    }else{
        $GelenTelefonNumarasi = "";
    }

    if(isset($_POST["Cinsiyet"])){
        $GelenCinsiyet = Guvenlik($_POST["Cinsiyet"]);
    }else{
        $GelenCinsiyet = "";
    }
    $md5Sifrele = md5($GelenSifre);

    if(($GelenEmailAdresi != "") && ($GelenSifre != "") && ($GelenSifreTekrar !="") && ($GelenTelefonNumarasi!="") && ($GelenCinsiyet!="")){
        if($GelenSifre != $GelenSifreTekrar){
            yonlendir("index.php?SK=57");
        }else{
            if($GelenSifre == "KullaniciSifresi"){
                $SifreDegistirmeDurumu = 0;
            }else{
                $SifreDegistirmeDurumu = 1;
            }

            if($KullaniciEmailAdresi != $GelenEmailAdresi){
                $KontrolSorgusu = $veritabani->prepare("SELECT * FROM uyeler WHERE EmailAdresi = ? ");
                $KontrolSorgusu->execute([$GelenEmailAdresi]);
                $KontrolSayisi = $KontrolSorgusu->rowCount();
                if($KontrolSayisi>0){
                    yonlendir("index.php?SK=55");
                }
            }

        if($SifreDegistirmeDurumu == 1){
            $KullaniciGuncellemeSorgusu = $veritabani->prepare("UPDATE uyeler SET EmailAdresi =?, Sifre =?, IsimSoyisim=?, TelefonNumarasi=?,Cinsiyet=? WHERE id=? LIMIT  1");
            $KullaniciGuncellemeSorgusu->execute([$GelenEmailAdresi,$md5Sifrele,$GelenisimSoyisim,$GelenTelefonNumarasi,$GelenCinsiyet,$KullaniciID]);
        }else{
            $KullaniciGuncellemeSorgusu = $veritabani->prepare("UPDATE uyeler SET EmailAdresi =?, IsimSoyisim=?, TelefonNumarasi=?,Cinsiyet=? WHERE id=? LIMIT  1");
            $KullaniciGuncellemeSorgusu->execute([$GelenEmailAdresi,$GelenisimSoyisim,$GelenTelefonNumarasi,$GelenCinsiyet,$KullaniciID]);
        }
            $GuncellemeKayitSayisi = $KullaniciGuncellemeSorgusu->rowCount();
            if($GuncellemeKayitSayisi>0){
                $_SESSION["Kullanici"] = $GelenEmailAdresi;
                header("Location:index.php?SK=53");
                exit();
            }else{
                yonlendir("index.php?SK=54");
            }
        }
    }else{
        yonlendir("index.php?SK=56");
    }

}else{
    yonlendir("index.php");
}

