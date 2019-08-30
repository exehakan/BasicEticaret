<?php
global $veritabani;
    if(isset($_SESSION["Yonetici"])){
        if(isset($_GET["ID"])){
            $GelenID = Guvenlik($_GET["ID"]);
        }else{
            $GelenID = "";
        }



        if($GelenID != ""){
            $BannerSil = $veritabani->prepare("SELECT * FROM bannerlar WHERE id = ? LIMIT  1");
            $BannerSil->execute([$GelenID]);
            $KayitSayisi = $BannerSil->rowCount();
            $BannerKaydi = $BannerSil->fetch(PDO::FETCH_ASSOC);

            $SilinecekDosyaYolu = "../Resimler/Banner/".$BannerKaydi["BannerResmi"];

            if($KayitSayisi>0){
                $BannerlariSilebilirsim = $veritabani->prepare("DELETE FROM bannerlar WHERE id = ? LIMIT 1");
                $BannerlariSilebilirsim->execute([$GelenID]);
                $BannerlariSilebilirsimKontrol = $BannerlariSilebilirsim->rowCount();
                if($BannerlariSilebilirsimKontrol>0){
                    unlink($SilinecekDosyaYolu);
                    yonlendir("index.php?SKD=0&SKI=40");
                }else{
                    yonlendir("index.php?SKD=0&SKI=41");

                }
            }else{
                yonlendir("index.php?SKD=0&SKI=41");
            }
        }else{
            yonlendir("index.php?SKD=0&SKI=41");
        }
    }

?>