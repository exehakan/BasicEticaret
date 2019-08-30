<?php
global $veritabani;
if(isset($_SESSION["Yonetici"])){
    if(isset($_GET["ID"])){
        $GelenID = Guvenlik($_GET["ID"]);
    }else{
        $GelenID = "";
    }
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
    if(($GelenIbanNumarasi !="") and ($GelenHesapNumarasi !="") and ($GelenHesapSahibi !="") and ($GelenSubeKodu !="") and ($GelenSubeAdi !="") and ($GelenKonumUlke !="") and ($GelenkonumSehir !="")   and ($GelenBankaAdi !="") and ($GelenID != "")){

        $HesapGuncellemeSorgusu = $veritabani->prepare("UPDATE bankahesaplarimiz SET BankaAdi = ?,konumSehir = ?,KonumUlke = ?,SubeAdi = ?,SubeKodu = ?,HesapSahibi = ?,HesapNumarasi = ?,IbanNumarasi = ?, ParaBirimi = ? WHERE id = ? LIMIT 1");
        $HesapGuncellemeSorgusu->execute([$GelenBankaAdi,$GelenkonumSehir,$GelenKonumUlke,$GelenSubeAdi,$GelenSubeKodu,$GelenHesapSahibi,$GelenHesapNumarasi,$GelenIbanNumarasi,$GelenParaBirimi,$GelenID]);
        $HesapGuncellemeSorgusuSayisi = $HesapGuncellemeSorgusu->rowCount();

        if(($GelenBankaLogosu["name"] != "") and ($GelenBankaLogosu["type"]!="") and ($GelenBankaLogosu["tmp_name"]!="") and ($GelenBankaLogosu["error"] == 0) and ($GelenBankaLogosu["size"]>0)){
            $BankaResmiSorgusu = $veritabani->prepare("SELECT * FROM bankahesaplarimiz WHERE id = ? LIMIT 1");
            $BankaResmiSorgusu->execute([$GelenID]);
            $BankaResmiKaydi = $BankaResmiSorgusu->fetch(PDO::FETCH_ASSOC);
            $BankaLogosuveYolAdresi = $BankaResmiKaydi["BankaLogosu"];
            $SilinecekDosyaYolu = "../Resimler/".$BankaLogosuveYolAdresi.".png";
            unlink($SilinecekDosyaYolu);

            $ResimAdiOlustur = ResimIcinDosyaAdiOlustur();
            $GelenResminUzantisi = substr($GelenBankaLogosu["name"],-4);
            if($GelenResminUzantisi == "jpeg"){
                $GelenResminUzantisi = ".".$GelenResminUzantisi;
            }

            $ResimIcinYeniDosyaAdi = $ResimAdiOlustur;
            $BankaLogosuYukle = new upload($GelenBankaLogosu,"tr-TR");
            if($BankaLogosuYukle>0){
                $BankaLogosuYukle	=	new upload($GelenBankaLogosu, "tr-TR");
                if($BankaLogosuYukle->uploaded){
                    $BankaLogosuYukle->mime_magic_check			=	true;
                    $BankaLogosuYukle->allowed					=	array("image/*");
                    $BankaLogosuYukle->file_new_name_body		=	$ResimIcinYeniDosyaAdi;
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

                        $BankaHesabiResmiGuncele = $veritabani->prepare("UPDATE bankahesaplarimiz SET BankaLogosu = ? WHERE id = ? LIMIT 1");
                        $BankaHesabiResmiGuncele->execute([$ResimIcinYeniDosyaAdi,$GelenID]);
                        $BankaHesabiResmiGunceleSayisi =$BankaHesabiResmiGuncele->rowCount();

                        if($BankaHesabiResmiGunceleSayisi>0){
                            yonlendir("index.php?SKD=0&SKI=16");
                        }
                    }else{
                        yonlendir("index.php?SKD=0&SKI=17");

                    }
                }
            }

        }else{
            $e->HTMLYazdir("<h2>Üzgünüm Resim Kontrol Hatasi</h2>");
        }
    }else{
        $e->HTMLYazdir("<h2>Üzgünüm Kosul Kontrol Hatasi</h2>");
    }
}else{
    yonlendir("index.php?SKD=1");
}







/*($GelenBankaLogosu["name"] != "") and ($GelenBankaLogosu["type"] != "") and ($GelenBankaLogosu["tmp_name"] != "") and ($GelenBankaLogosu["error"] == 0) and ($GelenBankaLogosu["size"]>0)*/


?>