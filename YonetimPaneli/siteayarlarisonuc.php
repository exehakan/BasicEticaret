<?php
global $veritabani;
if(isset($_SESSION["Yonetici"])){

    if(isset($_POST["SiteAdi"])){
        $GelenSiteAdi = Guvenlik($_POST["SiteAdi"]);
    }else{
        $GelenSiteAdi = "";
    }

    if(isset($_POST["SiteTitle"])){
        $GelenSiteTitle = Guvenlik($_POST["SiteTitle"]);
    }else{
        $GelenSiteTitle = "";
    }


    if(isset($_POST["SiteDescription"])){
        $GelenSiteDescription = Guvenlik($_POST["SiteDescription"]);
    }else{
        $GelenSiteDescription = "";
    }


    if(isset($_POST["SiteKeywords"])){
        $GelenSiteKeywords = Guvenlik($_POST["SiteKeywords"]);
    }else{
        $GelenSiteKeywords = "";
    }


    if(isset($_POST["SiteLinki"])){
        $GelenSiteLinki = Guvenlik($_POST["SiteLinki"]);
    }else{
        $GelenSiteLinki = "";
    }



    if(isset($_POST["SiteEmailAdresi"])){
        $GelenSiteEmailAdresi = Guvenlik($_POST["SiteEmailAdresi"]);
    }else{
        $GelenSiteEmailAdresi = "";
    }

    if(isset($_POST["copyrightMetni"])){
        $GelenCopyrightMetni = Guvenlik($_POST["copyrightMetni"]);
    }else{
        $GelenCopyrightMetni = "";
    }


    if(isset($_POST["LinkedInLinki"])){
        $GelenLinkedInLinki = Guvenlik($_POST["LinkedInLinki"]);
    }else{
        $GelenLinkedInLinki = "";
    }


    if(isset($_POST["TwitterLinki"])){
        $GelenTwitterLinki = Guvenlik($_POST["TwitterLinki"]);
    }else{
        $GelenTwitterLinki = "";
    }


    if(isset($_POST["FacebookLinki"])){
        $GelenFacebookLinki = Guvenlik($_POST["FacebookLinki"]);
    }else{
        $GelenFacebookLinki = "";
    }

    if(isset($_POST["SiteEmailHostAdresi"])){
        $GelenSiteEmailHostAdresi = Guvenlik($_POST["SiteEmailHostAdresi"]);
    }else{
        $GelenSiteEmailHostAdresi = "";
    }

    if(isset($_POST["SiteEmailSifresi"])){
        $GelenSiteEmailSifresi = Guvenlik($_POST["SiteEmailSifresi"]);
    }else{
        $GelenSiteEmailSifresi = "";
    }

    if(isset($_POST["InstagramLinki"])){
        $GelenInstagramLinki = Guvenlik($_POST["InstagramLinki"]);
    }else{
        $GelenInstagramLinki = "";
    }

    if(isset($_POST["YoutubeLinki"])){
        $GelenYoutubeLinki = Guvenlik($_POST["YoutubeLinki"]);
    }else{
        $GelenYoutubeLinki = "";
    }

    if(isset($_POST["DolarKuru"])){
        $GelenDolarKuru = Guvenlik($_POST["DolarKuru"]);
    }else{
        $GelenDolarKuru = "";
    }


    if(isset($_POST["EuroKuru"])){
        $GelenEuroKuru = Guvenlik($_POST["EuroKuru"]);
    }else{
        $GelenEuroKuru = "";
    }

    if(isset($_POST["UcretsizKargoBaraji"])){
        $GelenUcretsizKargoBaraji = Guvenlik($_POST["UcretsizKargoBaraji"]);
    }else{
        $GelenUcretsizKargoBaraji = "";
    }

    if(isset($_POST["SanalPosClientId"])){
        $GelenSanalPosClientId = Guvenlik($_POST["SanalPosClientId"]);
    }else{
        $GelenSanalPosClientId = "";
    }

    if(isset($_POST["SanalPosStoreKey"])){
        $GelenSanalPosStoreKey = Guvenlik($_POST["SanalPosStoreKey"]);
    }else{
        $GelenSanalPosStoreKey = "";
    }

    if(isset($_POST["SanalPosAPIAdi"])){
        $GelenSanalPosAPIAdi = Guvenlik($_POST["SanalPosAPIAdi"]);
    }else{
        $GelenSanalPosAPIAdi = "";
    }

    if(isset($_POST["SanalPosAPISifresi"])){
        $GelenSanalPosAPISifresi = Guvenlik($_POST["SanalPosAPISifresi"]);
    }else{
        $GelenSanalPosAPISifresi = "";
    }

    $GelenSiteLogosu = $_FILES["SiteLogosu"];

    if(($GelenSiteAdi !="" ) and ($GelenSiteTitle!="") and ($GelenSiteDescription !="") and ($GelenSiteKeywords != "") and ($GelenCopyrightMetni != "") and ($GelenSiteLinki != "") and ($GelenSiteEmailAdresi!="") and ($GelenSiteEmailSifresi !="") and ($GelenFacebookLinki != "") and ($GelenTwitterLinki != "") and ($GelenLinkedInLinki !="") and ($GelenInstagramLinki != "") and ($GelenYoutubeLinki != "") and ($GelenSiteEmailHostAdresi!="") and ($GelenDolarKuru != "") and ($GelenEuroKuru != "") and ($GelenUcretsizKargoBaraji != "") and ($GelenSanalPosClientId != "") and ($GelenSanalPosStoreKey!="") and ($GelenSanalPosAPIAdi!="") and ($GelenSanalPosAPISifresi!="") ){
            // Koşul İşlemleri
            $AyarlariGuncelle = $veritabani->prepare("UPDATE ayarlar SET 
                SiteAdi             = ?,
                SiteBaslik          = ?,
                SiteAciklama        = ?,
                SiteAnahtarlari     = ?,
                SiteCopyrightMetni  = ?,
                SiteLogosu          = ?,
                SiteLinki           = ?,
                SiteEmailAdresi     = ?,
                SiteEmailSifresi    = ?,
                SosyalLinkFacebook  = ?,
                SosyalLinkTwitter   = ?,
                SosyalLinkLinkedin  = ?,
                SosyalLinkInstagram = ?,
                SosyalLinkYoutube   = ?,
                SiteEmailHostAdresi = ?,
                DolarKuru           = ?,
                EuroKuru            = ?,
                UcretsizKargoBaraji = ?,
                ClientID            = ?,
                StoreKey            = ?,
                ApiKullanicisi      = ?,
                ApiSifresi          = ? 
             LIMIT  1");


        $AyarlariGuncelle->execute([
            $GelenSiteAdi,
            $GelenSiteTitle,
            $GelenSiteDescription,
            $GelenSiteKeywords,
            $GelenCopyrightMetni,
            "Logo.png",
            $GelenSiteLinki,
            $GelenSiteEmailAdresi,
            $GelenSiteEmailSifresi,
            $GelenFacebookLinki,
            $GelenTwitterLinki,
            $GelenLinkedInLinki,
            $GelenInstagramLinki,
            $GelenYoutubeLinki,
            $GelenSiteEmailHostAdresi,
            $GelenDolarKuru,
            $GelenEuroKuru,
            $GelenUcretsizKargoBaraji,
            $GelenSanalPosClientId,
            $GelenSanalPosStoreKey,
            $GelenSanalPosAPIAdi,
            $GelenSanalPosAPISifresi
        ]);


            if(($GelenSiteLogosu["name"] != "") and ($GelenSiteLogosu["type"] != "") and ($GelenSiteLogosu["tmp_name"] != "") and ($GelenSiteLogosu["error"] == 0) and ($GelenSiteLogosu["size"]>0)){
                // Verot Sinifinin Kullanalim

                $SiteLogosunuYukle = new upload($GelenSiteLogosu,"tr-TR");
                //uploaded : yüklendiyse veya yüklenebiliyorsa.
                if($SiteLogosunuYukle->uploaded){
                    $SiteLogosunuYukle->mime_magic_check        =   true;
                    $SiteLogosunuYukle->allowed                 =   array("image/*"); // Hangi Türdeki Resim dosyalarina izin verilsin
                    $SiteLogosunuYukle->file_new_name_body      =   "Logo";
                    $SiteLogosunuYukle->file_overwrite          =   true;       //  Dosyanin üstünemi yazssin
                    $SiteLogosunuYukle->image_convert           =   "png";      //  Resmin Hangi resim formatina/uzantisina dönüştürüleceğini belirtir.
                    $SiteLogosunuYukle->image_quality           =   100;        //  Resmin Kalitesini Düzenler
                    $SiteLogosunuYukle->image_background_color  =   null;       //  Resmin Boyutlandirmasi
                    $SiteLogosunuYukle->image_resize            =   true;
                    $SiteLogosunuYukle->image_y                 =   35;         //Resmin Yükseklik Değeri
                    $SiteLogosunuYukle->image_x                 =   192;       //Resmin Genişlik Değeri
                   // Process İşle Özel işlem uygula veya artık bunlari yaptin bu işlemi sınuçlandir gibi anlamlara gelir
                    $SiteLogosunuYukle->process(VerotIcinResimKlasorYolu());
                    if($SiteLogosunuYukle->processed){
                        $SiteLogosunuYukle->clean();
                        yonlendir("index.php?SKD=0&SKI=3");
                    }else{
                        yonlendir("index.php?SKD=0&SKI=4");
                    }
                }else{
                    echo "Resim Yüklenemedi";
                }
            }else{
                $e->HTMLYazdir("<h2>Logo Dosyasi Haricindeki Bütün Değerler Güncellendi!</h2>");
            }

    }else{
        echo "Gelen Boş değer var";

    }

}else{
   yonlendir("index.php");
}
?>
