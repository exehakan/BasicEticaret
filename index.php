<?php
    session_start();
    ob_start();
    require_once("Config/ayar.php");
    require_once("Config/fonksiyonlar.php");
    require_once("sitesayfalari.php");
    require_once("Config/class.system.php");
    if(isset($_REQUEST["SK"])){
        $SayfaKoduDegeri = RakamlarHaricTumKarakterleriSil($_REQUEST["SK"]);
    }else{
        $SayfaKoduDegeri = 0;
    }

    //Merhaba hakan

    if(isset($_REQUEST["SYF"])){
        $Sayfalama = SayiliIcerikleriFilitrele($_REQUEST["SYF"]);
    }else{
        $Sayfalama = 1;
    }

?>
<!doctype html>
<html lang="tr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <meta http-equiv="content-language" content="tr">
    <meta name="Robots" content="index, follow">
    <meta name="googlebot" content="index, follow">
    <title><?php echo DonusumleriGeriDondur($SiteBaslik) ?></title>
    <link type="text/png" href="Resimler/Favicon.png" rel="icon"/>
    <meta name="description" content="<?php  echo DonusumleriGeriDondur($SiteAciklama) ?>">
    <meta name="Keywords" content="<?php  echo DonusumleriGeriDondur($SiteAnahtarlari) ?>">
    <link rel="stylesheet" type="text/css" href="Config/stil.css">
    <script src="https://cdn.jsdelivr.net/npm/vue"></script>
    <script src="Config/anime.min.js"></script>
    <script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>
    <link href="https://fonts.googleapis.com/css?family=Open+Sans:400,400i,600,600i,700,700i&display=swap&subset=greek" rel="stylesheet">
    <script src="Frameworks/jQuery/jquery-3.4.0.min.js" type="text/javascript"></script>
    <script type="text/javascript" src="Config/fonksiyonlar.js"></script>
</head>
<body>
<div id="app">
    <transition name="bounce">
    <div v-if="show"  class="TamSayfaKapsamaAlani">
        <div class="TamSayfaSinirlamaAlani">
            <header>
                <div class="UstHeaderMesajAlani">
                    <a href=""><img src="Resimler/HeaderMesajResmi.png" class="HeaderResim" alt="">
                </div>
                <div class="AltHeaderMenulerAlani">
                    <ul class="MenulerAlani">
                        <?php
                            if(isset($_SESSION["Kullanici"])){

                        ?>
                                <a href="index.php?SK=50"><li class="Menuler"><img src="Resimler/KullaniciBeyaz16x16.png" alt="">Hesabım</li></a>
                                <a href="index.php?SK=49'"><li class="Menuler"><img src="Resimler/CikisBeyaz16x16.png" alt="">Çıkış Yap</li></a>
                        <?php
                            }else{
                            ?>
                                <a href="index.php?SK=31"><li class="Menuler"><img src="Resimler/KullaniciBeyaz16x16.png" alt="">Giriş Yap</li></a>
                                <a href="index.php?SK=22"><li class="Menuler"><img src="Resimler/KullaniciEkleBeyaz16x16.png" alt="">Yeni Üye Ol</li></a>
                            <?php
                            }
                        ?>
                        <a href="index.php?SK=93"><li class="Menuler"><img src="Resimler/SepetBeyaz16x16.png" alt="">Alışveriş Sepeti</li></a>
                    </ul>
                </div>

                <div class="MenulerLogoveMenuAlani">
                    <div class="SolLogoKapsamaAlani">
                        <div class="SolLogoSinirlamaAlani">
                            <a href="index.php">
                                <img src="Resimler/<?php echo DonusumleriGeriDondur($SiteLogosu);?>" alt="">
                            </a>

                        </div>
                    </div>
                    <div class="SagMenulerKapsamaAlani">
                        <div class="SagMenulerSinirlamaAlani">
                            <ul class="MenuListeleri">
                                <a href="index.php?SK=0"><li class="MenuListesi">Ana Sayfa</li></a>
                                <a href="index.php?SK=83"><li class="MenuListesi">Erkek Ayakkabilari</li></a>
                                <a href="index.php?SK=84"><li class="MenuListesi">Kadın Ayakkabilari</li></a>
                                <a href="index.php?SK=85"><li class="MenuListesi">Çocuk Ayakkabilari</li></a>
                            </ul>
                        </div>
                    </div>
                </div>
            </header>
            <section>
                <?php
                    if((!$SayfaKoduDegeri) or ($SayfaKoduDegeri=="") or ($SayfaKoduDegeri == 0)){
                        include($Sayfa[0]);
                    }else{
                        include($Sayfa[$SayfaKoduDegeri]);
                    }
                ?>
            </section>
            <footer>
                <div class="FooterKapsamaAlani">
                    <div class="FooterSinirlamaAlani">
                        <div class="FooterListeBolumlemeAlani">
                            <div class="FooterBolumBaslikKapsamaAlani">
                                <div class="ListeBaslikAlani">Kurumsal<div class="Animasyon"></div></div>
                            </div>
                            <ul class="Listelemeler">
                                <a href="index.php?SK=1"><li class="Listeler">Hakkımızda</li></a>
                                <a href="index.php?SK=8"><li class="Listeler">Banka Hesaplarimiz</li></a>
                                <a href="index.php?SK=9"><li class="Listeler">Havale Bildirim Formu</li></a>
                                <a href="index.php?SK=14"><li class="Listeler">Kargo Nerede?</li></a>
                                <a href="index.php?SK=16"><li class="Listeler">İletişim</li></a>
                            </ul>
                        </div>
                    </div>
                    <div class="FooterSinirlamaAlani">
                        <div class="FooterListeBolumlemeAlani">
                            <div class="FooterBolumBaslikKapsamaAlani">
                                <div class="ListeBaslikAlani">Üyelik Hizmetler<div class="Animasyon"></div></div>
                            </div>
                            <ul class="Listelemeler">
                                <?php
                                if(isset($_SESSION["Kullanici"])){
                                    ?>
                                    <a href="index.php?SK=50"><li class="Menuler"><img src="Resimler/KullaniciBeyaz16x16.png" alt="">Hesabım</li></a>
                                    <a href="index.php?SK=49"><li class="Menuler"><img src="Resimler/CikisBeyaz16x16.png" alt="">Çıkış Yap</li></a>
                                    <?php
                                }else{
                                    ?>
                                    <a href="index.php?SK=31"><li class="Menuler"><img src="Resimler/KullaniciBeyaz16x16.png" alt="">Giriş Yap</li></a>
                                    <a href="index.php?SK=22"><li class="Menuler"><img src="Resimler/KullaniciEkleBeyaz16x16.png" alt="">Yeni Üye Ol</li></a>
                                    <?php
                                }
                                ?>
                                <a href="index.php?SK=21"><li class="Listeler">Sık Sorulan Sorular</li></a>
                            </ul>
                        </div>
                    </div>
                    <div class="FooterSinirlamaAlani">
                        <div class="FooterListeBolumlemeAlani">
                            <div class="FooterBolumBaslikKapsamaAlani">
                                <div class="ListeBaslikAlani">Sözleşmeler<div class="Animasyon"></div></div>
                            </div>
                            <ul class="Listelemeler">
                                <a href="index.php?SK=2"><li class="Listeler">Üyelik Sözleşmesi</li></a>
                                <a href="index.php?SK=3"><li class="Listeler">Kullanım Koşullari</li></a>
                                <a href="index.php?SK=4"><li class="Listeler">Gizlilik Sözleşmesi</li></a>
                                <a href="index.php?SK=5"><li class="Listeler">Mesafeli Satiş Sözleşmesi</li></a>
                                <a href="index.php?SK=6"><li class="Listeler">Teslimat</li></a>
                                <a href="index.php?SK=7"><li class="Listeler">İptal / İade / Değişim</li></a>
                            </ul>
                        </div>
                    </div>


                    <div class="FooterSinirlamaAlani">
                        <div class="FooterListeBolumlemeAlani">
                            <div class="FooterBolumBaslikKapsamaAlani">
                                <div class="ListeBaslikAlani">Kurumsal<div class="Animasyon"></div></div>
                            </div>
                            <ul class="Listelemeler">
                                <a href="<?php echo DonusumleriGeriDondur($SosyalLinkFacebook) ?>" target="_blank"><li class="Listeler"><img src="Resimler/Facebook16x16.png" alt="">Facebook</li></a>
                                <a href="<?php echo DonusumleriGeriDondur($SosyalLinkTwitter) ?>" target="_blank"><li class="Listeler"><img src="Resimler/Twitter16x16.png" alt="">Twitter</li></a>
                                <a href="<?php echo DonusumleriGeriDondur($SosyalLinkLinkedin) ?>" target="_blank"><li class="Listeler"><img src="Resimler/LinkedIn16x16.png" alt="">Linkedin</li></a>
                                <a href="<?php echo DonusumleriGeriDondur($SosyalLinkInstagram) ?>" target="_blank"><li class="Listeler"><img src="Resimler/Instagram16x16.png" alt="">İnstagram</li></a>
                                <a href="<?php echo DonusumleriGeriDondur($SosyalLinkYoutube) ?>" target="_blank"><li class="Listeler"><img src="Resimler/YouTube16x16.png" alt="">Youtube</li></a>
                            </ul>
                        </div>
                    </div>
                </div>
                <div class="FooterGizlilikAlani">
                    Copyright © DemirYazilim Tüm Haklari Saklidir.
                </div>
            </footer>
        </div>
    </div>
    </transition>
<!--    <script src="https://cdn.jsdelivr.net/npm/vuetify/dist/vuetify.js"></script>-->
    <script src="Config/vue.js" type="text/javascript" language="JavaScript"></script>
</div>
</body>
</html>
<?php
    $veritabani = null;
    ob_end_flush();
?>