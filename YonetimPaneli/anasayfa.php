<?php if(isset($_SESSION["Yonetici"])){ ?>

    <div class="YoneticiPaneliTamSayfaKapsamaAlani">
        <div class="YoneticiPaneliSinirlamaAlani">
            <div class="YoneticiPaneliSolMenuAlani">
                <ul class="YonetimPaneliSolMenuListeAlani">
                    <a href="index.php">
                        <div class="YonetimPaneliSolMenuLogoAlani" id="test">
                            <img src="../Resimler/Logo.png" alt="">
                        </div>
                    </a>
<!--                    <li class="YonetimPaneliSolMenuElemanlari"><a href="#">SİPARİŞLER</a></li>-->
<!--                    <li class="YonetimPaneliSolMenuElemanlari"><a href="#">HAVALE BİLDİRİMLERİ</a></li>-->
<!--                    <li class="YonetimPaneliSolMenuElemanlari"><a href="#">ÜRÜNLER</a></li>-->
                    <li class="YonetimPaneliSolMenuElemanlari"><a href="index.php?SKD=0&SKI=82">ÜYELER</a></li>
                    <li class="YonetimPaneliSolMenuElemanlari"><a href="index.php?SKD=0&SKI=90">YORUMLAR</a></li>
                    <li class="YonetimPaneliSolMenuElemanlari"><a href="index.php?SKD=0&SKI=1">SİTE AYARLARI</a></li>
                    <li class="YonetimPaneliSolMenuElemanlari"><a href="index.php?SKD=0&SKI=57">MENÜLER</a></li>
                    <li class="YonetimPaneliSolMenuElemanlari"><a href="index.php?SKD=0&SKI=9">BANKA HESAP AYARLARI</a></li>
                    <li class="YonetimPaneliSolMenuElemanlari"><a href="index.php?SKD=0&SKI=5">SÖZLEŞMELER VE METİNLER</a></li>
                    <li class="YonetimPaneliSolMenuElemanlari"><a href="index.php?SKD=0&SKI=21">KARGO AYARLARI</a></li>
                    <li class="YonetimPaneliSolMenuElemanlari"><a href="index.php?SKD=0&SKI=33">BANNER AYARLARI</a></li>
                    <li class="YonetimPaneliSolMenuElemanlari"><a href="index.php?SKD=0&SKI=45">DESTEK İÇERİKLERİ</a></li>
                    <li class="YonetimPaneliSolMenuElemanlari"><a href="index.php?SKD=0&SKI=69">YÖNETİCİLER</a></li>
                    <li class="YonetimPaneliSolMenuElemanlari"><a href="index.php?SKD=4">ÇIKIŞ</a></li>
                </ul>
            </div>
            <div class="YonetiPanelSagMenuAlani">
                <div class="YoneticiPaneliSagMenuIcerikVeModullerAlani">
                    <?php
                        if((!$IcSayfaKoduDegeri) or ($IcSayfaKoduDegeri == "") or ($IcSayfaKoduDegeri == 0)){
                            include($SayfaIc[0]);
                        }else{
                            include($SayfaIc[$IcSayfaKoduDegeri]);
                        }
                    ?>

                </div>
            </div>

        </div>
    </div>
<?php } ?>
























