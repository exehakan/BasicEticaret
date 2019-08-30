<?php
global $veritabani;
if(isset($_SESSION["Yonetici"])){
    if(isset($_POST["SoruBasligi"])){
        $GelenSoruBasligi = Guvenlik($_POST["SoruBasligi"]);
    }else{
        $GelenSoruBasligi = "";
    }

    if(isset($_POST["BaslikCevabi"])){
        $GelenBaslikCevabi = Guvenlik($_POST["BaslikCevabi"]);
    }else{
        $GelenBaslikCevabi = "";
    }

    if(($GelenSoruBasligi !="") && ($GelenBaslikCevabi!="")){

        $YeniKayitEkle = $veritabani->prepare("INSERT INTO sorular(soru, cevap) values (?,?)");
        $YeniKayitEkle->execute([$GelenSoruBasligi,$GelenBaslikCevabi]);
        $YeniKayitEkleSayisi = $YeniKayitEkle->rowCount();
        if($YeniKayitEkleSayisi){
            yonlendir("index.php?SKD=0&SKI=48");
        }else{
            yonlendir("index.php?SKD=0&SKI=49");
        }


    }else{
        yonlendir("index.php?SKD=0&SKI=49");
    }


}

?>