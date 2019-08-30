<?php
global $KullaniciID;
if($e->setEdilmisIseSession("Kullanici")){
    if($e->setEdilmisse($_GET["ID"])){
        $GelenUrunID = Guvenlik($_GET["ID"]);
    }else{
        $GelenUrunID = "";
    }

    if($GelenUrunID != ""){
        $FavoriKontrolSorgusu = $veritabani->prepare("SELECT * FROM favoriler WHERE UrunId = ? AND UyeId = ? LIMIT 1");
        $FavoriKontrolSorgusu->execute([$GelenUrunID,$KullaniciID]);
        $FavoriKontrolSayisi = $FavoriKontrolSorgusu->rowCount();
        if($FavoriKontrolSayisi>0){
            yonlendir("index.php?SK=89");
        }else{
            $FavoriUrunEkle = $veritabani->prepare("INSERT INTO favoriler(UrunId, UyeId) values(?,?)");
            $FavoriUrunEkle->execute([$GelenUrunID,$KullaniciID]);
            $EklenenFavoriSayisi = $FavoriUrunEkle->rowCount();
            if($EklenenFavoriSayisi>0){
                yonlendir("index.php?SK=87");
            }else{
                yonlendir("index.php?SK=88");
            }
        }
    }



}