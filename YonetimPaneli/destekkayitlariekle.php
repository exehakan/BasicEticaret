<?php
    if(isset($_SESSION["Yonetici"])){
        ?>
        <div class="YoneticiSayfasiSayfalarKapsamaAlani">
            <div class="YoneticiSayfasiSayfalarBasligi">
                Yeni Destek İçeriği Ekle
            </div>
            <div class="YoneticiSayfasiSayfaIcerikleri">

                <form action="index.php?SKD=0&SKI=47" method="post">
                    <div class="YoneticiSayfasiSayfaIcerikleri sifirla">

                        <div class="InputAciklamaMetinleriKapsamaAlani">
                            <div class="InputAciklamaMetini">Soru Basligi&nbsp;:</div>
                            <input type="text"  name="SoruBasligi" class="YonetimPaneliStandartInput">
                        </div>

                        <div class="InputAciklamaMetinleriKapsamaAlani">
                            <div class="InputAciklamaMetini">Baslik Cevabi&nbsp;:</div>
                            <textarea style="height: 150px" type="text"  name="BaslikCevabi" class="YonetimPaneliStandartInput"></textarea>
                        </div>

                        <div class="FormdakiVerileriGondermekIcinSubmitAlani">
                            <input type="submit" value="Yeni Destek İçeriğini Kaydet" class="YonetimPaneliStandartInput">
                        </div>
                    </div>
                </form>

            </div>
        </div>

        <?php
    }
?>