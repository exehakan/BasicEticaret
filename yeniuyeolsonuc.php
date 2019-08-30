<?php
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;
require 'Frameworks/PHPMailer/src/Exception.php';
require 'Frameworks/PHPMailer/src/PHPMailer.php';
require 'Frameworks/PHPMailer/src/SMTP.php';


if(isset($_POST["EmailAdresi"])){
    $GelenEmailAdresi = Guvenlik($_POST["EmailAdresi"]);
}else{
    $Gelen  = "";
}
if(isset($_POST["Sifre"])){
    $GelenSifre = Guvenlik($_POST["Sifre"]);
}else{
    $Gelen  = "";
}
if(isset($_POST["SifreTekrar"])){
    $GelenSifreTekrar = Guvenlik($_POST["SifreTekrar"]);
}else{
    $Gelen  = "";
}
if(isset($_POST["TelefonNumarasi"])){
    $GelenTelefonNumarasi = Guvenlik($_POST["TelefonNumarasi"]);
}else{
    $Gelen  = "";
}
if(isset($_POST["Cinsiyet"])){
    $GelenCinsiyet = Guvenlik($_POST["Cinsiyet"]);
}else{
    $Gelen  = "";
}
if(isset($_POST["isimSoyisim"])){
    $GelenisimSoyisim = Guvenlik($_POST["isimSoyisim"]);
}else{
    $Gelen  = "";
}
if(isset($_POST["Sozlesme"])){
    $GelenSozlesme = Guvenlik($_POST["Sozlesme"]);
}else{
    $Gelen  = "";
}

$AktivasyonKKodlari = AktivasyonKoduUret();
$SifreyiMD5Yap = md5($GelenSifre);

if(($GelenEmailAdresi != "") and ($GelenSifre != "") and ($GelenTelefonNumarasi != "") and ($GelenCinsiyet != "") and ($GelenisimSoyisim != "") and ($GelenSozlesme != "") and ($GelenSifreTekrar != "")){
    if($GelenSozlesme == 0){
        yonlendir("index.php?SK=29");
    }else{
        if($GelenSifre != $GelenSifreTekrar){
            yonlendir("index.php?SK=28");
        }else{
            $KontrolSorgusu = $veritabani->prepare("SELECT * FROM uyeler WHERE EmailAdresi = ?");
            $KontrolSorgusu->execute([$GelenEmailAdresi]);
            $KontrolSorguSayisi = $KontrolSorgusu->rowCount();
            if($KontrolSorguSayisi>0){
                yonlendir("index.php?SK=27");
            }else{
                $UyeEklemeSorgusu = $veritabani->prepare("INSERT INTO uyeler (EmailAdresi,Sifre,IsimSoyisim,TelefonNumarasi,Cinsiyet,Durumu,KayitTarihi,KayitIpAdresi,AktivasyonKodu) values(?,?,?,?,?,?,?,?,?)");
                $UyeEklemeSorgusu->execute([$GelenEmailAdresi,$SifreyiMD5Yap,$GelenisimSoyisim,$GelenTelefonNumarasi,$GelenCinsiyet,0,$TarihSaat,$IPAdresi,$AktivasyonKKodlari]);
                $KullaniciSayisi = $UyeEklemeSorgusu->rowCount();
                if($KullaniciSayisi>0){
                    //MAil Ayarlari için Postaya Gidicek içeriklerin ayar kısımlari
                    $GelenMailHakkindaBilgiler = "Merhaba Sayin ".$GelenisimSoyisim . " <br/> Sitemize yapmış olduğunuz üyelik kaydini Tamamlamak için ";
                    $GelenMailHakkindaBilgiler .= "<a href='".$SiteLinki."/aktivasyon.php?AktivasyonKodu=".$AktivasyonKKodlari."&Email=".$GelenEmailAdresi."'>Buraya Tıklayiniz</a>";
                    $MailGonder = new PHPMailer(true);
                    try {
                        //Sunucu Ayarlari
                        $MailGonder->SMTPDebug = 0;                                       // HATA CIKTILAMASİ 0'SA CIKTILAMAYİ KAPATİR.
                        $MailGonder->isSMTP();                                            // Set mailer to use SMTP
                        $MailGonder->Host       = DonusumleriGeriDondur($SiteEmailHostAdresi);  // Specify main and backup SMTP servers
                        $MailGonder->SMTPAuth   = true;                                   // Enable SMTP authentication
                        $MailGonder->CharSet = "UTF-8";
                        $MailGonder->Username   = DonusumleriGeriDondur($SiteEmailAdresi);                     // SMTP username
                        $MailGonder->Password   = DonusumleriGeriDondur($SiteEmailSifresi);                               // SMTP password
                        $MailGonder->SMTPSecure = 'tls';                                  // Enable TLS encryption, `ssl` also accepted
                        $MailGonder->Port       = 587;                                    // TCP port to connect to
                        $MailGonder->SMTPOptions = array(
                            "ssl"=> array(
                                "verify_peer"=>false, // Doğrulama
                                "verify_peer_name"=>false, // Doğrulama Adi
                                "allow_self_signed"=>true // Doğrulama İmzasi
                            )
                        );
                        //Alicilar
                        $MailGonder->setFrom(DonusumleriGeriDondur($GelenEmailAdresi), DonusumleriGeriDondur($SiteAdi));
                        $MailGonder->addAddress(DonusumleriGeriDondur($GelenEmailAdresi), DonusumleriGeriDondur($GelenisimSoyisim));     // Add a recipient
                        $MailGonder->addReplyTo(DonusumleriGeriDondur($GelenEmailAdresi), DonusumleriGeriDondur($SiteAdi));
                        // İcerik
                        $MailGonder->isHTML(true);                                  // Set email format to HTML
                        $MailGonder->Subject = DonusumleriGeriDondur($SiteAdi) . "Üyelik Aktivasyonu";
                        $MailGonder->msgHTML($GelenMailHakkindaBilgiler);
                        $MailGonder->send();
                        yonlendir("index.php?SK=18");
                    } catch (Exception $e) {
                        echo "Message could not be sent. Mailer Error: {$MailGonder->ErrorInfo}";
                        yonlendir("index.php?SK=19");
                    }
                }else{
                    yonlendir("index.php?SK=25");
                }
            }
        }
    }
}else{
    yonlendir("index.php?SK=26");
}
?>