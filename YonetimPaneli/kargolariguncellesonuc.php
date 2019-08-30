<?php
global $veritabani;
if(isset($_SESSION["Yonetici"])){
    if(isset($_GET["ID"])){
        $GelenKargoID = Guvenlik($_GET["ID"]);
    }else{
        $GelenKargoID = "";
    }

    if(isset($_POST["KargoFirmasininAdi"])){
        $GelenKargoFirmasininAdi = Guvenlik($_POST["KargoFirmasininAdi"]);
    }else{
        $GelenKargoFirmasininAdi = "";
    }

    $GelenKargoFirmasiLogosu = $_FILES["KargoFirmasiLogosu"];

    if(($GelenKargoID != "") && ($GelenKargoFirmasininAdi != "")){


        $KargoGuncellemeSorgusu = $veritabani->prepare("UPDATE kargofirmalari SET KargoFirmasininAdi = ? WHERE id = ? LIMIT 1");
        $KargoGuncellemeSorgusu->execute([$GelenKargoFirmasininAdi,$GelenKargoID]);
        $KargoGuncellemeSorgusuSayisi = $KargoGuncellemeSorgusu->rowCount();

        if(($GelenKargoFirmasiLogosu["name"] != "") && ($GelenKargoFirmasiLogosu["error"] == 0) && ($GelenKargoFirmasiLogosu["type"] != "") && ($GelenKargoFirmasiLogosu["tmp_name"] != "") && ($GelenKargoFirmasiLogosu["size"]>0)){

            $KargoResmiSorgusu = $veritabani->prepare("SELECT * FROM kargofirmalari WHERE  id = ? LIMIT 1");
            $KargoResmiSorgusu->execute([$GelenKargoID]);
            $KargoResmiSorgusuSayisi = $KargoResmiSorgusu->rowCount();
            $KargoResmiSorgusuKaydi = $KargoResmiSorgusu->fetch(PDO::FETCH_ASSOC);

            $SilinecekDosyaYolu = "../Resimler/".$KargoResmiSorgusuKaydi["KargoFirmasininLogosu"];
            unlink($SilinecekDosyaYolu);

            $ResimIcinDosyaAdi = ResimIcinDosyaAdiOlustur();
            $GelenResimUzantisi = substr($GelenKargoFirmasiLogosu["name"],-4);
            if($GelenResimUzantisi == "jpeg"){
                $GelenResimUzantisi = ".".$GelenResimUzantisi;
            }

            $ResminTamUzantiliHazirHali = $ResimIcinDosyaAdi;

            $KargoResminiGuncelle = new upload($GelenKargoFirmasiLogosu,"tr-TR");
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
                $KargoResminiGuncelle->process(VerotIcinResimKlasorYolu());

                if ($KargoResminiGuncelle->processed) {

                    $KargoFirmalariniGuncelle = $veritabani->prepare("UPDATE kargofirmalari SET KargoFirmasininLogosu = ? WHERE  id = ? LIMIT 1");
                    $KargoFirmalariniGuncelle->execute([$ResminTamUzantiliHazirHali.$GelenResimUzantisi,$GelenKargoID]);
                    $KargoFirmalariniGuncelleSayisi = $KargoFirmalariniGuncelle->rowCount();

                    if($KargoFirmalariniGuncelleSayisi>0){
                        $KargoResminiGuncelle->clean();
                        yonlendir("index.php?SKD=0&SKI=29");
                    }else{
                        echo "Kargo Firmalarinin Logo Tablosunun Guncelleyemedik";
                    }
                } else {
                    yonlendir("index.php?SKD=0&SKI=28");
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