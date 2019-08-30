<?php
global $veritabani;
if(isset($_SESSION["Yonetici"])){
    if(isset($_GET["ID"])){
        $GelenID = Guvenlik(SayiliIcerikleriFilitrele($_GET["ID"]));
    }else{
        $GelenID = "";
    }

    if($GelenID != ""){

        $MenuSilmeSorgusu = $veritabani->prepare("DELETE FROM menuler WHERE id = ? LIMIT 1");
        $MenuSilmeSorgusu->execute([$GelenID]);
        $MenuSilmeSorgusuSayisi = $MenuSilmeSorgusu->rowCount();
        if($MenuSilmeSorgusuSayisi>0){
            ///Ürünleri Sil
            $Urunlersorgusu = $veritabani->prepare("SELECT * FROM urunler WHERE MenuId = ? LIMIT 1");
            $Urunlersorgusu->execute([$GelenID]);
            $UrunlersorgusuKontrol = $Urunlersorgusu->rowCount();
            $UrunlersorgusuKaydi = $Urunlersorgusu->fetchAll(PDO::FETCH_ASSOC);
            if($UrunlersorgusuKontrol>0){
                foreach($UrunlersorgusuKaydi as $Kayitlar){
                    $SilinecekUrunIDsi = $Kayitlar["id"];

                    $UrunGuncellemeSorgusu = $veritabani->prepare("UPDATE urunler SET Durumu = ? WHERE  MenuId = ?");
                    $UrunGuncellemeSorgusu->execute([0,$GelenID]);
                    $UrunGuncellemeSorgusuSayisi = $UrunGuncellemeSorgusu->rowCount();

                    $SepetSilmeSorgusu = $veritabani->prepare("DELETE FROM sepetim WHERE UrunId = ? ");
                    $SepetSilmeSorgusu->execute([$SilinecekUrunIDsi]);

                    $FavorilerSilmeSorgusu = $veritabani->prepare("DELETE FROM favoriler WHERE UrunId = ?");
                    $FavorilerSilmeSorgusu->execute([$SilinecekUrunIDsi]);
                }
            }
            yonlendir("index.php?SKD=0&SKI=67");
        }else{
            yonlendir("index.php?SKD=0&SKI=68");
        }

    }else{
        yonlendir("index.php?SKD=0&SKI=67");
    }
}else{
    yonlendir("index.php?SKD=1");
}

?>