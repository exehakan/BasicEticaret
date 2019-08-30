<?php
if(isset($_SESSION["Yonetici"])){
    ?>
    <form action="index.php?&SKI=71" method="post">
        <div class="YoneticiSayfasiSayfalarKapsamaAlani">
            <div class="YoneticiSayfasiSayfalarBasligi">Yeni Yönetici Ekle</div>
            <div class="YoneticiSayfasiSayfaIcerikleri"  style="border:none;">

                <div class="InputAciklamaMetinleriKapsamaAlani">
                    <div class="InputAciklamaMetini">Kullanici Adi&nbsp;:</div>
                    <input type="text"  name="KullaniciAdi"  class="YonetimPaneliStandartInput">
                </div>
                <div class="InputAciklamaMetinleriKapsamaAlani">
                    <div class="InputAciklamaMetini">Şifre&nbsp;:</div>
                    <input type="text"  name="Sifre"  class="YonetimPaneliStandartInput">
                </div>
                <div class="InputAciklamaMetinleriKapsamaAlani">
                    <div class="InputAciklamaMetini">İsim Soyisim&nbsp;:</div>
                    <input type="text"  name="isimSoyisim"  class="YonetimPaneliStandartInput">
                </div>
                <div class="InputAciklamaMetinleriKapsamaAlani">
                    <div class="InputAciklamaMetini">Email Adresi&nbsp;:</div>
                    <input type="text"  name="EmailAdresi"  class="YonetimPaneliStandartInput">
                </div>
                <div class="InputAciklamaMetinleriKapsamaAlani">
                    <div class="InputAciklamaMetini">Telefon Numarasi&nbsp;:</div>
                    <input type="text" id="TelefonNumarasijQuery" name="TelefonNumarasi"  class="YonetimPaneliStandartInput">
                </div>

                <div class="FormdakiVerileriGondermekIcinSubmitAlani">
                    <input type="submit" value="Yeni Yöneticiyi Ekle" class="YonetimPaneliStandartInput">
                </div>

            </div>
        </div>
    </form>
    <?php
}
?>
