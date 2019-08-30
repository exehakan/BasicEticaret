<?php
global $veritabani;
if(isset($_SESSION["Yonetici"])){
    $MenuEklemeSorgusu = $veritabani->prepare("SELECT * FROM menuler ORDER BY UrunTuru ASC");
    $MenuEklemeSorgusu->execute();
    $MenuEklemeSorgusuSayisi = $MenuEklemeSorgusu->rowCount();
    $MenuEklemeSorgusuKaydi = $MenuEklemeSorgusu->fetchAll(PDO::FETCH_ASSOC);

    ?>
    <div class="YoneticiSayfasiSayfalarKapsamaAlani">
        <div class="YoneticiSayfasiSayfalarBasligi">
            Yeni Menu Ekle
        </div>
        <div class="YoneticiSayfasiSayfaIcerikleri">
            <form action="index.php?SKD=0&SKI=59" method="post">
                <div class="YoneticiSayfasiSayfaIcerikleri sifirla">
                    <div class="InputAciklamaMetinleriKapsamaAlani">
                        <div class="InputAciklamaMetini">Menü İçin Ürün Türü&nbsp;:</div>
                        <select name="UrunTuru" class="YonetimPaneliStandartInput">
                            <option value="Bos">Lütfen Seçiniz</option>
                            <?php
                                if($MenuEklemeSorgusuSayisi>0){
                                    foreach($MenuEklemeSorgusuKaydi as $Kayitlar){
                                        ?>
                                        <option value="<?php echo $Kayitlar["UrunTuru"]?>"><?php echo $Kayitlar["UrunTuru"]?></option>
                                        <?php
                                    }
                                }else{
                                    ?>
                                    <option value="Erkek Ayakkabısı">Erkek Ayakkabısı</option>
                                    <option value="Kadın Ayakkabısı">Kadın Ayakkabısı</option>
                                    <option value="Çocuk Ayakkabısı">Çocuk Ayakkabısı</option>
                                    <?php
                                }
                            ?>
                        </select>
                    </div>
                    <div class="InputAciklamaMetinleriKapsamaAlani">
                        <div class="InputAciklamaMetini">Menü Adi&nbsp;:</div>
                        <input type="text" name="MenuAdi" class="YonetimPaneliStandartInput">
                    </div>

                    <div class="FormdakiVerileriGondermekIcinSubmitAlani">
                        <input type="submit" value="Yeni Menü'yü Ekle" class="YonetimPaneliStandartInput">
                    </div>
                </div>
            </form>
        </div>
    </div>
    <?php
}
?>