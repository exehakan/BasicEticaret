<?php
global $veritabani;
global $KullaniciID;
global $DolarKuru;
global $EuroKuru;
global $UcretsizKargoBaraji;
if(isset($_SESSION["Kullanici"])) {
    if (isset($_POST["AdresSecimi"])) {
        $GelenAdres = Guvenlik($_POST["AdresSecimi"]);

    } else {
        $GelenAdres = "";
    }
    if (isset($_POST["KargoSecimi"])) {
        $GelenKargoSecimi = Guvenlik($_POST["KargoSecimi"]);
    } else {
        $GelenKargoSecimi = "";
    }

    if (($GelenAdres !="") and ($GelenKargoSecimi !="")) {
        /*
         * Sepet Burada Gelen KardoID ve AdresID'ye göre hangi kullanici girişi yapılmissi o kişiye ait bilgiler ile Güncellenmektedir.
         */
        $SepetiGuncellemeSorgusu = $veritabani->prepare("UPDATE sepetim SET KargoId = ?, AdresId = ? WHERE UyeId = ?");
        $SepetiGuncellemeSorgusu->execute([$GelenKargoSecimi, $GelenAdres, $KullaniciID]);
        $SepetGuncellemeSayisi = $SepetiGuncellemeSorgusu->rowCount();
        if($SepetGuncellemeSayisi>0){
           $BilgileriDogruGuncelle = $veritabani->prepare("SELECT * FROM sepetim WHERE UyeId = ? ");
           $BilgileriDogruGuncelle->execute([$KullaniciID]);
           $BilgilerinSayisi = $BilgileriDogruGuncelle->rowCount();
           $BilgileriAl = $BilgileriDogruGuncelle->fetchAll(PDO::FETCH_ASSOC);
//           if($BilgilerinSayisi>0){
//               $DongudenGelenTablodakiKargoID = [];
//               $DongudenGelenTablodakiAdresID = [];
//               foreach($BilgileriAl as $GuncellencekBilgiSatirlari){
//                  $TablodakiKargoID = $GuncellencekBilgiSatirlari["KargoId"];
//                  $TablodakiAdresID = $GuncellencekBilgiSatirlari["AdresId"];
//                  //Bilgileri Dişaridaki Alana Gönderelim
//                   $DongudenGelenTablodakiKargoID[0] = $TablodakiKargoID;
//                   $DongudenGelenTablodakiAdresID[0] = $TablodakiAdresID;
//              }
//              $GelenTabloDegerleriniTekeDusurKargo = array_unique($DongudenGelenTablodakiKargoID,0);
//              $GelenTabloDegerleriniTekeDusurAdres = array_unique($DongudenGelenTablodakiAdresID,0);
//              //Artık Form'dan gelen değerler ile tablodaki değerler eşit değil ise bir güncelleme bu alan içerisinde gerçekleşecektir.
//              if(($GelenTabloDegerleriniTekeDusurKargo != $GelenKargoSecimi) && ($GelenTabloDegerleriniTekeDusurAdres != $GelenAdres)){
//                  //Kargo ID bilgileri Güncelle
//                  $KargoBilgileriniArtıkGuncelle = $veritabani->prepare("UPDATE sepet SET KargoId = ? , AdresId = ? WHERE UyeId = ? LIMIT 1");
//                  $KargoBilgileriniArtıkGuncelle->execute([
//                      $TablodakiKargoID,
//                      $TablodakiAdresID,
//                      $KullaniciID
//                  ]);
//                  //Adres ID Bilgilerini Güncelle
//              }else{
//                    echo "xxxxxxx hata";
//              }
//           }
        }else{
           echo "Üzgünüm Sepet Güncellenemedi!";
        }
        $StokIcinSepettekiUrunlerSorgusu = $veritabani->prepare("SELECT * FROM sepetim WHERE UyeId = ?");
        $StokIcinSepettekiUrunlerSorgusu->execute([$KullaniciID]);
        $StokIcinSepettekiUrunlerSayisi = $StokIcinSepettekiUrunlerSorgusu->rowCount();
        $StokIcinSepettekiKayitlar = $StokIcinSepettekiUrunlerSorgusu->fetchAll(PDO::FETCH_ASSOC);
        if($StokIcinSepettekiUrunlerSayisi>0){
            foreach($StokIcinSepettekiKayitlar as $StokIcinSepettekiSatirlar){
                $StokIcinSepetIDsi                      = $StokIcinSepettekiSatirlar["id"];
                $StokIcinSepettekiUrununVaryantIDsi     = $StokIcinSepettekiSatirlar["VaryantId"];
                $StokIcinSepettekiUrununAdedi           = $StokIcinSepettekiSatirlar["UrunAdedi"];
                $StokIcinUrunVaryantBilgileriSorgusu = $veritabani->prepare("SELECT * FROM urunvaryantlari WHERE id= ? LIMIT 1");
                $StokIcinUrunVaryantBilgileriSorgusu->execute([$StokIcinSepettekiUrununVaryantIDsi]);
                $StokIcinVaryantKaydi = $StokIcinUrunVaryantBilgileriSorgusu->fetch(PDO::FETCH_ASSOC);
                $StokIcinUrununStokAdedi = $StokIcinVaryantKaydi["StokAdedi"];
                if($StokIcinUrununStokAdedi == 0){
                    $SepettekiUrunuSilSorgusu = $veritabani->prepare("DELETE FROM sepetim WHERE id = ? AND UyeId = ? LIMIT 1");
                    $SepettekiUrunuSilSorgusu->execute([$StokIcinSepetIDsi,$KullaniciID]);
                }elseif($StokIcinUrununStokAdedi > $StokIcinSepettekiUrununAdedi){
                    $SepetGuncellemeSorgulari = $veritabani->prepare("UPDATE sepetim SET UrunAdedi = ? where id=? and UyeId = ? LIMIT 1");
                    $SepetGuncellemeSorgulari->execute([$StokIcinUrununStokAdedi,$StokIcinSepetIDsi,$KullaniciID]);
                }
            }
        }
        $SepettekiUrunlerSorgusu = $veritabani->prepare("SELECT * FROM sepetim WHERE UyeId = ? ORDER BY id DESC");
        $SepettekiUrunlerSorgusu->execute([$KullaniciID]);
        $SepettekiUrunlerSayisi = $SepettekiUrunlerSorgusu->rowCount();
        $SepettekiToplamKayitlar = $SepettekiUrunlerSorgusu->fetchAll(PDO::FETCH_ASSOC);
        if($SepettekiUrunlerSayisi > 0) {
            $SepettekiToplamUrunSayisi              = 0;
            $SepettekiToplamFiyat                   = 0;
            $SepettekiToplamKargoFiyatiniHesapla    = 0;
            foreach ($SepettekiToplamKayitlar as $SepetKayitlari) {
                $SepetIDsi = $SepetKayitlari["id"];
                $SepettekiUrunIDsi = $SepetKayitlari["UrunId"];
                $SepettekiVaryantIDsi = $SepetKayitlari["VaryantId"];
                $SepettekiUrunAdedi = $SepetKayitlari["UrunAdedi"];
                $UrunBilgileriSorgusu = $veritabani->prepare("SELECT * FROM urunler WHERE  id = ? LIMIT 1");
                $UrunBilgileriSorgusu->execute([$SepettekiUrunIDsi]);
                $UrunBilgileriSorgusuKaydi = $UrunBilgileriSorgusu->fetch(PDO::FETCH_ASSOC);
                $UrunFiyati = $UrunBilgileriSorgusuKaydi["UrunFiyati"];
                $ParaBirimi = $UrunBilgileriSorgusuKaydi["ParaBirimi"];
                $KargoUcreti = $UrunBilgileriSorgusuKaydi["KargoUcreti"];
                if ($ParaBirimi == "USD") {
                    $UrununFiyatiniHesapla = $UrunFiyati * $DolarKuru;
                    $UrunFiyatiBicimlendir = FiyatBicimlendir($UrununFiyatiniHesapla);
                } elseif ($ParaBirimi == "EUR") {
                    $UrununFiyatiniHesapla = $UrunFiyati * $EuroKuru;
                    $UrunFiyatiBicimlendir = FiyatBicimlendir($UrununFiyatiniHesapla);
                } else {
                    $UrununFiyatiniHesapla = $UrunFiyati;
                    $UrunFiyatiBicimlendir = FiyatBicimlendir($UrunFiyati);
                }
                $UrununToplamFiyatiniHesapla = ($UrununFiyatiniHesapla * $SepettekiUrunAdedi);
                $UrununToplamFiyatiniBicimlendir = FiyatBicimlendir($UrununToplamFiyatiniHesapla);
                $SepettekiToplamUrunSayisi  += $SepettekiUrunAdedi;
                $SepettekiToplamFiyat       += ($UrununFiyatiniHesapla * $SepettekiUrunAdedi);
                $SepettekiToplamKargoFiyatiniHesapla        += ($KargoUcreti * $SepettekiUrunAdedi);
                $SepettekiToplamKargoFiyatiniBicimlendir    =  FiyatBicimlendir($SepettekiToplamKargoFiyatiniHesapla);
            }//Foreach END
                if($SepettekiToplamFiyat >= $UcretsizKargoBaraji ){
                    $SepettekiToplamKargoFiyatiniHesapla            = 0;
                    $SepettekiTosplamKargoFiyatiniBicimlendir       =  FiyatBicimlendir($SepettekiToplamKargoFiyatiniHesapla);
                    $OdenecekToplamTutariBicimlendir                =  FiyatBicimlendir($SepettekiToplamFiyat);
                }else{
                    $OdenecekToplamTutariHesapla                    = ($SepettekiToplamFiyat + $SepettekiToplamKargoFiyatiniHesapla);
                    $OdenecekToplamTutariBicimlendir                = FiyatBicimlendir($OdenecekToplamTutariHesapla);
                }
                //Taksitlendirme için Matematiksel işlemler

                $IkiTaksitAylikOdemeTutari = number_format(($SepettekiToplamFiyat   / 2),"2",",",".");
                $UcTaksitAylikOdemeTutari = number_format(($SepettekiToplamFiyat    / 3),"2",",",".");
                $DortTaksitAylikOdemeTutari = number_format(($SepettekiToplamFiyat  / 4),"2",",",".");
                $BesTaksitAylikOdemeTutari = number_format(($SepettekiToplamFiyat   / 5),"2",",",".");
                $AltiTaksitAylikOdemeTutari = number_format(($SepettekiToplamFiyat  / 6),"2",",",".");
                $YediTaksitAylikOdemeTutari = number_format(($SepettekiToplamFiyat  / 7),"2",",",".");
                $SekizTaksitAylikOdemeTutari = number_format(($SepettekiToplamFiyat / 8),"2",",",".");
                $DokuzTaksitAylikOdemeTutari = number_format(($SepettekiToplamFiyat / 9),"2",",",".");
        }else{
            yonlendir("index.php");
        } ?>
    <div class="AlisverisSepetiKrediKartiVeBankaHavalesiveTaksitKapsamaAlani">
        <form action="index.php?SK=99" method="post">
        <div class="AnaSayfaIcerik" style="background-color: #FFF !important;width: 73% !important;float: left;margin-top:55px">
            <div class="AlisverisSepetiBaslikAciklamasiOdemeTuru">Ödeme türünün aşağidan seçebilirsiniz.</div>
            <div class="OdemeTuruSecimiBaslik">
                Ödeme Türü Seçimi
            </div>

                <div class="OdemeIslemleriIcinKartlarinKapsamaAlani">
                    <div  class="KrediKartiOdemesiSecimi">
                        <img src="Resimler/KrediKarti92x75.png" alt="">
                        <input type="radio" name="OdemeTuruSecimi" value="Kredi Kartı" onclick="$.KrediKartiSecildiAlani()">
                    </div>
                    <div class="BankaHavalesiOdemesiSecimi">
                        <img src="Resimler/Banka80x75.png" alt="">
                        <input type="radio"  name="OdemeTuruSecimi" value="Banka Havalesi" onclick="$.BankaHavalesiSecildi()">
                    </div>
                </div>
                <div class="KrediKartiIleOdemeBilgiAlani BHAlanlari">
                    <div class="KrediKartiBilgiKutulari">
                        <img src="Resimler/OdemeSecimiAxessCard.png" alt="">
                    </div>
                    <div class="KrediKartiBilgiKutulari">
                        <img src="Resimler/OdemeSecimiBonusCard.png" alt="">
                    </div>
                    <div class="KrediKartiBilgiKutulari">
                        <img src="Resimler/OdemeSecimiCardFinans.png" alt="">
                    </div>
                    <div class="KrediKartiBilgiKutulari">
                        <img src="Resimler/OdemeSecimiATMKarti.png" alt="">
                    </div>
                    <div class="KrediKartiBilgiKutulari">
                        <img src="Resimler/OdemeSecimiParafCard.png" alt="">
                    </div>
                    <div class="KrediKartiBilgiKutulari">
                        <img src="Resimler/OdemeSecimiMaximumCard.png" alt="">
                    </div>
                    <div class="KrediKartiBilgiKutulari">
                        <img src="Resimler/OdemeSecimiCardFinans.png" alt="">
                    </div>
                    <div class="KrediKartiBilgiKutulari">
                        <img src="Resimler/OdemeSecimiAxessCard.png" alt="">
                    </div>
                </div>
                <div class="BankaHavalesiEFTOdemeAlani BHAlanlari">
                    <div class="BankaHavalesiEFTBaslikAlani"> Banka Havalesi / EFT İle Ödeme</div>
                    <div class="BankaHavalesiEFTBaslikAciklamasi">Lorem ipsum dolor sit amet, consectetur adipisicing elit. Ab aliquam aperiam aspernatur atque beatae exercitationem hic provident repellat sit ullam! Ad consequatur doloribus esse eveniet ex expedita fugit minus vel?</div>
                </div>
                <div class="KrediKartiIleOdemeSecimiAlani KKAlanlari">
                    <div class="KrediKartiOdemeBasligi">Taksit Seçimi</div>
                    <div class="TaksitSecimiAciklama">Lütfen ödeme işleminde istediğiniz taksit sayisini seçiniz</div>


                    <!-- Takstitlendirme Radio Button Alani >>>>>>>>>>>>>>>>>-->
                    <div class="TaksitSecimAlani">
                        <input type="radio" name="TaksitSecimi" value="1">
                        <div class="TaksitBilgilendirmesiRadioButton">Tek Çekim</div>
                        <div class="TaksitHesaplamaGostergesi">1 x <?php echo $OdenecekToplamTutariBicimlendir ?> </div>
                        <div class="ToplamTutar"><?php echo $OdenecekToplamTutariBicimlendir ?> TL</div>
                    </div>
                    <!-- Takstitlendirme Radio Button Alani <<<<<<<<<<<<<<<<<<-->


                    <!-- Takstitlendirme Radio Button Alani >>>>>>>>>>>>>>>>>-->
                    <div class="TaksitSecimAlani">
                        <input type="radio" name="TaksitSecimi" value="2">
                        <div class="TaksitBilgilendirmesiRadioButton">2 Taksit</div>
                        <div class="TaksitHesaplamaGostergesi">2 x <?php echo $IkiTaksitAylikOdemeTutari ?> </div>
                        <div class="ToplamTutar"><?php echo $OdenecekToplamTutariBicimlendir ?> TL</div>
                    </div>
                    <!-- Takstitlendirme Radio Button Alani <<<<<<<<<<<<<<<<<<-->



                    <!-- Takstitlendirme Radio Button Alani >>>>>>>>>>>>>>>>>-->
                    <div class="TaksitSecimAlani">
                        <input type="radio" name="TaksitSecimi" value="3">
                        <div class="TaksitBilgilendirmesiRadioButton">3 Taksit</div>
                        <div class="TaksitHesaplamaGostergesi">3 x <?php echo $UcTaksitAylikOdemeTutari ?> </div>
                        <div class="ToplamTutar"><?php echo $OdenecekToplamTutariBicimlendir ?> TL</div>
                    </div>
                    <!-- Takstitlendirme Radio Button Alani <<<<<<<<<<<<<<<<<<-->



                    <!-- Takstitlendirme Radio Button Alani >>>>>>>>>>>>>>>>>-->
                    <div class="TaksitSecimAlani">
                        <input type="radio" name="TaksitSecimi" value="4">
                        <div class="TaksitBilgilendirmesiRadioButton">4 Taksit</div>
                        <div class="TaksitHesaplamaGostergesi">4 x <?php echo $DortTaksitAylikOdemeTutari ?> </div>
                        <div class="ToplamTutar"><?php echo $OdenecekToplamTutariBicimlendir ?> TL</div>
                    </div>
                    <!-- Takstitlendirme Radio Button Alani <<<<<<<<<<<<<<<<<<-->



                    <!-- Takstitlendirme Radio Button Alani >>>>>>>>>>>>>>>>>-->
                    <div class="TaksitSecimAlani">
                        <input type="radio" name="TaksitSecimi" value="5">
                        <div class="TaksitBilgilendirmesiRadioButton">5 Taksit</div>
                        <div class="TaksitHesaplamaGostergesi">5 x <?php echo $BesTaksitAylikOdemeTutari ?> </div>
                        <div class="ToplamTutar"><?php echo $OdenecekToplamTutariBicimlendir ?> TL</div>
                    </div>
                    <!-- Takstitlendirme Radio Button Alani <<<<<<<<<<<<<<<<<<-->



                    <!-- Takstitlendirme Radio Button Alani >>>>>>>>>>>>>>>>>-->
                    <div class="TaksitSecimAlani">
                        <input type="radio" name="TaksitSecimi" value="6">
                        <div class="TaksitBilgilendirmesiRadioButton">6 Taksit</div>
                        <div class="TaksitHesaplamaGostergesi">6 x <?php echo $AltiTaksitAylikOdemeTutari ?> </div>
                        <div class="ToplamTutar"><?php echo $OdenecekToplamTutariBicimlendir ?> TL</div>
                    </div>
                    <!-- Takstitlendirme Radio Button Alani <<<<<<<<<<<<<<<<<<-->



                    <!-- Takstitlendirme Radio Button Alani >>>>>>>>>>>>>>>>>-->
                    <div class="TaksitSecimAlani">
                        <input type="radio" name="TaksitSecimi" value="7">
                        <div class="TaksitBilgilendirmesiRadioButton">7 Taksit</div>
                        <div class="TaksitHesaplamaGostergesi">7 x <?php echo $YediTaksitAylikOdemeTutari ?> </div>
                        <div class="ToplamTutar"><?php echo $OdenecekToplamTutariBicimlendir ?> TL</div>
                    </div>
                    <!-- Takstitlendirme Radio Button Alani <<<<<<<<<<<<<<<<<<-->



                    <!-- Takstitlendirme Radio Button Alani >>>>>>>>>>>>>>>>>-->
                    <div class="TaksitSecimAlani">
                        <input type="radio" name="TaksitSecimi" value="8">
                        <div class="TaksitBilgilendirmesiRadioButton">8 Taksit</div>
                        <div class="TaksitHesaplamaGostergesi">8 x <?php echo $SekizTaksitAylikOdemeTutari ?> </div>
                        <div class="ToplamTutar"><?php echo $OdenecekToplamTutariBicimlendir ?> TL</div>
                    </div>
                    <!-- Takstitlendirme Radio Button Alani <<<<<<<<<<<<<<<<<<-->



                    <!-- Takstitlendirme Radio Button Alani >>>>>>>>>>>>>>>>>-->
                    <div class="TaksitSecimAlani">
                        <input type="radio" name="TaksitSecimi" value="9">
                        <div class="TaksitBilgilendirmesiRadioButton">9 Taksit</div>
                        <div class="TaksitHesaplamaGostergesi">9 x <?php echo $DokuzTaksitAylikOdemeTutari ?> </div>
                        <div class="ToplamTutar"><?php echo $OdenecekToplamTutariBicimlendir ?> TL</div>
                    </div>
                    <!-- Takstitlendirme Radio Button Alani <<<<<<<<<<<<<<<<<<-->
                </div>

        </div>

            <div class="AlisverisSepetiSagTutarveBilgiAlani" style="width: 25% !important;float:left;">
                <div class="AlisverisSepetiSagTutarSinirlamaAlani">
                    <div class="AlisverisSepetiSagBaslikAlani">Sipariş Özeti</div>
                    <div class="AlisverisSepetiSagTutarDetaylari">Toplam <span><?php $e->yazdir($SepettekiToplamUrunSayisi)?></span> Adet Ürün</div>

                    <div class="AlisverisSepetiSagOdenecekTutarBilgilendirmesi">
                        Ödenecek Tutar (KDV Dahil)
                    </div>
                    <div class="AlisverisSepetiSagOdenecekTutarDegeri"><?php echo $OdenecekToplamTutariBicimlendir; ?></div>

                    <div class="AlisverisSepetiSagOdenecekTutarBilgilendirmesi">
                        Ürünün Toplam Fiyati (KDV Dahil)
                    </div>
                    <div class="AlisverisSepetiSagOdenecekTutarDegeri"><?php echo FiyatBicimlendir($SepettekiToplamFiyat); ?></div>

                    <div class="AlisverisSepetiSagOdenecekTutarBilgilendirmesi">
                        Kargo Tutari (KDV Dahil)
                    </div>
                    <div class="AlisverisSepetiSagOdenecekTutarDegeri"><?php echo $SepettekiToplamKargoFiyatiniBicimlendir; ?></div>

                    <div class="AlisverisSepetiSagDevamEtButtonuAlani">
                        <input type="submit" class="KargoAdresSecimiFormButton" value="ÖDEME YAP">
                    </div>

                </div>
            </div>
        </form>
    </div>

    <?php }else{ yonlendir("index.php");  } ?> <?php } ?>
