<?php
global $veritabani;
if(isset($_SESSION["Yonetici"])){
   if(isset($_POST["HakkimizdaMetni"])){
       $GelenHakkimizdaMetni = Guvenlik($_POST["HakkimizdaMetni"]);
   }else{
       $GelenHakkimizdaMetni = "";
   }

   if(isset($_POST["UyelikSozlesmesiMetni"])){
       $GelenUyelikSozlesmesiMetni = Guvenlik($_POST["UyelikSozlesmesiMetni"]);
   }else{
       $GelenUyelikSozlesmesiMetni = "";
   }

   if(isset($_POST["KullanimKosullariMetni"])){
       $GelenKullanimKosullariMetni = Guvenlik($_POST["KullanimKosullariMetni"]);
   }else{
       $GelenKullanimKosullariMetni = "";
   }

   if(isset($_POST["GizlilikSozlesmesiMetni"])){
       $GelenGizlilikSozlesmesiMetni = Guvenlik($_POST["GizlilikSozlesmesiMetni"]);
   }else{
       $GelenGizlilikSozlesmesiMetni = "";
   }

    if(isset($_POST["MesafeliSatisSozlesmesiMetni"])){
        $GelenMesafeliSatisSozlesmesiMetni = Guvenlik($_POST["MesafeliSatisSozlesmesiMetni"]);
    }else{
        $GelenMesafeliSatisSozlesmesiMetni = "";
    }

    if(isset($_POST["TeslimatMetni"])){
        $GelenTeslimatMetni = Guvenlik($_POST["TeslimatMetni"]);
    }else{
        $GelenTeslimatMetni = "";
    }

    if(isset($_POST["IptalIadeDegisimMetni"])){
        $GelenIptalIadeDegisimMetni = Guvenlik($_POST["IptalIadeDegisimMetni"]);
    }else{
        $GelenIptalIadeDegisimMetni = "";
    }


    if(($GelenHakkimizdaMetni != "") and ($GelenUyelikSozlesmesiMetni != "") and ($GelenKullanimKosullariMetni != "") and ($GelenGizlilikSozlesmesiMetni != "") and ($GelenMesafeliSatisSozlesmesiMetni != "") and ($GelenTeslimatMetni != "") and ($GelenIptalIadeDegisimMetni != "")){
        $MetinleriGuncelle = $veritabani->prepare("UPDATE sozlesmelervemetinler SET 
         HakkimizdaMetni = ?,
         UyelikSozlesmesiMetni = ?,
         KullanimKosullariMetni = ?,
         GizlilikSozlesmesiMetni = ?,
         MesafeliSatisSozlesmesiMetni = ?,
         TeslimatMetni = ?,
         IptalIadeDegisimMetni = ?
         ");
        $MetinleriGuncelle->execute([
            $GelenHakkimizdaMetni,
            $GelenUyelikSozlesmesiMetni,
            $GelenKullanimKosullariMetni,
            $GelenGizlilikSozlesmesiMetni,
            $GelenMesafeliSatisSozlesmesiMetni,
            $GelenTeslimatMetni,
            $GelenIptalIadeDegisimMetni,
        ]);

        $MetinleriGuncelleSayisi = $MetinleriGuncelle->rowCount();
        if($MetinleriGuncelleSayisi>0){
            yonlendir("index.php?SKD=0&SKI=8");
        }else{
            yonlendir("index.php?SKD=0&SKI=7");
        }
    }else{
        yonlendir("index.php?SKD=0&SKI=7");
    }

}else{
    yonlendir("index.php?SKD=0&SKI=");
}


?>


