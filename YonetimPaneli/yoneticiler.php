<?php
global $veritabani;
if(isset($_SESSION["Yonetici"])){
    ?>

    <div class="YoneticiSayfasiSayfalarKapsamaAlani">
        <div class="YoneticiSayfasiSayfalarBasligi">
            Yöneticiler
            <a href="index.php?SKD=0&SKI=70" olay="BankaKartiEkle(this)" animasyon="evet" class="SiteAyarlariSagTarafYeniKrediKartiEkle">Yeni Yönetici Ekle</a>
        </div>

        <?php
        $YoneticilerSorgusu = $veritabani->prepare("SELECT * FROM yoneticiler ORDER BY id ASC");
        $YoneticilerSorgusu->execute();
        $YoneticilerSorgususayisi = $YoneticilerSorgusu->rowCount();
        $YoneticilerSorgusuKayitlari = $YoneticilerSorgusu->fetchAll(PDO::FETCH_ASSOC);
        ?>
        <div class="YoneticiSayfasiSayfaIcerikleri" style="border: none" animasyon="evet">

            <div class="YoneticilerSinirlamaAlani">
                <div class="YoneticilerKapsamaAlani">
                    <?php
                    if($YoneticilerSorgususayisi>0){
                        foreach($YoneticilerSorgusuKayitlari as $Kayitlar){
                            ?>
                            <div class="YoneticilerAlani">
                                <div class="YoneticiBlok"><?php echo $Kayitlar["KullaniciAdi"]?></div>
                                <div class="YoneticilerUrunTuruMenusuAlani"><?php echo $Kayitlar["isimSoyisim"] ?></div>
                                <div class="YoneticilerUrunTuruMenusuAlani"><?php echo $Kayitlar["EmailAdresi"] ?></div>
                                <div class="MenulerGuncelleveSilSagAlan">
                                    <div class="KargoGuncelle"><a href="index.php?SKD=0&SKI=75&ID=<?php echo $Kayitlar["id"]?>"><img src="../Resimler/Guncelleme20x20.png" alt="">Güncelle</a></div>
                                    <div class="KargoSil"><a href="index.php?SKD=0&SKI=79&ID=<?php echo $Kayitlar["id"]?>"><img src="../Resimler/Sil20x20.png" alt="">SİL</a></div>
                                </div>
                            </div>

                            <?php
                        }
                    }
                    ?>
                </div>
            </div>
        </div>
    </div>

<?php } ?>