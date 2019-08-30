<?php
global $veritabani;
if(isset($_SESSION["Yonetici"])){
    if(isset($_GET["ID"])){
        $GelenKargoIDsi = Guvenlik($_GET["ID"]);
    }else{
        $GelenKargoIDsi = "";
    }

    $KargoGuncelleSorgusu = $veritabani->prepare("SELECT * FROM kargofirmalari WHERE id = ? LIMIT 1");
    $KargoGuncelleSorgusu->execute([$GelenKargoIDsi]);
    $KargoGuncelleSorgusuSayisi = $KargoGuncelleSorgusu->rowCount();
    $KargoKayitlari = $KargoGuncelleSorgusu->fetch(PDO::FETCH_ASSOC);
    ?>
    <div class="YoneticiSayfasiSayfalarKapsamaAlani">
        <div class="YoneticiSayfasiSayfalarBasligi">Kargo Bilgilerini Güncelle</div>
        <div class="YoneticiSayfasiSayfaIcerikleri">
            <form action="index.php?SKD=0&SKI=27&ID=<?php echo $GelenKargoIDsi ?>" method="post" enctype="multipart/form-data">

                <div class="InputAciklamaMetinleriKapsamaAlani">
                    <div class="InputAciklamaMetini">Kargo Firmasi Logosu:</div>
                    <input type="file"  name="KargoFirmasiLogosu"  class="YonetimPaneliStandartInput">
                </div>

                <div class="InputAciklamaMetinleriKapsamaAlani">
                    <div class="InputAciklamaMetini">Kargo Firmasi Adi:</div>
                    <input type="text"  name="KargoFirmasininAdi"  value="<?php echo $KargoKayitlari["KargoFirmasininAdi"]?>" class="YonetimPaneliStandartInput">
                </div>

                <div class="FormdakiVerileriGondermekIcinSubmitAlani">
                    <input type="submit" value="Kargo Bilgilerini Güncelle" class="YonetimPaneliStandartInput">
                </div>
            </form>

        </div>
    </div>
  <?php } ?>