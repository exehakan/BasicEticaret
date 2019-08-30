<?php
global $veritabani;
if(isset($_SESSION["Yonetici"])){
    ?>
    <form action="index.php?SKD=0&SKI=35" method="post" enctype="multipart/form-data">
        <div class="YoneticiSayfasiSayfalarKapsamaAlani">
            <div class="YoneticiSayfasiSayfalarBasligi">
               Yeni Banner Ekle
            </div>
            <div class="YoneticiSayfasiSayfaIcerikleri">
                <div class="InputAciklamaMetinleriKapsamaAlani"">
                    <div class="InputAciklamaMetini">Banner Alani&nbsp;:</div>
                    <?php
                        $BannerSorgusu = $veritabani->prepare("SELECT * FROM bannerlar ORDER BY id ASC");
                        $BannerSorgusu->execute();
                        $BannerSorgusuKaydi = $BannerSorgusu->fetchAll(PDO::FETCH_ASSOC);
                    ?>

                    <select name="BannerAlani" class="YonetimPaneliStandartInput" olay="SelectAlanininGenisliginiDuzenle(this)">
                        <option value="">Lütfen Seçiniz</option>
                        <?php
                            foreach($BannerSorgusuKaydi as $Kayitlar){
                                ?>
                                    <option value="<?php echo $Kayitlar["BannerAlani"]?>"><?php echo $Kayitlar["BannerAlani"]?></option>
                                <?php
                            }
                        ?>
                    </select>
                </div>

                <div class="InputAciklamaMetinleriKapsamaAlani">
                    <div class="InputAciklamaMetini">Banner Resmi&nbsp;:</div>
                    <input type="file" name="BannerResmi" class="YonetimPaneliStandartInput">
                </div>

                <div class="InputAciklamaMetinleriKapsamaAlani">
                    <div class="InputAciklamaMetini">Banner Adi&nbsp;:</div>
                    <input type="text" name="BannerAdi" class="YonetimPaneliStandartInput">
                </div>


                <div class="FormdakiVerileriGondermekIcinSubmitAlani">
                    <input type="submit" value="Banka Bilgilerini Kaydet" class="YonetimPaneliStandartInput">
                </div>
            </div>
        </div>
    </form>

    <?php
}
?>