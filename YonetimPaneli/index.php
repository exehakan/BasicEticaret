<?php
session_start();
ob_start();
require_once "../Config/ayar.php"; // Veritabani
require_once "../Config/fonksiyonlar.php";
require_once "../Frameworks/Verot/src/class.upload.php";
require_once "../Config/YonetimSayfalariIc.php";
require_once "../Config/YonetimSayfalariDis.php";
require_once "../Config/class.system.php";
global $SiteTitle;
//Sayfalama Islemleri
if(isset($_REQUEST["SKD"])){
    $DisSayfaKoduDegeri = SayiliIcerikleriFilitrele($_REQUEST["SKD"]);
}else{
    $DisSayfaKoduDegeri = 0;
}

if(isset($_REQUEST["SKI"])){
    $IcSayfaKoduDegeri  = SayiliIcerikleriFilitrele($_REQUEST["SKI"]);
}else{
    $IcSayfaKoduDegeri  = 0;
}

if(isset($_REQUEST["SYF"])){
    $Sayfalama = SayiliIcerikleriFilitrele($_REQUEST["SYF"]);
}else{
    $Sayfalama = 1;

}
?>
    <!doctype html>
    <html lang="tr">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
        <meta http-equiv="X-UA-Compatible" content="ie=edge">
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
        <meta http-equiv="Content-Language" content="tr">
        <meta name="robots" content="noindex, nofollow, noarchive">
        <meta name="googlebot" content="noindex, nofollow, noarchive">
        <title><?php echo DonusumleriGeriDondur($SiteBaslik); ?></title>
        <link type="image/png" rel="icon" href="../Resimler/Favicon.png">
        <link type="text/css" rel="stylesheet" href="../Config/stilyonetim.css">
        <script type="text/javascript" src="../Frameworks/jQuery/jquery-3.4.0.min.js"></script>
        <script type="text/javascript" src="../Config/fonksiyonlar.js"></script>
        <link href="https://fonts.googleapis.com/css?family=Open+Sans:400,400i,600,600i,700,700i&display=swap&subset=greek" rel="stylesheet">
        <script src="../Config/simplebar.js" type="text/javascript"></script>
        <link href="../Config/simplebar.css" rel="stylesheet">
        <script src="../Config/CoreFunc/process.js" type="text/javascript"></script>



        <script type="module">import ("../Config/CoreFunc/core.js").then().catch(function(err){
                console.error("Bir hata meydana geldi");
                console.warn("Değer:" + err);
            })</script>

        <script src="../Config/CoreFunc/corefunction.js" type="text/javascript"></script>
    </head>
    <body>
    <?php
        //Empty ile yöneticinin olup olmadiğini kontrol ediyoruz yani empty yönetici sessionu set edilmemisse true döner edilmisse false döner.
        if(empty($_SESSION["Yonetici"])){
            if((!$DisSayfaKoduDegeri) or ($DisSayfaKoduDegeri == "") or ($DisSayfaKoduDegeri == 0) ){
                include($SayfaDis[1]);
            }else{
                include($SayfaDis[$DisSayfaKoduDegeri]);
            }
        }else{
           if((!$DisSayfaKoduDegeri) or ($DisSayfaKoduDegeri == "") or ($DisSayfaKoduDegeri == 0)){
               include($SayfaDis[0]);
           }else{
               include($SayfaDis[$DisSayfaKoduDegeri]);
           }
        }
    ?>

    </body>
    </html>




























<?php
    $veritabani = null;
    ob_end_flush();
?>