<?php
try{
    $veritabani = new PDO("mysql:host=localhost;dbname=exehakan;charset=UTF8;","root","");
}catch (PDOException $hata){
    echo "Bağlanti Hatasi<br/>";
    echo $hata->getMessage();
}
$AyarlarSorgusu = $veritabani->prepare("SELECT * FROM ayarlar LIMIT 1");
$AyarlarSorgusu->execute();
$AyarlarSayisi = $AyarlarSorgusu->rowCount();
$Ayarlar = $AyarlarSorgusu->fetch(PDO::FETCH_ASSOC);
if($AyarlarSayisi>0){
    $SiteAdi                = $Ayarlar["SiteAdi"];
    $SiteBaslik             = $Ayarlar["SiteBaslik"];
    $SiteAciklama           = $Ayarlar["SiteAciklama"];
    $SiteAnahtarlari        = $Ayarlar["SiteAnahtarlari"];
    $SiteCopyrightMetni     = $Ayarlar["SiteCopyrightMetni"];
    $SiteLogosu             = $Ayarlar["SiteLogosu"];
    $SiteLinki              = $Ayarlar["SiteLinki"];
    $SiteEmailAdresi        = $Ayarlar["SiteEmailAdresi"];
    $SiteEmailSifresi       = $Ayarlar["SiteEmailSifresi"];
    $SiteEmailHostAdresi    = $Ayarlar["SiteEmailHostAdresi"];
    $SosyalLinkFacebook     = $Ayarlar["SosyalLinkFacebook"];
    $SosyalLinkTwitter      = $Ayarlar["SosyalLinkTwitter"];
    $SosyalLinkLinkedin     = $Ayarlar["SosyalLinkLinkedin"];
    $SosyalLinkInstagram    = $Ayarlar["SosyalLinkInstagram"];
    $SosyalLinkYoutube      = $Ayarlar["SosyalLinkYoutube"];
    $DolarKuru              = $Ayarlar["DolarKuru"];
    $EuroKuru               = $Ayarlar["EuroKuru"];
    $UcretsizKargoBaraji    = $Ayarlar["UcretsizKargoBaraji"];
    $ClientID               = $Ayarlar["ClientID"];
    $StoreKey               = $Ayarlar["StoreKey"];
    $ApiKullanicisi         = $Ayarlar["ApiKullanicisi"];
    $ApiSifresi             = $Ayarlar["ApiSifresi"];
}else{
    echo "Veri tabani sorgu esnasinda bir hata meydana geldi!";
    die();
}


$MetinlerSorgusu = $veritabani->prepare("SELECT * FROM sozlesmelervemetinler LIMIT 1");
$MetinlerSorgusu->execute();
$MetinlerSorgusuSayisi = $MetinlerSorgusu->rowCount();
$MetinDegerleri = $MetinlerSorgusu->fetch(PDO::FETCH_ASSOC);

if($MetinlerSorgusuSayisi>0){
    $HakkimizdaMetni                = $MetinDegerleri["HakkimizdaMetni"];
    $UyelikSozlesmesiMetni          = $MetinDegerleri["UyelikSozlesmesiMetni"];
    $KullanimKosullariMetni         = $MetinDegerleri["KullanimKosullariMetni"];
    $GizlilikSozlesmesiMetni        = $MetinDegerleri["GizlilikSozlesmesiMetni"];
    $MesafeliSatisSozlesmesiMetni   = $MetinDegerleri["MesafeliSatisSozlesmesiMetni"];
    $TeslimatMetni                  = $MetinDegerleri["TeslimatMetni"];
    $IptalIadeDegisimMetni          = $MetinDegerleri["IptalIadeDegisimMetni"];
}else{
    echo "Metin sorgularini alirken bir hata oluştu";
    die();
}

//Kullanici Session işlemleri

//BU KISIM İLERLEYEN ZAMANLARDA EĞİTİMLERDE DUZENLENECEK NORMALDE YONETİCİLER ADİNDA BİR TABLO VAR FAKAT BASLANGIÇTA EĞİTİMDE BU SEKİLDE YAZİLİP ATLANDİ İLERLEYEN ZAMANLARDA ÇÖZÜLECEKTİR.

if(isset($_SESSION["Yonetici"])){
    $Yonetici = $veritabani->prepare("SELECT * FROM yoneticiler where KullaniciAdi = ? LIMIT 1");
    $Yonetici->execute([$_SESSION["Yonetici"]]);
    $YoneticiSayisi = $Yonetici->rowCount();
    $YoneticiKaydi = $Yonetici->fetch(PDO::FETCH_ASSOC);
    if($YoneticiSayisi>0){
        $YoneticiID                 = $YoneticiKaydi["id"];
        $YoneticiKullaniciAdi       = $YoneticiKaydi["KullaniciAdi"];
        $YoneticiSifre              = $YoneticiKaydi["Sifre"];
        $YoneticiisimSoyisim        = $YoneticiKaydi["isimSoyisim"];
        $YoneticiEmailAdresi        = $YoneticiKaydi["EmailAdresi"];
        $YoneticiTelefonNumrasi     = $YoneticiKaydi["TelefonNumrasi"];
    }else{
        unset($_SESSION["Yonetici"]);
        session_destroy();
    }
}






if(isset($_SESSION["Kullanici"])){
    $KullaniciSorgusu = $veritabani->prepare("SELECT * FROM uyeler WHERE EmailAdresi = ? LIMIT  1");
    $KullaniciSorgusu->execute([$_SESSION["Kullanici"]]);
    $KullaniciSorguSayi = $KullaniciSorgusu->rowCount();
    $KullaniciKayitlari = $KullaniciSorgusu->fetch(PDO::FETCH_ASSOC);
    if($KullaniciSorguSayi > 0 ){
        $KullaniciID                =  $KullaniciKayitlari["id"];
        $KullaniciEmailAdresi       =  $KullaniciKayitlari["EmailAdresi"];
        $KullaniciSifre             =  $KullaniciKayitlari["Sifre"];
        $KullaniciIsimSoyisim       =  $KullaniciKayitlari["IsimSoyisim"];
        $KullaniciTelefonNumarasi   =  $KullaniciKayitlari["TelefonNumarasi"];
        $KullaniciCinsiyet          =  $KullaniciKayitlari["Cinsiyet"];
        $KullaniciDurumu            =  $KullaniciKayitlari["Durumu"];
        $KullaniciKayitTarihi       =  $KullaniciKayitlari["KayitTarihi"];
        $KullaniciKayitIpAdresi     =  $KullaniciKayitlari["KayitIpAdresi"];
        $KullaniciAktivasyonKodu    =  $KullaniciKayitlari["AktivasyonKodu"];

    }else{
        die();
    }
}else{
}


if(isset($_SESSION["Kullanici"])){
    $KullanicininBakiyeBilgisi = $veritabani->prepare("SELECT * FROM kullanicininkredikartibilgileri  WHERE UyeID = ? LIMIT 1");
    $KullanicininBakiyeBilgisi->execute([$KullaniciID]);
    $KullanicininBakiyeSorgusuSayisi = $KullanicininBakiyeBilgisi->rowCount();
    $KullanicininTabloKayitlari = $KullanicininBakiyeBilgisi->fetch(PDO::FETCH_ASSOC);
    if($KullanicininBakiyeSorgusuSayisi>0){
        $KullanicininBakiyesi                   = $KullanicininTabloKayitlari["KullanicininHesapBakiyesi"];
        $KullanicicinBakiyesiBicimlendirilmis   = number_format($KullanicininBakiyesi,2,",",".");
    }
}else{
    //Eğer kullanici session set edilmemis ise yani kullanici girisi yok ise,
    //Sende burada die komutunu kullanır isen doğal olarak seni sayfadan aticaktir.
    //Ve index.php sayfasina dahi giriş yapamassin.
}


function UyelikAktivasyonDurumKontrolu($GelenParametre){
    if($GelenParametre == 1){
        echo "Aktivasyon Onayli";
    }else{
        echo "Aktivasyon Onaysiz";
    }
}

?>