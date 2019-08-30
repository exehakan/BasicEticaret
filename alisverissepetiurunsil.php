<?php
global $KullaniciID;
global $veritabani;

if($e->setEdilmisIseSession("Kullanici")){
    if($e->setEdilmisIseGET("ID")){
        $GelenID = Guvenlik($_GET["ID"]);
        if($GelenID != ""){
            $SilmeIslemiSorgusu = $veritabani->prepare("DELETE FROM sepetim WHERE UyeId = ? AND id = ? LIMIT 1");
            $SilmeIslemiSorgusu->execute([$KullaniciID,$GelenID]);
            $SilmeIslemiSayisi = $SilmeIslemiSorgusu->rowCount();
            if($SilmeIslemiSayisi>0){
                yonlendir($_SERVER["HTTP_REFERER"]);
            }
        }
    }else{
        yonlendir("index.php");
    }
}else{
    yonlendir("index.php");
}

