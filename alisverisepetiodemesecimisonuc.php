<?php
global $KullaniciID;
global $EuroKuru;
global $DolarKuru;
global $UcretsizKargoBaraji;
global $veritabani;
global $ZamanDamgasi;
global $IPAdresi;
if(isset($_SESSION["Kullanici"])){

    if(isset($_POST["OdemeTuruSecimi"])){
        $GelenodemeTuruSecimi = Guvenlik($_POST["OdemeTuruSecimi"]);
    }else{
        $GelenodemeTuruSecimi = "";
    }

    if(isset($_POST["TaksitSecimi"])){
        $GelenTaksitSecimi = Guvenlik($_POST["TaksitSecimi"]);
    }else{
        $GelenTaksitSecimi = "";
    }

    if($GelenodemeTuruSecimi!=""){
        if($GelenodemeTuruSecimi == "Banka Havalesi"){
            $AlisverisSepetiSorgusu = $veritabani->prepare("SELECT * FROM sepetim WHERE UyeId");
            $AlisverisSepetiSorgusu->execute([$KullaniciID]);
            $AlisverisSepetiSorgusuSayisi = $AlisverisSepetiSorgusu->rowCount();
            $AlisverisSepetiSorgusuKayitlari = $AlisverisSepetiSorgusu->fetchAll(PDO::FETCH_ASSOC);
            if($AlisverisSepetiSorgusuSayisi>0){
                foreach($AlisverisSepetiSorgusuKayitlari as $SepetSatirlari){
                        $SepetIDsi                  = $SepetSatirlari["id"];
                        $SepettekiSepetNumarasi     = $SepetSatirlari["SepetNumarasi"];
                        $SepettekiUyeId             = $SepetSatirlari["UyeId"];
                        $SepettekiUrunId            = $SepetSatirlari["UrunId"];
                        $SepettekiAdresId           = $SepetSatirlari["AdresId"];
                        $SepettekiVaryantId         = $SepetSatirlari["VaryantId"];
                        $SepettekiKargoId           = $SepetSatirlari["KargoId"];

                        $SepettekiUrunAdedi         = $SepetSatirlari["UrunAdedi"];
                        $SepettekiOdemeSecimi       = $SepetSatirlari["OdemeSecimi"];
                        $SepettekiTaksitSecimi      = $SepetSatirlari["TaksitSecimi"];

                    $UrunBilgileriSorgusu = $veritabani->prepare("SELECT * FROM urunler WHERE id = ? LIMIT 1");
                    $UrunBilgileriSorgusu->execute([$SepettekiUrunId]);
                    $UrunBilgileriKaydi = $UrunBilgileriSorgusu->fetch(PDO::FETCH_ASSOC);
                        $UrununTuru            = $UrunBilgileriKaydi["UrunTuru"];
                        $UrununAdi             = $UrunBilgileriKaydi["UrunAdi"];
                        $UrununFiyati          = $UrunBilgileriKaydi["UrunFiyati"];
                        $UrununParaBirimi      = $UrunBilgileriKaydi["ParaBirimi"];
                        $UrununKdvOrani        = $UrunBilgileriKaydi["KdvOrani"];
                        $UrununKargoUcreti     = $UrunBilgileriKaydi["KargoUcreti"];
                        $UrununResmiBir        = $UrunBilgileriKaydi["UrunResmiBir"];
                        $UrununVaryantBasligi  = $UrunBilgileriKaydi["VaryantBasligi"];


                     $UrununVaryantBilgileriSorgusu = $veritabani->prepare("SELECT * FROM urunvaryantlari WHERE id = ?");
                     $UrununVaryantBilgileriSorgusu->execute([$SepettekiVaryantId]);
                     $VaryantKaydi = $UrununVaryantBilgileriSorgusu->fetch(PDO::FETCH_ASSOC);
                        $VaryantAdi = $VaryantKaydi["VaryantAdi"];



                     $KargoBilgileriSorgusu = $veritabani->prepare("SELECT * FROM kargofirmalari WHERE id = ? LIMIT 1");
                     $KargoBilgileriSorgusu->execute([$SepettekiKargoId]);
                     $KargoBilgileriSorgusuSayisi = $KargoBilgileriSorgusu->rowCount();
                     $KargoBilgileriKaydi = $KargoBilgileriSorgusu->fetch(PDO::FETCH_ASSOC);
                     $KargonunAdi = $KargoBilgileriKaydi["KargoFirmasininAdi"];


                    $AdresilgileriSorgusu = $veritabani->prepare("SELECT * FROM adresler WHERE  id = ? LIMIT 1");
                    $AdresilgileriSorgusu->execute([$SepettekiAdresId]);
                    $AdresiBilgileriSorgusuKaydi = $AdresilgileriSorgusu->fetch(PDO::FETCH_ASSOC);
                        $AdresAdiSoyadi     = $AdresiBilgileriSorgusuKaydi["AdiSoyadi"];
                        $AdresAdres         = $AdresiBilgileriSorgusuKaydi["Adres"];
                        $AdresSehir         = $AdresiBilgileriSorgusuKaydi["Sehir"];
                        $AdresIlce          = $AdresiBilgileriSorgusuKaydi["Ilce"];
                        $AdresToparla       = $AdresAdres. " " . $AdresIlce . " " . $AdresSehir;
                        $AdresTelefonNumarasi = $AdresiBilgileriSorgusuKaydi["TelefonNumarasi"];

                    if ($UrununParaBirimi == "USD") {
                        $UrununFiyatiniHesapla = ($UrununFiyati * $DolarKuru);
                    } elseif ($UrununParaBirimi == "EUR") {
                        $UrununFiyatiniHesapla = ($UrununFiyati * $EuroKuru);
                    } else {
                        $UrununFiyatiniHesapla = $UrununFiyati;
                    }


                    $UrununToplamFiyati = ($UrununFiyatiniHesapla * $SepettekiUrunAdedi);
                    $UrununToplamKargoFiyati = ($UrununKargoUcreti * $SepettekiUrunAdedi);

                    # Siparişin ekleneceği Tablo ve Diğer Kontrol İşlemleri

                    $SiparisEkle = $veritabani->prepare("
                        INSERT INTO siparisler(
                        UyeId,
                        SiparisNumarasi,
                        UrunId,
                        UrunTuru,
                        UrunAdi,
                        UrunFiyati,
                        KdvOrani,
                        UrunAdedi,
                        ToplamUrunFiyati,
                        KargoFirmasiSecimi,
                        KargoUcreti,
                        UrunResmiBir,
                        VaryantBasligi,
                        VaryantSecimi,
                        AdresAdiSoyadi,
                        AdresDetay,
                        AdresTelefon,
                        OdemeSecimi,
                        TaksitSecimi,
                        SiparisTarihi,
                        SiparisIpAdresi    
                        ) VALUES (?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?)
                    ");
                    $SiparisEkle->execute([
                       $SepettekiUyeId,
                       $SepettekiSepetNumarasi,
                       $SepettekiUrunId,
                       $UrununTuru,
                       $UrununAdi,
                       $UrununFiyatiniHesapla,
                       $UrununKdvOrani,
                       $SepettekiUrunAdedi,
                       $UrununToplamFiyati,
                       $KargonunAdi,
                       $UrununToplamKargoFiyati,
                       $UrununResmiBir,
                       $UrununVaryantBasligi,
                       $VaryantAdi,
                       $AdresAdiSoyadi,
                       $AdresToparla,
                       $AdresTelefonNumarasi,
                       $GelenodemeTuruSecimi,
                       $GelenTaksitSecimi,
                       $ZamanDamgasi,
                       $IPAdresi,


                    ]);
                    /*echo "<pre>";
                        print_r([$SepettekiUyeId, $SepettekiSepetNumarasi, $SepettekiUrunId,$UrununTuru, $UrununAdi,$UrununFiyatiniHesapla,$UrununKdvOrani, $SepettekiUrunAdedi, $UrununToplamFiyati, $KargonunAdi,$UrununToplamKargoFiyati, $UrununResmiBir,  $UrununVaryantBasligi,$VaryantAdi,  $AdresAdiSoyadi,  $AdresToparla,$AdresTelefonNumarasi,$GelenodemeTuruSecimi,$ZamanDamgasi,$IPAdresi]);*/

                    $SiparisEklemeKontrol = $SiparisEkle->rowCount();
                    if($SiparisEklemeKontrol>0){
                        //Ürünü Seppeten sil
                        $SepettenSilmeSorgusu  = $veritabani->prepare("DELETE FROM sepetim WHERE id = ? AND UyeId = ? LIMIT 1");
                        $SepettenSilmeSorgusu->execute([$SepetIDsi,$SepettekiUyeId]);
                        $SepettenSilmeSorgusuSayisi = $SepettenSilmeSorgusu->rowCount();
                        if($SepettenSilmeSorgusuSayisi>0){

                        }

                        //Ürün Satildiği için satiş sayisini arttir
                        $UrunSatisiArttirmaSorgusu = $veritabani->prepare("UPDATE urunler set ToplamSatisSayisi=ToplamSatisSayisi + ? WHERE id=?");
                        $UrunSatisiArttirmaSorgusu->execute([$SepettekiUrunAdedi,$SepettekiUrunId]);
                        $UrunSatisiSayisi = $UrunSatisiArttirmaSorgusu->rowCount();
                        if($UrunSatisiSayisi>0){

                        }
                        //Stoklari Güncelleme
                        $StokGuncellemeSorgusu = $veritabani->prepare("UPDATE urunvaryantlari SET StokAdedi=StokAdedi - ? WHERE id = ? LIMIT  1");
                        $StokGuncellemeSorgusu->execute([$SepettekiUrunAdedi,$SepettekiVaryantId]);
                        $StokSayisi = $StokGuncellemeSorgusu->rowCount();
                        if($StokSayisi>0){

                        }
                    }else{
                        header("Location:index.php?SK=101");
                    }
                } // Foreach BİTİŞ



                $KargoFiyatiIcinSiparislerSorgusu = $veritabani->prepare("SELECT SUM(ToplamUrunFiyati) AS ToplamUcret FROM siparisler WHERE UyeId = ? AND SiparisNumarasi = ? ");
                $KargoFiyatiIcinSiparislerSorgusu->execute([$KullaniciID,$SepettekiSepetNumarasi]);
                $KargoFiyatiKaydi = $KargoFiyatiIcinSiparislerSorgusu->fetch(PDO::FETCH_ASSOC);
                $ToplamUcretimiz = $KargoFiyatiKaydi["ToplamUcret"];

                if($ToplamUcretimiz>=$UcretsizKargoBaraji){
                    $SiparisiGuncelle = $veritabani->prepare("UPDATE siparisler SET KargoUcreti = ? WHERE  UyeId = ? AND SiparisNumarasi = ? ");
                    $SiparisiGuncelle->execute([0,$KullaniciID,$SepettekiSepetNumarasi]);
                }

                header("Location:index.php?SK=100");

            }else {

            }
        }else{
            if($GelenTaksitSecimi != ""){

                $SepetiGuncelle = $veritabani->prepare("UPDATE sepetim SET OdemeSecimi = ? , TaksitSecimi = ? WHERE UyeId = ? ");
                $SepetiGuncelle->execute([$GelenodemeTuruSecimi,$GelenTaksitSecimi,$KullaniciID]);
                $SepetKontrol = $SepetiGuncelle->rowCount();
                if($SepetKontrol>0){
                    echo "Başarili";
                    header("Location:index.php?SK=102");
                }else{
                    echo "Başarisiz";
                    header("Location:index.php");
                }
            }else{
                echo "TaksitDeğeri boş";
            }
        }
    }else{
        header("Location:index.php");
    }

}else{
    header("Location:index.php");
}


?>