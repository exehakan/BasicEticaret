<?php
if(isset($_SESSION["Kullanici"])){
    $SayfalamaIcinSolveSagButtonSayisi = 2;
    $SayfaBasinaGosterilecekKayitSayisi = 5;
    $ToplamKayitSorgusu = $veritabani->prepare("SELECT * FROM favoriler WHERE UyeId = ? ORDER BY id DESC ");
    $ToplamKayitSorgusu->execute([$KullaniciID]);
    $ToplamKayitSorgusu = $ToplamKayitSorgusu->rowCount();
    $SayfalamayaBaslanacakKayitSayisi = ($Sayfalama * $SayfaBasinaGosterilecekKayitSayisi) - $SayfaBasinaGosterilecekKayitSayisi;
    $BulunanSayfaSayisi = ceil($ToplamKayitSorgusu/$SayfaBasinaGosterilecekKayitSayisi);

    ?>
    <div  class="HesabimSayfasiUstMenu">
        <ul class="UstMenuKapsamaAlani">
            <a href="index.php?SK=50"><li class="UstMenuler">Üyelik Bilgilerim</li></a>
            <a href="index.php?SK=58"><li class="UstMenuler">Adresler</li></a>
            <a href="index.php?SK=59"><li class="UstMenuler">Favoriler</li></a>
            <a href="index.php?SK=60"><li class="UstMenuler">Yorumlar</li></a>
            <a href="index.php?SK=61"><li class="UstMenuler">Siparişler</li></a>
        </ul>
    </div>
    <div class="AnaSayfaSectionBaslik">Hesabim > Favoriler</div>
    <div class="AnaSayfaIcerik">
        <table width="100%" cellspacing="2" aria cellpadding="0" border="0" bgcolor="#0a3d62">
            <tr bgcolor="#218c74">
                <th class="TabloBaslikDuzenlemesi">Resim</th>
                <th class="TabloBaslikDuzenlemesi">Sil</th>
                <th class="TabloBaslikDuzenlemesi">Adi</th>
                <th class="TabloBaslikDuzenlemesi">Fiyati</th>


            </tr>

            <?php
            $FavorilerSorgusu = $veritabani->prepare("SELECT * FROM favoriler WHERE UyeId = ? ORDER BY id DESC LIMIT $SayfalamayaBaslanacakKayitSayisi,$SayfaBasinaGosterilecekKayitSayisi");
            $FavorilerSorgusu->execute([$KullaniciID]);
            $FavorilerSorgusuKayitlar = $FavorilerSorgusu->fetchAll(PDO::FETCH_ASSOC);
            $FavorilerSorgusuEtkilenen = $FavorilerSorgusu->rowCount();


            if($FavorilerSorgusuEtkilenen>0){

                foreach ($FavorilerSorgusuKayitlar as $FavoriSatirlar){

                    $UrunlerSorgusu = $veritabani->prepare("SELECT * FROM urunler WHERE id = ? LIMIT 1");
                    $UrunlerSorgusu->execute([$FavoriSatirlar["UrunId"]]);
                    $UrunlerSorgusuKayitlari = $UrunlerSorgusu->fetch(PDO::FETCH_ASSOC);
                    global $DolarKuru;
                    global $EuroKuru;



                    if($UrunlerSorgusuKayitlari["ParaBirimi"] == "USD"){
                        $UrunFiyati = $e->SayiyiYukariYuvarla($UrunlerSorgusuKayitlari["UrunFiyati"] * $DolarKuru);
                    }elseif($UrunlerSorgusuKayitlari["ParaBirimi"] == "EUR"){
                        $UrunFiyati = $e->SayiyiYukariYuvarla($UrunlerSorgusuKayitlari["UrunFiyati"] * $EuroKuru);
                    }else{
                        $UrunFiyati = $e->SayiyiYukariYuvarla($UrunlerSorgusuKayitlari["UrunFiyati"]);
                    }


                    $UrununAdi = DonusumleriGeriDondur($UrunlerSorgusuKayitlari["UrunAdi"]);
                    $UrununUrunTuru = DonusumleriGeriDondur($UrunlerSorgusuKayitlari["UrunTuru"]);
                    $UrununResmi = DonusumleriGeriDondur($UrunlerSorgusuKayitlari["UrunResmiBir"]);
                    $UrununFiyati = DonusumleriGeriDondur($UrunFiyati);
                    $UrununParaBirimi = DonusumleriGeriDondur($UrunlerSorgusuKayitlari["ParaBirimi"]);

                        $UrunTuru = DonusumleriGeriDondur($UrununUrunTuru);


                        if($UrunTuru == "Erkek Ayakkabısi"){
                            $ResimKlasoruAdi = "Erkek/";
                        }elseif($UrunTuru == "Kadın Ayakkabısı"){
                            $ResimKlasoruAdi = "kadin/";
                        }else{
                            $ResimKlasoruAdi = "Cocuk/";
                        }
                        $ResimYoluTamam = "Resimler/UrunResimleri/".$ResimKlasoruAdi.$UrununResmi;
                        ?>
                        <tr>
                            <td class="TabloIcerikDuzenlemesi"><img class="ResimOptimize" src="<?php echo $ResimYoluTamam ?>" alt=""></td>
                            <td class="TabloIcerikDuzenlemesi"><a href="index.php?SK=80&ID=<?php echo $FavoriSatirlar["id"] ?>"><img style="vertical-align: top;padding-right: 2px;" src="Resimler/Sil20x20.png" alt=""></a>Sil</td>
                            <td class="TabloIcerikDuzenlemesi"><?php echo $UrununAdi; ?></td>
                            <td class="TabloIcerikDuzenlemesi"><?php echo $UrununFiyati; ?></td>

                        </tr>

                        <?php
                    }// foreach end
            }
            ?>

        </table>

        <?php
        if($BulunanSayfaSayisi>1){
            ?>
            <div class="SayfalamaKapsamaAlani">
                <ul class="SayfalamaSinirlamaAlani">
                    <?php
                    if($Sayfalama>1){
                        echo "<a href='index.php?SK=59&SYF=1'><li class=\"Sayfalama\">&lt;&lt;</li></a>";
                        $SayfalamaIcinSayfaDegeriniBirGeriAl = $Sayfalama-1;
                        echo "<a href='index.php?SK=59&SYF={$SayfalamaIcinSayfaDegeriniBirGeriAl}'><li class=\"Sayfalama\">&lt;</li></a>";
                    }


                    for ($SayfalamaIcinIndexDegeri = $Sayfalama-$SayfalamaIcinSolveSagButtonSayisi;$SayfalamaIcinIndexDegeri<=$Sayfalama+$SayfalamaIcinSolveSagButtonSayisi;$SayfalamaIcinIndexDegeri++){
                        if(($SayfalamaIcinIndexDegeri>0) and ($SayfalamaIcinIndexDegeri <= $BulunanSayfaSayisi)){
                            if($Sayfalama==$SayfalamaIcinIndexDegeri){
                                echo "<li class=\"Sayfalama SayfalamaPasif\">{$SayfalamaIcinIndexDegeri}</li>";
                            }else{
                                echo "<a href='index.php?SK=59&SYF={$SayfalamaIcinIndexDegeri}'><li class=\"Sayfalama\">{$SayfalamaIcinIndexDegeri}</li></a>";
                            }
                        }

                    }

                    if($Sayfalama != $BulunanSayfaSayisi){
                        $SayfalamaIcinSayfaDegeriniBirIleriAl = $Sayfalama+1;
                        echo "<a href='index.php?SK=59&SYF={$SayfalamaIcinSayfaDegeriniBirIleriAl}'><li class=\"Sayfalama\">&gt;</li></a>";
                        echo "<a href='index.php?SK=59&SYF={$BulunanSayfaSayisi}'><li class=\"Sayfalama\">&gt;&gt;</li></a>";
                    }
                    ?>
                </ul>
            </div>

            Toplam <?php echo $BulunanSayfaSayisi. " Sayfada " . $ToplamKayitSorgusu . " Kayit"?>


            <?php
        }
        ?>



    </div>
    <?php
}else{
    yonlendir("index.php");
}
?>










