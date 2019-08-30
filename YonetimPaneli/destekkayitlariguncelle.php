<?php
global $veritabani;
if(isset($_SESSION["Yonetici"])){
    if(isset($_GET["ID"])){
        $GelenID = Guvenlik(SayiliIcerikleriFilitrele($_GET["ID"]));
    }else{
        $GelenID = "";
    }

    $GuncellemeSorgusu = $veritabani->prepare("SELECT * FROM sorular WHERE id = ? LIMIT 1");
    $GuncellemeSorgusu->execute([$GelenID]);
    $GuncellemeSorgusuSayi = $GuncellemeSorgusu->rowCount();
    $GuncellemeSorgusuKaydi = $GuncellemeSorgusu->fetch(PDO::FETCH_ASSOC);

    ?>
    <div class="YoneticiSayfasiSayfalarKapsamaAlani">
        <div class="YoneticiSayfasiSayfalarBasligi">
            Destek İçeriklerini Güncelle
        </div>
        <div class="YoneticiSayfasiSayfaIcerikleri">

            <form action="index.php?SKD=0&SKI=51&ID=<?php echo $GelenID;?>" method="post">
                <div class="YoneticiSayfasiSayfaIcerikleri sifirla">

                    <div class="InputAciklamaMetinleriKapsamaAlani">
                        <div class="InputAciklamaMetini">Soru Basligi&nbsp;:</div>
                        <input type="text"  name="SoruBasligi" value="<?php echo $GuncellemeSorgusuKaydi["soru"]?>" class="YonetimPaneliStandartInput">
                    </div>

                    <div class="InputAciklamaMetinleriKapsamaAlani">
                        <div class="InputAciklamaMetini">Baslik Cevabi&nbsp;:</div>
                        <textarea style="height: 150px" type="text"  name="BaslikCevabi"  class="YonetimPaneliStandartInput TextAreaIylestirme"><?php echo $GuncellemeSorgusuKaydi["cevap"]?></textarea>
                    </div>

                    <div class="FormdakiVerileriGondermekIcinSubmitAlani">
                        <input type="submit" value="Yeni Destek İçeriğini Kaydet" class="YonetimPaneliStandartInput">
                    </div>
                </div>
            </form>

        </div>
    </div>
    <?php
}else{
    yonlendir("index.php?SKD=1");
}

?>