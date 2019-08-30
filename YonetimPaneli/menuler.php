<?php
global $veritabani;
if(isset($_SESSION["Yonetici"])){
    ?>

    <div class="YoneticiSayfasiSayfalarKapsamaAlani">
        <div class="YoneticiSayfasiSayfalarBasligi">
            Menuler
            <a href="index.php?SKD=0&SKI=58" olay="BankaKartiEkle(this)" animasyon="evet" class="SiteAyarlariSagTarafYeniKrediKartiEkle">Yeni Menu Ekle</a>
        </div>

        <?php
            $MenulerSorgusu = $veritabani->prepare("SELECT * FROM menuler ORDER BY UrunTuru ASC");
            $MenulerSorgusu->execute();
            $MenulerSorgususayisi = $MenulerSorgusu->rowCount();
            $MenulerSorgusuKayitlari = $MenulerSorgusu->fetchAll(PDO::FETCH_ASSOC);
        ?>
        <div class="YoneticiSayfasiSayfaIcerikleri">

            <div class="MenulerSinirlamaAlani">
                <div class="MenulerKapsamaAlani">


                    <?php
                        if($MenulerSorgususayisi>0){
                            foreach($MenulerSorgusuKayitlari as $Kayitlar){
                                ?>
                                <div class="MenulerAlani">
                                    <div class="MenuUrunTuruAlani"><?php echo $Kayitlar["UrunTuru"]?></div>
                                    <div class="MenulerUrunTuruMenusuAlani"><?php echo $Kayitlar["MenuAdi"] ?>(<?php echo $Kayitlar["UrunSayisi"]?>)</div>
                                    <div class="MenulerGuncelleveSilSagAlan">
                                        <div class="KargoGuncelle"><a href="index.php?SKD=0&SKI=62&ID=<?php echo $Kayitlar["id"]?>"><img src="../Resimler/Guncelleme20x20.png" alt="">Güncelle</a></div>
                                        <div class="KargoSil"><a href="index.php?SKD=0&SKI=66&ID=<?php echo $Kayitlar["id"]?>"><img src="../Resimler/Sil20x20.png" alt="">SİL</a></div>
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