<?php
global $veritabani;
global $KullaniciID;
global $KullanicininBakiyesi;
global $ZamanDamgasi;
global $IPAdresi;


if(isset($_SESSION["Kullanici"])){
        if(isset($_POST["KullanicininHesapBakiyesi"])){
            $GelenKullanicininHesapBakiyesi  =   Guvenlik($_POST["KullanicininHesapBakiyesi"]);
        }else{
            $GelenKullanicininHesapBakiyesi  = "";
        }

        if(isset($_POST["KullanicicininOdeyecegiTutar"])){
            $GelenKullanicicininOdeyecegiTutar  =   Guvenlik($_POST["KullanicicininOdeyecegiTutar"]);
        }else{
            $GelenKullanicicininOdeyecegiTutar  = "";
        }

        if(isset($_POST["KrediKartiNumarasi"])){
            $GelenKrediKartiNumarasi  =   Guvenlik($_POST["KrediKartiNumarasi"]);
        }else{
            $GelenKrediKartiNumarasi  = "";
        }

        if(isset($_POST["SonKullanmaTarihiAY"])){
            $GelenSonKullanmaTarihiAY  =   Guvenlik($_POST["SonKullanmaTarihiAY"]);
        }else{
            $GelenSonKullanmaTarihiAY  = "";
        }

        if(isset($_POST["SonKullanmaTarihiYil"])){
            $GelenSonKullanmaTarihiYil  =   Guvenlik($_POST["SonKullanmaTarihiYil"]);
        }else{
            $GelenSonKullanmaTarihiYil  = "";
        }

        if(isset($_POST["KrediKartiTuru"])){
            $GelenKrediKartiTuru  =   Guvenlik($_POST["KrediKartiTuru"]);
        }else{
            $GelenKrediKartiTuru  = "";
        }

        if(isset($_POST["KrediKartiGuvenlikKodu"])){
            $GelenKrediKartiGuvenlikKodu  =   Guvenlik($_POST["KrediKartiGuvenlikKodu"]);
        }else{
            $GelenKrediKartiGuvenlikKodu  = "";
        }

        if(isset($_POST["SepettekiUrununUrunIDsi"])){
            $GelenSepettekiUrununUrunIDsi = Guvenlik($_POST["SepettekiUrununUrunIDsi"]);
        }else{
            $GelenSepettekiUrununUrunIDsi= "";
        }

        $GelenBilgileriIsle = explode(",",$GelenSepettekiUrununUrunIDsi);
        foreach ($GelenBilgileriIsle as $kayitlar){
            if(($GelenKullanicininHesapBakiyesi != "") and ($GelenKullanicicininOdeyecegiTutar != "") and ($GelenKrediKartiNumarasi != "") and ($GelenSonKullanmaTarihiAY != "") and ($GelenSonKullanmaTarihiYil != "") and ($GelenKrediKartiTuru != "") and ($GelenKullanicininHesapBakiyesi != "") and ($GelenKrediKartiGuvenlikKodu != "") and ($GelenSepettekiUrununUrunIDsi != "")){

                $KullanicinBilgileriniDogrulamaSorgusu = $veritabani->prepare("SELECT * FROM kullanicininkredikartibilgileri WHERE UyeID = ? LIMIT 1");
                $KullanicinBilgileriniDogrulamaSorgusu->execute([$KullaniciID]);
                $KullanicininIslemSayisi = $KullanicinBilgileriniDogrulamaSorgusu->rowcount();
                $KullanicininKayitlari = $KullanicinBilgileriniDogrulamaSorgusu->fetch(PDO::FETCH_ASSOC);
                if($KullanicininIslemSayisi>0){
                    if(($KullanicininKayitlari["KrediKartiNumarasi"] == $GelenKrediKartiNumarasi) and($KullanicininKayitlari["SonKullanmaTarihiAY"] == $GelenSonKullanmaTarihiAY) and($KullanicininKayitlari["SonKullanmaTarihiYil"] == $GelenSonKullanmaTarihiYil) and($KullanicininKayitlari["KartTuru"] == $GelenKrediKartiTuru) and($KullanicininKayitlari["GuvenlikKodu"] == $GelenKrediKartiGuvenlikKodu)){
                        if(isset($_POST["KullanicicininOdeyecegiTutar"]) > $KullanicininBakiyesi){
                            echo "Üzgünüm Kullanicinin Bakiyesi Bu Ürünün Almak İçin Yetersiz ";
                        }else{
                            $UrununToplamFiyati = Guvenlik($_POST["KullanicicininOdeyecegiTutar"]);
                            $HesapBakiyeIslemleri = $veritabani->prepare("UPDATE kullanicininkredikartibilgileri SET KullanicininHesapBakiyesi=KullanicininHesapBakiyesi - ? WHERE UyeID = ? LIMIT 1");
                            $HesapBakiyeIslemleri->execute([$UrununToplamFiyati,$KullaniciID]);
                            $HesapSonuclariSayisi = $HesapBakiyeIslemleri->rowCount();
                            if($HesapSonuclariSayisi>0){
                                $BilgileriKontrolle = $veritabani->prepare("SELECT * FROM sepetim where UyeId = ? AND UrunId = ? LIMIT 1");
                                $BilgileriKontrolle->execute([$KullaniciID,$kayitlar]);
                                $BilgileriKontrolleSayisi = $BilgileriKontrolle->rowCount();
                                $BilgileriKontrolleKayitlari = $BilgileriKontrolle->fetch(PDO::FETCH_ASSOC);
                                if($BilgileriKontrolleSayisi>0){
                                    $SepetIDsi                  = $BilgileriKontrolleKayitlari["id"];
                                    $SepettekiSepetNumarasi     = $BilgileriKontrolleKayitlari["SepetNumarasi"];
                                    $SepettekiUyeId             = $BilgileriKontrolleKayitlari["UyeId"];
                                    $SepettekiUrunId            = $BilgileriKontrolleKayitlari["UrunId"];
                                    $SepettekiAdresId           = $BilgileriKontrolleKayitlari["AdresId"];
                                    $SepettekiVaryantId         = $BilgileriKontrolleKayitlari["VaryantId"];
                                    $SepettekiKargoId           = $BilgileriKontrolleKayitlari["KargoId"];
                                    $SepettekiUrunAdedi         = $BilgileriKontrolleKayitlari["UrunAdedi"];
                                    $GelenodemeTuruSecimi        = $BilgileriKontrolleKayitlari["OdemeSecimi"];
                                    $GelenTaksitSecimi      = $BilgileriKontrolleKayitlari["TaksitSecimi"];

                                    $UrunBilgileriSorgusu = $veritabani->prepare("SELECT * FROM urunler WHERE id = ? LIMIT 1");
                                    $UrunBilgileriSorgusu->execute([$SepettekiUrunId]);
                                    $UrunBilgileriKaydi = $UrunBilgileriSorgusu->fetch(PDO::FETCH_ASSOC);
                                    $UrununTuru            = $UrunBilgileriKaydi["UrunTuru"];
                                    $UrununAdi             = $UrunBilgileriKaydi["UrunAdi"];
                                    $UrununFiyati          = $UrunBilgileriKaydi["UrunFiyati"]; // Fiyati Hesaplanacak ve Toplam fiyati Alinacak
                                    $UrununParaBirimi      = $UrunBilgileriKaydi["ParaBirimi"];
                                    $UrununKdvOrani        = $UrunBilgileriKaydi["KdvOrani"];
                                    $UrununKargoUcreti     = $UrunBilgileriKaydi["KargoUcreti"];
                                    $UrununResmiBir        = $UrunBilgileriKaydi["UrunResmiBir"];
                                    $UrununVaryantBasligi  = $UrunBilgileriKaydi["VaryantBasligi"];

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

                                    $UrunVaryantlari = $veritabani->prepare("SELECT * from urunvaryantlari WHERE  UrunId = ? LIMIT 1");
                                    $UrunVaryantlari->execute([$kayitlar]);
                                    $UrunVaryantlariAl = $UrunVaryantlari->fetch(PDO::FETCH_ASSOC);

                                    $VaryantAdi = $UrunVaryantlariAl["VaryantAdi"];
                                    $ArtıkSepettekileriSil = $veritabani->prepare("DELETE FROM sepetim WHERE UrunId = ? AND UyeId = ? LIMIT 1");
                                    $ArtıkSepettekileriSil->execute([$kayitlar,$KullaniciID]);
                                    $SilinenUrunBasariliIse = $ArtıkSepettekileriSil->rowCount();
                                    if($SilinenUrunBasariliIse>0){

                                        $SilinenUrunleriSiparisOlarakSiparislerimTablosunaEkle = $veritabani->prepare(
                                            "INSERT INTO  siparisler(UyeId,SiparisNumarasi,UrunId,UrunTuru,UrunAdi,UrunFiyati,KdvOrani,UrunAdedi,ToplamUrunFiyati,KargoFirmasiSecimi,KargoUcreti,UrunResmiBir,VaryantBasligi,VaryantSecimi,AdresAdiSoyadi,AdresDetay,AdresTelefon,OdemeSecimi,TaksitSecimi,SiparisTarihi,SiparisIpAdresi) values (?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?)");

                                        $SilinenUrunleriSiparisOlarakSiparislerimTablosunaEkle->execute([$SepettekiUyeId,$SepettekiSepetNumarasi,$SepettekiUrunId,$UrununTuru,$UrununAdi,$UrununFiyatiniHesapla,$UrununKdvOrani,$SepettekiUrunAdedi,$UrununToplamFiyati,$KargonunAdi,$UrununToplamKargoFiyati,$UrununResmiBir,$UrununVaryantBasligi,$VaryantAdi,$AdresAdiSoyadi,$AdresToparla,$AdresTelefonNumarasi,$GelenodemeTuruSecimi,$GelenTaksitSecimi,$ZamanDamgasi,$IPAdresi,]);

                                        $EklenenUrununSayisi  = $SilinenUrunleriSiparisOlarakSiparislerimTablosunaEkle->rowCount();
                                        if($EklenenUrununSayisi>0){
                                            yonlendir("index.php?SK=108");
                                        }

                                    }else{
                                        echo "Silinen ürün başarili değil";
                                    }
                                }else{
                                    echo "üzgünüm sepetteki işlem gerçekleştirilemedi ";
                                }
                            }else{
                                echo "Bir hata";
                            }
                        }
                    }
                }
            }
        }










































    }

?>