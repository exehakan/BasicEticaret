<?php
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;
require 'Frameworks/PHPMailer/src/Exception.php';
require 'Frameworks/PHPMailer/src/PHPMailer.php';
require 'Frameworks/PHPMailer/src/SMTP.php';


if(isset($_POST["isimSoyisim"])){
    $GelenisimSoyisim = Guvenlik($_POST["isimSoyisim"]);
}else{
    $GelenisimSoyisim = "";
}

if(isset($_POST["EmailAdresi"])){
    $GelenEmailAdresi = Guvenlik($_POST["EmailAdresi"]);
}else{
    $GelenEmailAdresi = "";
}
if(isset($_POST["TelefonNumarasi"])){
    $GelenTelefonNumarasi = SayiliIcerikleriFilitrele(Guvenlik($_POST["TelefonNumarasi"]));
}else{
    $GelenTelefonNumarasi = "";
}
if(isset($_POST["Mesaj"])){
    $GelenMesaj = Guvenlik($_POST["Mesaj"]);
}else{
    $GelenMesaj = "";
}


if(($GelenisimSoyisim != "") and ($GelenEmailAdresi != "") and ($GelenTelefonNumarasi != "") and ($GelenMesaj != "")){
    $GelenMailHakkindaBilgiler = "İsim Soyisim:" . $GelenisimSoyisim . "<br/>Email Adresi:" . $GelenEmailAdresi . "<br/>Telefon Numarasi:" . $GelenTelefonNumarasi ."<br/>Mesaj:".$GelenMesaj;


    $MailGonder = new PHPMailer(true);
    $mail = new PHPMailer(true);
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
        $MailGonder->addAddress(DonusumleriGeriDondur($GelenEmailAdresi), DonusumleriGeriDondur($SiteAdi));     // Add a recipient
        $MailGonder->addReplyTo($SiteEmailAdresi,$GelenisimSoyisim);
        // İcerik
        $MailGonder->isHTML(true);                                  // Set email format to HTML
        $MailGonder->Subject = DonusumleriGeriDondur($SiteAdi) . "İletişim Formu Mesaji";
        $MailGonder->msgHTML($GelenMailHakkindaBilgiler);
        $MailGonder->send();
        yonlendir("index.php?SK=18");
    } catch (Exception $e) {
        echo "Message could not be sent. Mailer Error: {$MailGonder->ErrorInfo}";
        yonlendir("index.php?SK=19");
    }


}else{
    yonlendir("index.php?SK=20");
}





?>
