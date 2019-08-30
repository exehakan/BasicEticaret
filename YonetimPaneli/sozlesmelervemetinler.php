<?php if(isset($_SESSION["Yonetici"])){ ?>
<form action="index.php?SKD=0&SKI=6" method="post">
    <div class="YoneticiSayfasiSayfalarKapsamaAlani">
        <div class="YoneticiSayfasiSayfalarBasligi">Sözleşme ve Metinler</div>
                <div class="InputAciklamaMetinleriKapsamaAlani" animasyon="OpacityEffect" olay="AltBosluk(this)">
                    <div class="InputAciklamaMetini">Hakkimizda&nbsp:</div>
                    <textarea name="HakkimizdaMetni" class="YonetimPaneliTextAreaKutulari"><?php echo DonusumleriGeriDondur($HakkimizdaMetni)?></textarea>
                </div>

                <div class="InputAciklamaMetinleriKapsamaAlani" animasyon="OpacityEffect" olay="AltBosluk(this)">
                    <div class="InputAciklamaMetini">Uyelik Sozlesmesi Metni&nbsp;:</div>
                    <textarea name="UyelikSozlesmesiMetni" class="YonetimPaneliTextAreaKutulari"><?php echo DonusumleriGeriDondur($UyelikSozlesmesiMetni)?></textarea>
                </div>

                <div class="InputAciklamaMetinleriKapsamaAlani" animasyon="OpacityEffect" olay="AltBosluk(this)">
                    <div class="InputAciklamaMetini">Kullanim Kosullari Metni&nbsp;:</div>
                    <textarea name="KullanimKosullariMetni" class="YonetimPaneliTextAreaKutulari"><?php echo DonusumleriGeriDondur($KullanimKosullariMetni)?></textarea>
                </div>

                <div class="InputAciklamaMetinleriKapsamaAlani" animasyon="OpacityEffect" olay="AltBosluk(this)">
                    <div class="InputAciklamaMetini">Gizlilik Sozlesmesi Metni&nbsp;:</div>
                    <textarea name="GizlilikSozlesmesiMetni" class="YonetimPaneliTextAreaKutulari"><?php echo DonusumleriGeriDondur($GizlilikSozlesmesiMetni)?></textarea>
                </div>

                <div class="InputAciklamaMetinleriKapsamaAlani" animasyon="OpacityEffect" olay="AltBosluk(this)">
                    <div class="InputAciklamaMetini">Mesafeli Satis Sozlesmesi Metni&nbsp;:</div>
                    <textarea name="MesafeliSatisSozlesmesiMetni" class="YonetimPaneliTextAreaKutulari"><?php echo DonusumleriGeriDondur($MesafeliSatisSozlesmesiMetni)?></textarea>
                </div>

                <div class="InputAciklamaMetinleriKapsamaAlani" animasyon="OpacityEffect" olay="AltBosluk(this)">
                    <div class="InputAciklamaMetini">Teslimat Metni&nbsp;:</div>
                    <textarea name="TeslimatMetni" class="YonetimPaneliTextAreaKutulari"><?php echo DonusumleriGeriDondur($TeslimatMetni)?></textarea>
                </div>

                <div class="InputAciklamaMetinleriKapsamaAlani" animasyon="OpacityEffect" olay="AltBosluk(this)">
                    <div class="InputAciklamaMetini">Iptal Iade Degisim Metni&nbsp;:</div>
                    <textarea name="IptalIadeDegisimMetni" class="YonetimPaneliTextAreaKutulari"><?php echo DonusumleriGeriDondur($IptalIadeDegisimMetni)?></textarea>
                </div>

                <div class="FormdakiVerileriGondermekIcinSubmitAlani" olay="AltBosluk(this)">
                    <input type="submit" value="Ayarlari Kaydet" class="YonetimPaneliStandartInput">
                </div>

        </div>
    </div>
</form>



<?php }else{
    yonlendir("index.php?SKD=1");
} ?>