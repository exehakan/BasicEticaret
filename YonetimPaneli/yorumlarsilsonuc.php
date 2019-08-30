<?php
global $veritabani;
if(isset($_SESSION["Yonetici"])){
    if(isset($_GET["ID"])){
        $GelenID = Guvenlik(SayiliIcerikleriFilitrele($_GET["ID"]));
    }else{
        $GelenID = "";
    }

    if($GelenID != ""){
        $YorumlarSorgusu = $veritabani->prepare("SELECT * FROM yorumlar WHERE id = ? LIMIT 1");
        $YorumlarSorgusu->execute([$GelenID]);
        $YorumlarSorgusuSayisi = $YorumlarSorgusu->rowCount();
        $YorumlarSorgusuKaydi = $YorumlarSorgusu->fetch(PDO::FETCH_ASSOC);

        if($YorumlarSorgusuSayisi>0){
            $GuncellenecekUrununIDsi = $YorumlarSorgusuKaydi["UrunId"];
            $GuncellenecekUrununDusulecekYildizPuani = $YorumlarSorgusuKaydi["Puan"];
            //Yorum sil >>>>>>>
            $YorumSilmeSorgusu = $veritabani->prepare("DELETE FROM yorumlar WHERE id = ? LIMIT 1");
            $YorumSilmeSorgusu->execute([$GelenID]);
            $YorumSilinmeSayisi = $YorumSilmeSorgusu->rowCount();

            if($YorumSilinmeSayisi>0){
                $UrunGuncelle = $veritabani->prepare("UPDATE urunler SET YorumSayisi=YorumSayisi-1, ToplamYorumPuani = ToplamYorumPuani - ? WHERE id = ? LIMIT 1");
                $UrunGuncelle->execute([$GuncellenecekUrununDusulecekYildizPuani,$GuncellenecekUrununIDsi]);
                $UrunGuncelleKontrol = $UrunGuncelle->rowCount();
                if($UrunGuncelleKontrol>0){
                    yonlendir("index.php?SKD=0&SKI=92");
                }
            }else{
                yonlendir("index.php?SKD=0&SKI=93");
            }

        }else{
            yonlendir("index.php?SKD=0&SKI=93");
        }

    }else{
        yonlendir("index.php?SKD=0&SKI=93");
    }
}else{
    yonlendir("index.php?SKD=0&SKI=93");
}

?>