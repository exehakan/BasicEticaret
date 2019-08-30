<?php
//require_once "testdb.php";
//require_once "Config/ayar.php";
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;
require 'Frameworks/PHPMailer/src/Exception.php';
require 'Frameworks/PHPMailer/src/PHPMailer.php';
require 'Frameworks/PHPMailer/src/SMTP.php';

if(isset($_POST["EmailAdresi"])){
    $GelenMailAdresi = Guvenlik($_POST["EmailAdresi"]);
}else{
    $GelenMailAdresi = "";
}
if(isset($_POST["TelefonNumarasi"])){
    $GelenTelefonNumarasi = SayiliIcerikleriFilitrele($_POST["TelefonNumarasi"]);
}else{
    $GelenTelefonNumarasi = "";
}

if(($GelenMailAdresi !="") or ($GelenTelefonNumarasi !="")){
       $KontrolSorgusu = $veritabani->prepare("SELECT * FROM uyeler WHERE EmailAdresi=? OR TelefonNumarasi=?");
       $KontrolSorgusu->execute([$GelenMailAdresi,$GelenTelefonNumarasi]);
       $KontrolKayitSayisi = $KontrolSorgusu->rowCount();
       $KontrolKaydi = $KontrolSorgusu->fetch(PDO::FETCH_ASSOC);
        if($KontrolKayitSayisi>0){

        $GelenMailHakkindaBilgiler = "Merhaba Sayin {$KontrolKaydi["IsimSoyisim"]} Şifrenizi Sifirlamak İçin Lütfen <a href='".$SiteLinki."/index.php?SK=43&AktivasyonKodu={$KontrolKaydi['AktivasyonKodu']}&Email={$KontrolKaydi['EmailAdresi']}'>Tıklayiniz</a>";
           //MAil Ayarlari için Postaya Gidicek içeriklerin ayar kısımlari

           $MailGonder = new PHPMailer(true);
           try {
               //Sunucu Ayarlari
               $MailGonder->SMTPDebug = 0;                                              // HATA CIKTILAMASİ 0'SA CIKTILAMAYİ KAPATİR.
               $MailGonder->isSMTP();                                                   // Set mailer to use SMTP
               $MailGonder->Host       = DonusumleriGeriDondur($SiteEmailHostAdresi);   // Specify main and backup SMTP servers
               $MailGonder->SMTPAuth   = true;                                          // Enable SMTP authentication
               $MailGonder->CharSet = "UTF-8";
               $MailGonder->Username   = DonusumleriGeriDondur($SiteEmailAdresi);       // SMTP username
               $MailGonder->Password   = DonusumleriGeriDondur($SiteEmailSifresi);      // SMTP password
               $MailGonder->SMTPSecure = 'tls';                                         // Enable TLS encryption, `ssl` also accepted
               $MailGonder->Port       = 587;                                           // TCP port to connect to
               $MailGonder->SMTPOptions = array(
                   "ssl"=> array(
                       "verify_peer"=>false, // Doğrulama
                       "verify_peer_name"=>false, // Doğrulama Adi
                       "allow_self_signed"=>true // Doğrulama İmzasi
                   )
               );
               //Alicilar
               $MailGonder->setFrom(DonusumleriGeriDondur($GelenMailAdresi), DonusumleriGeriDondur($SiteAdi));
               $MailGonder->addAddress(DonusumleriGeriDondur($KontrolKaydi["EmailAdresi"]), DonusumleriGeriDondur($KontrolKaydi["IsimSoyisim"]));     // Add a recipient
               $MailGonder->addReplyTo(DonusumleriGeriDondur($GelenMailAdresi), DonusumleriGeriDondur($SiteAdi));
               // İcerik
               $MailGonder->isHTML(true);                                  // Set email format to HTML
               $MailGonder->Subject = DonusumleriGeriDondur($SiteAdi) . "Şifre Sifirlama";
               $MailGonder->msgHTML($GelenMailHakkindaBilgiler);
               $MailGonder->send();
               yonlendir("index.php?SK=39");
           } catch (Exception $e) {
               echo "Message could not be sent. Mailer Error: {$MailGonder->ErrorInfo}";
               yonlendir("index.php?SK=40");
           }

       }else{
           yonlendir("index.php?SK=41");
       }
}else{
    yonlendir("index.php?SK=42");
}













