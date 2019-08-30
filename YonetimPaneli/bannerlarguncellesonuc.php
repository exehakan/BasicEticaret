<?php
global $veritabani;
if(isset($_SESSION["Yonetici"])){
    if(isset($_GET["ID"])){
        $GelenBannerID = Guvenlik($_GET["ID"]);
    }else{
        $GelenBannerID = "";
    }

    if(isset($_POST["BannerAlanAdi"])){
        $GelenBannerAlanAdi = Guvenlik($_POST["BannerAlanAdi"]);
    }else{
        $GelenBannerAlanAdi = "";
    }

    $GelenBannerResmi = $_FILES["BannerResmi"];

    if(($GelenBannerID != "") && ($GelenBannerAlanAdi != "")){


        $KargoGuncellemeSorgusu = $veritabani->prepare("UPDATE bannerlar SET BannerAlani = ? WHERE id = ? LIMIT 1");
        $KargoGuncellemeSorgusu->execute([$GelenBannerAlanAdi,$GelenBannerID]);
        $KargoGuncellemeSorgusuSayisi = $KargoGuncellemeSorgusu->rowCount();

        if(($GelenBannerResmi["name"] != "") && ($GelenBannerResmi["error"] == 0) && ($GelenBannerResmi["type"] != "") && ($GelenBannerResmi["tmp_name"] != "") && ($GelenBannerResmi["size"]>0)){

            $KargoResmiSorgusu = $veritabani->prepare("SELECT * FROM bannerlar WHERE  id = ? LIMIT 1");
            $KargoResmiSorgusu->execute([$GelenBannerID]);
            $KargoResmiSorgusuSayisi = $KargoResmiSorgusu->rowCount();
            $KargoResmiSorgusuKaydi = $KargoResmiSorgusu->fetch(PDO::FETCH_ASSOC);

            $SilinecekDosyaYolu = "../Resimler/Banner/".$KargoResmiSorgusuKaydi["BannerResmi"];
            unlink($SilinecekDosyaYolu);

            $ResimIcinDosyaAdi = ResimIcinDosyaAdiOlustur();
            $GelenResimUzantisi = substr($GelenBannerResmi["name"],-4);
            if($GelenResimUzantisi == "jpeg"){
                $GelenResimUzantisi = ".".$GelenResimUzantisi;
            }

            $ResminTamUzantiliHazirHali = $ResimIcinDosyaAdi;

            $KargoResminiGuncelle = new upload($GelenBannerResmi,"tr-TR");
            if($KargoResminiGuncelle->uploaded) {
                $KargoResminiGuncelle->mime_magic_check = false;
                $KargoResminiGuncelle->allowed = array("image/*");
                $KargoResminiGuncelle->file_new_name_body = $ResminTamUzantiliHazirHali;
                $KargoResminiGuncelle->file_overwrite = true;
                $KargoResminiGuncelle->image_quality = 100;
                $KargoResminiGuncelle->image_background_color = "#FFF";
                $KargoResminiGuncelle->image_resize = true;
                $KargoResminiGuncelle->image_ratio = true;
                $KargoResminiGuncelle->image_y = 30;
                $KargoResminiGuncelle->process(VerotIcinResimKlasorYoluBanner());

                if ($KargoResminiGuncelle->processed) {

                    $BannerlariGuncelle = $veritabani->prepare("UPDATE bannerlar SET BannerResmi = ? WHERE  id = ? LIMIT 1");
                    $BannerlariGuncelle->execute([$ResminTamUzantiliHazirHali.$GelenResimUzantisi,$GelenBannerID]);
                    $BannerlariGuncelleSayisi = $BannerlariGuncelle->rowCount();

                    if($BannerlariGuncelleSayisi>0){
                        $KargoResminiGuncelle->clean();
                        yonlendir("index.php?SKD=0&SKI=43");
                    }else{
                        echo "Kargo Firmalarinin Logo Tablosunun Guncelleyemedik";
                    }
                } else {
                    yonlendir("index.php?SKD=0&SKI=44");
                }
            }
        }else{
            echo "Bir hata meydana geldi verot sinifinda";
        }

    }else{
        yonlendir("index.php?SKD=0&SKI=28");
    }

}


?>