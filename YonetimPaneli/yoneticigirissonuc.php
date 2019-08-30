<?php
if(empty($_SESSION["Yonetici"])){
    //Sessiondaki Yönetici Yok ise bizde yönetici giris bilgilerimizi ekleyelim

    if(isset($_POST["YKullanici"])){
        $GelenYoneticiKullanici = Guvenlik($_POST["YKullanici"]);
    }else{
        $GelenYoneticiKullanici = "";
    }

    if(isset($_POST["YSifre"])){
        $GelenYoneticiSifre = Guvenlik($_POST["YSifre"]);
    }else{
        $GelenYoneticiSifre = "";
    }


    $md5YoneticiSifrele = md5($GelenYoneticiSifre);

    if(($GelenYoneticiKullanici !="") && ($GelenYoneticiSifre != "")){
        $KontrolSorgusu  = $veritabani->prepare("SELECT * FROM yoneticiler WHERE KullaniciAdi = ? AND Sifre = ?");
        $KontrolSorgusu->execute([$GelenYoneticiKullanici,$md5YoneticiSifrele]);
        $KontrolSorguSonucSayisi = $KontrolSorgusu->rowCount();
        $KontrolSorgusuKaydi = $KontrolSorgusu->fetch(PDO::FETCH_ASSOC);

        if($KontrolSorguSonucSayisi>0){
            $_SESSION["Yonetici"] = $GelenYoneticiKullanici;
            header("Location:index.php?SKD=0&SKI=0");
        }else{
            yonlendir("index.php?SKD=3");
        }


    }else{
        yonlendir("index.php?SK=3");
    }

}else{
    yonlendir("index.php?SKD=1");
}


?>

