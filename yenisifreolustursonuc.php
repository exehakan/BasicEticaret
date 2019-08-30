<?php

if(isset($_POST["Sifre"])){
    $GelenSifre = Guvenlik($_POST["Sifre"]);
}else{
    $GelenSifre = "";
}

if(isset($_POST["SifreTekrar"])){
    $GelenSifreTekrar = Guvenlik($_POST["SifreTekrar"]);
}else{
    $GelenSifreTekrar = "";
}


//NOT : Formdan veri gönderirken method post olsa dahi action içerisinde yani tarayici çubuğu içerisinde veri gönderdiğimizde örneğin index.php?Email=HakanDemir gibi bu bize $_GET Yöntemiyle gelmektedir.

if(isset($_GET["EmailAdresi"])){
    $GelenEmailAdresi = Guvenlik($_GET["EmailAdresi"]);
}else{
    $GelenEmailAdresi = "Boş";
}
if(isset($_GET["AktivasyonKodu"])){
    $GelenAktivasyonKodu = Guvenlik($_GET["AktivasyonKodu"]);
}else {
    $GelenAktivasyonKodu = "";
}
$md5Sifre = md5($GelenSifre);
$YeniAktivasyonGirisi = AktivasyonKoduUret();
if(($GelenSifre != "") && ($GelenSifreTekrar !="") && ($GelenEmailAdresi !="") && ($GelenAktivasyonKodu !="")){
    if($GelenSifre!=$GelenSifreTekrar){
     yonlendir("index.php?SK=47");
    }else{
        $KontrolSorgusu = $veritabani->prepare("UPDATE uyeler SET Sifre = ? , AktivasyonKodu = ?  WHERE AktivasyonKodu = ? AND EmailAdresi = ? LIMIT 1");
        $KontrolSorgusu->execute([$md5Sifre,$YeniAktivasyonGirisi,$GelenAktivasyonKodu,$GelenEmailAdresi]);
        $SorguSayisi = $KontrolSorgusu->rowCount();
        if($SorguSayisi>0){
            yonlendir("index.php?SK=45");
        }else{
            //yonlendir("index.php?SK=46");
        }
    }
}else{
    yonlendir("index.php?SK=48");
}









