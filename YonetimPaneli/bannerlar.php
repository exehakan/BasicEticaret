<?php
global $veritabani;
if(isset($_SESSION["Yonetici"])){
    ?>
    <div class="YoneticiSayfasiSayfalarKapsamaAlani">
        <div class="YoneticiSayfasiSayfalarBasligi">
            Banner Ayarlari
            <a href="index.php?SKD=0&SKI=34" olay="BankaKartiEkle(this),$(this).css('color','#fdcb6e')" animasyon="evet" class="SiteAyarlariSagTarafYeniKrediKartiEkle">Yeni Banner Ekle</a>
        </div>
        <div class="YoneticiSayfasiSayfaIcerikleri" olay="$(this).css('border','none')" animasyon="evet">

            <?php
            $BannerSorgulari = $veritabani->prepare("SELECT * FROM bannerlar ORDER BY id DESC");
            $BannerSorgulari->execute();
            $BannerSorgulariSayisi = $BannerSorgulari->rowCount();
            $BannerSorgulariKayitlari = $BannerSorgulari->fetchAll(PDO::FETCH_ASSOC);
            ?>

            <div class="KargoFirmalariKapsamaAlani">
                <div class="KargoFirmalariSinirlamaAlani">
                    <?php
                    foreach($BannerSorgulariKayitlari as $Kayitlar){
                        ?>
                        <div class="KargoFirmalari" olay="" animasyon="evet">
                            <div class="KargoFirmalariSolLogoAlani">
                                <img src="../Resimler/Banner/<?php echo DonusumleriGeriDondur($Kayitlar["BannerResmi"])?>" alt="">
                            </div>
                            <div class="KargoFirmasiAdi">Banner Adi : <?php echo DonusumleriGeriDondur($Kayitlar["BannerAdi"])?></div>
                            <div class="KargoFirmasiAdi">Yeri : <?php echo DonusumleriGeriDondur($Kayitlar["BannerAlani"])?></div>
                            <div class="KargoFirmalariSagGuncelleVeSilAlani">
                                <div class="KargoGuncelle"><a href="index.php?SKD=0&SKI=38&ID=<?php echo $Kayitlar["id"]?>"><img src="../Resimler/Guncelleme20x20.png" alt="">Güncelle</a></div>
                                <div class="KargoSil"><a href="index.php?SKD=0&SKI=42&ID=<?php echo $Kayitlar["id"]?>"><img src="../Resimler/Sil20x20.png" alt="">SİL</a></div>
                            </div>
                        </div>
                    <?php } ?>
                </div>
            </div>

        </div>
    </div>
<?php }?>