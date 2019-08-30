<?php
global $veritabani;
if(isset($_SESSION["Yonetici"])){
    if(isset($_GET["ID"])){
        $GelenID = Guvenlik($_GET["ID"]);
    }else{
        $GelenID = "";
    }


    if($GelenID != ""){
        $HavaleBildirimleriKontrol = $veritabani->prepare("SELECT * FROM havalebildirimleri WHERE BankaId = ? LIMIT 1");
        $HavaleBildirimleriKontrol->execute([$GelenID]);
        $HavaleBildirimleriKontrolSayisi = $HavaleBildirimleriKontrol->rowCount();

        if($HavaleBildirimleriKontrolSayisi>0){
            yonlendir("index.php?SKD=0&SKI=20");
        }else{
            $BankaHesapKontrolu  = $veritabani->prepare("SELECT * FROM bankahesaplarimiz WHERE  id = ? LIMIT 1");
            $BankaHesapKontrolu->execute([$GelenID]);
            $BankaHesapKontroluSayisi = $BankaHesapKontrolu->rowCount();
            $BankaHesapKontroluKayitlari = $BankaHesapKontrolu->fetch(PDO::FETCH_ASSOC);
            $SilinecekDosyaYoluveAdi = $BankaHesapKontroluKayitlari["BankaLogosu"].".png";

            $HesapSilmeSorgusu = $veritabani->prepare("DELETE FROM bankahesaplarimiz WHERE id = ? LIMIT 1");
            $HesapSilmeSorgusu->execute([$GelenID]);
            $HesapSilmeSorgusuSayisi = $HesapSilmeSorgusu->rowCount();


            if($HesapSilmeSorgusuSayisi>0){
                unlink($SilinecekDosyaYoluveAdi);
                yonlendir("index.php?SKD=0&SKI=19");
            }else{
                yonlendir("index.php?SKD=0&SKI=20");
            }
        }
    }else{
        yonlendir("index.php?SKD=0&SKI=20");
    }

}else{
    yonlendir("index.php?SKD=0");
}

?>