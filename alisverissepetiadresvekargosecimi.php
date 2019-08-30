<?php
//97
global $veritabani;
global $KullaniciID;
global $DolarKuru;
global $EuroKuru;
global $UcretsizKargoBaraji;
if($e->setEdilmisIseSession("Kullanici")){

$StokIcinSepettekiUrunlerSorgusu = $veritabani->prepare("SELECT * FROM sepetim WHERE UyeId = ? ");
$StokIcinSepettekiUrunlerSorgusu->execute([$KullaniciID]);
$StokSayisi = $StokIcinSepettekiUrunlerSorgusu->rowCount();
$StokIcinSepettekiKayitlar = $StokIcinSepettekiUrunlerSorgusu->fetchAll(PDO::FETCH_ASSOC);


if($StokSayisi>0){

    foreach($StokIcinSepettekiKayitlar as $StokKayitlariKontrol){
        $StokIcinSepetIDsi                  = $StokKayitlariKontrol["id"];
        $StokIcinSepettekiUrunVaryantIDsi   = $StokKayitlariKontrol["VaryantId"];
        $StokIcinSepettekiUrunAdedi         = $StokKayitlariKontrol["UrunAdedi"];
        $StokIcinUrunVaryantBilgileriSorgusu = $veritabani->prepare("SELECT * FROM urunvaryantlari WHERE id = ? LIMIT 1");
        $StokIcinUrunVaryantBilgileriSorgusu->execute([$StokIcinSepettekiUrunVaryantIDsi]);
        $UrunVaryantlariKayitlari = $StokIcinUrunVaryantBilgileriSorgusu->fetch(PDO::FETCH_ASSOC);
        $StokIcinUrununStokAdedi = $UrunVaryantlariKayitlari["StokAdedi"];
        if($StokIcinUrununStokAdedi == 0){
            $SepetSilSorgusu = $veritabani->prepare("DELETE FROM sepetim WHERE  id = ? AND UyeId = ? LIMIT 1");
            $SepetSilSorgusu->execute([$StokIcinSepetIDsi,$KullaniciID]);
        }elseif($StokIcinUrununStokAdedi >$StokIcinSepettekiUrunAdedi){
            $SepetGuncellemeSorgusu = $veritabani->prepare("UPDATE sepetim SET UrunAdedi = ? WHERE id= ? AND UyeId = ? LIMIT 1");
            $SepetGuncellemeSorgusu->execute([$StokIcinUrununStokAdedi,$StokIcinSepetIDsi,$KullaniciID]);
        }
    }
}



?>
<form action="index.php?SK=98" method="post">
<div class="AlisverisSepetiKapsamaAlani">
    <div class="AlisverisSepetiSinirlamaAlani">
        <div class="AlisverisSepetiSolUrunlerAlani">
            <div class="AlisverisSepetiBaslik">Alışveriş Sepeti</div>
            <div class="AlisverisSepetiBaslikAciklamasi">Adres ve kargo seçiminizi aşağıdan belirtebilirsiniz.</div>
            <div class="AlisverisSepetiUrunlerListesiSinirlamaAlani">
                <?php
                $SepettekiUrunlerSorgusu =$veritabani->prepare("SELECT * FROM sepetim WHERE UyeId = ? ORDER BY id ASC");
                $SepettekiUrunlerSorgusu->execute([$KullaniciID]);
                $SepettekiUrunlerSorgusuSayisi = $SepettekiUrunlerSorgusu->rowCount();
                $SepettekiUrunlerSorgusuKayitlari = $SepettekiUrunlerSorgusu->fetchAll(PDO::FETCH_ASSOC);
                if($SepettekiUrunlerSorgusuSayisi > 0) {
                    $SepettekiToplamUrunSayisi              = 0;
                    $SepettekiToplamFiyat                   = 0;
                    $SepettekiToplamKargoFiyatiniHesapla    = 0;
                    foreach ($SepettekiUrunlerSorgusuKayitlari as $SepetKayitlari) {
                        $SepetIDsi                  = $SepetKayitlari["id"];
                        $SepettekiUrunIDsi          = $SepetKayitlari["UrunId"];
                        $SepettekiVaryantIDsi       = $SepetKayitlari["VaryantId"];
                        $SepettekiUrunAdedi         = $SepetKayitlari["UrunAdedi"];
                        $UrunBilgileriSorgusu       = $veritabani->prepare("SELECT * FROM urunler WHERE  id = ? LIMIT 1");
                        $UrunBilgileriSorgusu->execute([$SepettekiUrunIDsi]);
                        $UrunBilgileriSorgusuKaydi  = $UrunBilgileriSorgusu->fetch(PDO::FETCH_ASSOC);
                        $UrunFiyati                 = $UrunBilgileriSorgusuKaydi["UrunFiyati"];
                        $ParaBirimi                 = $UrunBilgileriSorgusuKaydi["ParaBirimi"];
                        $KargoUcreti                = $UrunBilgileriSorgusuKaydi["KargoUcreti"];

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
                            $SepettekiToplamKargoFiyatiniHesapla        = 0;
                            $SepettekiToplamKargoFiyatiniBicimlendir    =  FiyatBicimlendir($SepettekiToplamKargoFiyatiniHesapla);
                            $OdenecekToplamTutariBicimlendir            =  FiyatBicimlendir($SepettekiToplamFiyat);
                        }else{
                            $OdenecekToplamTutariHesapla                = ($SepettekiToplamFiyat + $SepettekiToplamKargoFiyatiniHesapla);
                            $OdenecekToplamTutariBicimlendir            = FiyatBicimlendir($OdenecekToplamTutariHesapla);
                        }


                }else{
                    yonlendir("index.php");
                }
        }else{
                    yonlendir("index.php");
        }


?>

                <div class="AdresSecimleriKapsamaAlani">
                    <div class="AdresSecimiBaslikAlani">
                        <span class="AdresSecimiBasligi">Adres Seçimi</span>
                        <span class="YeniAdresEkleAlani"><a href="index.php?SK=58">+ YENİ ADRES EKLE</a></span>
                    </div>
                        <ul class="AdreslerAlani">
                            <?php
                            $AdreslerSorgusu = $veritabani->prepare("SELECT * FROM adresler WHERE UyeId = ? ORDER BY id DESC");
                            $AdreslerSorgusu->execute([$KullaniciID]);
                            $AdreslerSorgusuSayisi = $AdreslerSorgusu->rowCount();
                            $AdresKayitlari = $AdreslerSorgusu->fetchAll(PDO::FETCH_ASSOC);
                            if( $AdreslerSorgusuSayisi > 0){
                                $AdresSecimiIcinSayisalDegerArttirma = 0;
                                    foreach($AdresKayitlari as $AdresSatirlari){
                                    $AdresSecimiIcinSayisalDegerArttirma++;
                                    $SayiKisalt = $AdresSecimiIcinSayisalDegerArttirma;
                                ?>
                            <li class="Adresler">
                                <input type="radio"  name="AdresSecimi" id="Adres<?php $e->yazdir($SayiKisalt)?>" value="<?php echo $AdresSatirlari["id"] ?>">
                                <label for="Adres<?php $e->yazdir($SayiKisalt)?>">
                                <?php $e->yazdir($AdresSatirlari["AdiSoyadi"])?> &nbsp;
                                <?php $e->yazdir($AdresSatirlari["Adres"])?> &nbsp;
                                <?php $e->yazdir($AdresSatirlari["Sehir"])?>&nbsp;
                                <?php $e->yazdir($AdresSatirlari["Ilce"])?>&nbsp;
                                <?php $e->yazdir($AdresSatirlari["TelefonNumarasi"])?>
                                </label>
                            </li>
                                <?php } ?>
                    </ul>
                    <div class="KargoSecimiAlani">
                        <ul class="KargoSecimiSinirlamaAlani">
                            <?php
                                $KargoFirmalariSorgu = $veritabani->prepare("SELECT * FROM kargofirmalari");
                                $KargoFirmalariSorgu->execute();
                                $KargoSayisi = $KargoFirmalariSorgu->rowCount();
                                $KargoKayitlari = $KargoFirmalariSorgu->fetchAll(PDO::FETCH_ASSOC);
                                $KargoSecimiIcinSayisalDegerArttirma = 0;

                                foreach($KargoKayitlari as $KargoKaydi){
                                    /*
                                     * Kargo Radio Buttonlarin valuelerinin alinacaği ve yazdiralacaği alan
                                     * */
                                    $KargoSecimiIcinSayisalDegerArttirma++;
                                    $KargoSayiKisalt = $KargoSecimiIcinSayisalDegerArttirma;
                                    ?>
                                    <li class="Kargocular">
                                        <img src="Resimler/<?php $e->yazdir($KargoKaydi["KargoFirmasininLogosu"]) ?>" alt="">
                                        <input type="radio" name="KargoSecimi" value="<?php echo $KargoKaydi["id"] ?>">
                                    </li>
                                <?php } //Foreach END ?>
                        </ul>
                    </div>
                </div>
                </form>
            </div>

        </div> <!-- SOL ALİSVERİSSEPETİ ALANLARİ-->

        <div class="AlisverisSepetiSagTutarveBilgiAlani">
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
                        <img src="Resimler/SepetBeyaz21x20.png" alt=""><input type="submit" class="KargoAdresSecimiFormButton" value="DEVAM ET">
                    </div>

            </div>
        </div>

        <?php }else{ echo "Lütfen bir adres ekleyiniz"; } ?>
    </div>
</div>
</form>

