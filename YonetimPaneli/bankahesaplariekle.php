<?php
if(isset($_SESSION["Yonetici"])){
    ?>
    <form action="index.php?SKD=0&SKI=11" method="post" enctype="multipart/form-data">
        <div class="YoneticiSayfasiSayfalarKapsamaAlani">
            <div class="YoneticiSayfasiSayfalarBasligi">
                Site Ayarlari
                <a href="index.php?SKD=0&SKI=10" animasyon="evet" olay="BankaKartiEkle(this)" class="SiteAyarlariSagTarafYeniKrediKartiEkle">Yeni Banka Hesabi Ekle</a>
            </div>

            <div class="YoneticiSayfasiSayfaIcerikleri">

                <div class="InputAciklamaMetinleriKapsamaAlani">
                    <div class="InputAciklamaMetini">Site Logosu&nbsp;:</div>
                    <input type="file" name="BankaLogosu" class="YonetimPaneliStandartInput">
                </div>

                <div class="InputAciklamaMetinleriKapsamaAlani">
                    <div class="InputAciklamaMetini">Banka Adi&nbsp;:</div>
                    <input type="text"  name="BankaAdi"  class="YonetimPaneliStandartInput">
                </div>
                <div class="InputAciklamaMetinleriKapsamaAlani">
                    <div class="InputAciklamaMetini">Konum ve Sehir &nbsp;:</div>
                    <input type="text" name="konumSehir"  class="YonetimPaneliStandartInput">
                </div>
                <div class="InputAciklamaMetinleriKapsamaAlani">
                    <div class="InputAciklamaMetini">Konum ve Ulke&nbsp;:</div>
                    <input type="text" name="KonumUlke"  class="YonetimPaneliStandartInput">
                </div>
                <div class="InputAciklamaMetinleriKapsamaAlani">
                    <div class="InputAciklamaMetini">Sube Adi&nbsp;:</div>
                    <input type="text" name="SubeAdi"  class="YonetimPaneliStandartInput">
                </div>
                <div class="InputAciklamaMetinleriKapsamaAlani">
                    <div class="InputAciklamaMetini">Sube Kodu&nbsp;:</div>
                    <input type="text" name="SubeKodu"  class="YonetimPaneliStandartInput">
                </div>
                <div class="InputAciklamaMetinleriKapsamaAlani">
                    <div class="InputAciklamaMetini">Hesap Sahibi&nbsp;:</div>
                    <input type="text" name="HesapSahibi"  class="YonetimPaneliStandartInput">
                </div>

                <div class="InputAciklamaMetinleriKapsamaAlani">
                    <div class="InputAciklamaMetini">Hesap Numarasi&nbsp;:</div>
                    <input type="text" name="HesapNumarasi"  class="YonetimPaneliStandartInput">
                </div>

                <div class="InputAciklamaMetinleriKapsamaAlani">
                    <div class="InputAciklamaMetini">Iban Numarasi&nbsp;:</div>
                    <input type="text" name="IbanNumarasi"  class="YonetimPaneliStandartInput">
                </div>

                <div class="InputAciklamaMetinleriKapsamaAlani">
                    <div class="InputAciklamaMetini">Hesabin Para Birimi&nbsp;:</div>
                    <input type="text" name="ParaBirimi"  class="YonetimPaneliStandartInput">
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