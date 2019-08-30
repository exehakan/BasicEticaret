<?php
if(isset($_SESSION["Kullanici"])){
    if(isset($_GET["ID"])){
        $GelenID = Guvenlik($_GET["ID"]);
    }else{
        $GelenID = "";
    }


    if($GelenID != ""){
        $FavoriSilmeSorgusu = $veritabani->prepare("DELETE FROM favoriler WHERE id = ? AND UyeId = ? LIMIT 1");
        $FavoriSilmeSorgusu->execute([$GelenID,$KullaniciID]);
        $FavoriSilmeEtkilenen = $FavoriSilmeSorgusu->rowCount();
        if($FavoriSilmeEtkilenen>0){
            yonlendir("index.php?SK=59");
        }else{
            yonlendir("index.php?SK=81");
        }
    }else{
        yonlendir("index.php?SK=81");
    }
}else{
    yonlendir("index.php");
}