<?php
global $veritabani;
if(isset($_SESSION["Yonetici"])){
    if(isset($_POST["BankaAdi"])){
        $GelenBankaAdi = Guvenlik($_POST["BankaAdi"]);
    }else{
        $GelenBankaAdi = "";
    }

    if(isset($_POST["konumSehir"])){
        $GelenkonumSehir = Guvenlik($_POST["konumSehir"]);
    }else{
        $GelenkonumSehir = "";
    }

    if(isset($_POST["KonumUlke"])){
        $GelenKonumUlke = Guvenlik($_POST["KonumUlke"]);
    }else{
        $GelenKonumUlke = "";
    }

    if(isset($_POST["SubeAdi"])){
        $GelenSubeAdi = Guvenlik($_POST["SubeAdi"]);
    }else{
        $GelenSubeAdi = "";
    }

    if(isset($_POST["SubeKodu"])){
        $GelenSubeKodu = Guvenlik($_POST["SubeKodu"]);
    }else{
        $GelenSubeKodu = "";
    }

    if(isset($_POST["HesapSahibi"])){
        $GelenHesapSahibi = Guvenlik($_POST["HesapSahibi"]);
    }else{
        $GelenHesapSahibi = "";
    }

    if(isset($_POST["HesapNumarasi"])){
        $GelenHesapNumarasi = Guvenlik(SayiliIcerikleriFilitrele($_POST["HesapNumarasi"]));
    }else{
        $GelenHesapNumarasi = "";
    }

    if(isset($_POST["IbanNumarasi"])){
        $GelenIbanNumarasi = Guvenlik($_POST["IbanNumarasi"]);
    }else{
        $GelenIbanNumarasi = "";
    }

    if(isset($_POST["ParaBirimi"])){
        $GelenParaBirimi = Guvenlik($_POST["IbanNumarasi"]);
    }else{
        $GelenParaBirimi = "";
    }


    $GelenBankaLogosu = $_FILES["BankaLogosu"];
    if(($GelenBankaLogosu["name"] != "") and ($GelenBankaLogosu["type"] != "") and ($GelenBankaLogosu["tmp_name"] != "") and ($GelenBankaLogosu["error"] == 0) and ($GelenBankaLogosu["size"]>0) and ($GelenIbanNumarasi !="") and ($GelenHesapNumarasi !="") and ($GelenHesapSahibi !="") and ($GelenSubeKodu !="") and ($GelenSubeAdi !="") and ($GelenKonumUlke !="") and ($GelenkonumSehir !="")   and ($GelenBankaAdi !="") ){
        $ResimIcinDosyaninAdi = ResimIcinDosyaAdiOlustur();
        $GelenResimUzantisi = substr($GelenBankaLogosu["name"],-4);
        if($GelenResimUzantisi == "jpeg"){
            $GelenResimUzantisi = ".".$GelenResimUzantisi;
        }
        $ResimYeniDosyaAdi = $ResimIcinDosyaninAdi.$GelenResimUzantisi;
        $HesapEklemeSorgusu = $veritabani->prepare("INSERT INTO bankahesaplarimiz(
          BankaAdi, 
          konumSehir, 
          KonumUlke, 
          SubeAdi, 
          SubeKodu, 
          HesapSahibi, 
          HesapNumarasi, 
          IbanNumarasi, 
          BankaLogosu,
          ParaBirimi
          ) values (?,?,?,?,?,?,?,?,?,?)");
        $HesapEklemeSorgusu->execute([
            $GelenBankaAdi,
            $GelenkonumSehir,
            $GelenKonumUlke,
            $GelenSubeAdi,
            $GelenSubeKodu,
            $GelenHesapSahibi,
            $GelenHesapNumarasi,
            $GelenIbanNumarasi,
            $ResimYeniDosyaAdi,
            $GelenParaBirimi
        ]);
        $HesapEklemeSorgusuSayisi = $HesapEklemeSorgusu->rowCount();
        if($HesapEklemeSorgusuSayisi>0){
            $BankaLogosuYukle	=	new upload($GelenBankaLogosu, "tr-TR");
            if($BankaLogosuYukle->uploaded){
                $BankaLogosuYukle->mime_magic_check			=	true;
                $BankaLogosuYukle->allowed					=	array("image/*");
                $BankaLogosuYukle->file_new_name_body		=	$ResimYeniDosyaAdi;
                $BankaLogosuYukle->file_overwrite			=	true;
                //$BankaLogosuYukle->image_convert				=	"png";
                $BankaLogosuYukle->image_quality				=	100;
                $BankaLogosuYukle->image_background_color	=	"#FFFFFF";
                $BankaLogosuYukle->image_resize				=	true;
                $BankaLogosuYukle->image_ratio				=	true;
                $BankaLogosuYukle->image_y					=	30;
                $BankaLogosuYukle->process(VerotIcinResimKlasorYolu());

                if($BankaLogosuYukle->processed){
                    $BankaLogosuYukle->clean();
                    header("Location:index.php?SKD=0&SKI=12");
                    exit();
                }else{
                    header("Location:index.php?SKD=0&SKI=13");
                    exit();
                }
            }
        }
    }


}else{
    yonlendir("index.php?SKD=1");
}








/*
 * BankaLogosu








 */
?>