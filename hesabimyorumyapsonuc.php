<?php
if(isset($_SESSION["Kullanici"])){
    if(isset($_GET["UrunID"])){
        $GelenUrunID = Guvenlik($_GET["UrunID"]);
    }else{
        $GelenUrunID = "";
    }

    if(isset($_POST["Puan"])){
        $GelenPuan = Guvenlik($_POST["Puan"]);
    }else{
        $GelenPuan = "";
    }

    if(isset($_POST["Yorum"])){
        $GelenYorum = Guvenlik($_POST["Yorum"]);
    }else{
        $GelenYorum = "";
    }

    if(($GelenUrunID != "") && ($GelenPuan != "") && ($GelenYorum != "")){
        $urunTablosuSorguKontrolu = $veritabani->prepare("SELECT * FROM urunler WHERE id = ? LIMIT 1");
        $urunTablosuSorguKontrolu->execute([$GelenUrunID]);
        $EtkilenenSutunSayisi = $urunTablosuSorguKontrolu->rowCount();
        if($EtkilenenSutunSayisi>0){
            $YorumSorgusu = $veritabani->prepare("INSERT INTO yorumlar(UrunId, UyeId, Puan, YorumMetini, YorumTarihi, YorumIPAdresi)
            values(?,?,?,?,?,?)");
            $YorumSorgusu->execute([$GelenUrunID,$KullaniciID,$GelenPuan,$GelenYorum,$ZamanDamgasi,$IPAdresi]);
            $Etiklenen = $YorumSorgusu->rowCount();
            if($Etiklenen>0){
                $UrunGuncellemeSorgusu = $veritabani->prepare("UPDATE urunler SET YorumSayisi = YorumSayisi+1, ToplamYorumPuani=ToplamYorumPuani + ? WHERE id = ? LIMIT 1");
                $UrunGuncellemeSorgusu->execute([$GelenPuan,$GelenUrunID]);
                $EtkilenenGuncelleme = $UrunGuncellemeSorgusu->rowCount();
                if($EtkilenenGuncelleme>0){
                   yonlendir("index.php?SK=77");
                }
            }else{
                yonlendir("index.php?SK=78");
            }
        }else{
            yonlendir("index.php?SK=78");
        }

    }else{
        yonlendir("index.php?SK=79");
    }

}else{
    yonlendir("index.php");
}
?>
