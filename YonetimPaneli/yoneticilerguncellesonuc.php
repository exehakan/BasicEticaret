<?php
global $veritabani;
if(isset($_SESSION["Yonetici"])){
    if(isset($_GET["ID"])){
        $GelenID = Guvenlik(SayiliIcerikleriFilitrele($_GET["ID"]));
    }else {
        $GelenID = "";
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

    if(($GelenID != "") && ($GelenisimSoyisim != "") && ($GelenEmailAdresi != "") && ($GelenTelefonNumarasi != "")){
        $YoneticiSifreSorgusu = $veritabani->prepare("SELECT * FROM yoneticiler WHERE  id = ? LIMIT 1");
        $YoneticiSifreSorgusu->execute([$GelenID]);
        $YoneticiSifreSorgusuSayisi = $YoneticiSifreSorgusu->rowCount();
        $YoneticiSifreSorgusuKaydi = $YoneticiSifreSorgusu->fetch(PDO::FETCH_ASSOC);

        if($YoneticiSifreSorgusuSayisi>0){
            $YoneticininSifresi = $YoneticiSifreSorgusuKaydi["Sifre"];
            if($GelenSifre == ""){
                $YoneticiIcinKaydedilecekSifre = $YoneticininSifresi;
            }else{
                $YoneticiIcinKaydedilecekSifre = md5($GelenSifre);
            }

            $YoneticiGuncelle = $veritabani->prepare("UPDATE yoneticiler SET isimSoyisim = ?, Sifre = ?, EmailAdresi = ?, TelefonNumrasi = ? WHERE id = ? LIMIT 1");
            $YoneticiGuncelle->execute([$GelenisimSoyisim,$YoneticiIcinKaydedilecekSifre,$GelenEmailAdresi,$GelenTelefonNumarasi,$GelenID]);
            $YoneticiGuncelleSayisi = $YoneticiGuncelle->rowCount();
            if($YoneticiGuncelleSayisi>0){
                yonlendir("index.php?SKD=0&SKI=77");
            }else{
                echo "Eğer Bir değişiklik yapmicaksaniz lütfen sistemi yormak için uğraşmayiniz";
            }
        }else{
            yonlendir("index.php?SKD=0&SKI=78");
        }
    }else{
        yonlendir("index.php?SKD=0&SKI=78");
    }
}else{
    yonlendir("index.php?SKD=1");
}
?>