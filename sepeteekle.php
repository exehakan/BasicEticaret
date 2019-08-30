<?php
global $veritabani;
global $KullaniciID;
if(isset($_SESSION["Kullanici"])){

    if(isset($_GET["ID"])){
        $GelenID = Guvenlik($_GET["ID"]);
    }else{
        $GelenID = "";
    }

    if(isset($_POST["Varyant"])){
        $GelenVaryantIDsi = Guvenlik($_POST["Varyant"]);
    }else{
        $GelenVaryantIDsi = "";
    }

    if(($GelenID != "") && ($GelenVaryantIDsi != "")) {
        $KullanicininSepetSorgusu = $veritabani->prepare("SELECT * FROM sepetim WHERE UyeId = ? ORDER BY id DESC LIMIT 1");
        $KullanicininSepetSorgusu->execute([$KullaniciID]);
        $SepetSorguSayisi = $KullanicininSepetSorgusu->rowCount();
        if ($SepetSorguSayisi > 0) {

            $UrunSepetKontrolSorgusu = $veritabani->prepare("SELECT * FROM sepetim WHERE UyeId = ? AND UrunId = ? AND VaryantId = ? LIMIT 1");
            $UrunSepetKontrolSorgusu->execute([$KullaniciID,$GelenID,$GelenVaryantIDsi]);
            $UrunSepetKontrolSayisi = $UrunSepetKontrolSorgusu->rowCount();
            $UrunSepetKaydi = $UrunSepetKontrolSorgusu->fetch(PDO::FETCH_ASSOC);

            if($UrunSepetKontrolSayisi>0){
                $UrununIDsi                 = $UrunSepetKaydi["id"];
                $UrununSepettekiMevcutAdedi = $UrunSepetKaydi["UrununAdedi"];
                $UrununYeniAdedi            = $UrununSepettekiMevcutAdedi+1;

                $UrununGuncellemeSorgusu = $veritabani->prepare("UPDATE sepetim SET UrunAdedi = ? WHERE id = ? AND UyeId = ? AND UrunId = ? LIMIT 1");
                $UrununGuncellemeSorgusu->execute([$UrununYeniAdedi,$UrununIDsi,$KullaniciID,$GelenID]);
                $UrunGuncellemeSayisi = $UrununGuncellemeSorgusu->rowCount();
                if($UrunGuncellemeSayisi>0){
                    $e->yazdir("ok");
                    yonlendir("index.php?SK=93");
                }else{
                    yonlendir("index.php?SK=91");
                }
            }else{
                $UrunEklemeSorgusu = $veritabani->prepare("INSERT INTO sepetim (UyeId,UrunId,VaryantId,UrunAdedi) values(?,?,?,?)");
                $UrunEklemeSorgusu->execute([$KullaniciID,$GelenID,$GelenVaryantIDsi,1]);
                $UrunEklemeSorgusuSayisi = $UrunEklemeSorgusu->rowCount();
                $SonIdDegeri = $veritabani->lastInsertId();

                if($UrunEklemeSorgusuSayisi>0){
                    $SiparisNumarasiniGuncelleSorgusu = $veritabani->prepare("UPDATE sepetim SET SepetNumarasi = ? WHERE UyeId = ?");
                    $SiparisNumarasiniGuncelleSorgusu->execute([$SonIdDegeri,$KullaniciID]);
                    $SiparisNumarasiGuncelleSayisi = $SiparisNumarasiniGuncelleSorgusu->rowCount();
                    if($SiparisNumarasiGuncelleSayisi>0){
                        yonlendir("index.php?SK=93");
                    }else{
                        yonlendir("index.php?SK=92");
                    }
                }else{
                    echo "ok";
                }
            }
        }else{
            $UrunEklemeSorgusu = $veritabani->prepare("INSERT INTO sepetim (UyeId,UrunId,VaryantId,UrunAdedi) values(?,?,?,?)");
            $UrunEklemeSorgusu->execute([$KullaniciID,$GelenID,$GelenVaryantIDsi,1]);
            $UrunEklemeSorgusuSayisi = $UrunEklemeSorgusu->rowCount();
            $SonIdDegeri = $veritabani->lastInsertId();
            if($UrunEklemeSorgusuSayisi>0){
                yonlendir("index.php?SK=93");
            }
        }

    }else{
       echo "<h1>Üzgünüm Ürün Varyanti Eksik</h1>";
    }
}else{
    echo "<h2>Lütfen üye girişi yapiniz.</h2>";
}

