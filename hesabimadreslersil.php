<?php
if(isset($_SESSION["Kullanici"])){
    if(isset($_GET["ID"])){
       $GelenID = Guvenlik($_GET["ID"]);
    }else{
        $GelenID = "";
    }

    if($GelenID != ""){
        $AdresSilmeSorgusu = $veritabani->prepare("DELETE FROM adresler WHERE id = ? LIMIT 1");
        $AdresSilmeSorgusu->execute([$GelenID]);
        $AdresSilmeSorgusuEtkilenen = $AdresSilmeSorgusu->rowCount();
        if($AdresSilmeSorgusuEtkilenen>0){
            yonlendir("index.php?SK=68");
        }else{
            yonlendir("index.php?SK=69");
        }
    }else{
        yonlendir("index.php?SK=69");
    }


}else{
    yonlendir("index.php");
}