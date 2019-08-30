<?php
global $veritabani
?>
<div class="AnaSayfaKapsamaAlani">
    <div class="AnasayfaUstBannerAlani">
        <div class="BannerSinirlamaAlani">
            <img class="AnaSayfaBannerAlani" src="Resimler/Banner/1.jpg">
        </div>
    </div>
    <div class="UrunKategorisiDuzBaslik">En Yeni Urunler</div>
    <?php ?>
<?php

$UrunlerSorgusu  = $veritabani->prepare("SELECT * FROM urunler WHERE Durumu = '1' AND UrunTuru = 'Erkek Ayakkabısı' ORDER BY id DESC LIMIT 5");
$UrunlerSorgusu->execute([]);
$UrunlerSorgusuKaydi = $UrunlerSorgusu->fetchAll(PDO::FETCH_ASSOC);
foreach($UrunlerSorgusuKaydi as $Urunler){
    $UrunResmiKontrolu  = $Urunler["UrunResmiBir"];
    $UrunTuru           = $Urunler["UrunTuru"];
    $UrununAdi          = $Urunler["UrunAdi"];
    $UrununAciklamasi   = $Urunler["UrunAciklamasi"];


    if($UrunTuru == "Erkek Ayakkabısı"){
        $UrununUrunTuru = "Resimler/UrunResimleri/Erkek/";
    }elseif($UrunTuru == "Cocuk Ayakkabısı"){
        $UrununUrunTuru = "Resimler/UrunResimleri/Cocuk/";
    }elseif($UrunTuru == "Kadın Ayakkabısı"){
        $UrununUrunTuru = "Resimler/UrunResimleri/Kadin/";
    }

    $UrununResmiYolu = $UrununUrunTuru.$UrunResmiKontrolu;


   $ToplamYorumPuani    = $Urunler["ToplamYorumPuani"];
   $ToplamYorumSayisi   = $Urunler["YorumSayisi"];

   if($ToplamYorumPuani>0){
       $PuanlamaIslemleri = ceil($ToplamYorumPuani / $ToplamYorumSayisi);

       if($PuanlamaIslemleri >= 5){
           $PuanlamaIslemleri = 5;
       }
        /*
         * YildizCizgiliBos
         * YildizCizgiliBirDolu
         * YildizCizgiliIkiDolu
         * YildizCizgiliUcDolu
         * YildizCizgiliDortDolu
         * YildizCizgiliBesDolu
         * */

       if($PuanlamaIslemleri < 1){
           $PuanSonucu  =    "YildizCizgiliBos.png";
       }elseif($PuanlamaIslemleri>0 && $PuanlamaIslemleri < 2){
           $PuanSonucu  =    "YildizCizgiliBirDolu.png";
       }elseif($PuanlamaIslemleri>1 && $PuanlamaIslemleri < 3){
           $PuanSonucu  =    "YildizCizgiliIkiDolu.png";
       }elseif($PuanlamaIslemleri>2 && $PuanlamaIslemleri < 4){
           $PuanSonucu  =    "YildizCizgiliUcDolu.png";
       }elseif($PuanlamaIslemleri>3 && $PuanlamaIslemleri < 5){
           $PuanSonucu  =    "YildizCizgiliDortDolu.png";
       }elseif($PuanlamaIslemleri>4 && $PuanlamaIslemleri < 6){
           $PuanSonucu  =    "YildizCizgiliBesDolu.png";
       }elseif($PuanlamaIslemleri>6){
           $PuanSonucu  =    "YildizCizgiliBos.png";
       }


   }
?>
    <div class="UrununSinirlamaAlani">
        <div class="UrununResimAlani">

            <a href="index.php?SK=82&ID=<?php echo $Urunler["id"]?>">
                <img src="<?php echo $UrununResmiYolu ?>" alt="" width="205" height="273">
            </a>

        </div>
        <div class="UrunResmiBaslik"><?php echo $UrununAdi ?></div>
        <div class="UrunResmiAciklamasi"><?php echo mb_substr($UrununAciklamasi,0,25) ?></div>
        <div class="UrununYildizlamaPuani">
            <img src="Resimler/<?php echo $PuanSonucu ?>" alt="">
        </div>
        <div class="UrununFiyati"><?php echo $Urunler["UrunFiyati"]?>TL</div>
    </div>

<?php } ?>

    <div class="UrunKategorisiDuzBaslik">En Popüler Ürünler</div>
<?php

$UrunlerSorgusu  = $veritabani->prepare("SELECT * FROM urunler WHERE Durumu = '1' ORDER BY ToplamSatisSayisi DESC  LIMIT 5");
$UrunlerSorgusu->execute([]);
$UrunlerSorgusuKaydi = $UrunlerSorgusu->fetchAll(PDO::FETCH_ASSOC);
foreach($UrunlerSorgusuKaydi as $Urunler){
    $UrunResmiKontrolu  = $Urunler["UrunResmiBir"];
    $UrunTuru           = $Urunler["UrunTuru"];
    $UrununAdi          = $Urunler["UrunAdi"];
    $UrununAciklamasi   = $Urunler["UrunAciklamasi"];


    if($UrunTuru == "Erkek Ayakkabısı"){
        $UrununUrunTuru = "Resimler/UrunResimleri/Erkek/";
    }elseif($UrunTuru == "Cocuk Ayakkabısı"){
        $UrununUrunTuru = "Resimler/UrunResimleri/Cocuk/";
    }elseif($UrunTuru == "Kadın Ayakkabısı"){
        $UrununUrunTuru = "Resimler/UrunResimleri/Kadin/";
    }

    $UrununResmiYolu = $UrununUrunTuru.$UrunResmiKontrolu;


   $ToplamYorumPuani    = $Urunler["ToplamYorumPuani"];
   $ToplamYorumSayisi   = $Urunler["YorumSayisi"];

   if($ToplamYorumPuani>0){
       $PuanlamaIslemleri = ceil($ToplamYorumPuani / $ToplamYorumSayisi);

       if($PuanlamaIslemleri >= 5){
           $PuanlamaIslemleri = 5;
       }
        /*
         * YildizCizgiliBos
         * YildizCizgiliBirDolu
         * YildizCizgiliIkiDolu
         * YildizCizgiliUcDolu
         * YildizCizgiliDortDolu
         * YildizCizgiliBesDolu
         * */

       if($PuanlamaIslemleri < 1){
           $PuanSonucu  =    "YildizCizgiliBos.png";
       }elseif($PuanlamaIslemleri>0 && $PuanlamaIslemleri < 2){
           $PuanSonucu  =    "YildizCizgiliBirDolu.png";
       }elseif($PuanlamaIslemleri>1 && $PuanlamaIslemleri < 3){
           $PuanSonucu  =    "YildizCizgiliIkiDolu.png";
       }elseif($PuanlamaIslemleri>2 && $PuanlamaIslemleri < 4){
           $PuanSonucu  =    "YildizCizgiliUcDolu.png";
       }elseif($PuanlamaIslemleri>3 && $PuanlamaIslemleri < 5){
           $PuanSonucu  =    "YildizCizgiliDortDolu.png";
       }elseif($PuanlamaIslemleri>4 && $PuanlamaIslemleri < 6){
           $PuanSonucu  =    "YildizCizgiliBesDolu.png";
       }elseif($PuanlamaIslemleri>6){
           $PuanSonucu  =    "YildizCizgiliBos.png";
       }
   }
?>
    <div class="UrununSinirlamaAlani">
        <div class="UrununResimAlani">
            <a href="index.php?SK=82&ID=<?php echo $Urunler["id"]?>">
                <img src="<?php echo $UrununResmiYolu ?>" alt="" width="205" height="273">
            </a>
        </div>
        <div class="UrunResmiBaslik"><?php echo $UrununAdi ?></div>
        <div class="UrunResmiAciklamasi"><?php echo mb_substr($UrununAciklamasi,0,25) ?></div>
        <div class="UrununYildizlamaPuani">
            <img src="Resimler/<?php echo $PuanSonucu ?>" alt="">
        </div>
        <div class="UrununFiyati"><?php echo $Urunler["UrunFiyati"]?>TL</div>
    </div>
<?php } ?>
    <div class="UrunKategorisiDuzBaslik">En Çok Satan Ürünler</div>
    <?php
    $UrunlerSorgusu  = $veritabani->prepare("SELECT * FROM urunler WHERE Durumu = '1'  ORDER BY GoruntulenmeSayisi DESC LIMIT 5");
    $UrunlerSorgusu->execute([]);
    $UrunlerSorgusuKaydi = $UrunlerSorgusu->fetchAll(PDO::FETCH_ASSOC);
    foreach($UrunlerSorgusuKaydi as $Urunler){
        $UrunResmiKontrolu  = $Urunler["UrunResmiBir"];
        $UrunTuru           = $Urunler["UrunTuru"];
        $UrununAdi          = $Urunler["UrunAdi"];
        $UrununAciklamasi   = $Urunler["UrunAciklamasi"];


        if($UrunTuru == "Erkek Ayakkabısı"){
            $UrununUrunTuru = "Resimler/UrunResimleri/Erkek/";
        }elseif($UrunTuru == "Cocuk Ayakkabısı"){
            $UrununUrunTuru = "Resimler/UrunResimleri/Cocuk/";
        }elseif($UrunTuru == "Kadın Ayakkabısı"){
            $UrununUrunTuru = "Resimler/UrunResimleri/Kadin/";
        }

        $UrununResmiYolu = $UrununUrunTuru.$UrunResmiKontrolu;


        $ToplamYorumPuani    = $Urunler["ToplamYorumPuani"];
        $ToplamYorumSayisi   = $Urunler["YorumSayisi"];

        if($ToplamYorumPuani>0){
            $PuanlamaIslemleri = ceil($ToplamYorumPuani / $ToplamYorumSayisi);

            if($PuanlamaIslemleri >= 5){
                $PuanlamaIslemleri = 5;
            }

            if($PuanlamaIslemleri < 1){
                $PuanSonucu  =    "YildizCizgiliBos.png";
            }elseif($PuanlamaIslemleri>0 && $PuanlamaIslemleri < 2){
                $PuanSonucu  =    "YildizCizgiliBirDolu.png";
            }elseif($PuanlamaIslemleri>1 && $PuanlamaIslemleri < 3){
                $PuanSonucu  =    "YildizCizgiliIkiDolu.png";
            }elseif($PuanlamaIslemleri>2 && $PuanlamaIslemleri < 4){
                $PuanSonucu  =    "YildizCizgiliUcDolu.png";
            }elseif($PuanlamaIslemleri>3 && $PuanlamaIslemleri < 5){
                $PuanSonucu  =    "YildizCizgiliDortDolu.png";
            }elseif($PuanlamaIslemleri>4 && $PuanlamaIslemleri < 6){
                $PuanSonucu  =    "YildizCizgiliBesDolu.png";
            }elseif($PuanlamaIslemleri>6){
                $PuanSonucu  =    "YildizCizgiliBos.png";
            }
        }
        ?>
        <div class="UrununSinirlamaAlani">
            <div class="UrununResimAlani">

                <a href="index.php?SK=82&ID=<?php echo $Urunler["id"]?>">
                    <img src="<?php echo $UrununResmiYolu ?>" alt="" width="205" height="273">
                </a>
            </div>
            <div class="UrunResmiBaslik"><?php echo $UrununAdi ?></div>
            <div class="UrunResmiAciklamasi"><?php echo mb_substr($UrununAciklamasi,0,25) ?></div>
            <div class="UrununYildizlamaPuani">
                <img src="Resimler/<?php echo $PuanSonucu ?>" alt="">
            </div>
            <div class="UrununFiyati"><?php echo $Urunler["UrunFiyati"]?>TL</div>
        </div>

    <?php } ?>

    <div class="UrunKargoTeslimatHakkındaBilgilendirmeleri">
        <div class="BilgilendiriciKapsama">
            <img src="Resimler/HizliTeslimat.png" alt="">
            <div class="BilgilendiriciBasligi">Bugün Teslimat</div>
            <div class="BilgilendiriciAciklamasi">Saat 14:00!a kadar verdiğiniz siparişler aynı gün kapınızda.</div>
        </div>
        <div class="BilgilendiriciKapsama">
            <img src="Resimler/GuvenliAlisveris.png" alt="">
            <div class="BilgilendiriciBasligi">Bugün Teslimat</div>
            <div class="BilgilendiriciAciklamasi">Saat 14:00!a kadar verdiğiniz siparişler aynı gün kapınızda.</div>
        </div>
        <div class="BilgilendiriciKapsama">
            <img src="Resimler/MobilErisim.png" alt="">
            <div class="BilgilendiriciBasligi">Bugün Teslimat</div>
            <div class="BilgilendiriciAciklamasi">Saat 14:00!a kadar verdiğiniz siparişler aynı gün kapınızda.</div>
        </div>
        <div class="BilgilendiriciKapsama">
            <img src="Resimler/IadeGarantisi.png" alt="">
            <div class="BilgilendiriciBasligi">Bugün Teslimat</div>
            <div class="BilgilendiriciAciklamasi">Saat 14:00!a kadar verdiğiniz siparişler aynı gün kapınızda.</div>
        </div>
    </div>

</div>




