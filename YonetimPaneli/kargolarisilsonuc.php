<?php
global $veritabani;
if(isset($_SESSION["Yonetici"])){
    if(isset($_GET["ID"])){
        $GelenID = Guvenlik(SayiliIcerikleriFilitrele($_GET["ID"]));
    }else{
        $GelenID = "";
    }


    if($GelenID != ""){
        $KargoSorgusu = $veritabani->prepare("SELECT * FROM kargofirmalari WHERE id = ? LIMIT 1");
        $KargoSorgusu->execute([$GelenID]);
        $KargoKaydi = $KargoSorgusu->fetch(PDO::FETCH_ASSOC);

        $SilinecekDosyaYolu = "../Resimler/".$KargoKaydi["KargoFirmasininLogosu"];

        $KargoFirmasiniSil = $veritabani->prepare("DELETE FROM kargofirmalari WHERE id = ? LIMIT 1");
        $KargoFirmasiniSil->execute([$GelenID]);
        $KargoFirmasiniSilSayisi = $KargoFirmasiniSil->rowCount();

        if($KargoFirmasiniSilSayisi>0){
            unlink($SilinecekDosyaYolu);
            yonlendir("index.php?SKD=0&SKI=21"); # Silme başarili ise kargo sayfasina gönderelim
        }else{
            yonlendir("index.php?SKD=0&SKI=32");
        }
    }else{
        yonlendir("index.php?SKD=0&SKI=32");
    }

}


?>