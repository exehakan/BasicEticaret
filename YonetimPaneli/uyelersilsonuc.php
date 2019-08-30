<?php
global $veritabani;
if(isset($_SESSION["Yonetici"])){
    if(isset($_GET["ID"])){
        $GelenID = Guvenlik($_GET["ID"]);
    }else{
        $GelenID = "";
    }
    if($GelenID != ""){
        $UyeSilmeSorgusu = $veritabani->prepare("UPDATE uyeler SET SilinmeDurumu = ? WHERE id = ? LIMIT 1");
        $UyeSilmeSorgusu->execute([1,$GelenID]);
        $UyeSilmeSorgusuSayisi = $UyeSilmeSorgusu->rowCount();

        if($UyeSilmeSorgusuSayisi>0){
            $UyeyeAitSepettekiUrunleriSil = $veritabani->prepare("DELETE FROM sepetim WHERE UyeId = ? ");
            $UyeyeAitSepettekiUrunleriSil->execute([$GelenID]);

            $UyeyeAitYorumlariSil = $veritabani->prepare("SELECT * FROM yorumlar WHERE UyeId = ? ");
            $UyeyeAitYorumlariSil->execute([$GelenID]);
            $UyeyeAitYorumlariSilinenSayi = $UyeyeAitYorumlariSil->rowCount();
            $UyeyeAitYorumlariSilKayitlari = $UyeyeAitYorumlariSil->fetchAll(PDO::FETCH_ASSOC);
            if($UyeyeAitYorumlariSilinenSayi>0){
                foreach($UyeyeAitYorumlariSilKayitlari as $Kayitlar){
                    $YorumID = $Kayitlar["id"];
                    $GuncellemeIslemiYapilacakUrunID = $Kayitlar["UrunId"];
                    $GuncellenecekUrununPuanDegeri = $Kayitlar["Puan"];


                    $UrunGuncellemeSorgu = $veritabani->prepare("UPDATE urunler SET YorumSayisi=YorumSayisi-1, ToplamYorumPuani=ToplamYorumPuani - ? WHERE id = ? LIMIT 1");
                    $UrunGuncellemeSorgu->execute([$GuncellenecekUrununPuanDegeri,$GuncellemeIslemiYapilacakUrunID]);
                    $UrunGuncellemeSorguSayisi = $UrunGuncellemeSorgu->rowCount();
                    if($UrunGuncellemeSorguSayisi<1){
                        yonlendir("index.php?SKD=0&SKI=86");
                    }

                    $YorumSilmeSorgusu = $veritabani->prepare("DELETE FROM yorumlar WHERE id = ? LIMIT 1");
                    $YorumSilmeSorgusu->execute([$YorumID]);
                    $YorumSilmeSayisi = $YorumSilmeSorgusu->rowCount();

                    if($YorumSilmeSayisi<1){
                        yonlendir("index.php?SKD=0&SKI=86");
                    }

                }
            }else{
                yonlendir("index.php?SKD=0&SKI=85");
            }

        }else{
            yonlendir("index.php?SKD=0&SKI=86");
        }
    }else{
        yonlendir("index.php?SKD=0&SKI=86");
    }
}else{
    yonlendir("index.php?SKD=1");
}


?>