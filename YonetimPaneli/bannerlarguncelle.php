<?php
global $veritabani;
if(isset($_SESSION["Yonetici"])){
    if(isset($_GET["ID"])){
        $GelenBannerIdsi = Guvenlik($_GET["ID"]);
    }else{
        $GelenBannerIdsi = "";
    }

    $BannerGuncelleSorgusu = $veritabani->prepare("SELECT * FROM bannerlar WHERE id = ? LIMIT 1");
    $BannerGuncelleSorgusu->execute([$GelenBannerIdsi]);
    $BannerGuncelleSorgusuSayisi = $BannerGuncelleSorgusu->rowCount();
    $BannerKayitlari = $BannerGuncelleSorgusu->fetch(PDO::FETCH_ASSOC);
    ?>
    <div class="YoneticiSayfasiSayfalarKapsamaAlani">
        <div class="YoneticiSayfasiSayfalarBasligi">Banner Bilgilerini Güncelle</div>
        <div class="YoneticiSayfasiSayfaIcerikleri">
            <form action="index.php?SKD=0&SKI=39&ID=<?php echo $GelenBannerIdsi ?>" method="post" enctype="multipart/form-data">
                <div class="InputAciklamaMetinleriKapsamaAlani">
                    <div class="InputAciklamaMetini">BannerResmi:</div>
                    <input type="file"  name="BannerResmi"  class="YonetimPaneliStandartInput">
                </div>
                <div class="InputAciklamaMetinleriKapsamaAlani">
                    <div class="InputAciklamaMetini">Banner Alan Adi:</div>
                    <input type="text"  name="BannerAlanAdi"  value="<?php echo $BannerKayitlari["BannerAlani"]?>" class="YonetimPaneliStandartInput">
                </div>
                <div class="FormdakiVerileriGondermekIcinSubmitAlani">
                    <input type="submit" value="Banner Bilgilerini Güncelle" class="YonetimPaneliStandartInput">
                </div>
            </form>

        </div>
    </div>
<?php } ?>