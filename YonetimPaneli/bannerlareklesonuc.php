<?php
global $veritabani;
if(isset($_SESSION["Yonetici"])){
    if(isset($_POST["BannerAlani"])){
        $GelenBannerAlani = Guvenlik($_POST["BannerAlani"]);
    }else{
        $GelenBannerAlani =  "";
    }

    if(isset($_POST["BannerAdi"])){
        $GelenBannerAdi = Guvenlik($_POST["BannerAdi"]);
    }else{
        $GelenBannerAdi =  "";
    }

    $GelenBannerResmi = $_FILES["BannerResmi"];

    if(($GelenBannerAlani != "") && ($GelenBannerAdi != "") && ($GelenBannerResmi["name"] != "") && ($GelenBannerResmi["type"] != "") && ($GelenBannerResmi["size"]>0) && ($GelenBannerResmi["error"] == 0) && ($GelenBannerResmi["tmp_name"] != "")){


        $ResimIcinDosyaAdiOlustur = ResimIcinDosyaAdiOlustur();
        $GelenResimUzantisiKontrol = substr($GelenBannerResmi["name"],-4);
        if($GelenResimUzantisiKontrol == "jpeg"){
            $GelenResimUzantisiKontrol = ".".$GelenResimUzantisiKontrol;
        }

        $ResimIcinYeniDosyaAdi = $ResimIcinDosyaAdiOlustur.$GelenResimUzantisiKontrol;

        $BannerEklemeSorgusu =$veritabani->prepare("INSERT INTO bannerlar(BannerAlani, BannerAdi, BannerResmi) values (?,?,?)");
        $BannerEklemeSorgusu->execute([$GelenBannerAlani,$GelenBannerAdi,$ResimIcinYeniDosyaAdi]);
        $BannerEklemeSayisi = $BannerEklemeSorgusu->rowCount();

        if($BannerEklemeSayisi>0){
            if($GelenBannerAlani == "Ana Sayfa"){
                $Genislik = 1065;
                $Yukseklik = 186;
            }elseif($GelenBannerAlani == "Menu Altı"){
                $Genislik = 250;
                $Yukseklik = 500;
            }elseif($GelenBannerAlani == "Urun Detay"){
                $Genislik = 350;
                $Yukseklik = 350;
            }

            $BannerResmiYukle = new upload($GelenBannerResmi,"tr-TR");
            if($BannerResmiYukle->uploaded){
                $BannerResmiYukle->mime_magic_check = false;
                $BannerResmiYukle->allowed = array("image/*");
                $BannerResmiYukle->file_new_name_body = $ResimIcinDosyaAdiOlustur;
                $BannerResmiYukle->file_overwrite = true;
                $BannerResmiYukle->image_quality = 100;
                $BannerResmiYukle->image_background_color = "#FFF";
                $BannerResmiYukle->image_resize = true;
                $BannerResmiYukle->image_ratio = true;
                $BannerResmiYukle->image_x = $Genislik;
                $BannerResmiYukle->image_y = $Yukseklik;
                $BannerResmiYukle->process(VerotIcinResimKlasorYoluBanner());

                if($BannerResmiYukle->processed){
                    $BannerResmiYukle->clean();
                    yonlendir("index.php?SKD=0&SKI=36");
                }else{
                    yonlendir("index.php?SKD=0&SKI=37");
                }
            }else{
                echo "Üzgünüm Resim uploaded edilemedi";
            }


        }
    }else{
        yonlendir("index.php?SKD=0&SKI=25");
    }
}
?>
