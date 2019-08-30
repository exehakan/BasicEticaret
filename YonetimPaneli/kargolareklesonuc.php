<?php
global $veritabani;
if(isset($_SESSION["Yonetici"])){
    if(isset($_POST["KargoFirmasininAdi"])){
        $GelenKargoFirmasininAdi = Guvenlik($_POST["KargoFirmasininAdi"]);
    }else{
        $GelenKargoFirmasininAdi =  "";
    }

    $GelenKargoFirmasiLogosu = $_FILES["KargoFirmasiLogosu"];

    if(($GelenKargoFirmasininAdi != "") && ($GelenKargoFirmasiLogosu["name"] != "") && ($GelenKargoFirmasiLogosu["type"] != "") && ($GelenKargoFirmasiLogosu["size"]>0) && ($GelenKargoFirmasiLogosu["error"] == 0) && ($GelenKargoFirmasiLogosu["tmp_name"] != "")){
        $ResimIcinDosyaAdiOlustur = ResimIcinDosyaAdiOlustur();
        $GelenResimUzantisiKontrol = substr($GelenKargoFirmasiLogosu["name"],-4);
        if($GelenResimUzantisiKontrol == "jpeg"){
            $GelenResimUzantisiKontrol = ".".$GelenResimUzantisiKontrol;
        }


        $ResimIcinYeniDosyaAdi = $ResimIcinDosyaAdiOlustur.$GelenResimUzantisiKontrol;
        $KargoFirmasiEklemeSorgusu =$veritabani->prepare("INSERT INTO kargofirmalari(KargoFirmasininLogosu, KargoFirmasininAdi) values (?,?)");
        $KargoFirmasiEklemeSorgusu->execute([$ResimIcinYeniDosyaAdi,$GelenKargoFirmasininAdi]);
        $KargoSorguSayisi = $KargoFirmasiEklemeSorgusu->rowCount();
        if($KargoSorguSayisi>0){
            $KargoLogosuYukle = new upload($GelenKargoFirmasiLogosu,"tr-TR");
            if($KargoLogosuYukle->uploaded){
                $KargoLogosuYukle->mime_magic_check = false;
                $KargoLogosuYukle->allowed = array("image/*");
                $KargoLogosuYukle->file_new_name_body = $ResimIcinDosyaAdiOlustur;
                $KargoLogosuYukle->file_overwrite = true;
                $KargoLogosuYukle->image_quality = 100;
                $KargoLogosuYukle->image_background_color = "#FFF";
                $KargoLogosuYukle->image_resize = true;
                $KargoLogosuYukle->image_ratio = true;
                $KargoLogosuYukle->image_y = 30;
                $KargoLogosuYukle->process(VerotIcinResimKlasorYolu());

                if($KargoLogosuYukle->processed){
                    $KargoLogosuYukle->clean();
                    yonlendir("index.php?SKD=0&SKI=24");
                }else{
                    yonlendir("index.php?SKD=0&SKI=25");
                }
            }else{
                echo "Üzgünüm Resim uploaded edilemedi";
            }
        }else{
            yonlendir("index.php?SKD=0&SKI=25");
        }
    }else{
        yonlendir("index.php?SKD=0&SKI=25");
    }
}
?>
