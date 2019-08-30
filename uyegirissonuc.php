<?php
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;
require 'Frameworks/PHPMailer/src/Exception.php';
require 'Frameworks/PHPMailer/src/PHPMailer.php';
require 'Frameworks/PHPMailer/src/SMTP.php';

if(isset($_POST["EmailAdresi"])){
    $UyeGirisEmailAdresi = Guvenlik($_POST["EmailAdresi"]);
}else{
    $UyeGirisEmailAdresi = "";
}

if(isset($_POST["Sifre"])){
    $UyeGirisSifre = Guvenlik($_POST["Sifre"]);
}else{
    $UyeGirisSifre = "";
}


$MD5UyeGirisSifre = md5($UyeGirisSifre);



if(($UyeGirisEmailAdresi !="") and ($UyeGirisSifre!="")){
    $UyeGirisKontrol = $veritabani->prepare("SELECT * FROM uyeler WHERE EmailAdresi=? AND Sifre=?");
    $UyeGirisKontrol->execute([$UyeGirisEmailAdresi,$MD5UyeGirisSifre]);
    $EtkilenenKayitlar = $UyeGirisKontrol->rowCount();
    $KullaniciKayitlari = $UyeGirisKontrol->fetch(PDO::FETCH_ASSOC);
    if($EtkilenenKayitlar>0){
        if($KullaniciKayitlari["Durumu"] == 1){
            $_SESSION["Kullanici"] = $UyeGirisEmailAdresi;
            if($_SESSION["Kullanici"] == $UyeGirisEmailAdresi){
                yonlendir("index.php?SK=50");
            }else{
                yonlendir("index.php?SK=33");
            }
        }else{
            //MAil Ayarlari için Postaya Gidicek içeriklerin ayar kısımlari
            $GelenMailHakkindaBilgiler = "Merhaba Sayin ".$KullaniciKayitlari["IsimSoyisim"]. " <br/> Lütfen Aktivasyon Kodunu Doğrula! ";
            $GelenMailHakkindaBilgiler .= "<a href='".$SiteLinki."/aktivasyon.php?AktivasyonKodu=".$KullaniciKayitlari["AktivasyonKodu"]."&Email=".$KullaniciKayitlari["EmailAdresi"]."'>Buraya Tıklayiniz</a>";
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
                $MailGonder->addAddress(DonusumleriGeriDondur($KullaniciKayitlari["EmailAdresi"]), DonusumleriGeriDondur($KullaniciKayitlari["IsimSoyisim"]));     // Add a recipient
                $MailGonder->addReplyTo(DonusumleriGeriDondur($GelenEmailAdresi), DonusumleriGeriDondur($SiteAdi));
                // İcerik
                $MailGonder->isHTML(true);                                  // Set email format to HTML
                $MailGonder->Subject = DonusumleriGeriDondur($SiteAdi) . "Üyelik Aktivasyonu";
                $MailGonder->msgHTML($GelenMailHakkindaBilgiler);
                $MailGonder->send();
                yonlendir("index.php?SK=24");
            } catch (Exception $e) {
                echo "Message could not be sent. Mailer Error: {$MailGonder->ErrorInfo}";
                yonlendir("index.php?SK=33");
            }
        }
    }else{
        yonlendir("index.php?SK=34");
    }
}else{
    yonlendir("index.php?SK=33");
}






