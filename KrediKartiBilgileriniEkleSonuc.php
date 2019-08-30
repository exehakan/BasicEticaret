<?php
global $KullaniciID;
global $veritabani;

if(isset($_SESSION["Kullanici"])){
    if((isset($_POST["KrediKartiSahibininBilgileri"]))){
        $GelenKrediKartiSahibininBilgileri = Guvenlik($_POST["KrediKartiSahibininBilgileri"]);
    }else{
        $GelenKrediKartiSahibininBilgileri = "";
    }

    if((isset($_POST["KrediKartiNumarasi"]))){
        $GelenKrediKartiNumarasi = Guvenlik(SayiliIcerikleriFilitrele($_POST["KrediKartiNumarasi"]));
    }else{
        $GelenKrediKartiNumarasi = "";
    }

    if((isset($_POST["SonKullanmaTarihiAY"]))){
        $GelenSonKullanmaTarihiAY = Guvenlik($_POST["SonKullanmaTarihiAY"]);
    }else{
        $GelenSonKullanmaTarihiAY = "";
    }

    if(isset($_POST["SonKullanmaTarihiYil"])){
        $GelenSonKullanmaTarihiYil = Guvenlik($_POST["SonKullanmaTarihiYil"]);
    }else{
        $GelenSonKullanmaTarihiYil = "";
    }

    if(isset($_POST["KrediKartiTuru"])){
        $GelenKrediKartiTuru    =   Guvenlik($_POST["KrediKartiTuru"]);
    }else{
        $GelenKrediKartiTuru    =   "";
    }

    if(isset($_POST["KrediKartiGuvenlikKodu"])){
        $GelenKrediKartiGuvenlikKodu    = Guvenlik($_POST["KrediKartiGuvenlikKodu"]);
    }else{
        $GelenKrediKartiGuvenlikKodu    = "";
    }

    if(($GelenKrediKartiSahibininBilgileri != "") and ($GelenKrediKartiNumarasi != "") and ($GelenSonKullanmaTarihiAY != "") and ($GelenSonKullanmaTarihiYil != "") and ($GelenKrediKartiTuru != "") and ($GelenKrediKartiGuvenlikKodu != "")){
        $KrediKartiBilgileriniEkle = $veritabani->prepare("INSERT INTO kullanicininkredikartibilgileri(
        UyeID, KrediKartiNumarasi, KrediKartiSahibi, SonKullanmaTarihiAY, SonKullanmaTarihiYil, KartTuru, GuvenlikKodu) values (?,?,?,?,?,?,?)");
        $KrediKartiBilgileriniEkle->execute([
            $KullaniciID,
            $GelenKrediKartiNumarasi,
            $GelenKrediKartiSahibininBilgileri,
            $GelenSonKullanmaTarihiAY,
            $GelenSonKullanmaTarihiYil,
            $GelenKrediKartiTuru,
            $GelenKrediKartiGuvenlikKodu
        ]);

        $KrediKartiBilgileriniEkleSayisi = $KrediKartiBilgileriniEkle->rowCount();
        if($KrediKartiBilgileriniEkleSayisi>0){
            yonlendir("index.php?SK=106");
        }

    }else{
       yonlendir("index.php?SK=107");
    }
}else{
    yonlendir("index.php?SK=107");
}