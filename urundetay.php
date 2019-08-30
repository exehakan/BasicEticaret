<?php
global $SosyalLinkFacebook;
global $SosyalLinkTwitter;
if($e->setEdilmisse($_GET["ID"])){
    $GelenUrunIdsi = SayiliIcerikleriFilitrele($_GET["ID"]);
    $UrunHitiGuncelleme = $veritabani->prepare("UPDATE urunler SET GoruntulenmeSayisi=GoruntulenmeSayisi+1  WHERE id=? AND Durumu=?  LIMIT 1");
    $UrunHitiGuncelleme->execute([$GelenUrunIdsi,1]);
    //ÜRÜNÜN SORGU KAYDİ
    $UrunSorgusu = $veritabani->prepare("SELECT * FROM urunler WHERE id = ? AND Durumu = ? LIMIT 1");
    $UrunSorgusu->execute([$GelenUrunIdsi,1]);
    $UrunSayisi = $UrunSorgusu->rowCount();
    $UrunSorgusuKaydi = $UrunSorgusu->fetch(PDO::FETCH_ASSOC);
    //ÜRÜNÜN SORGU KAYDİ

    if($UrunSayisi > 0){
        $UrunTuru = $UrunSorgusuKaydi["UrunTuru"];
        if($UrunTuru == "Erkek Ayakkabısı"){
            $ResimKlasoru = "Erkek";
        }elseif($UrunTuru == "Kadın Ayakkabısı"){
            $ResimKlasoru = "Kadın";
        }elseif($UrunTuru == "Cocuk Ayakkabısı"){
            $ResimKlasoru = "Cocuk";
        }

        $UrununFiyati = DonusumleriGeriDondur($UrunSorgusuKaydi["UrunFiyati"]);
        $UrununParaBirimi = DonusumleriGeriDondur($UrunSorgusuKaydi["ParaBirimi"]);
        /*
         * GLOBAL Değişken Tanimlari
         * */
        global $DolarKuru;
        global $EuroKuru;
        if($UrununParaBirimi == "USD"){
            $UrununFiyatiniHesapla = $UrununFiyati * $DolarKuru;
        }elseif($UrununParaBirimi == "EUR"){
            $UrununFiyatiniHesapla = $UrununFiyati * $EuroKuru;
        }else{
            $UrununFiyatiniHesapla = $UrununFiyati;

        }
        ?>
    <div class="AnaSayfaIcerik UrunDetay">
        <div class="UrunDetayKapsamaAlani">
            <div class="UrunDetaySolUrunFotograflariAlani">
                <div class="UrunDetaySolUrunFotograflari">
                    <div class="UrunDetayDevResimAlani">
                        <img id="DEVResim" src="Resimler/UrunResimleri/<?php $e->yazdir($ResimKlasoru."/".DonusumleriGeriDondur($UrunSorgusuKaydi["UrunResmiBir"]))?>" alt="">
                    </div>
                    <ul class="UrunDetayDortluResimler">
                        <li class="UrunDetayResimleri">
                            <img src="Resimler/UrunResimleri/<?php $e->yazdir($ResimKlasoru."/".DonusumleriGeriDondur($UrunSorgusuKaydi["UrunResmiBir"]))?>" alt=""
                            onclick="$.ResimOnizlemeFonksiyonu('<?php $e->yazdir($ResimKlasoru) ?>','<?php $e->yazdir($UrunSorgusuKaydi["UrunResmiBir"])?>')"
                            >
                        </li>
                        <li class="UrunDetayResimleri">
                            <img src="Resimler/UrunResimleri/<?php $e->yazdir($ResimKlasoru."/".DonusumleriGeriDondur($UrunSorgusuKaydi["UrunResmiIki"]))?>" alt=""
                                 onclick="$.ResimOnizlemeFonksiyonu('<?php $e->yazdir($ResimKlasoru) ?>','<?php $e->yazdir($UrunSorgusuKaydi["UrunResmiIki"])?>')"
                            >

                        </li>
                        <li class="UrunDetayResimleri">
                            <img src="Resimler/UrunResimleri/<?php $e->yazdir($ResimKlasoru."/".DonusumleriGeriDondur($UrunSorgusuKaydi["UrunResmiUc"]))?>" alt=""
                                 onclick="$.ResimOnizlemeFonksiyonu('<?php $e->yazdir($ResimKlasoru) ?>','<?php $e->yazdir($UrunSorgusuKaydi["UrunResmiUc"])?>')"
                            >

                        </li>
                        <li class="UrunDetayResimleri">
                            <img src="Resimler/UrunResimleri/<?php $e->yazdir($ResimKlasoru."/".DonusumleriGeriDondur($UrunSorgusuKaydi["UrunResmiDort"]))?>" alt=""
                                 onclick="$.ResimOnizlemeFonksiyonu('<?php $e->yazdir($ResimKlasoru) ?>','<?php $e->yazdir($UrunSorgusuKaydi["UrunResmiDort"])?>')"
                            >

                        </li>
                    </ul>
                </div>

                <!-- REKLAMLAR ALANİ           -->

                <div class="UrunDetaySayfasiReklamAlani">
                    <div class="UrunDetayReklamBasligi">
                        REKLAMLAR
                    </div>
                    <div class="ReklamResimYoluVeBilgileri UrunDetayReklam">
                        <?php
                            $BannerSorgusu = $veritabani->prepare("SELECT * FROM bannerlar WHERE BannerAlani ='Urun Detay' ORDER BY GosterimSayisi ASC LIMIT 1");
                            $BannerSorgusu->execute();
                            $BannerSorguSayisi = $BannerSorgusu->rowCount();
                            $BannerKayitlari = $BannerSorgusu->fetch(PDO::FETCH_ASSOC);
                        ?>
                            <img class="UrunDetayReklam" src="Resimler/Banner/<?php $e->yazdir(DonusumleriGeriDondur($BannerKayitlari["BannerResmi"]))?>" alt="">
                        <?php
                            //Banner Güncellemeleri
                            $BannerGuncelle = $veritabani->prepare("UPDATE bannerlar SET GosterimSayisi=GosterimSayisi+1 WHERE id=? LIMIT 1");
                            $BannerGuncelle->execute([DonusumleriGeriDondur($BannerKayitlari["id"])])

                        ?>

                    </div>
                </div>
                <!-- REKLAMLAR ALANİ           -->
            </div>


            <!--URUN DETAY SAG ALAN        -->
            <div class="UrunDetaySagAlan">
                <div class="UrunDetaySagSinirlamaAlani">


                    <!-- SEPETE GİDECEK OLAN ÜRÜN BİLGİLERİ FORM ACTİON İÇERİSİNDE ID DEĞERLERİ İLE BİRLİKTE GÖNDERİLMEKTEDİR.-->
                <form action="index.php?SK=90&ID=<?php $e->yazdir(DonusumleriGeriDondur($UrunSorgusuKaydi["id"]))?>" method="post">
                    <div class="UrunDetaySagUrunBasligiAlani"><?php $e->yazdir(DonusumleriGeriDondur($UrunSorgusuKaydi["UrunAdi"]))?></div>
                    <div class="UrunDetaySepetVeSosyalAlan">
                        <div class="UrunDetaySosyalAlan">
                            <a href="<?php $e->yazdir(DonusumleriGeriDondur($SosyalLinkFacebook))?>"><img src="Resimler/Facebook24x24.png" alt=""></a>
                            <a href="<?php $e->yazdir(DonusumleriGeriDondur($SosyalLinkTwitter))?>"><img src="Resimler/Twitter24x24.png" alt=""></a>


                <?php
                    if($e->setEdilmisIseSession("Kullanici")){
                        $GelenUrunIdsiDonusumleriGeriDondur = DonusumleriGeriDondur($UrunSorgusuKaydi["id"]);
                        $e->HTMLYazdir("<a href=\"index.php?SK=86&ID={$GelenUrunIdsiDonusumleriGeriDondur}\"><img src=\"Resimler/KalpKirmiziDaireliBeyaz24x24.png\" alt=\"\"></a>");
                    }else{
                        $e->HTMLYazdir("<img src=\"Resimler/KalpKirmiziDaireliBeyaz24x24.png\" alt=\"\">");
                    }
                ?>

                        </div>

                        <div class="UrunDetaySepeteEkle">
                            <input type="submit" value="SEPETE EKLE" class="SepeteEkleButtonu">
                        </div>
                    </div>

                    <div class="UrunVaryant">
                        <?php
                        $UrunVaryantlariSorgusu = $veritabani->prepare("SELECT * FROM urunvaryantlari WHERE UrunId = ? AND StokAdedi > ? ORDER BY VaryantAdi ASC");
                        $UrunVaryantlariSorgusu->execute([DonusumleriGeriDondur($UrunSorgusuKaydi["id"]),0]);
                        $VaryantSayisi = $UrunVaryantlariSorgusu->rowCount();
                        $VaryantKayitlari = $UrunVaryantlariSorgusu->fetchAll(PDO::FETCH_ASSOC);
                        ?>

                        <select name="Varyant" class="VaryantSelecti">
                            <option value=""><?php $e->yazdir(DonusumleriGeriDondur($UrunSorgusuKaydi["VaryantBasligi"]))?></option>
                        <?php 
                         foreach($VaryantKayitlari as $Varyantlar){
                             ?>
                             <option style="padding: 15px;" value="<?php $e->yazdir($Varyantlar["id"])?>"><?php $e->yazdir($Varyantlar["VaryantAdi"]) ?></option>
                             <?php
                         }
                        ?>

                        </select>
                        <div class="UrunDetayUrunFiyati"><?php $e->yazdir(FiyatBicimlendir($UrununFiyatiniHesapla))?></div>
                    </div>
                </form>
                    <hr style="display: block;margin:0 auto;padding: 0;overflow: hidden;font-weight: 400;">
                    <ul class="UrunDetayHakkındaBilgilendirme">
                        <li class="UrunDetayBilgilendirme"><img src="Resimler/SaatEsnetikGri20x20.png" alt="">Siparişiniz <?php $e->yazdir(UcGunIleriTarihiBul())?> tarihine kadar kargoya verilecektir.</li>
                        <li class="UrunDetayBilgilendirme"><img src="Resimler/SaatHizCizgiliLacivert20x20.png" alt="">İlgili ürün süper hızlı gönderi kapsamındadır. Aynı gün teslimat yapılabilir.</li>
                        <li class="UrunDetayBilgilendirme"><img src="Resimler/KrediKarti20x20.png" alt="">Tüm bankaların kredi kartları ile peşin veya taksitli ödeme seçeneği.</li>
                        <li class="UrunDetayBilgilendirme"><img src="Resimler/Banka20x20.png" alt="">Tüm bankalardan havale veya EFT ile ödeme seçeneği.</li>
                    </ul>
                    <hr>

                    <div class="UrunDetayAciklamasi">
                        <div class="UrunDetayAciklamaBasligi">Ürün Açiklamasi</div>
                        <div class="UrunAciklamasi"><?php $e->yazdir($UrunSorgusuKaydi["UrunAciklamasi"])?></div>
                        <div class="UrunDetayYorumBasligi">Ürün Yorumlari</div>
                        <ul class="UrunYorumlariKapsamaAlani">
                            <?php
                                $UrunYorumlariSorgusu = $veritabani->prepare("SELECT * FROM yorumlar WHERE UrunId = ? ORDER BY YorumTarihi DESC");
                                $UrunYorumlariSorgusu->execute([$GelenUrunIdsi]);
                                $YorumSayisi = $UrunYorumlariSorgusu->rowCount();
                                $YorumKayitlari = $UrunYorumlariSorgusu->fetchAll(PDO::FETCH_ASSOC);
                                if($YorumSayisi>0){
                                    foreach($YorumKayitlari as $YorumKayit){


                                        $YorumPuani = DonusumleriGeriDondur($YorumKayit["Puan"]);
                                        if($YorumPuani == 1){
                                            $YorumPuaniResmi = "YildizBirDolu.png";
                                        }elseif($YorumPuani == 2){
                                            $YorumPuaniResmi = "YildizIkiDolu.png";
                                        }elseif($YorumPuani == 3){
                                            $YorumPuaniResmi = "YildizUcDolu.png";
                                        }elseif($YorumPuani == 4){
                                            $YorumPuaniResmi = "YildizDortDolu.png";
                                        }elseif($YorumPuani == 5){
                                            $YorumPuaniResmi = "YildizBesDolu.png";
                                        }

                                        $YorumlarIcinUyeSorgusu = $veritabani->prepare("SELECT * FROM uyeler WHERE id=? LIMIT 1");
                                        $YorumlarIcinUyeSorgusu->execute([$YorumKayit["UyeId"]]);
                                        $UyeSorguKayitlari = $YorumlarIcinUyeSorgusu->fetch(PDO::FETCH_ASSOC);

                                        ?>



                                        <li class="UrunYorumu">
                                            <img src="Resimler/<?php $e->yazdir($YorumPuaniResmi)?>" alt="">
                                            <a href="#"><?php  $e->yazdir($UyeSorguKayitlari["IsimSoyisim"])?></a> <span class="YorumTarigi"><?php $e->yazdir(date("d.m.Y H:i:s", $YorumKayit["YorumTarihi"]))?></span>
                                            <span class="UrunYorumMetni">
                                                <?php $e->yazdir($YorumKayit["YorumMetini"])?>
                                            </span>
                                        </li>
                                        <?php
                                    } # foreach end
                                }else{
                                    $e->yazdir("<center><b>Üzgünüm Bu Ürüne Hiç Yorum Yapilmamis</b></center>");
                                }
                            ?>

                        </ul>
                    </div>

                </div>
            </div>
            <!--URUN DETAY SAG ALAN        -->
        </div>
    </div>

        <?php
    }else{
        yonlendir("index.php");
    }

}else{
    yonlendir("index.php");

} ?>

