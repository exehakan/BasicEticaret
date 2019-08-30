<?php
global $veritabani;
if(isset($_SESSION["Yonetici"])){
    ?>
    <div class="YoneticiSayfasiSayfalarKapsamaAlani">
        <div class="YoneticiSayfasiSayfalarBasligi">
            Kargo Ayarlari
            <a href="index.php?SKD=0&SKI=22" olay="BankaKartiEkle(this),$(this).css('color','#fdcb6e')" class="SiteAyarlariSagTarafYeniKrediKartiEkle">Yeni Kargo Firmasi Ekle</a>
        </div>
        <div class="YoneticiSayfasiSayfaIcerikleri" olay="$(this).css('border','none')" animasyon="evet">

            <?php
                $KargoSorgulari = $veritabani->prepare("SELECT * FROM kargofirmalari ORDER BY KargoFirmasininAdi ASC");
                $KargoSorgulari->execute();
                $KargoSorgulariSayisi = $KargoSorgulari->rowCount();
                $KargoSorgulariKayitlari = $KargoSorgulari->fetchAll(PDO::FETCH_ASSOC);
            ?>

            <div class="KargoFirmalariKapsamaAlani">
                <div class="KargoFirmalariSinirlamaAlani">
                    <?php
                        foreach($KargoSorgulariKayitlari as $Kayitlar){
                            ?>
                            <div class="KargoFirmalari" olay="">
                                <div class="KargoFirmalariSolLogoAlani">
                                    <img src="../Resimler/<?php echo DonusumleriGeriDondur($Kayitlar["KargoFirmasininLogosu"])?>" alt="">
                                </div>
                                <div class="KargoFirmasiAdi">Firma Adi : <?php echo DonusumleriGeriDondur($Kayitlar["KargoFirmasininAdi"])?></div>
                                <div class="KargoFirmalariSagGuncelleVeSilAlani">
                                    <div class="KargoGuncelle"><a href="index.php?SKD=0&SKI=26&ID=<?php echo $Kayitlar["id"]?>"><img src="../Resimler/Guncelleme20x20.png" alt="">Güncelle</a></div>
                                    <div class="KargoSil"><a href="index.php?SKD=0&SKI=30&ID=<?php echo $Kayitlar["id"]?>"><img src="../Resimler/Sil20x20.png" alt="">SİL</a></div>
                                </div>
                            </div>
                    <?php } ?>
                </div>
            </div>

        </div>
    </div>
<?php }?>