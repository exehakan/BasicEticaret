<?php
    if(isset($_SESSION["Kullanici"])){
        $SayfalamaIcinSolveSagButtonSayisi = 2;
        $SayfaBasinaGosterilecekKayitSayisi = 5;
        $ToplamKayitSorgusu = $veritabani->prepare("SELECT DISTINCT SiparisNumarasi FROM siparisler where UyeId = ? ORDER BY SiparisNumarasi DESC");
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
<div class="AnaSayfaSectionBaslik">Hesabim > Siparişler</div>
<div class="AnaSayfaIcerik">
    <table width="100%" cellspacing="2" aria cellpadding="0" border="0" bgcolor="#0a3d62">
        <tr bgcolor="#218c74">
            <th class="TabloBaslikDuzenlemesi">Sipariş Numarasi</th>
            <th class="TabloBaslikDuzenlemesi">Resim</th>
            <th class="TabloBaslikDuzenlemesi">Yorum Adi</th>
            <th class="TabloBaslikDuzenlemesi">Fiyat</th>
            <th class="TabloBaslikDuzenlemesi">Adet</th>
            <th class="TabloBaslikDuzenlemesi">Toplam Fiyat</th>
            <th class="TabloBaslikDuzenlemesi">Kargo Durumu/Takip</th>

        </tr>

    <?php
        $SiparisNumaralariSorgusu = $veritabani->prepare("SELECT DISTINCT SiparisNumarasi FROM siparisler WHERE UyeId = ? ORDER BY SiparisNumarasi ASC LIMIT $SayfalamayaBaslanacakKayitSayisi,$SayfaBasinaGosterilecekKayitSayisi");
        $SiparisNumaralariSorgusu->execute([$KullaniciID]);
        $SiparisNumaralariSorgusuEtkilenen = $SiparisNumaralariSorgusu->rowCount();
        $SiparisNumaralariSorgusuKayitlar = $SiparisNumaralariSorgusu->fetchAll(PDO::FETCH_ASSOC);
        if($SiparisNumaralariSorgusuEtkilenen>0){



        foreach($SiparisNumaralariSorgusuKayitlar as $SiparisNumaralariSatirlar){

        $SiparisNo = DonusumleriGeriDondur($SiparisNumaralariSatirlar["SiparisNumarasi"]);
        $SiparisSorgusu = $veritabani->prepare("SELECT * FROM siparisler WHERE UyeId = ? AND SiparisNumarasi = ? ORDER BY  id ASC LIMIT 1");
        $SiparisSorgusu->execute([$KullaniciID,$SiparisNo]);
        $SiparisSorgusuKayitlari = $SiparisSorgusu->fetchAll(PDO::FETCH_ASSOC);

        foreach ($SiparisSorgusuKayitlari as $SiparisSatirlar){
        $UrunTuru = DonusumleriGeriDondur($SiparisSatirlar["UrunTuru"]);
        $SiparisUrunID = $SiparisSatirlar["UrunId"];

            if($UrunTuru == "Erkek Ayakkabısı"){
                $ResimKlasoruAdi = "Erkek/";
            }elseif($UrunTuru == "Kadın Ayakkabısı"){
                $ResimKlasoruAdi = "kadin/";
            }else{
                $ResimKlasoruAdi = "Cocuk/";
            }
            if($SiparisSatirlar["UrunResmiBir"] != ""){
                $UrunResimi = $SiparisSatirlar["UrunResmiBir"];
            }else{
                $UrunResimi = "resim-yok.jpg";
            }


            $ResimYoluTamam = "Resimler/UrunResimleri/".$ResimKlasoruAdi.$UrunResimi;

            $KargoDurumu = DonusumleriGeriDondur($SiparisSatirlar["KargoDurumu"]);
            if($KargoDurumu == 0){
                $KargoDurumuYazdir = "Beklemede";
            }else{
                $KargoDurumuYazdir = DonusumleriGeriDondur($SiparisSatirlar["KargoGonderiKodu"]);
            }
    ?>
        <tr>
            <td class="TabloIcerikDuzenlemesi">#<?php echo $SiparisSatirlar["SiparisNumarasi"]; ?></td>
            <td class="TabloIcerikDuzenlemesi"><img class="ResimOptimize" src="<?php echo $ResimYoluTamam ?>" alt=""></td>
            <td class="TabloIcerikDuzenlemesi">
                <a href="index.php?SK=75&UrunID=<?php echo $SiparisUrunID ?>">
                    <img style="vertical-align: top;padding-right: 2px;" src="Resimler/DokumanKirmiziKalemli20x20.png" alt="">
                </a>
                <span><?php echo $SiparisSatirlar["UrunAdi"]?></span>
            </td>
            <td class="TabloIcerikDuzenlemesi"><?php echo FiyatBicimlendir($SiparisSatirlar["UrunFiyati"])?> TL</td>
            <td class="TabloIcerikDuzenlemesi"><?php echo $SiparisSatirlar["UrunAdedi"] ?></td>
            <td class="TabloIcerikDuzenlemesi"><?php echo FiyatBicimlendir($SiparisSatirlar["ToplamUrunFiyati"]) ?> TL</td>
            <td class="TabloIcerikDuzenlemesi"><?php echo $KargoDurumuYazdir ?></td>
        </tr>

        <?php
            }// foreach end
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
                        echo "<a href='index.php?SK=61&SYF=1'><li class=\"Sayfalama\">&lt;&lt;</li></a>";
                        $SayfalamaIcinSayfaDegeriniBirGeriAl = $Sayfalama-1;
                        echo "<a href='index.php?SK=61&SYF={$SayfalamaIcinSayfaDegeriniBirGeriAl}'><li class=\"Sayfalama\">&lt;</li></a>";
                    }


                    for ($SayfalamaIcinIndexDegeri = $Sayfalama-$SayfalamaIcinSolveSagButtonSayisi;$SayfalamaIcinIndexDegeri<=$Sayfalama+$SayfalamaIcinSolveSagButtonSayisi;$SayfalamaIcinIndexDegeri++){
                        if(($SayfalamaIcinIndexDegeri>0) and ($SayfalamaIcinIndexDegeri <= $BulunanSayfaSayisi)){
                            if($Sayfalama==$SayfalamaIcinIndexDegeri){
                                echo "<li class=\"Sayfalama SayfalamaPasif\">{$SayfalamaIcinIndexDegeri}</li>";
                            }else{
                                echo "<a href='index.php?SK=61&SYF={$SayfalamaIcinIndexDegeri}'><li class=\"Sayfalama\">{$SayfalamaIcinIndexDegeri}</li></a>";
                            }
                        }

                    }

                    if($Sayfalama != $BulunanSayfaSayisi){
                        $SayfalamaIcinSayfaDegeriniBirIleriAl = $Sayfalama+1;
                        echo "<a href='index.php?SK=61&SYF={$SayfalamaIcinSayfaDegeriniBirIleriAl}'><li class=\"Sayfalama\">&gt;</li></a>";
                        echo "<a href='index.php?SK=61&SYF={$BulunanSayfaSayisi}'><li class=\"Sayfalama\">&gt;&gt;</li></a>";
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










