
<?php
/**/
global $veritabani;
global $KullaniciID;
global $DolarKuru;
global $EuroKuru;
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

    $SepetSifirlamaSorgusu = $veritabani->prepare("UPDATE sepetim SET AdresId = ? , KargoId = ? , OdemeSecimi = ? , TaksitSecimi = ? WHERE UyeId = ? ");
    $SepetSifirlamaSorgusu->execute([0,0,"",0,$KullaniciID]);

    ?>
<div class="AlisverisSepetiKapsamaAlani">
    <div class="AlisverisSepetiSinirlamaAlani">
        <div class="AlisverisSepetiSolUrunlerAlani">
            <div class="AlisverisSepetiBaslik">Alışveriş Sepeti</div>
            <div class="AlisverisSepetiBaslikAciklamasi">Alışveriş Sepetine Eklemiş Olduğunuz Ürünler Aşağıdadır</div>
            <div class="AlisverisSepetiUrunlerListesiSinirlamaAlani">

    <?php

    $SepettekiUrunlerSorgusu =$veritabani->prepare("SELECT * FROM sepetim WHERE UyeId = ? ORDER BY id ASC");
    $SepettekiUrunlerSorgusu->execute([$KullaniciID]);
    $SepettekiUrunlerSorgusuSayisi = $SepettekiUrunlerSorgusu->rowCount();
    $SepettekiUrunlerSorgusuKayitlari = $SepettekiUrunlerSorgusu->fetchAll(PDO::FETCH_ASSOC);

    if($SepettekiUrunlerSorgusuSayisi > 0){
        $SepettekiToplamUrunSayisi = 0;
        $SepettekiToplamFiyat = 0;

        foreach($SepettekiUrunlerSorgusuKayitlari as $SepetKayitlari){

            $SepetIDsi              = $SepetKayitlari["id"];
            $SepettekiUrunIDsi      = $SepetKayitlari["UrunId"];
            $SepettekiVaryantIDsi   = $SepetKayitlari["VaryantId"];
            $SepettekiUrunAdedi     = $SepetKayitlari["UrunAdedi"];


            $UrunBilgileriSorgusu = $veritabani->prepare("SELECT * FROM urunler WHERE  id = ? LIMIT 1");
            $UrunBilgileriSorgusu->execute([$SepettekiUrunIDsi]);
            $UrunBilgileriSorgusuKaydi = $UrunBilgileriSorgusu->fetch(PDO::FETCH_ASSOC);

            $UrunTuru       = $UrunBilgileriSorgusuKaydi["UrunTuru"];
            $UrunResmi      = $UrunBilgileriSorgusuKaydi["UrunResmiBir"];
            $UrunAdi        = $UrunBilgileriSorgusuKaydi["UrunAdi"];
            $UrunFiyati     = $UrunBilgileriSorgusuKaydi["UrunFiyati"];
            $ParaBirimi     = $UrunBilgileriSorgusuKaydi["ParaBirimi"];
            $VaryantBasligi = $UrunBilgileriSorgusuKaydi["VaryantBasligi"];

            $UrunVaryantBilgileriSorgusu = $veritabani->prepare("SELECT * FROM urunvaryantlari WHERE id = ? LIMIT 1");
            $UrunVaryantBilgileriSorgusu->execute([$SepettekiVaryantIDsi]);
            $VaryantKaydi   =   $UrunVaryantBilgileriSorgusu->fetch(PDO::FETCH_ASSOC);

            $UrununVaryantAdi       = $VaryantKaydi["VaryantAdi"];
            $UrununVaryantStokAdedi = $VaryantKaydi["StokAdedi"];


            if($UrunTuru == "Erkek Ayakkabısı"){
                $urununResimKlasoru = "Erkek";
            }elseif($UrunTuru == "Kadın Ayakkabısı"){
                $urununResimKlasoru = "Kadin";
            }elseif($UrunTuru == "Cocuk Ayakkabısı"){
                $urununResimKlasoru = "Cocuk";
            }


            if($ParaBirimi == "USD"){
                $UrununFiyatiniHesapla = $UrunFiyati * $DolarKuru;
                $UrunFiyatiBicimlendir = FiyatBicimlendir($UrununFiyatiniHesapla);
            }elseif($ParaBirimi == "EUR"){
                $UrununFiyatiniHesapla = $UrunFiyati * $EuroKuru;
                $UrunFiyatiBicimlendir = FiyatBicimlendir($UrununFiyatiniHesapla);
            }else{
                $UrununFiyatiniHesapla = $UrunFiyati;
                $UrunFiyatiBicimlendir = FiyatBicimlendir($UrunFiyati);
            }

            $UrununToplamFiyatiniHesapla = ($UrununFiyatiniHesapla * $SepettekiUrunAdedi);
            $UrununToplamFiyatiniBicimlendir = FiyatBicimlendir($UrununToplamFiyatiniHesapla);



           $SepettekiToplamUrunSayisi += $SepettekiUrunAdedi;
           $SepettekiToplamFiyat      += ($UrununFiyatiniHesapla * $SepettekiUrunAdedi);


            ?>
            <!--  ÜRÜN BLOKLARİ ALANİ>>>>>>>>>>>>>>>>>>>>              -->
            <div class="AlisverisSepetiUrunKapsamaAlani">
                <div class="AlisverisSepetiUrunResmi"><img src="Resimler/UrunResimleri/<?php echo $urununResimKlasoru ?>/<?php echo DonusumleriGeriDondur($UrunResmi);?>" alt=""></div>
                <div class="AlisverisSepetiUrunSilResmi"><a href="index.php?SK=94&ID=<?php $e->yazdir($SepetIDsi)?>"><img src="Resimler/SilDaireli20x20.png" alt=""></a></div>
                <div class="AlisverisSepetiUrunBasligi">
                    <?php DonusumleriGeriDondur($e->yazdir($UrunAdi))?>
                    <div class="Temizle"></div>
                    <span class="AlisverisSepetiUrunVaryanti"><?php $e->yazdir($VaryantBasligi)?>: <?php $e->yazdir($UrununVaryantAdi)?></span>
                </div>

                <div class="AlisverisSepetiAzaltButtonuAlani">
                    <?php
                        if($SepettekiUrunAdedi > 1 ){
                            ?>
                            <a href="index.php?SK=95&ID=<?php $e->yazdir(DonusumleriGeriDondur($SepetIDsi)); ?>"><img src="Resimler/AzaltDaireli20x20.png" alt=\"\"></a>
                            <?php
                        }else{
                            $e->HTMLYazdir("&nbsp;");
                        }
                    ?>
                </div>
                <div class="AlisverisSepetiSepettekiArttirilmisVeyaAzaltilmisUrunSayisi"><?php $e->yazdir(DonusumleriGeriDondur($SepettekiUrunAdedi))?></div>
                <div class="AlisverisSepetiArttirButtonuAlani">
                    <a href="index.php?SK=96&ID=<?php $e->yazdir(DonusumleriGeriDondur($SepetIDsi))?>"><img src="Resimler/ArttirDaireli20x20.png" alt=""></a>
                </div>

                <div class="AlisverisSepetiUrunFiyatlariVeDigerFiyatlariAlani">
                    <div class="AlisverisSepetiUrunBirimiFiyati"><?php $e->yazdir($UrunFiyatiBicimlendir)?> TL </div>
                    <div class="Temizle"></div>
                    <div class="AlisverisSepetiUrunBirimlerininiToplamFiyati"> <?php $e->yazdir($UrununToplamFiyatiniBicimlendir)?> TL </div>
                </div>
            </div>
            <!--  ÜRÜN BLOKLARİ ALANİ<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<        -->            <?php
        }

        }else{
            $SepettekiToplamUrunSayisi = 0;
            $SepettekiToplamFiyat = 0;
            echo "<h2>Sepetinizde herhangi bir ürün bulunmamaktadır</h2>";
        }
    }else{

        yonlendir("index.php");
    }
?>

            </div>
        </div> <!-- SOL ALİSVERİSSEPETİ ALANLARİ-->
        <?php

        ?>
        <?php if($SepettekiToplamUrunSayisi>0){?>
        <div class="AlisverisSepetiSagTutarveBilgiAlani">
            <div class="AlisverisSepetiSagTutarSinirlamaAlani">
                <div class="AlisverisSepetiSagBaslikAlani">Sipariş Özeti</div>
                <div class="AlisverisSepetiSagTutarDetaylari">Toplam <span><?php $e->yazdir($SepettekiToplamUrunSayisi)?></span> Adet Ürün</div>
                <div class="AlisverisSepetiSagOdenecekTutarBilgilendirmesi">
                    Ödenecek Tutar (KDV Dahil)
                </div>
                <div class="AlisverisSepetiSagOdenecekTutarDegeri"><?php $e->yazdir(DonusumleriGeriDondur(FiyatBicimlendir($SepettekiToplamFiyat)))?> TL </div>

                <a href="index.php?SK=97">
                    <div class="AlisverisSepetiSagDevamEtButtonuAlani">
                        <img src="Resimler/SepetBeyaz21x20.png" alt=""><span>DEVAM ET</span>
                    </div>
                </a>
            </div>
        </div>
        <?php } ?>
    </div>
</div>














































