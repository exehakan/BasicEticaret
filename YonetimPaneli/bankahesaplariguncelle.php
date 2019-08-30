<?php
global $veritabani;
if(isset($_SESSION["Yonetici"])){
    if(isset($_GET["ID"])){
        $GelenIDDegeri = Guvenlik($_GET["ID"]);
    }else{
        $GelenIDDegeri = "";
    }

    if($GelenIDDegeri != ""){

        $BankaHesapSorgusu = $veritabani->prepare("SELECT * FROM bankahesaplarimiz WHERE id = ? LIMIT 1");
        $BankaHesapSorgusu->execute([$GelenIDDegeri]);
        $BankaHesapSorgusuSayisi = $BankaHesapSorgusu->rowCount();
        $BankaHesapSorgusuKaydi = $BankaHesapSorgusu->fetch(PDO::FETCH_ASSOC);

    }


    ?>
    <form action="index.php?SKD=0&SKI=15&ID=<?php echo DonusumleriGeriDondur($GelenIDDegeri)?>" method="post" enctype="multipart/form-data">
        <div class="YoneticiSayfasiSayfalarKapsamaAlani">
            <div class="YoneticiSayfasiSayfalarBasligi">
                Site Ayarlari
                <a href="index.php?SKD=0&SKI=10" olay="BankaKartiEkle(this)" animasyon="evet" class="SiteAyarlariSagTarafYeniKrediKartiEkle">Yeni Banka Hesabi Ekle</a>
            </div>

            <div class="YoneticiSayfasiSayfaIcerikleri">
                <div class="InputAciklamaMetinleriKapsamaAlani">
                    <div class="InputAciklamaMetini">Site Logosu&nbsp;:</div>
                    <input type="file" name="BankaLogosu" class="YonetimPaneliStandartInput">
                </div>

                <div class="InputAciklamaMetinleriKapsamaAlani">
                    <div class="InputAciklamaMetini">Banka Adi&nbsp;:</div>
                    <input type="text"  name="BankaAdi" value="<?php echo $BankaHesapSorgusuKaydi["BankaAdi"]  ?>"  class="YonetimPaneliStandartInput">
                </div>
                <div class="InputAciklamaMetinleriKapsamaAlani">
                    <div class="InputAciklamaMetini">Konum ve Sehir &nbsp;:</div>
                    <input type="text" name="konumSehir" value="<?php echo $BankaHesapSorgusuKaydi["konumSehir"] ?>"  class="YonetimPaneliStandartInput">
                </div>
                <div class="InputAciklamaMetinleriKapsamaAlani">
                    <div class="InputAciklamaMetini">Konum ve Ulke&nbsp;:</div>
                    <input type="text" name="KonumUlke" value="<?php echo $BankaHesapSorgusuKaydi["KonumUlke"] ?>"  class="YonetimPaneliStandartInput">
                </div>
                <div class="InputAciklamaMetinleriKapsamaAlani">
                    <div class="InputAciklamaMetini">Sube Adi&nbsp;:</div>
                    <input type="text" name="SubeAdi" value="<?php echo $BankaHesapSorgusuKaydi["SubeAdi"] ?>"  class="YonetimPaneliStandartInput">
                </div>
                <div class="InputAciklamaMetinleriKapsamaAlani">
                    <div class="InputAciklamaMetini">Sube Kodu&nbsp;:</div>
                    <input type="text" name="SubeKodu" value="<?php echo $BankaHesapSorgusuKaydi["SubeKodu"] ?>"  class="YonetimPaneliStandartInput">
                </div>
                <div class="InputAciklamaMetinleriKapsamaAlani">
                    <div class="InputAciklamaMetini">Hesap Sahibi&nbsp;:</div>
                    <input type="text" name="HesapSahibi" value="<?php echo $BankaHesapSorgusuKaydi["HesapSahibi"] ?>"  class="YonetimPaneliStandartInput">
                </div>

                <div class="InputAciklamaMetinleriKapsamaAlani">
                    <div class="InputAciklamaMetini">Hesap Numarasi&nbsp;:</div>
                    <input type="text" name="HesapNumarasi" value="<?php echo $BankaHesapSorgusuKaydi["HesapNumarasi"] ?>"  class="YonetimPaneliStandartInput">
                </div>

                <div class="InputAciklamaMetinleriKapsamaAlani">
                    <div class="InputAciklamaMetini">Iban Numarasi&nbsp;:</div>
                    <input type="text" name="IbanNumarasi" value="<?php echo $BankaHesapSorgusuKaydi["IbanNumarasi"] ?>"  class="YonetimPaneliStandartInput">
                </div>

                <div class="InputAciklamaMetinleriKapsamaAlani">
                    <div class="InputAciklamaMetini">Hesabin Para Birimi&nbsp;:</div>
                    <input type="text" name="ParaBirimi" value="<?php echo $BankaHesapSorgusuKaydi["ParaBirimi"] ?>"  class="YonetimPaneliStandartInput">
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