<?php
if(isset($_SESSION["Yonetici"])){
    ?>
    <div class="YoneticiSayfasiSayfalarKapsamaAlani">
        <div class="YoneticiSayfasiSayfalarBasligi">Yeni Bir Kargo Firmasi Ekle</div>
        <div class="YoneticiSayfasiSayfaIcerikleri">
        <form action="index.php?SKD=0&SKI=23" method="post" enctype="multipart/form-data">

            <div class="InputAciklamaMetinleriKapsamaAlani">
                <div class="InputAciklamaMetini">Kargo Firmasi Logosu:</div>
                <input type="file"  name="KargoFirmasiLogosu"  class="YonetimPaneliStandartInput">
            </div>

            <div class="InputAciklamaMetinleriKapsamaAlani">
                <div class="InputAciklamaMetini">Kargo Firmasi Adi:</div>
                <input type="text"  name="KargoFirmasininAdi"  class="YonetimPaneliStandartInput">
            </div>

            <div class="FormdakiVerileriGondermekIcinSubmitAlani">
                <input type="submit" value="Yeni Kargoyu Ekle" class="YonetimPaneliStandartInput">
            </div>
        </form>

        </div>
    </div>






















    <?php
}

?>