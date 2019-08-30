<?php
global $veritabani;
global $KullaniciID;
if($e->setEdilmisIseSession("Kullanici")){
    if($e->setEdilmisIseGET("ID")){
        $GelenID = Guvenlik($_GET["ID"]);
        $SepetGuncellemeSorgusu =$veritabani->prepare("UPDATE sepetim SET UrunAdedi=UrunAdedi-1 WHERE id = ? AND UyeId = ? LIMIT 1");
        $SepetGuncellemeSorgusu->execute([$GelenID,$KullaniciID]);
        $GuncellemeSayisi = $SepetGuncellemeSorgusu->rowCount();
        if($GuncellemeSayisi>0){
            yonlendir("index.php?SK=93");
        }


    }
}

?>
<?php
