<?php
if(isset($_POST["isimSoyisim"])){
    $GelenisimSoyisim       = Guvenlik($_POST["isimSoyisim"]);
}else{
    $GelenisimSoyisim = "";
}

if(isset($_POST["EmailAdresi"])){
    $GelenEmailAdresi       = Guvenlik($_POST["EmailAdresi"]);
}else{
    $GelenEmailAdresi = "";
}

if(isset($_POST["TelefonNumarasi"])){
    $GelenTelefonNumarasi    = Guvenlik($_POST["TelefonNumarasi"]);
}else{
    $GelenTelefonNumarasi = "";
}

if(isset($_POST["BankaSecimi"])){
    $GelenBankaSecimi       = Guvenlik($_POST["BankaSecimi"]);
}else{
    $GelenBankaSecimi = "";
}

if(isset($_POST["Aciklama"])){
    $GelenAciklama          = Guvenlik($_POST["Aciklama"]);
}else{
    $GelenAciklama = "";
}

if(($GelenisimSoyisim != "") and ($GelenEmailAdresi != "") and ($GelenTelefonNumarasi != "") and ($GelenBankaSecimi != "")){
    $HavaleBildirimKaydet = $veritabani->prepare("INSERT INTO havalebildirimleri(BankaId,AdiSoyadi,EmailAdresi,TelefonNumarasi,Aciklama,IslemTarihi,Durum) values (?,?,?,?,?,?,?)");
    $HavaleBildirimKaydet->execute([$GelenBankaSecimi,$GelenisimSoyisim,$GelenEmailAdresi,$GelenTelefonNumarasi,$GelenAciklama,$ZamanDamgasi,0]);
    $HavaleBildirimKaydetSayisi = $HavaleBildirimKaydet->rowCount();
    //$HavaleBildirimKaydetSutunlarinaErisim = $HavaleBildirimKaydet->fetch(PDO::FETCH_ASSOC);
    if($HavaleBildirimKaydetSayisi>0){
        yonlendir("index.php?SK=11");

    }else{
        yonlendir("index.php?SK=12");
    }
}else{
    yonlendir("index.php?SK=13");
}

?>