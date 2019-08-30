<?php
global $veritabani;
if(isset($_SESSION["Yonetici"])){
    $SayfalamaKosulu = "";

    if(isset($_REQUEST["AramaIcerigi"])){
        $GelenAramaIcerigi   =  $_REQUEST["AramaIcerigi"];
        $AramaKosulu         =  " AND (EmailAdresi LIKE '%" . $GelenAramaIcerigi . "%' OR IsimSoyisim LIKE '%". $GelenAramaIcerigi . "%' OR TelefonNumarasi LIKE '%".$GelenAramaIcerigi."%' ) ";
        $SayfalamaKosulu    =  "&AramaIcerigi=".$GelenAramaIcerigi;
    }else{
        $AramaKosulu = "";
        $SayfalamaKosulu .= "";
    }



    $SayfalamaIcinSagveSolButonSayisi = 2;
    $SayfaBasinaGosterilecekKayitSayisi = 1;
    $ToplamKayitSayisiSorgusu = $veritabani->prepare("SELECT * FROM uyeler WHERE SilinmeDurumu = ? $AramaKosulu ORDER BY id DESC");
    $ToplamKayitSayisiSorgusu->execute([0]);
    $ToplamKayitSayisi = $ToplamKayitSayisiSorgusu->rowCount();
    $SayfalamayaBaslanacakKayitSayisi = ($Sayfalama * $SayfaBasinaGosterilecekKayitSayisi) - $SayfaBasinaGosterilecekKayitSayisi;
    $BulunanSayfaSayisi = ceil($ToplamKayitSayisi / $SayfaBasinaGosterilecekKayitSayisi);



    ?>
    <div class="YoneticiSayfasiSayfalarKapsamaAlani">
        <div class="YoneticiSayfasiSayfalarBasligi">
            Üyeler
            <a href="index.php?SKD=0&SKI=83" olay="BankaKartiEkle(this),$(this).css('color','#fdcb6e')" class="SiteAyarlariSagTarafYeniKrediKartiEkle">Silinmiş olan üyeler</a>
        </div>
        <div class="YoneticiSayfasiSayfaIcerikleri" olay="$(this).css('border','none')">
            <?php
                $uyelersorgusu = $veritabani->prepare("SELECT * FROM uyeler WHERE SilinmeDurumu = ? $AramaKosulu ORDER BY id DESC LIMIT $SayfalamayaBaslanacakKayitSayisi,$SayfaBasinaGosterilecekKayitSayisi");
                $uyelersorgusu->execute([0]);
                $UyelerSayisi = $uyelersorgusu->rowCount();
                $UyelerKaydi = $uyelersorgusu->fetchAll(PDO::FETCH_ASSOC);
            ?>
            <div class="UyelerKapsamaAlani">
                <div class="UrunAramaAlani AramaAlaniUyelerIcerisinde">
                    <form action="index.php?SKD=0&SKI=82" method="post">

                        <div class="FormInputAramaAlani">
                            <input type="text" class="AramaAlaniInputu UyelerInput" name="AramaIcerigi">
                        </div>
                        <div class="FormGonderButtonu">
                            <input type="submit" value="" class="AramaAlaniButtonu YoneticiSayfasiuyelerAramaButtonu">
                        </div>

                    </form>
                </div>
                <div class="UyelerSinirlamaAlani">
                    <?php
                    if($UyelerSayisi>0){
                        foreach($UyelerKaydi as $Kayitlar){
                            ?>
                    <div class="UyeninBilgilerininOlduguAlan">
                        <ul class="UyeBilgileri">
                            <li class="bilgiler"><span class="UyeAciklamasi">İsim Soyisim&nbsp;:  <?php echo  $Kayitlar["IsimSoyisim"]?></span>213123</li>
                            <li class="bilgiler"><span class="UyeAciklamasi">Email&nbsp; :  <?php echo  $Kayitlar["EmailAdresi"]?></span></li>
                            <li class="bilgiler"><span class="UyeAciklamasi">Telefon&nbsp; :  <?php echo  $Kayitlar["TelefonNumarasi"]?></span></li>
                            <li class="bilgiler"><span class="UyeAciklamasi">Cinsiyet&nbsp; :  <?php echo  $Kayitlar["Cinsiyet"]?></span></li>
                            <li class="bilgiler"><span class="UyeAciklamasi">Kayit Tarihi&nbsp; : <?php echo  $Kayitlar["KayitTarihi"]?></span></li>
                            <li class="bilgiler"><span class="UyeAciklamasi">Kayit IP&nbsp; : <?php echo  $Kayitlar["KayitIpAdresi"]?></span></li>
                            <div class="UyeyiSilAlani">
                                <a href="index.php?SKD=0&SKI=84&ID=<?php echo DonusumleriGeriDondur($Kayitlar["id"]) ?>"><img src="../Resimler/Sil20x20.png" alt="">Sil</a>
                            </div>
                        </ul>
                    </div>

                            <?php
                        }
                    }
                    ?>
                </div>
                <?php
                if($BulunanSayfaSayisi>1){
                    ?>
                    <div class="SayfalamaKapsamaAlani">
                        <div class="SayfalamaAlaniIciNumaraAlaniKapsayicisi">
                            <ul class="SayfalamaSinirlamaAlani">
            <?php

                        if($Sayfalama>1){
                            $e->HTMLYazdir("<a href='index.php?SKD=0&SKI=82{$SayfalamaKosulu}&SYF=1'><li class=\"Sayfalama\">&lt;&lt;</li></a>");
                            $SayfalamaIcinSayfaDegeriniBirGeriAl = $Sayfalama-1;
                            $e->HTMLYazdir("<a href='index.php?SKD=0&SKI=82&{$SayfalamaKosulu}&SYF={$SayfalamaIcinSayfaDegeriniBirGeriAl}'><li class=\"Sayfalama\">&lt;</li></a>");
                        }

                        for($SayfalamaIcinSayfaIndexDegeri=$Sayfalama-$SayfalamaIcinSagveSolButonSayisi;$SayfalamaIcinSayfaIndexDegeri<=$Sayfalama+$SayfalamaIcinSagveSolButonSayisi;$SayfalamaIcinSayfaIndexDegeri++){
                            if($SayfalamaIcinSayfaIndexDegeri>0 and $SayfalamaIcinSayfaIndexDegeri<=$BulunanSayfaSayisi){
                                if($Sayfalama==$SayfalamaIcinSayfaIndexDegeri){
                                    $e->HTMLYazdir("<li class='Sayfalama SayfalamaPasif'>$SayfalamaIcinSayfaIndexDegeri</li>");
                                }else{
                                    $e->HTMLYazdir("<a href='index.php?SKD=0&SKI=82{$SayfalamaKosulu}&SYF={$SayfalamaIcinSayfaIndexDegeri}'><li class=\"Sayfalama \">{$SayfalamaIcinSayfaIndexDegeri}</li></a>");
                                }
                            }
                        }


                        if($Sayfalama!=$BulunanSayfaSayisi){
                            $SayfalamaIcinSayfaDegeriniBirIleriAl = $Sayfalama+1;
                            $e->HTMLYazdir("<a href='index.php?SKD=0&SKI=82&{$SayfalamaKosulu}&SYF={$SayfalamaIcinSayfaDegeriniBirIleriAl}'><li class=\"Sayfalama\">&gt;</li></a>");

                            $e->HTMLYazdir("<a href='index.php?SKD=0&SKI=82{$SayfalamaKosulu}&SYF={$BulunanSayfaSayisi}'><li class=\"Sayfalama\">&gt;&gt;</li></a>");
                        }
                        ?>
                    </ul>
                </div>
            </div>

            <?php
        }else{
            $e->yazdir("Bu sayfada bulunan kayit sayisi {$ToplamKayitSayisi}");
        }
        ?>
            </div>

        </div>
    </div>

<?php }?>