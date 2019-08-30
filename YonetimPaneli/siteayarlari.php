<?php
    if(isset($_SESSION["Yonetici"])){
        ?>
        <form action="index.php?&SKI=2" method="post" enctype="multipart/form-data">
            <div class="YoneticiSayfasiSayfalarKapsamaAlani">
                <div class="YoneticiSayfasiSayfalarBasligi">Site Ayarlari</div>
                <div class="YoneticiSayfasiSayfaIcerikleri">
                    <div class="InputAciklamaMetinleriKapsamaAlani">
                        <div class="InputAciklamaMetini">Site Adi&nbsp;:</div>
                        <input type="text"  name="SiteAdi" value="<?php echo DonusumleriGeriDondur($SiteAdi) ?>" class="YonetimPaneliStandartInput">
                    </div>
                    <div class="InputAciklamaMetinleriKapsamaAlani">
                        <div class="InputAciklamaMetini">Site Title&nbsp;:</div>
                        <input type="text" name="SiteTitle" value="<?php echo DonusumleriGeriDondur($SiteBaslik) ?>" class="YonetimPaneliStandartInput">
                    </div>
                    <div class="InputAciklamaMetinleriKapsamaAlani">
                        <div class="InputAciklamaMetini">Site Description&nbsp;:</div>
                        <input type="text" name="SiteDescription" value="<?php echo DonusumleriGeriDondur($SiteAciklama) ?>" class="YonetimPaneliStandartInput">
                    </div>
                    <div class="InputAciklamaMetinleriKapsamaAlani">
                        <div class="InputAciklamaMetini">Site Keywords&nbsp;:</div>
                        <input type="text" name="SiteKeywords" value="<?php echo DonusumleriGeriDondur($SiteAnahtarlari) ?>" class="YonetimPaneliStandartInput">
                    </div>
                    <div class="InputAciklamaMetinleriKapsamaAlani">
                        <div class="InputAciklamaMetini">Site Logosu&nbsp;:</div>
                        <input type="file" name="SiteLogosu" class="YonetimPaneliStandartInput">
                    </div>
                    <div class="InputAciklamaMetinleriKapsamaAlani">
                        <div class="InputAciklamaMetini">Site Linki&nbsp;:</div>
                        <input type="text" name="SiteLinki" value="<?php echo DonusumleriGeriDondur($SiteLinki) ?>" class="YonetimPaneliStandartInput">
                    </div>
                    <div class="InputAciklamaMetinleriKapsamaAlani">
                        <div class="InputAciklamaMetini">Copyright Metni&nbsp;:</div>
                        <input type="text" name="copyrightMetni" value="<?php echo DonusumleriGeriDondur($SiteCopyrightMetni) ?>" class="YonetimPaneliStandartInput">
                    </div>
                    <div class="InputAciklamaMetinleriKapsamaAlani">
                        <div class="InputAciklamaMetini">Site Email Adresi&nbsp;:</div>
                        <input type="text" name="SiteEmailAdresi" value="<?php echo DonusumleriGeriDondur($SiteEmailAdresi) ?>" class="YonetimPaneliStandartInput">
                    </div>
                    <div class="InputAciklamaMetinleriKapsamaAlani">
                        <div class="InputAciklamaMetini">Site Email Şifre&nbsp;:</div>
                        <input type="text" name="SiteEmailSifresi" value="<?php echo DonusumleriGeriDondur($SiteEmailSifresi) ?>" class="YonetimPaneliStandartInput">
                    </div>
                    <div class="InputAciklamaMetinleriKapsamaAlani">
                        <div class="InputAciklamaMetini">Site Email Host Adresi&nbsp;:</div>
                        <input type="text" name="SiteEmailHostAdresi" value="<?php echo DonusumleriGeriDondur($SiteEmailHostAdresi) ?>" class="YonetimPaneliStandartInput">
                    </div>
                    <div class="InputAciklamaMetinleriKapsamaAlani">
                        <div class="InputAciklamaMetini">Facebook Linki&nbsp;:</div>
                        <input type="text" name="FacebookLinki" value="<?php echo DonusumleriGeriDondur($SosyalLinkFacebook) ?>" class="YonetimPaneliStandartInput">
                    </div>
                    <div class="InputAciklamaMetinleriKapsamaAlani">
                        <div class="InputAciklamaMetini">Twitter Linki&nbsp;:</div>
                        <input type="text" name="TwitterLinki" value="<?php echo DonusumleriGeriDondur($SosyalLinkTwitter) ?>" class="YonetimPaneliStandartInput">
                    </div>
                    <div class="InputAciklamaMetinleriKapsamaAlani">
                        <div class="InputAciklamaMetini">LinkedIn Linki&nbsp;:</div>
                        <input type="text" name="LinkedInLinki" value="<?php echo DonusumleriGeriDondur($SosyalLinkLinkedin) ?>" class="YonetimPaneliStandartInput">
                    </div>
                    <div class="InputAciklamaMetinleriKapsamaAlani">
                        <div class="InputAciklamaMetini">Instagram Linki&nbsp;:</div>
                        <input type="text" name="InstagramLinki" value="<?php echo DonusumleriGeriDondur($SosyalLinkInstagram) ?>" class="YonetimPaneliStandartInput">
                    </div>
                    <div class="InputAciklamaMetinleriKapsamaAlani">
                        <div class="InputAciklamaMetini">Youtube Linki&nbsp;:</div>
                        <input type="text" name="YoutubeLinki" value="<?php echo DonusumleriGeriDondur($SosyalLinkYoutube) ?>" class="YonetimPaneliStandartInput">
                    </div>
                    <div class="InputAciklamaMetinleriKapsamaAlani">
                        <div class="InputAciklamaMetini">Dolar Kuru&nbsp;:</div>
                        <input type="text" name="DolarKuru" value="<?php echo DonusumleriGeriDondur($DolarKuru) ?>" class="YonetimPaneliStandartInput">
                    </div>
                    <div class="InputAciklamaMetinleriKapsamaAlani">
                        <div class="InputAciklamaMetini">Euro Kuru&nbsp;:</div>
                        <input type="text" name="EuroKuru" value="<?php echo DonusumleriGeriDondur($EuroKuru) ?>" class="YonetimPaneliStandartInput">
                    </div>

                    <div class="InputAciklamaMetinleriKapsamaAlani">
                        <div class="InputAciklamaMetini">Ücretsiz Kargo Baraji&nbsp;:</div>
                        <input type="text" name="UcretsizKargoBaraji" value="<?php echo DonusumleriGeriDondur($UcretsizKargoBaraji) ?>" class="YonetimPaneliStandartInput">
                    </div>

                    <div class="InputAciklamaMetinleriKapsamaAlani">
                        <div class="InputAciklamaMetini">Sanal Pos Client ID&nbsp;:</div>
                        <input type="text" name="SanalPosClientId" value="<?php echo DonusumleriGeriDondur($ClientID) ?>" class="YonetimPaneliStandartInput">
                    </div>

                    <div class="InputAciklamaMetinleriKapsamaAlani">
                        <div class="InputAciklamaMetini">Sanal Pos Store Key&nbsp;:</div>
                        <input type="text" name="SanalPosStoreKey" value="<?php echo DonusumleriGeriDondur($StoreKey) ?>" class="YonetimPaneliStandartInput">
                    </div>

                    <div class="InputAciklamaMetinleriKapsamaAlani">
                        <div class="InputAciklamaMetini">Sanal Pos API Adi&nbsp;:</div>
                        <input type="text" name="SanalPosAPIAdi" value="<?php echo DonusumleriGeriDondur($ApiKullanicisi) ?>" class="YonetimPaneliStandartInput">
                    </div>

                    <div class="InputAciklamaMetinleriKapsamaAlani">
                        <div class="InputAciklamaMetini">Sanal Pos API Şifresi&nbsp;:</div>
                        <input type="text" name="SanalPosAPISifresi" value="<?php echo DonusumleriGeriDondur($ApiSifresi) ?>" class="YonetimPaneliStandartInput">
                    </div>

                    <div class="FormdakiVerileriGondermekIcinSubmitAlani">
                        <input type="submit" value="Site Ayarlarini Kaydet" class="YonetimPaneliStandartInput">
                    </div>
                </div>
            </div>
        </form>

        <?php
    }
?>