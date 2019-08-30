<?php
    if(empty($_SESSION["Yonetici"])) {
        ?>
        <div class="YonetimPaneliYoneticiGirisSayfasiKapsamaAlani">
            <div class="YoneticiGirisSayfasiSinirlamaAlani">
                <form action="index.php?SKD=2" method="post">
                    <div class="YonetimPaneliUstLogoAlani">
                        <img src="https://img.icons8.com/dusk/200/000000/crown.png">
                    </div>
                    <div class="YoneticiGirdiBasliklari">Yönetici K.Adi</div>
                    <div class="YoneticiGirdiKutulari">
                        <input type="text" name="YKullanici" class="YoneticiPaneliTextInputlari">
                    </div>
                    <div class="YoneticiGirdiBasliklari">Yönetici K.Şifresi</div>
                    <div class="YoneticiGirdiKutulari">
                        <input type="password" name="YSifre" class="YoneticiPaneliTextInputlari">
                    </div>
                    <div class="YonetimPaneliButtonKutusu">
                        <input type="submit" value="Giriş Yap" class="YonetimPaneliGirisButtonu">
                    </div>
                </form>
            </div>
        </div>
        <?php
    }
?>
